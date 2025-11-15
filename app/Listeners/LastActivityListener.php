<?php

namespace App\Listeners;

use App\Events\LastActivityEvent;
use App\Http\Controllers\Auth\LoginController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class LastActivityListener
{

    public function __construct()
    {
        //
    }


    public function handle(LastActivityEvent $event)
    {


        $user = Auth::user();

        $time = (int)Settings('device_limit_time');
        $last_activity = $user->last_activity_at;
        if ($time != 0) {
            if (!empty($last_activity)) {
                $valid_activity = Carbon::parse($last_activity)->addMinutes($time);
                $current_time = Carbon::now();
                if ($current_time->lt($valid_activity)) {
//                    Toastr::success('in');
                } else {
//                    Toastr::error('out');
                    $loginController = new LoginController();
                    $loginController->logout(request());

                }
            }
        }

        $user->last_activity_at = now();
        $user->save();
    }

}
