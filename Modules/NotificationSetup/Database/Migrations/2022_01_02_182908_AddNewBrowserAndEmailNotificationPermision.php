<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewBrowserAndEmailNotificationPermision extends Migration
{

    public function up()
    {

        DB::table('role_email_templates')->insert([
            'role_id' => 1,
            'template_act' => 'Course_Chapter_Added',
            'status' => 1
        ]);

        DB::table('role_email_templates')->insert([
            'role_id' => 2,
            'template_act' => 'Course_Chapter_Added',
            'status' => 1
        ]);


        DB::table('role_email_templates')->insert([
            'role_id' => 1,
            'template_act' => 'Course_Lesson_Added',
            'status' => 1
        ]);

        DB::table('role_email_templates')->insert([
            'role_id' => 2,
            'template_act' => 'Course_Lesson_Added',
            'status' => 1
        ]);

        DB::table('role_email_templates')->insert([
            'role_id' => 1,
            'template_act' => 'Course_ExerciseFile_Added',
            'status' => 1
        ]);

        DB::table('role_email_templates')->insert([
            'role_id' => 2,
            'template_act' => 'Course_ExerciseFile_Added',
            'status' => 1
        ]);

    }


    public function down()
    {
        //
    }
}
