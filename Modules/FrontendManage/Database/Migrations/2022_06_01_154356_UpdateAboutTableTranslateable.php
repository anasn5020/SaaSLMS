<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateAboutTableTranslateable extends Migration
{

    public function up()
    {

        Schema::table('about_pages', function($table){
            $table->longText("who_we_are")->nullable()->change();
            $table->longText("banner_title")->nullable()->change();
            $table->longText("story_title")->nullable()->change();
            $table->longText("story_description")->nullable()->change();
            $table->longText("total_teacher")->nullable()->change();
            $table->longText("teacher_title")->nullable()->change();
            $table->longText("teacher_details")->nullable()->change();
            $table->longText("total_student")->nullable()->change();
            $table->longText("student_title")->nullable()->change();
            $table->longText("student_details")->nullable()->change();
            $table->longText("total_courses")->nullable()->change();
            $table->longText("course_title")->nullable()->change();
            $table->longText("course_details")->nullable()->change();
            $table->longText("about_page_content_title")->nullable()->change();
            $table->longText("about_page_content_details")->nullable()->change();
            $table->longText("live_class_title")->nullable()->change();
            $table->longText("live_class_details")->nullable()->change();
            $table->longText("sponsor_title")->nullable()->change();
            $table->longText("sponsor_sub_title")->nullable()->change();
        });


        $lang_code = 'en';
        $table_name = 'about_pages';


        $rows = DB::table($table_name)->get();
        foreach ($rows as $row) {

            $columns = [
                'who_we_are',
                'banner_title',
                'story_title',
                'story_description',
                'total_teacher',
                'teacher_title',
                'teacher_details',
                'total_student',
                'student_title',
                'student_details',
                'total_courses',
                'course_title',
                'course_details',
                'about_page_content_title',
                'about_page_content_details',
                'live_class_title',
                'live_class_details',
                'sponsor_title',
                'sponsor_sub_title',
            ];

            foreach ($columns as $column) {
                $pos = strpos($row->$column, '{"');
                if ($pos === false) {
                    DB::table($table_name)->where('id', $row->id)->update([
                        $column => '{"' . $lang_code . '":"' . $row->$column . '"}',
                    ]);
                }
            }



        }
    }


    public function down()
    {
        //
    }
}
