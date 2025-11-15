<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\SystemSetting\Entities\EmailTemplate;

return new class extends Migration
{
    public function up(): void
    {
        $br = "<br/>";

        $templates =[
           [
               'act'=>'BlogPostApproval',
               'subject'=>'New Blog Post Pending Approval',
               'body'=>'Hello {{name}},' . $br .
                   ' A new blog post titled <strong>{{blog_title}}</strong> has been submitted and is waiting for your approval '. $br .
               'Post By: {{blog_author}}' . $br .
               'Post Date: {{blog_date}}'. $br,
               'shortcodes' => '{"name":"Admin Name","blog_title":"Blog Post Title","blog_author":"Blog Post Author","blog_date":"Blog Post Date"}',

           ],[
               'act'=>'BankDepositRequest',
               'subject'=>'Bank Payment Request for Deposit',
               'body'=>'Hello {{name}},' . $br .
                   'A request to add funds has been received with the following details: '. $br .
               'Amount: {{amount}}' . $br .
               'Date: {{date}}'. $br.
               'Request By: {{request_by}}'. $br,
               'shortcodes' => '{"name":"Admin Name","amount":"Amount","date":"Date","request_by":"Request By"}',

           ],
        ];

        foreach ($templates as $template) {
            EmailTemplate::insert([
                'act' => $template['act'],
                'name' => $template['subject'],
                'subj' => $template['subject'],
                'email_body' => htmlPart($template['subject'], $template['body']),
                'shortcodes' => $template['shortcodes'],
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::table('role_email_templates')
                ->where('template_act', $template['act'])
                ->updateOrInsert([
                    'template_act' => $template['act'],
                    'role_id' => 1,
                    'status' => 1,
                ]);
        }


    }

    public function down(): void
    {
        //
    }
};
