<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCourseSettingTableRatingColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courses', function ($table) {
            if (!Schema::hasColumn('courses', 'total_rating')) {
                $table->integer('total_rating')->default(0);;
            }
        });

        //add column in review page
        Schema::table('course_reveiws', function ($table) {
            if (!Schema::hasColumn('course_reveiws', 'instructor_id')) {
                $table->integer('instructor_id',)->nullable();;
            }
        });

        $courses = \Modules\CourseSetting\Entities\Course::all();
        foreach ($courses as $course) {

            $all = \Modules\CourseSetting\Entities\CourseReveiw::where('course_id', $course->id)->where('status', 1)->get();
            $ratings = 0;
            foreach ($all as $data) {
                $ratings = $data->star + $ratings;
                $data->instructor_id = $course->user_id;
                $data->save();
            }
            if (count($all) != 0) {
                $avg = ($ratings / count($all));
            } else {
                $avg = 0;
            }
            if ($avg - floor($avg) > 0) {
                $rate = number_format($avg, 1);
            } else {
                $rate = number_format($avg, 0);
            }
            $course->total_rating = $rate;
            $course->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
