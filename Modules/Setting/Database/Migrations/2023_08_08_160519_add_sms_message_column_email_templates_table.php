<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSmsMessageColumnEmailTemplatesTable extends Migration
{
    public function up()
    {
        Schema::table('email_templates', function (Blueprint $table) {
            if (!Schema::hasColumn("email_templates", 'sms_message')) {
                $table->mediumText('sms_message')->nullable();
            }
        });
    }


    public function down()
    {
        Schema::table('email_templates', function (Blueprint $table) {
            if (Schema::hasColumn("email_templates", 'sms_message')) {
                $table->dropColumn('sms_message');
            }
        });
    }
}
