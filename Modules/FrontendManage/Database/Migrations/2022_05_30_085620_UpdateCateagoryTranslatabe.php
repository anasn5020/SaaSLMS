<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCateagoryTranslatabe extends Migration
{

    public function up()
    {

        Schema::table('categories', function($table){
            $table->longText("name")->nullable()->change();
            $table->longText("description")->nullable()->change();
        });
//        DB::statement('ALTER TABLE `categories`
//    CHANGE `name` `name` LONGTEXT  NULL DEFAULT NULL,
//    CHANGE `description` `description` LONGTEXT NULL DEFAULT NULL;');

        $lang_code = 'en';
        $table_name = 'categories';

        $rows = DB::table($table_name)->get();
        foreach ($rows as $row) {
            $pos = strpos($row->name, '{"');
            if ($pos === false) {
                DB::table($table_name)->where('id', $row->id)->update([
                    'name' => '{"' . $lang_code . '":"' . $row->name . '"}',
                    'description' => '{"' . $lang_code . '":"' . $row->description . '"}',
                ]);
            }
        }
    }


    public function down()
    {
        //
    }
}
