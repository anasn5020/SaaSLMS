<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateOnlineQuizTableTranslateable extends Migration
{
    public function up()
    {
        try {
            Schema::table('online_quizzes', function ($table) {
                $table->dropIndex(['title']);
            });
//            DB::statement('ALTER TABLE `online_quizzes` DROP INDEX `online_quizzes_title_index`;');
        }catch (\Exception $e){
        }

        Schema::table('online_quizzes', function($table){
            $table->longText("title")->nullable()->change();
            $table->longText("instruction")->nullable()->change();
        });
//        DB::statement('ALTER TABLE `online_quizzes`
//    CHANGE `title` `title` LONGTEXT  NULL DEFAULT NULL,
//    CHANGE `instruction` `instruction` LONGTEXT  NULL DEFAULT NULL;');

        $lang_code = 'en';
        $table_name = 'online_quizzes';

        $rows = DB::table($table_name)->get();
        foreach ($rows as $row) {
            $pos = strpos($row->title, '{"');
            if ($pos === false) {
                DB::table($table_name)->where('id', $row->id)->update([
                    'title' => '{"' . $lang_code . '":"' . $row->title . '"}',
                ]);
            }

            $pos = strpos($row->instruction, '{"');
            if ($pos === false) {
                DB::table($table_name)->where('id', $row->id)->update([
                    'instruction' => '{"' . $lang_code . '":"' . $row->instruction . '"}',
                ]);
            }

        }
    }

    public function down()
    {
        //
    }
}
