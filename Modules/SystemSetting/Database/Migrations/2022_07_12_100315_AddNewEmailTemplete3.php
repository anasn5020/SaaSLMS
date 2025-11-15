<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\SystemSetting\Entities\EmailTemplate;

class AddNewEmailTemplete3 extends Migration
{
    public function up()
    {
        $subject = 'Send Reset OTP Notification';
        $br = "<br/>";
        $body = 'Hello {{name}}, Your otp Code is {{otp}} ' . $br . "{{footer}}";

        EmailTemplate::insert([
            'act' => 'ResetOTP',
            'name' => 'Send Reset OTP Notification',
            'subj' => 'Send Reset OTP Notification',
            'email_body' => htmlPart($subject, $body),
            'shortcodes' => '{"otp":"OTP Code","email":"Email Address","name":"Name"}',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('role_email_templates')
            ->where('template_act', 'ResetOTP')
            ->updateOrInsert([
                'template_act' => 'ResetOTP',
                'role_id' => 3,
                'status' => 1,
            ]);
    }

    public function down()
    {
        //
    }
}
