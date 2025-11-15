<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\CourseSetting\Entities\CourseLevel;

class CreateCourseLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_levels', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });

        CourseLevel::withoutEvents(function () {

            CourseLevel::insert([
                [
                    'id' => 1,
                    'title' => 'Beginner'
                ], [
                    'id' => 2,
                    'title' => 'Intermediate'
                ], [
                    'id' => 3,
                    'title' => 'Advance'
                ], [
                    'id' => 4,
                    'title' => 'Pro'
                ],
            ]);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_levels');
    }
}
