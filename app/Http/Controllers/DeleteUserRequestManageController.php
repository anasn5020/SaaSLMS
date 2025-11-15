<?php

namespace App\Http\Controllers;


use App\Models\DeleteAccountRequest;
use App\Traits\SendNotification;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DeleteUserRequestManageController extends Controller
{
    use SendNotification;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('RoutePermissionCheck:admin.user_delete_request.index', ['only' => ['index', 'datatable']]);
        $this->middleware('RoutePermissionCheck:admin.user_delete_request.destroy', ['only' => ['destroy']]);
        $this->middleware('RoutePermissionCheck:admin.user_delete_request.reject', ['only' => ['reject']]);

    }

    public function index()
    {
        try {
            return view('backend.delete_request.index');
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }

    }

    public function datatable(Request $request)
    {

        try {
            $query = DeleteAccountRequest::query();
            $query->with(['user'])->select('delete_account_requests.*');
            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('created_at', function ($row) {
                    return showDate($row->created_at);
                })
                ->addColumn('name', function ($row) {
                    return $row->user->name;
                })
                ->addColumn('email', function ($row) {
                    return $row->user->email;
                })
                ->addColumn('action', function ($row) {
                    return view('backend.delete_request.components._action', ['row' => $row]);
                })
                ->rawColumns(['action'])
                ->toJson();
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 503);
        }
    }

    public function destroy(Request $request)
    {
        $rules = [
            'id' => 'required'
        ];

        $this->validate($request, $rules, validationMessage($rules));

        if (demoCheckById($request->id,[1,2,3,4])) {
            return back();
        }

        try {
            $success = trans('lang.Deleted') . ' ' . trans('lang.Successfully');
            $row = DeleteAccountRequest::where('id', $request->id)->first();
            if ($row) {
                $user = User::where('id', $row->user_id)->first();


                $notificationTemplate = 'Account_Deletion';
                $notificationTemplateData = [
                    'name' => $user->name,
                ];

                $this->sendNotification($notificationTemplate, $user, $notificationTemplateData);
                $user->delete();
                $row->delete();
            }
            Toastr::success($success, trans('common.Success'));
            return redirect()->back();
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }

    }

    public function reject(Request $request)
    {
        $rules = [
            'id' => 'required'
        ];

        $this->validate($request, $rules, validationMessage($rules));

        if (demoCheckById($request->id,[1,2,3,4,5])) {
            return  back();
        }

        try {
            $success = trans('common.Reject') . ' ' . trans('lang.Successfully');
            $row = DeleteAccountRequest::where('id', $request->id)->first();
            if ($row) {
                User::where('id', $row->user_id)->update(['status' => 1]);
                $row->delete();
            }
            Toastr::success($success, trans('common.Success'));
            return redirect()->back();
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }

    }
}
