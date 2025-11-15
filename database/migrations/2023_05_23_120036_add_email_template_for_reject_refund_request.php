<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\SystemSetting\Entities\EmailTemplate;

class AddEmailTemplateForRejectRefundRequest extends Migration
{
    public function up()
    {
        $template = EmailTemplate::where('act', 'REFUND_REJECT')->first();
        if (!$template) {
            $template = new EmailTemplate();
            $template->act = 'REFUND_REJECT';
        }
        $shortCode = '{"name":"Student Name","course":"Course","date":" Date" ,"reason":"Reason"}';


        $subject = 'Refund Request Rejected';


        $br = "<br/>";

        $body = "Hello,: {{name}} "
            . $br . "Admin rejected your refund request {{course}}  because of {{reason}}  at {{date}} ."
            . "{{footer}}";
        $template->name = $subject;
        $template->subj = $subject;
        $template->shortcodes = $shortCode;
        $template->status = 1;

        $template->email_body = htmlPart($subject, $body);
        $template->save();


        DB::table('role_email_templates')
            ->where('template_act', 'REFUND_REJECT')
            ->where('role_id', 3,)
            ->updateOrInsert([
                'template_act' => 'REFUND_REJECT',
                'role_id' => 3,
                'status' => 1,
            ]);


    }

    public function down()
    {

    }
}
