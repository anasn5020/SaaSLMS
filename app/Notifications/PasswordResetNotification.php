<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Auth;
use Modules\SystemSetting\Entities\EmailSetting;
use Modules\SystemSetting\Entities\EmailTemplate;

class PasswordResetNotification extends ResetPassword
{
    use Queueable;

    public $token;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $this->token);
        }

        if (Auth::check()) {
            $user = Auth::user();
            $lang = $user->language_code ?? 'en';
        } else {
            if (session()->get('locale')) {
                $lang = session()->get('locale') ?? 'en';
            } else {
                $lang = Settings('language_code') ?? 'en';
            }
        }

        app()->setLocale($lang);

        $tamplate = EmailTemplate::where('act', 'Reset_Password')->first();
        $subject = $tamplate->subj;
        $body = $tamplate->email_body;


        $key = ['http://{{reset_link}}', '{{reset_link}}', '{{app_name}}'];
        $value = [route('password.reset', $this->token), route('password.reset', $this->token), Settings('site_title')];
        $body = str_replace($key, $value, $body);

        $config = EmailSetting::where('active_status', 1)->first();
        if ($config && $config->email_engine_type == 'sendgrid') {
            $email = !empty($notifiable->email) ? $notifiable->email : Auth::user()->email;
            $emailSendGrid = new \SendGrid\Mail\Mail();
            $emailSendGrid->setFrom($config->from_email, $config->from_name);
            $emailSendGrid->setSubject($subject);
            $emailSendGrid->addTo($email, $email);
            $emailSendGrid->addContent(
                "text/html", $body
            );
            $sendgrid = new \SendGrid($config->api_key);
            $response = $sendgrid->send($emailSendGrid);
        }
        return (new MailMessage)
            ->view('partials.email', ["body" => $body])->subject($subject);

    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
