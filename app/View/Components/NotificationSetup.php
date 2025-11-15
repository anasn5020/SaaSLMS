<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;
use Modules\NotificationSetup\Entities\RoleEmailTemplate;
use Modules\NotificationSetup\Entities\UserNotificationSetup;

class NotificationSetup extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {

        $templates = RoleEmailTemplate::where('role_id', Auth::user()->role_id)->where('status', 1)->with('template')->get();
        $user_notification_setup = UserNotificationSetup::where('user_id', Auth::user()->id)->first();

        if ($user_notification_setup) {
            $email_ids = explode(',', $user_notification_setup->email_ids);
            $browser_ids = explode(',', $user_notification_setup->browser_ids);
            $sms_ids = explode(',', $user_notification_setup->sms_ids);

        } else {
            $email_ids = [];
            $browser_ids = [];
            $sms_ids = [];

        }
        return view(theme('components.notification-setup'), compact('templates', 'user_notification_setup', 'email_ids', 'browser_ids', 'sms_ids'));
    }
}
