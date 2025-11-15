<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTotalUserInPostedNotification extends Migration
{

    public function up()
    {
        Schema::table('posted_notifications', function (Blueprint $table) {
            if (!Schema::hasColumn("posted_notifications", 'total_users')) {
                $table->integer('total_users')->nullable()->default(0);
            }
        });
    }


    public function down()
    {
        //
    }
}
