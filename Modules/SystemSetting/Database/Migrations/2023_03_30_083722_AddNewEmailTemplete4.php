<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Modules\SystemSetting\Entities\EmailTemplate;

class AddNewEmailTemplete4 extends Migration
{
    public function up()
    {
        $this->newCourseNotification();
        $this->payoutRequestNotification();
        $this->assignLessonQuiz();
    }

    public function down()
    {
        //
    }


    public function newCourseNotification()
    {
        $subject = 'New Course Created';
        $br = "<br/>";
        $body = 'Hello {{admin}}, A New Course ({{course}}) Created By {{instructor}}.  ' . $br . "{{footer}}";

        EmailTemplate::insert([
            'act' => 'NewCourseCreated',
            'name' => $subject,
            'subj' => $subject,
            'email_body' => htmlPart($subject, $body),
            'shortcodes' => '{"admin":"Admin Name","course":"Course Name","instructor":"Instructor Name"}',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function payoutRequestNotification()
    {
        $subject = 'Payout Request';
        $br = "<br/>";
        $body = 'Hello {{admin}}, {{amount}} payout requested by {{instructor}} ' . $br . "{{footer}}";

        EmailTemplate::insert([
            'act' => 'PayoutRequest',
            'name' => $subject,
            'subj' => $subject,
            'email_body' => htmlPart($subject, $body),
            'shortcodes' => '{"admin":"Admin Name","amount":"Payout Requested amount","instructor":"Instructor Name"}',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function assignLessonQuiz()
    {
        $roles = [1, 2, 3];
        foreach ($roles as $role) {
            DB::table('role_email_templates')
                ->updateOrInsert([
                    'template_act' => 'Course_Quiz_Added',
                    'role_id' => $role,
                    'status' => 1,
                ]);
        }


    }


}
