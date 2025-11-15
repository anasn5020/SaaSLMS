<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSmsIdsColumnToUserNotificationsTable extends Migration
{
    public function up()
    {
        Schema::table('user_notification_setups', function (Blueprint $table) {
            if (!Schema::hasColumn("user_notification_setups", 'sms_ids')) {
                $table->text('sms_ids')->nullable();
            }
        });
    }


    public function down()
    {
        Schema::table('user_notification_setups', function (Blueprint $table) {
            if (Schema::hasColumn("user_notification_setups", 'sms_ids')) {
                $table->dropColumn('sms_ids');
            }
        });
    }
}
