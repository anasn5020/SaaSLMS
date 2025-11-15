<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\SystemSetting\Entities\EmailTemplate;

class AddNewEmailTemplete5 extends Migration
{
    public function up()
    {
        $subject = 'Course Expire Soon';
        $act = 'CourseExpireSoon';
        $br = "<br/>";
        $body = 'Hello {{name}}, {{course}}  will be expire at {{date}} .' . $br . 'Course Link: {{link}}';

        EmailTemplate::insert([
            'act' => $act,
            'name' => $subject,
            'subj' => $subject,
            'email_body' => htmlPart($subject, $body),
            'shortcodes' => '{"name":"Student Name","course":"Course Name","date":"Expire Date","link":"Course Link"}',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('role_email_templates')
            ->where('template_act', $act)
            ->updateOrInsert([
                'template_act' => $act,
                'role_id' => 3,
                'status' => 1,
            ]);
    }

    public function down()
    {
        //
    }
}
