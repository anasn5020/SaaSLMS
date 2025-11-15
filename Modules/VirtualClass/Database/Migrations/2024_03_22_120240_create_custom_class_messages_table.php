<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomClassMessagesTable extends Migration
{
    public function up()
    {
        Schema::create('custom_class_messages', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->default(0);
            $table->integer('class_id')->nullable();
            $table->text('msg')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('custom_class_messages');
    }
}
