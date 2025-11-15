<?php

namespace App\Traits;



use Illuminate\Support\Facades\Mail;

trait SendMail
{
    //for real using purpose
    function sendMail($request)
    {
        $view = 'setting::emails.mail';
        $data = array('name' => saasEnv('MAIL_USERNAME'), 'subject' => "Virat Gandhi", 'content' => $request->content);
        if (Settings('mail_protocol') == "smtp") {
            try {
                Mail::send($view, $data, function ($message) {
                    $message->from(saasEnv('MAIL_USERNAME'), 'John Doe');
                    $message->sender(saasEnv('MAIL_USERNAME'), 'John Doe');
                    $message->to(saasEnv('MAIL_USERNAME'), 'John Doe');
                    $message->cc(saasEnv('MAIL_USERNAME'), 'John Doe');
                    $message->bcc(saasEnv('MAIL_USERNAME'), 'John Doe');
                    $message->replyto(saasEnv('MAIL_USERNAME'), 'John Doe');
                    $message->subject('Subject');
                });
            } catch (\Exception $e) {

            }
        }
    }

    //for testing purpose from backend admin panel
    function sendMailTest($request)
    {


        $view = 'setting::emails.mail';
        $data = array('name' => saasEnv('MAIL_USERNAME'), 'subject' => "Contact Message", 'content' => $request->content);
        if (Settings('mail_protocol') == "smtp") {
            try {
                Mail::send($view, $data, function ($message) {
                    $message->from(saasEnv('MAIL_USERNAME'), 'John Doe');
                    $message->sender(saasEnv('MAIL_USERNAME'), 'John Doe');
                    $message->to(saasEnv('MAIL_USERNAME'), 'John Doe');
                    $message->cc(saasEnv('MAIL_USERNAME'), 'John Doe');
                    $message->bcc(saasEnv('MAIL_USERNAME'), 'John Doe');
                    $message->replyto(saasEnv('MAIL_USERNAME'), 'John Doe');
                    $message->subject('Subject');
                });
            } catch (\Exception $e) {

            }
        }

    }

}
