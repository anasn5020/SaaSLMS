<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class UpdateLoginPageAsTranslatable extends Migration
{

    public function up()
    {
        Schema::table('login_pages', function($table){
            $table->longText("title")->nullable()->change();
            $table->longText("slogans1")->nullable()->change();
            $table->longText("slogans2")->nullable()->change();
            $table->longText("slogans3")->nullable()->change();

            $table->longText("reg_title")->nullable()->change();
            $table->longText("reg_slogans1")->nullable()->change();
            $table->longText("reg_slogans2")->nullable()->change();
            $table->longText("reg_slogans3")->nullable()->change();

            $table->longText("forget_title")->nullable()->change();
            $table->longText("forget_slogans1")->nullable()->change();
            $table->longText("forget_slogans2")->nullable()->change();
            $table->longText("forget_slogans3")->nullable()->change();


        });

//        DB::statement('ALTER TABLE `login_pages`
//            CHANGE `title` `title` LONGTEXT  NULL DEFAULT NULL,
//            CHANGE `slogans1` `slogans1` LONGTEXT  NULL DEFAULT NULL,
//            CHANGE `slogans2` `slogans2` LONGTEXT  NULL DEFAULT NULL,
//            CHANGE `slogans3` `slogans3` LONGTEXT  NULL DEFAULT NULL,
//
//            CHANGE `reg_title` `reg_title` LONGTEXT  NULL DEFAULT NULL,
//            CHANGE `reg_slogans1` `reg_slogans1` LONGTEXT  NULL DEFAULT NULL,
//            CHANGE `reg_slogans2` `reg_slogans2` LONGTEXT  NULL DEFAULT NULL,
//            CHANGE `reg_slogans3` `reg_slogans3` LONGTEXT  NULL DEFAULT NULL,
//
//            CHANGE `forget_title` `forget_title` LONGTEXT  NULL DEFAULT NULL,
//            CHANGE `forget_slogans1` `forget_slogans1` LONGTEXT  NULL DEFAULT NULL,
//            CHANGE `forget_slogans2` `forget_slogans2` LONGTEXT  NULL DEFAULT NULL,
//            CHANGE `forget_slogans3` `forget_slogans3` LONGTEXT  NULL DEFAULT NULL
//        ;');

        $lang_code = 'en';
        $table_name = 'login_pages';

        $rows = DB::table($table_name)->get();

        foreach ($rows as $row) {
            $pos = strpos($row->title, '{"');
            if ($pos === false) {
                DB::table($table_name)->where('id', $row->id)->update([
                    'title' => '{"' . $lang_code . '":"' . $row->title . '"}',
                ]);
            }

            $pos = strpos($row->slogans1, '{"');
            if ($pos === false) {
                DB::table($table_name)->where('id', $row->id)->update([
                    'slogans1' => '{"' . $lang_code . '":"' . $row->slogans1 . '"}',
                ]);
            }

            $pos = strpos($row->slogans2, '{"');
            if ($pos === false) {
                DB::table($table_name)->where('id', $row->id)->update([
                    'slogans2' => '{"' . $lang_code . '":"' . $row->slogans2 . '"}',
                ]);
            }

            $pos = strpos($row->slogans3, '{"');
            if ($pos === false) {
                DB::table($table_name)->where('id', $row->id)->update([
                    'slogans3' => '{"' . $lang_code . '":"' . $row->slogans3 . '"}',
                ]);
            }


            $pos = strpos($row->reg_title, '{"');
            if ($pos === false) {
                DB::table($table_name)->where('id', $row->id)->update([
                    'reg_title' => '{"' . $lang_code . '":"' . $row->reg_title . '"}',
                ]);
            }

            $pos = strpos($row->reg_slogans1, '{"');
            if ($pos === false) {
                DB::table($table_name)->where('id', $row->id)->update([
                    'reg_slogans1' => '{"' . $lang_code . '":"' . $row->reg_slogans1 . '"}',
                ]);
            }

            $pos = strpos($row->reg_slogans2, '{"');
            if ($pos === false) {
                DB::table($table_name)->where('id', $row->id)->update([
                    'reg_slogans2' => '{"' . $lang_code . '":"' . $row->reg_slogans2 . '"}',
                ]);
            }

            $pos = strpos($row->reg_slogans3, '{"');
            if ($pos === false) {
                DB::table($table_name)->where('id', $row->id)->update([
                    'reg_slogans3' => '{"' . $lang_code . '":"' . $row->reg_slogans3 . '"}',
                ]);
            }


            $pos = strpos($row->forget_title, '{"');
            if ($pos === false) {
                DB::table($table_name)->where('id', $row->id)->update([
                    'forget_title' => '{"' . $lang_code . '":"' . $row->forget_title . '"}',
                ]);
            }

            $pos = strpos($row->forget_slogans1, '{"');
            if ($pos === false) {
                DB::table($table_name)->where('id', $row->id)->update([
                    'forget_slogans1' => '{"' . $lang_code . '":"' . $row->forget_slogans1 . '"}',
                ]);
            }

            $pos = strpos($row->forget_slogans2, '{"');
            if ($pos === false) {
                DB::table($table_name)->where('id', $row->id)->update([
                    'forget_slogans2' => '{"' . $lang_code . '":"' . $row->forget_slogans2 . '"}',
                ]);
            }

            $pos = strpos($row->forget_slogans3, '{"');
            if ($pos === false) {
                DB::table($table_name)->where('id', $row->id)->update([
                    'forget_slogans3' => '{"' . $lang_code . '":"' . $row->forget_slogans3 . '"}',
                ]);
            }
        }
    }

    public function down()
    {
        //
    }
}
