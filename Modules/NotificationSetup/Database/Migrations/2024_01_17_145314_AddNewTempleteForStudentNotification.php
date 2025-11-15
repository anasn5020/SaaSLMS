<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Modules\SystemSetting\Entities\EmailTemplate;

class AddNewTempleteForStudentNotification extends Migration
{
    public function up()
    {

        $br = "<br/>";
        $templates = [
            [
                'act' => 'Payment_Done',
                'name' => 'Payment Confirmation',
                'subj' => 'Payment Confirmation',
                'shortcodes' => '{"name":"User Name","amount":"Amount","txn_id":"Txn ID","payment_date_time":"Payment Date & Time"}',
                'status' => 1,
                'email_body' => "Hello {{name}}, " . $br
                    . $br .
                    "We are pleased to inform you that your payment of {{amount}} has been successfully processed. " . $br
                    . "Transaction details are as follows:" . $br
                    . "Transaction ID: {{txn_id}}" . $br
                    . "Payment Date: {{payment_date}}" . $br
                    . $br
                    . "Thank you for choosing our services. If you have any questions or concerns, please feel free to contact us." . $br

            ],
            [
                'act' => 'Account_Deletion',
                'name' => 'Account Deletion Confirmation',
                'subj' => 'Account Deletion Confirmation',
                'shortcodes' => '{"name":"User Name"}',
                'status' => 1,
                'email_body' => "Hello {{name}}, " . $br
                    . $br .
                    "We regret to inform you that your account has been successfully deleted as per your request. " . $br
                    . "If you have any feedback or would like to provide reasons for your decision, please feel free to reply to this email." . $br
                    . $br
                    . "Thank you for being a part of our community. Should you decide to return in the future, we would be more than happy to assist you." . $br
             ], [
                'act' => 'Deposit_Unsuccessful',
                'name' => 'Deposit Unsuccessful Notification',
                'subj' => 'Deposit Unsuccessful',
                'shortcodes' => '{"name":"User Name","amount":"Amount","date_time":"Date and Time"}',
                'status' => 1,
                'email_body' => "Hello {{name}}, " . $br
                    . $br .
                    "We regret to inform you that your recent attempt to deposit {{amount}} into your account was unsuccessful. " . $br
                    . "Amount: {{amount}}" . $br
                    . "Date and Time: {{date_time}}" . $br
                    . $br
                    . "If you require further assistance or have any questions, please contact our customer support team." . $br
             ],
            [
                'act' => 'Deposit_Successful',
                'name' => 'Deposit Successful Confirmation',
                'subj' => 'Deposit Successful',
                'shortcodes' => '{"name":"User Name","amount":"Amount","date_time":"Date and Time"}',
                'status' => 1,
                'email_body' => "Hello {{name}}, " . $br
                    . $br .
                    "We are pleased to inform you that your recent deposit of {{amount}} into your account has been successfully processed. " . $br
                    . "Date and Time: {{date_time}}" . $br
                    . $br
                    . "If you have any questions or concerns, please do not hesitate to contact our customer support team." . $br
             ],
            [
                'act' => 'Wallet_Credited',
                'name' => 'Wallet Credited',
                'subj' => 'Wallet Credited',
                'shortcodes' => '{"name":"User Name","amount":"Amount","date_time":"Date and Time"}',
                'status' => 1,
                'email_body' => "Hello {{name}}, " . $br
                    . $br .
                    "Good news! Your wallet has been credited with {{amount}}. " . $br
                    . "This transaction was processed on {{date_time}}." . $br
                    . $br
                    . "If you have any inquiries or require assistance, please feel free to reach out to our customer support team." . $br
             ],
        ];
        EmailTemplate::unguard();
        foreach ($templates as $key => $template) {
            EmailTemplate::updateOrCreate([
                'act' => $template['act'],
            ], $template);

            DB::table('role_email_templates')
                ->where('template_act', $template['act'])
                ->where('role_id', 3,)
                ->updateOrInsert([
                    'template_act' => $template['act'],
                    'role_id' => 3,
                    'status' => 1,
                ]);
        }
    }

    public function down()
    {
        //
    }
}
