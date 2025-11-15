<?php

namespace Modules\Setting\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PushSettingController extends Controller
{
    public function index()
    {
        return view('setting::pusher_setting');
    }

    public function store(Request $request)
    {

        putEnvConfigration('PUSHER_APP_ID', $request->get('pusher_app_id'));
        putEnvConfigration('PUSHER_APP_KEY', $request->get('pusher_app_key'));
        putEnvConfigration('PUSHER_APP_SECRET', $request->get('pusher_app_secret'));
        putEnvConfigration('PUSHER_APP_CLUSTER', $request->get('pusher_app_cluster'));


        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }
}
