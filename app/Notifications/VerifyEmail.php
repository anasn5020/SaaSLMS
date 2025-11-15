<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Modules\SystemSetting\Entities\EmailSetting;
use Modules\SystemSetting\Entities\EmailTemplate;

class VerifyEmail extends Notification
{
    /**
     * The callback that should be used to build the mail message.
     *
     * @var \Closure|null
     */
    public static $toMailCallback;

    /**
     * Get the notification's channels.
     *
     * @param mixed $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */

    public function toMail($notifiable)
    {
        try {
            $verificationUrl = $this->verificationUrl($notifiable);

            if (static::$toMailCallback) {
                return call_user_func(static::$toMailCallback, $notifiable, $verificationUrl);
            }
            $tamplate = EmailTemplate::where('act', 'Email_Verification')->first();
            $subject = $tamplate->subj;
            $body = $tamplate->email_body;


            $key = ['http://{{link}}', '{{link}}', '{{app_name}}'];
            $value = [$verificationUrl, $verificationUrl, Settings('site_title')];
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
                $sendgrid->send($emailSendGrid);

            }
            return (new MailMessage)
                ->view('partials.email', ["body" => $body])->subject($subject);
        }catch (\Exception $exception){
            Log::error($exception->getMessage());
        }
    }


    /**
     * Get the verification URL for the given notifiable.
     *
     * @param mixed $notifiable
     * @return string
     */
    protected function verificationUrl($notifiable)
    {

        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }

    /**
     * Set a callback that should be used when building the notification mail message.
     *
     * @param \Closure $callback
     * @return void
     */
    public static function toMailUsing($callback)
    {
        static::$toMailCallback = $callback;
    }

}
