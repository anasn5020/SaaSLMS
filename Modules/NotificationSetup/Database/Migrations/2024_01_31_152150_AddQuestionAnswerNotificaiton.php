<?php

use Illuminate\Database\Migrations\Migration;
use Modules\SystemSetting\Entities\EmailTemplate;

class AddQuestionAnswerNotificaiton extends Migration
{
    public function up()
    {
        $br = "<br/>";
        $templates = [
            [
                'act' => 'New_Question',
                'name' => 'New Question Inquiry',
                'subj' => 'New Question Inquiry',
                'shortcodes' => '{"name":"User Name","question":"User Question","date_time":"Date and Time"}',
                'status' => 1,
                'email_body' => "Hello {{name}}, " . $br
                    . $br .
                    "Thank you for reaching out with your question. Your inquiry is important to us, and we appreciate your engagement with our services." . $br
                    . "Question Details:" . $br
                    . "Question: {{question}}" . $br
                    . "Date and Time: {{date_time}}" . $br
                    . $br
                    . "Our team will review your question and provide a detailed response as soon as possible. If you have any additional information to add, please reply to this email." . $br
                    . $br
                    . "Thank you for your patience." . $br
                    . "{{footer}}"
            ],
            [
                'act' => 'New_Question_Reply',
                'name' => 'Question Reply',
                'subj' => 'Question Reply',
                'shortcodes' => '{"name":"User Name","question":"User Question","reply":"Answer","date_time":"Date and Time"}',
                'status' => 1,
                'email_body' => "Hello {{name}}, " . $br
                    . $br .
                    "Thank you for your question. We appreciate your engagement with our services." . $br
                    . "Your Question:" . $br
                    . "{{question}}" . $br
                    . $br
                    . "Our Response:" . $br
                    . "{{reply}}" . $br
                    . "Date and Time: {{date_time}}" . $br
                    . $br
                    . "If you have any further questions or need additional assistance, please feel free to reach out. We're here to help!" . $br
                    . $br
                    . "Thank you for choosing our services." . $br
                    . "{{footer}}"
            ],
        ];
        EmailTemplate::unguard();
        foreach ($templates as $key => $template) {
            EmailTemplate::updateOrCreate([
                'act' => $template['act'],
            ], $template);
        }
    }

    public function down()
    {
        //
    }
}
