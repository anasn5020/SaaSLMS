<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_meetings', function (Blueprint $table) {
            $table->id();
            $table->integer('created_by')->nullable()->default(1);
            $table->integer('instructor_id')->nullable()->default(1);
            $table->integer('class_id')->nullable();
            $table->text('topic')->nullable();
            $table->text('description')->nullable();
            $table->double('duration')->default(0)->nullable();
            $table->text('date')->nullable();
            $table->text('host')->nullable();
            $table->text('link')->nullable();
            $table->text('time')->nullable();
            $table->text('datetime')->nullable();
            $table->text('datetime_utc')->nullable();
            $table->integer('lms_id')->default(1);
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
        Schema::dropIfExists('custom_meetings');
    }
}
