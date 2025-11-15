<?php

use Illuminate\Database\Migrations\Migration;
use Modules\NotificationSetup\Entities\RoleEmailTemplate;
use Modules\SystemSetting\Entities\EmailTemplate;

class UpdateRoleNotification2 extends Migration
{
    public function up()
    {
        $codes =[
            'Bank_Payment'=>'{"amount":"Request Amount","currency":"Currency Code","time":"Balance Added Time"}',
            'Course_Enroll_Payment'=>'{"time":"Enroll  Time","course":"Course Title","price":"Course Purchase Price","currency":"Currency Symbol","instructor":"Course Instructor Name","gateway":"Payment Method"}',
            'Enroll_notify_Instructor'=>'{"time":"Enroll Time","course":"Course Title","price":"Purchase Price","currency":"Currency Symbol","rev":"Instructor Revenue"}',
            'POSTED_NOTIFICATION'=>'{"name":"Student/Instructor/Specific User Name","title":"Notification title","message":"Notification Message"}'
        ];

        foreach ($codes as $key => $value) {
            EmailTemplate::where('act',$key)->update([
                'shortcodes'=>$value
            ]);
        }


        RoleEmailTemplate::where('template_act', 'QUIZ_RESULT_TEMPLATE')->delete();
        $roles = [2, 3];
        foreach ($roles as $role) {
            $temps =[
                'QUIZ_RESULT_TEMPLATE',
                'Complete_Course',
                'Deduct_Payment',
                'Account_Deletion'
            ];
            foreach ($temps as $temp){
                RoleEmailTemplate::create([
                    'template_act' => $temp,
                    'role_id' => $role,
                ]);
            }
        }
    }

    public function down()
    {
        //
    }
}
