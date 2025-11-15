<?php

use Illuminate\Database\Migrations\Migration;
use Modules\SystemSetting\Entities\EmailTemplate;
use Modules\NotificationSetup\Entities\RoleEmailTemplate;

class UpdateEmailTemplateForQuiz extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        //Publish Quiz

        $Quiz_Publish_Successfully = new  EmailTemplate();
        $Quiz_Publish_Successfully->act = 'Quiz_Publish_Successfully';
        $Quiz_Publish_Successfully->name = 'Quiz Publish Successfully';
        $Quiz_Publish_Successfully->subj = 'Quiz Publish Successfully';
        $Quiz_Publish_Successfully->shortcodes = '{"time":"Publish Time","quiz":"Quiz" }';

        $body = '{{quiz}} publish successfully at {{time}}.';
        $Quiz_Publish_Successfully->email_body = htmlPart($Quiz_Publish_Successfully->subj, $body);

        $Quiz_Publish_Successfully->save();

        //Unpublished Quiz

        $Quiz_Unpublished = new  EmailTemplate();
        $Quiz_Unpublished->act = 'Quiz_Unpublished';
        $Quiz_Unpublished->name = 'Quiz Unpublished';
        $Quiz_Unpublished->subj = 'Quiz Unpublished';
        $Quiz_Unpublished->shortcodes = '{"time":"Unpublished Time","quiz":"Quiz" }';

        $body = '{{quiz}} Unpublished at {{time}}.';
        $Quiz_Unpublished->email_body = htmlPart($Quiz_Unpublished->subj, $body);

        $Quiz_Unpublished->save();


        //Assign email template to role

        RoleEmailTemplate::insert([
            [
                'role_id' => 1,
                'template_act' => 'Quiz_Publish_Successfully'
            ],
            [
                'role_id' => 1,
                'template_act' => 'Quiz_Unpublished'
            ],
            [
                'role_id' => 2,
                'template_act' => 'Quiz_Publish_Successfully'
            ],
            [
                'role_id' => 2,
                'template_act' => 'Quiz_Unpublished'
            ],
            [
                'role_id' => 3,
                'template_act' => 'Quiz_Publish_Successfully'
            ],
            [
                'role_id' => 3,
                'template_act' => 'Quiz_Unpublished'
            ],
            [
                'role_id' => 4,
                'template_act' => 'Quiz_Publish_Successfully'
            ],
            [
                'role_id' => 4,
                'template_act' => 'Quiz_Unpublished'
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
