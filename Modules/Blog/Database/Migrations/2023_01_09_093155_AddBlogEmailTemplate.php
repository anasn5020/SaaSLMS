<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\SystemSetting\Entities\EmailTemplate;

class AddBlogEmailTemplate extends Migration
{
    public function up()
    {
        $template = EmailTemplate::where('act', 'BLOG_PUBLISH')->first();
        if (!$template) {
            $template = new EmailTemplate();
            $template->act = 'BLOG_PUBLISH';
        }
        $shortCode = '{"name":"Student/Instructor/Specific User Name","title":"Title","link":"Link"}';
        if (isModuleActive('Org')) {
            $subject = 'News announcement';
        } else {
            $subject = 'New Blog publish';
        }


        $br = "<br/>";
        $body = "Hello,: {{name}} " . $br . "You have a news: {{title}} " . $br . "Click Here to see detail: {{link}}," . "{{footer}}";
        $template->name = $subject;
        $template->subj = $subject;
        $template->shortcodes = $shortCode;
        $template->status = 1;

        $template->email_body = htmlPart($subject, $body);
        $template->save();

        DB::table('role_email_templates')
            ->where('template_act', 'BLOG_PUBLISH')
            ->where('role_id', 3,)
            ->updateOrInsert([
                'template_act' => 'BLOG_PUBLISH',
                'role_id' => 3,
                'status' => 1,
            ]);

        DB::table('role_email_templates')
            ->where('template_act', 'BLOG_PUBLISH')
            ->where('role_id', 2,)
            ->updateOrInsert([
                'template_act' => 'BLOG_PUBLISH',
                'role_id' => 2,
                'status' => 1,
            ]);
    }

    public function down()
    {
        //
    }
}
