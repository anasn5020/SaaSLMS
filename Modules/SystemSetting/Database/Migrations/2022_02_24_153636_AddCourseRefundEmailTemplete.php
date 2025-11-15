<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Modules\SystemSetting\Entities\EmailTemplate;

class AddCourseRefundEmailTemplete extends Migration
{

    public function up()
    {

        $subject ='Course Enroll Refund By Admin';
        $body=    'You have enrolled {{course}} on this course . Admin refund your enrollment   at {{time}}';
        EmailTemplate::insert([
            'act' => 'Enroll_Refund',
            'name' => $subject,
            'subj' =>$subject,
            'email_body' =>htmlPart($subject, $body),
            'shortcodes' => '{"course":"Course Name","time":"Refund Time"}',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('role_email_templates')->insert([
            'role_id' => 1,
            'template_act' => 'Enroll_Refund',
            'status' => 1
        ]);

        DB::table('role_email_templates')->insert([
            'role_id' => 2,
            'template_act' => 'Enroll_Refund',
            'status' => 1
        ]);

        DB::table('role_email_templates')->insert([
            'role_id' => 3,
            'template_act' => 'Enroll_Refund',
            'status' => 1
        ]);
    }


    public function down()
    {
        //
    }
}
