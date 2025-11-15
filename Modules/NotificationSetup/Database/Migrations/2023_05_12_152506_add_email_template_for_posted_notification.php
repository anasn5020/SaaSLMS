<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Modules\SystemSetting\Entities\EmailTemplate;

class AddEmailTemplateForPostedNotification extends Migration
{
    public function up()
    {
        $template = EmailTemplate::where('act', 'POSTED_NOTIFICATION')->first();
        if (!$template) {
            $template = new EmailTemplate();
            $template->act = 'POSTED_NOTIFICATION';
        }
        $shortCode = '{"name":"Student/Instructor/Specific User Name","title":"Notification title","message":"Notification Message"}';

        $subject = 'Posted Notification';

        $body = "User Name: {{name}} <br> title: {{title}} <br> message: {{message}}";
        
        $template->name = $subject;
        $template->subj = $subject;
        $template->shortcodes = $shortCode;
        $template->status = 1;

        $template->email_body = htmlPart($subject, $body);
        $template->save();

        DB::table('role_email_templates')
            ->where('template_act', 'BLOG_PUBLISH')
            ->where('role_id', 4,)
            ->updateOrInsert([
                'template_act' => 'POSTED_NOTIFICATION',
                'role_id' => 4,
                'status' => 1,
            ]);

        DB::table('role_email_templates')
            ->where('template_act', 'BLOG_PUBLISH')
            ->where('role_id', 3,)
            ->updateOrInsert([
                'template_act' => 'POSTED_NOTIFICATION',
                'role_id' => 3,
                'status' => 1,
            ]);

        DB::table('role_email_templates')
            ->where('template_act', 'BLOG_PUBLISH')
            ->where('role_id', 2,)
            ->updateOrInsert([
                'template_act' => 'POSTED_NOTIFICATION',
                'role_id' => 2,
                'status' => 1,
            ]);
        DB::table('role_email_templates')
            ->where('template_act', 'BLOG_PUBLISH')
            ->where('role_id', 1,)
            ->updateOrInsert([
                'template_act' => 'POSTED_NOTIFICATION',
                'role_id' => 1,
                'status' => 1,
            ]);
    }

    public function down()
    {

    }
}
