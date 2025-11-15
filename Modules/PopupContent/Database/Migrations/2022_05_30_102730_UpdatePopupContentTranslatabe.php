<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class UpdatePopupContentTranslatabe extends Migration
{
    public function up()
    {
        Schema::table('popup_contents', function($table){
            $table->longText("title")->nullable()->change();
            $table->longText("btn_txt")->nullable()->change();
            $table->longText("message")->nullable()->change();
        });
//        DB::statement('ALTER TABLE `popup_contents`
//    CHANGE `title` `title` LONGTEXT  NULL DEFAULT NULL,
//    CHANGE `btn_txt` `btn_txt` LONGTEXT  NULL DEFAULT NULL,
//    CHANGE `message` `message` LONGTEXT NULL DEFAULT NULL;');

        $lang_code = 'en';
        $table_name = 'popup_contents';

        $rows = DB::table($table_name)->get();
        foreach ($rows as $row) {
            $pos = strpos($row->title, '{"');
            if ($pos === false) {
                DB::table($table_name)->where('id', $row->id)->update([
                    'title' => '{"' . $lang_code . '":"' . $row->title . '"}',
                    'btn_txt' => '{"' . $lang_code . '":"' . $row->btn_txt . '"}',
                    'message' => '{"' . $lang_code . '":"' . $row->message . '"}',
                ]);
            }
        }
    }

    public function down()
    {
        //
    }
}
