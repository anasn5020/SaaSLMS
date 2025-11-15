<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCourseIdInSlider extends Migration
{

    public function up()
    {
        Schema::table('sliders', function ($table) {
            if (!Schema::hasColumn('sliders', 'course_id')) {
                $table->integer('course_id')->default(0);
            }
        });
    }

    public function down()
    {
        //
    }
}
