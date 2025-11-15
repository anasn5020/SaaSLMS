<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostedNotificationReceiversTable extends Migration
{
    public function up()
    {
        Schema::create('posted_notification_receivers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('notification_id');
            $table->unsignedBigInteger('receiver_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('posted_notification_receivers');
    }
}
