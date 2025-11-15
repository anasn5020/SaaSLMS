<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\SystemSetting\Entities\EmailTemplate;

class AddBrowserMessageColumnToEmailTemaplteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('email_templates', function ($table) {
            if (!Schema::hasColumn('email_templates', 'browser_message')) {
                $table->text('browser_message')->nullable();
            }
            if (!Schema::hasColumn('email_templates', 'is_system')) {
                $table->integer('is_system')->default(0);
            }
        });

        $system_mail=['PASS_UPDATE','Email_Verification','Reset_Password','Offline_Enrolled'];
        foreach ($system_mail as $key => $mail) {
            $template=EmailTemplate::where('act',$mail)->first();
            $template->is_system=1;
            $template->save();
        }
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
