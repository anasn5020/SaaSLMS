<?php

use Illuminate\Database\Migrations\Migration;
use Modules\SystemSetting\Entities\EmailTemplate;

class AddNewEmailTemplete2 extends Migration
{

    public function up()
    {
//        $template = EmailTemplate::where('act', 'Enroll_notify_Student')->first();
//        if (!$template) {
//            $template = new EmailTemplate();
//            $template->act = 'Enroll_notify_Student';
//        }
//
//        $shortCode = '{"time":"Enroll Time","course":"Course Title","price":"Purchase Price"}';
//        $subject = 'New Enroll Notification';
//        $br = "<br/>";
//        $body = "Subject: {{subject}} " . $br . "{{course}} have new enrolled at  {{time}}. Purchase price {{price}}" . $br . "{{footer}}";
//        $template->name = $subject;
//        $template->subj = $subject;
//        $template->shortcodes = $shortCode;
//        $template->status = 1;
//
//        $template->email_body = $this->htmlPart($subject, $body);
//        $template->save();
//------------------------------

        $template = EmailTemplate::where('act', 'Complete_Course')->first();
        if (!$template) {
            $template = new EmailTemplate();
            $template->act = 'Complete_Course';
        }

        $shortCode = '{"course":"Course Title","time":"Complete Time"}';
        $subject = 'Course Complete Notification';
        $br = "<br/>";
        $body = "Subject: {{subject}} " . $br . "{{course}} has complete successfully at  {{time}}. Purchase price {{price}}" . $br . "{{footer}}";
        $template->name = $subject;
        $template->subj = $subject;
        $template->shortcodes = $shortCode;
        $template->status = 1;

        $template->email_body = $this->htmlPart($subject, $body);
        $template->save();
//------------------------------

        $template = EmailTemplate::where('act', 'New_Student_Reg')->first();
        if (!$template) {
            $template = new EmailTemplate();
            $template->act = 'New_Student_Reg';
        }

        $shortCode = '{"name":"Student Name","time":"Registration Time"}';
        $subject = 'New Registration Notification';
         $body =   "{{name}} has registration successfully  at  {{time}}.";
        $template->name = $subject;
        $template->subj = $subject;
        $template->shortcodes = $shortCode;
        $template->status = 1;

        $template->email_body = $this->htmlPart($subject, $body);
        $template->save();
    }

    public function htmlPart($subject, $body)
    {
        $html = '
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
<style>

     .social_links {
        background: #F4F4F8;
        padding: 15px;
        margin: 30px 0 30px 0;
    }

    .social_links a {
        display: inline-block;
        font-size: 15px;
        color: #252B33;
        padding: 5px;
    }


</style>

<div class="">
<div style="color: rgb(255, 255, 255); font-family: &quot;Open Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; text-align: center; background-color: rgb(65, 80, 148); padding: 30px; border-top-left-radius: 3px; border-top-right-radius: 3px; margin: 0px;"><h1 style="margin: 20px 0px 10px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-weight: 500; line-height: 1.1; color: inherit; font-size: 36px;">
' . $subject . '

</h1></div><div style="color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; padding: 20px;">
<p style="color: rgb(85, 85, 85);"><br></p>
<p style="color: rgb(85, 85, 85);">' . $body . '</p></div>
</div>

<div class="email_invite_wrapper" style="text-align: center">


    <div class="social_links">
        <a href="https://twitter.com/codetheme"> <i class="fab fa-facebook-f"></i> </a>
        <a href="https://codecanyon.net/user/codethemes/portfolio"><i class="fas fa-code"></i> </a>
        <a href="https://twitter.com/codetheme" target="_blank"> <i class="fab fa-twitter"></i> </a>
        <a href="https://dribbble.com/codethemes"> <i class="fab fa-dribbble"></i></a>
    </div>
</div>

';
        return $html;
    }

    public function down()
    {
        //
    }
}
