<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\CourseSetting\Entities\CourseCanceled;
use Modules\CourseSetting\Entities\CourseEnrolled;

class WebsiteApiRefundController extends Controller
{
    public function index()
    {
        try {
            $flag = !(Settings('allow_refund_days') == 0);
            $records = CourseCanceled::where('user_id', auth()->id())
                ->with('course:title,id')
                ->latest()
                ->get();

            $ignore = CourseCanceled::where('user_id', auth()->id())
                ->where('status', 0)
                ->whereNotNull('enroll_id')
                ->pluck('enroll_id')->toArray();
            $courses = CourseEnrolled::where('user_id', auth()->id())
                ->where('purchase_price', ">", 0)
                ->whereNotIn('id', $ignore)
                ->when($flag, function ($query) {
                    $today = Carbon::now();
                    $date = $today->subDays((int)Settings('allow_refund_days'))->format('Y-m-d');
                    return $query->where(DB::raw('DATE(created_at)'), '>=', $date);
                })
                ->with('course')
                ->get();

            $courseList = [];
            foreach ($courses as $key => $enroll) {
                $courseList[$key]['id'] = $enroll->id;
                $courseList[$key]['title'] = $enroll->course->title;
            }

            $refundList =[];
            foreach ( $records as $key=>$refund){
                $refundList[$key]['id'] =$refund->id;
                $refundList[$key]['user_id'] =$refund->user_id;
                $refundList[$key]['enroll_id'] =$refund->enroll_id;
                $refundList[$key]['request_from'] =$refund->request_from;
                $refundList[$key]['request_by'] =$refund->request_by;
                $refundList[$key]['status'] =$refund->status;
                $refundList[$key]['reason'] =$refund->reason;
                $refundList[$key]['refund'] =$refund->refund;
                $refundList[$key]['course_id'] =$refund->course_id;
                $refundList[$key]['purchase_price'] =$refund->purchase_price;
                $refundList[$key]['course_title'] =$refund->course->title;
            }

            $response = [
                'success' => true,
                'data' => [
                    'courses_list' =>$courseList,
                    'refund_list' =>$refundList,
                ],
                'message' => "Getting List",
            ];
            return response()->json($response, 200);

        }catch (Exception $exception){
            $response = [
                'success' => false,
                'message' => $exception->getMessage(),
            ];
            return response()->json($response, 500);
        }
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'course_id' => 'required',
        ]);

        $user = Auth::user();

        $enroll = CourseEnrolled::where('user_id',$user->id)->find($request->course_id);
        if ($enroll){
            $exist = CourseCanceled::where('user_id', $user->id)->where('enroll_id', $request->course)->first();
            if ($exist){
                $response = [
                    'success' => false,
                    'message' => "Already cancel request send",
                ];
                return response()->json($response, 404);
            }

            $cancel = new CourseCanceled();
            $cancel->user_id = $user->id;
            $cancel->reason = $request->reason;
            $cancel->enroll_id = $request->course;
            $cancel->request_from = $user->role->name;
            $cancel->request_by = $user->id;
            $cancel->status = 0;
            $cancel->refund = 1;
            $cancel->course_id = $enroll->course_id;
            $cancel->purchase_price = $enroll->purchase_price;
            $cancel->save();

            $response = [
                'success' => true,
                'message' => "Successfully cancel request send",
            ];
            return response()->json($response, 200);
        }else{
            $response = [
                'success' => false,
                'message' => "This course is not enrolled yet",
            ];
            return response()->json($response, 404);
        }


    }

    public function show($id)
    {
        try {
            $cancel = CourseCanceled::find($id);
            $response = [
                'success' => true,
                'data'=> $cancel,
                'message' => "Getting List",
            ];
            return response()->json($response, 200);
        }catch (Exception $exception){
            $response = [
                'success' => false,
                'message' => $exception->getMessage(),
            ];
            return response()->json($response, 500);
        }
    }

    public function delete(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        try {
            $user = Auth::user();
            CourseCanceled::where('user_id',$user->id)->where('id',$request->id)->delete();
            $response = [
                'success' => true,
                'message' => "Request delete successfully",
            ];
            return response()->json($response, 200);
        }catch (Exception $exception){
            $response = [
                'success' => false,
                'message' => $exception->getMessage(),
            ];
            return response()->json($response, 500);
        }
    }

}
