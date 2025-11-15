<?php

namespace Modules\Setting\Http\Controllers;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Modules\Setting\Entities\ErrorLog;
use Yajra\DataTables\Facades\DataTables;

class ErrorLogController extends Controller
{

    public function index()
    {
        if (demoCheck('For the demo version, You can not view error logs')) {
            return redirect()->back();
        }
        return view('setting::error_log');
    }

    public function getAllErrorLogData(Request $request)
    {


        $query = ErrorLog::with(['user'])->latest()->select('error_logs.*');


        return Datatables::of($query)
            ->addIndexColumn()
            ->editColumn('created_at', function ($query) {
                return $query->created_at->diffForHumans();
            })
            ->addColumn('user', function ($query) {
                return !empty($query->user->name) ? $query->user->name : 'Guest';
            })
            ->addColumn('action', function ($query) {


                if (permissionCheck('error_log.DeleteErrorLog')) {

                    $error_log_delete = '<button class="dropdown-item deleteError_log"
                                                                    data-id="' . $query->id . '"
                                                                    type="button">' . trans('common.Delete') . '</button>';
                } else {
                    $error_log_delete = "";
                }

                $actioinView = ' <div class="dropdown CRM_dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                                            id="dropdownMenu2" data-bs-toggle="dropdown"
                                                            aria-haspopup="true"
                                                            aria-expanded="false">
                                                        ' . trans('common.Action') . '
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right"
                                                         aria-labelledby="dropdownMenu2">
                                                        ' . $error_log_delete . '




                                                    </div>
                                                </div>';

                return $actioinView;


            })->rawColumns(['action'])->make(true);
    }

    public function DeleteErrorLog(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        $rules = [
            'id' => 'required'
        ];

        $this->validate($request, $rules, validationMessage($rules));

        try {
            $success = trans('lang.Deleted') . ' ' . trans('lang.Successfully');

            $user = ErrorLog::findOrFail($request->id);
            $user->delete();

            Toastr::success($success, trans('common.Success'));
            return redirect()->back();

        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function EmptyErrorLog()
    {
        try {
            $success = trans('lang.Deleted') . ' ' . trans('lang.Successfully');

            ErrorLog::truncate();

            Toastr::success($success, trans('common.Success'));
            return redirect()->back();

        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());

        }
    }
}
