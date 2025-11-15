<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTranslationInEmailTemplete extends Migration
{

    public function up()
    {
        try {
            Schema::table('email_templates', function (Blueprint $table) {
                $table->longText('name')->nullable()->change();
                $table->longText('subj')->nullable()->change();
                $table->longText('email_body')->nullable()->change();
                $table->longText('browser_message')->nullable()->change();
                $table->longText('sms_message')->nullable()->change();
            });

        } catch (\Exception $e) {

        }
    }


    public function down()
    {
        //
    }
}
