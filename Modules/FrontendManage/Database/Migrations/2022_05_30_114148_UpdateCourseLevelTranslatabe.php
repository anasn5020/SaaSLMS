<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class UpdateCourseLevelTranslatabe extends Migration
{

    public function up()
    {
        try {

            Schema::table('course_levels', function ($table) {
                $table->dropIndex(['title']);
            });
//        DB::statement('ALTER TABLE `course_levels` DROP INDEX `course_levels_title_index`;');
        } catch (\Exception $e) {
        }

        Schema::table('course_levels', function ($table) {
            $table->longText("title")->nullable()->change();
        });
//        DB::statement('ALTER TABLE `course_levels`
//    CHANGE `title` `title` LONGTEXT  NULL DEFAULT NULL');

        $lang_code = 'en';
        $table_name = 'course_levels';

        $rows = DB::table($table_name)->get();
        foreach ($rows as $row) {
            $pos = strpos($row->title, '{"');
            if ($pos === false) {
                DB::table($table_name)->where('id', $row->id)->update([
                    'title' => '{"' . $lang_code . '":"' . $row->title . '"}',
                ]);
            }
        }
    }


    public function down()
    {
        //
    }
}
