<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();

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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
