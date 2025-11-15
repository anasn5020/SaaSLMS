<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\SystemSetting\Entities\EmailTemplate;

class AddNewEmailTemplate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $offline_enrolled_template = EmailTemplate::where('act', 'Offline_Enrolled')->first();
        if (!$offline_enrolled_template) {
            $offline_enrolled_template = new EmailTemplate();
            $offline_enrolled_template->act = 'Offline_Enrolled';
        }
        $shortCode = '{"email":"Email Address","password":"Password"}';
        $subject = 'Login Credentials';
        $br = "<br/>";
        $body = ' Please login to ' . url('/') . ' with email {{email}} and password {{password}} ' . $br . "{{footer}}";
        $offline_enrolled_template->name = $subject;
        $offline_enrolled_template->subj = $subject;
        $offline_enrolled_template->shortcodes = $shortCode;
        $offline_enrolled_template->status = 1;

        $offline_enrolled_template->email_body = $this->htmlPart($subject, $body);
        $offline_enrolled_template->save();


        $course_assignment_template = EmailTemplate::where('act', 'Course_Assignment_Added')->first();
        if (!$course_assignment_template) {
            $course_assignment_template = new EmailTemplate();
            $course_assignment_template->act = 'Course_Assignment_Added';
        }
        $shortCode = '{"time":"Publish Time","course":"Course","chapter":"Chapter Name","assignment":"Assignment Title"}';
        $subject = 'Course Assignment Added';

        $body = ' {{assignment}} Assignment added under {{chapter}} chapter of  {{course}} at  {{time}}. {{footer}}  ';
        $course_assignment_template->name = $subject;
        $course_assignment_template->subj = $subject;
        $course_assignment_template->shortcodes = $shortCode;
        $course_assignment_template->status = 1;

        $course_assignment_template->email_body = $this->htmlPart($subject, $body);
        $course_assignment_template->save();

        $course_assignment_template = EmailTemplate::where('act', 'Student_Submit_Assignment')->first();
        if (!$course_assignment_template) {
            $course_assignment_template = new EmailTemplate();
            $course_assignment_template->act = 'Student_Submit_Assignment';
        }
        $shortCode = '{"time":"Submit Time","student":"Student Name","assignment":"Assignment Title"}';
        $subject = 'Student Assignment Submitted';

        $body = ' {{student}} Submitted assignment  {{assignment}} at  {{time}}. {{footer}}  ';
        $course_assignment_template->name = $subject;
        $course_assignment_template->subj = $subject;
        $course_assignment_template->shortcodes = $shortCode;
        $course_assignment_template->status = 1;

        $course_assignment_template->email_body = $this->htmlPart($subject, $body);
        $course_assignment_template->save();

        $course_assignment_template = EmailTemplate::where('act', 'Teacher_Marked_Assignment')->first();
        if (!$course_assignment_template) {
            $course_assignment_template = new EmailTemplate();
            $course_assignment_template->act = 'Teacher_Marked_Assignment';
        }
        $shortCode = '{"time":"Marking Time","marks":"Marks","status":"Pass or Fail","assignment":"Assignment Title"}';
        $subject = 'Teacher Marked on Assignment';

        $body = ' You have obtain {{marks}} Marks on {{assignment}} assignment. Result is  {{status}}. Marked time {{time}}. {{footer}}  ';
        $course_assignment_template->name = $subject;
        $course_assignment_template->subj = $subject;
        $course_assignment_template->shortcodes = $shortCode;
        $course_assignment_template->status = 1;

        $course_assignment_template->email_body = $this->htmlPart($subject, $body);
        $course_assignment_template->save();


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
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
}
