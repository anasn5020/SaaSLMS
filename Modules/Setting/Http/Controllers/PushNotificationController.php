<?php

namespace Modules\Setting\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\PushNotificationJob;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Modules\StudentSetting\Entities\Institute;


class PushNotificationController extends Controller
{
    public function pushNotification()
    {
        $institutes = Institute::where('status',1)->get();
        return view('setting::push-notification',compact('institutes'));
    }


    public function pushNotificationSubmit(Request $request)
    {
        $system_lang = Settings('language_code') ?? 'en';

        if (isModuleActive('FrontendMultiLang') && $request->language_based != 1) {
            $rules = [
                'title.' . $system_lang => 'required|max:255',
                'details.' . $system_lang => 'required',
            ];

            $this->validate($request, $rules, validationMessage($rules));
        }


        $users = User::where('role_id', 3)
            ->whereNotNull('device_token')
            ->where('status', 1)
            ->when($request->institute_id, function ($q) use ($request) {
                return $q->where('institute_id', $request->institute_id);
            })
            ->get();
        foreach ($users as $user) {
            if ($request->language_based == 1) {
                if (!isset($request->title[$user->language_code]) || empty($request->title[$user->language_code])) {
                    continue;
                }
            }
            PushNotificationJob::dispatch($this->validInput($request->title, $user->language_code), $this->validInput($request->details, $user->language_code), $user->device_token);
        }

        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }

    private function validInput($input, $lang)
    {
        $system_lang = Settings('language_code') ?? 'en';
        if (isset($input[$lang])) {
            return $input[$lang];
        } else {
            return $input[$system_lang];
        }
    }
}
