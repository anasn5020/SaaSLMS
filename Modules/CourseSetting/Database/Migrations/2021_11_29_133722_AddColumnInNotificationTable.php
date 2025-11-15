<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnInNotificationTable extends Migration
{

    public function up()
    {

        Schema::dropIfExists('notifications');

        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type')->nullable();
//            $table->morphs('notifiable');
            $table->unsignedInteger("notifiable_id");
            $table->string("notifiable_type");
            $table->index(["notifiable_id", "notifiable_type"]);

            $table->text('data')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->integer('course_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('author_id')->nullable();
            $table->integer('message_id')->nullable();
            $table->integer('course_comment_id')->nullable();
            $table->integer('course_review_id')->nullable();
            $table->integer('course_enrolled_id')->nullable();
            $table->boolean('status')->default(0)->nullable();
            $table->timestamps();
        });


    }


    public function down()
    {
        //
    }
}
