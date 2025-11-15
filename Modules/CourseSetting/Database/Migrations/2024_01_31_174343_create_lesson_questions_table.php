<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonQuestionsTable extends Migration
{

    public function up()
    {
        Schema::create('lesson_questions', function (Blueprint $table) {
            $table->id();
            $table->text('text')->nullable();
            $table->bigInteger('parent_id')->default(0);
            $table->tinyInteger('status')->default(1)->comment('0=draft, 1=publish');
            $table->tinyInteger('replied')->default(0)->comment('0=not replied, 1=replied');
            $table->bigInteger('course_id')->unsigned();
            $table->bigInteger('lesson_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lesson_questions');
    }
}
