<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\SystemSetting\Entities\EmailTemplate;

class AddDeductBalanceColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('offline_payments', function ($table) {
            if (!Schema::hasColumn('offline_payments', 'type')) {
                $table->string('type')->default('Add');
            }
        });

        EmailTemplate::withoutEvents(function () {
            $template = EmailTemplate::where('act', 'Deduct_Payment')->first();
            if (!$template) {
                $template = new EmailTemplate();
                $template->act = 'Deduct_Payment';
            }

            $shortCode = '{"amount":"Amount","time":"Deduct Time"}';
            $subject = 'Deduct Amount From Fund';
            $br = "<br/>";
            $body = "{{amount}} has deduct successfully from your fund at {{time}} By Admin.";
            $template->name = $subject;
            $template->subj = $subject;
            $template->shortcodes = $shortCode;
            $template->status = 1;

            $template->email_body = htmlPart($subject, $body);
            $template->save();

        });

        DB::table('role_email_templates')->insert([
            [
                'role_id' => 3,
                'template_act' => 'Deduct_Payment',
                'status' => 1,
            ], [
                'role_id' => 2,
                'template_act' => 'Deduct_Payment',
                'status' => 1,
            ]
        ]);
//
//        DB::statement("INSERT INTO `role_email_templates` (`role_id`, `template_act`, `created_at`, `updated_at`) VALUE
//                        (3,'Deduct_Payment', now(), now()),(2,'Deduct_Payment', now(), now())");

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
