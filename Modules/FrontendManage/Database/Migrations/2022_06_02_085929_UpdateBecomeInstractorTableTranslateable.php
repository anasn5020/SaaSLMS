<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class UpdateBecomeInstractorTableTranslateable extends Migration
{
    public function up()
    {

        $lang_code = 'en';
        $table_name = 'become_instructors';


        Schema::table($table_name, function ($table) {
            $table->longText("section")->nullable()->change();
            $table->longText("title")->nullable()->change();
            $table->longText("description")->nullable()->change();
            $table->longText("btn_name")->nullable()->change();
        });

//        DB::statement('ALTER TABLE `' . $table_name . '`
//    CHANGE `section` `section` LONGTEXT  NULL DEFAULT NULL,
//    CHANGE `title` `title` LONGTEXT  NULL DEFAULT NULL,
//    CHANGE `description` `description` LONGTEXT  NULL DEFAULT NULL,
//    CHANGE `btn_name` `btn_name` LONGTEXT  NULL DEFAULT NULL;
//
//    ');

        $rows = DB::table($table_name)->get();
        foreach ($rows as $row) {

            $columns = ['section', 'title', 'description', 'btn_name'];

            foreach ($columns as $column) {
                $pos = strpos($row->$column, '{"');
                if ($pos === false) {
                    DB::table($table_name)->where('id', $row->id)->update([
                        $column => '{"' . $lang_code . '":"' . $row->$column . '"}',
                    ]);
                }
            }
        }


        $table_name = 'work_processes';

        Schema::table($table_name, function ($table) {
            $table->longText("title")->nullable()->change();
            $table->longText("description")->nullable()->change();
        });
//        DB::statement('ALTER TABLE `' . $table_name . '`
//    CHANGE `title` `title` LONGTEXT  NULL DEFAULT NULL,
//    CHANGE `description` `description` LONGTEXT  NULL DEFAULT NULL;
//    ');

        $rows = DB::table($table_name)->get();
        foreach ($rows as $row) {

            $columns = ['title', 'description'];

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
