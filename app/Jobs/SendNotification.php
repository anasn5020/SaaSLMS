<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $template, $user, $shortcodes, $action;

    public function __construct($template, $user, $shortcodes, $action=[])
    {
        $this->template = $template;
        $this->user = $user;
        $this->shortcodes = $shortcodes;
        $this->action = $action;
    }

    public function handle()
    {
        $template = $this->template;
        $user = $this->user;
        $shortcodes = $this->shortcodes;
        $action = $this->action;

        $lang = app()->getLocale();
        app()->setLocale($user->language_code ?? 'en');
        if (UserEmailNotificationSetup($template, $user)) {
            SendGeneralEmail::dispatch($user, $template, $shortcodes);
        }
        if (UserBrowserNotificationSetup($template, $user)) {
            send_browser_notification($user, $template, $shortcodes,
                $action['actionText'] ?? '',
                $action['actionUrl'] ?? '',
                $action['notificationType'] ?? '',
                $action['id'] ?? '',
            );
        }

        if (UserMobileNotificationSetup($template, $user) && !empty($user->device_token)) {
            send_mobile_notification($user, $template, $shortcodes);
        }
        if (UserSmsNotificationSetup($template, $user)) {
            send_sms_notification($user, $template, $shortcodes);
        }

        app()->setLocale($lang);
    }
}
