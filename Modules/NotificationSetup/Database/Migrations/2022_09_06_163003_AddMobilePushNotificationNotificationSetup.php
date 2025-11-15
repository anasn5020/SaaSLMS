<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMobilePushNotificationNotificationSetup extends Migration
{
    public function up()
    {
        Schema::table('user_notification_setups', function ($table) {
            if (!Schema::hasColumn('user_notification_setups', 'mobile_ids')) {
                $table->text('mobile_ids')->nullable();
            }
        });
    }

    public function down()
    {
        //
    }
}
