<?php

namespace Modules\FrontendManage\Http\Controllers;

use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\CourseReveiw;
use Yajra\DataTables\Facades\DataTables;

class TopicReviewController extends Controller
{

    public function index()
    {
        try {
            $user_query = User::query()->where('is_active', 1);
            $course_query = Course::query()->where('status', 1);

            if (isModuleActive('Organization') && Auth::user()->isOrganization()) {
                $user_query->where('organization_id', Auth::id());

                $course_query->whereHas('user', function ($q) {
                    $q->where('organization_id', Auth::id());
                    $q->orWhere('id', Auth::id());
                });
            }

            $data['users'] = $user_query->latest()->get();
            $data['courses'] = $course_query->latest()->get();

            return view('frontendmanage::topic_reviews.index', $data);

        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }




    public function datatable(Request $request)
    {
        try {
            // Determine the Institute ID
            $instituteId = isModuleActive('LmsSaas') ? app('institute')->id : 1;

            // Initialize the query
            $query = CourseReveiw::where('course_reveiws.lms_id', $instituteId)
                ->join('users', 'course_reveiws.user_id', '=', 'users.id')
                ->join('courses', 'courses.id', '=', 'course_reveiws.course_id')
                ->select(
                    'users.name as user_name',
                    'courses.title as course_title',
                    'course_reveiws.comment',
                    'course_reveiws.created_at',
                    'course_reveiws.id',
                    'course_reveiws.user_id',
                    'course_reveiws.course_id',
                    'course_reveiws.status',
                    'course_reveiws.star'
                )
                ->with(['user', 'course']);

            // Filter by date range
            if (!empty($request->f_date)) {
                $dateRange = formatDateRangeData($request->f_date);
                $query = $query->whereBetween('course_reveiws.created_at', $dateRange);
            }



            // Filter by course
            if (!empty($request->f_course)) {
                $query = $query->where('course_reveiws.course_id', $request->f_course);
            }
             // Return DataTables response
            return DataTables::of($query)
                ->addIndexColumn() // Add index column
                ->editColumn('created_at', function ($row) {
                    return showDate($row->created_at); // Format the created_at date
                })
                ->editColumn('course_title', function ($row) {
                    return $row->course->title ?? ''; // Safely access the course title
                })
                ->editColumn('type', function ($row) {
                    return trans('frontend.' . ($row->type ?? '')); // Translate the type
                })
                ->addColumn('status', function ($row) {
                    return view('frontendmanage::topic_reviews.components._status', ['row' => $row]);
                })
                ->addColumn('action', function ($row) {
                    return view('frontendmanage::topic_reviews.components._action', ['row' => $row]);
                })
                ->rawColumns(['action', 'status']) // Mark columns as raw
                ->toJson(); // Convert to JSON response
        } catch (Exception $e) {
            // Handle exceptions
            Toastr::error($e->getMessage(), trans('common.Failed'));
            return response()->json([
                'error' => $e->getMessage()
            ], 503);
        }
    }



    public function destroy(Request $request)
    {

        $request->validate([
            'id' => 'required',
        ]);

        try {
            $success = trans('lang.Deleted') . ' ' . trans('lang.Successfully');
            CourseReveiw::where('id', $request->id)->delete();
            Toastr::success($success, trans('common.Success'));
            return redirect()->back();

        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }
}
