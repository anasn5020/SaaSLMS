<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class AddAccessLimitInCourse extends Migration
{

    public function up()
    {
        Schema::table('courses', function ($table) {
            if (!Schema::hasColumn('courses', 'access_limit')) {
                $table->integer('access_limit')->default(0);
            }
        });


        Schema::table('course_enrolleds', function ($table) {
            if (!Schema::hasColumn('course_enrolleds', 'send_expire_notification')) {
                $table->tinyInteger('send_expire_notification')->default(0);
            }
        });


    }

    public function down()
    {
        //
    }
}
