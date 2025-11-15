<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class UpdateCourseTableTranslateable extends Migration
{
    public function up()
    {
        try{
            Schema::table('courses', function ($table) {
                $table->dropIndex(['category_id','subcategory_id','user_id','lang_id','title']);
            });
//            DB::statement('ALTER TABLE `courses` DROP INDEX `courses_category_id_subcategory_id_user_id_lang_id_title_index`;');

        }catch (\Exception $e){
        }

        Schema::table('courses', function($table){
            $table->longText("title")->nullable()->change();
            $table->longText("requirements")->nullable()->change();
            $table->longText("outcomes")->nullable()->change();
            $table->longText("about")->nullable()->change();
        });
//        DB::statement('ALTER TABLE `courses`
//    CHANGE `title` `title` LONGTEXT  NULL DEFAULT NULL,
//    CHANGE `requirements` `requirements` LONGTEXT  NULL DEFAULT NULL,
//    CHANGE `outcomes` `outcomes` LONGTEXT  NULL DEFAULT NULL,
//    CHANGE `about` `about` LONGTEXT  NULL DEFAULT NULL;');


        $lang_code = 'en';
        $table_name = 'courses';

        $rows = DB::table($table_name)->get();
        foreach ($rows as $row) {
            $pos = strpos($row->title, '{"');
            if ($pos === false) {
                DB::table($table_name)->where('id', $row->id)->update([
                    'title' => '{"' . $lang_code . '":"' . $row->title . '"}',
                ]);
            }

            $pos = strpos($row->requirements, '{"');
            if ($pos === false) {
                DB::table($table_name)->where('id', $row->id)->update([
                    'requirements' => '{"' . $lang_code . '":"' . $row->requirements . '"}',
                ]);
            }


            $pos = strpos($row->outcomes, '{"');
            if ($pos === false) {
                DB::table($table_name)->where('id', $row->id)->update([
                    'outcomes' => '{"' . $lang_code . '":"' . $row->outcomes . '"}',
                ]);
            }

            $pos = strpos($row->about, '{"');
            if ($pos === false) {
                DB::table($table_name)->where('id', $row->id)->update([
                    'about' => '{"' . $lang_code . '":"' . $row->about . '"}',
                ]);
            }
        }
    }

    public function down()
    {
        //
    }
}
