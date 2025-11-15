<?php

namespace Modules\Zoom\Http\Controllers;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Modules\Zoom\Entities\ZoomSetting;

class SettingController extends Controller
{
    public function settings()
    {
        $setting = ZoomSetting::where('user_id', Auth::id())->first();
        return view('zoom::settings', compact('setting'));
    }

    public function updateSettings(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        $rules = [
            'zoom_account_id' => 'required',
            'zoom_client_id' => 'required',
            'zoom_client_secret' => 'required',
        ];
        $this->validate($request, $rules, validationMessage($rules));

        try {
            ZoomSetting::updateOrCreate([
                'user_id' => Auth::id() ?? 1,
            ], [
                'user_id' => Auth::id() ?? 1,
                'package_id' => $request['package_id'] ??1,
                'host_video' => $request['host_video'] ??0,
                'participant_video' => $request['participant_video']??0,
                'join_before_host' => $request['join_before_host']??0,
                'audio' => $request['audio']??'both',
                'auto_recording' => $request['auto_recording']??'none',
                'approval_type' => $request['approval_type']??0,
                'mute_upon_entry' => $request['mute_upon_entry']??0,
                'waiting_room' => $request['waiting_room']??0,
                'zoom_account_id' => $request['zoom_account_id'],
                'zoom_client_id' => $request['zoom_client_id'],
                'zoom_client_secret' => $request['zoom_client_secret'],
            ]);

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

}
