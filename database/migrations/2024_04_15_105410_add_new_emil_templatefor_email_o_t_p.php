<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Modules\SystemSetting\Entities\EmailTemplate;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $subject = 'Send Email Verification OTP Notification';
        $br = "<br/>";
        $body = 'Hello {{name}}, Your otp Code is {{otp}} ' . $br . "{{footer}}";

        EmailTemplate::insert([
            'act' => 'EmailVerificationOTP',
            'name' => 'Send Email Verification OTP Notification',
            'subj' => 'Email Verification OTP Notification',
            'email_body' => htmlPart($subject, $body),
            'shortcodes' => '{"otp":"OTP Code","email":"Email Address","name":"Name"}',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('role_email_templates')
            ->where('template_act', 'EmailVerificationOTP')
            ->updateOrInsert([
                'template_act' => 'EmailVerificationOTP',
                'role_id' => 3,
                'status' => 1,
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
