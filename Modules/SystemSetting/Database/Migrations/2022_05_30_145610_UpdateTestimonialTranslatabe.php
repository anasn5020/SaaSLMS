<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class UpdateTestimonialTranslatabe extends Migration
{
    public function up()
    {

        Schema::table('testimonials', function($table){
            $table->longText("body")->nullable()->change();
            $table->longText("author")->nullable()->change();
            $table->longText("profession")->nullable()->change();
        });
//        DB::statement('ALTER TABLE `testimonials`
//    CHANGE `body` `body` LONGTEXT  NULL DEFAULT NULL,CHANGE `author` `author` LONGTEXT  NULL DEFAULT NULL,CHANGE `profession` `profession` LONGTEXT  NULL DEFAULT NULL');

        $lang_code = 'en';
        $table_name = 'testimonials';

        $rows = DB::table($table_name)->get();
        foreach ($rows as $row) {
            $pos = strpos($row->body, '{"');
            if ($pos === false) {
                DB::table($table_name)->where('id', $row->id)->update([
                    'body' => '{"' . $lang_code . '":"' . $row->body . '"}',
                ]);
            }

            $pos = strpos($row->author, '{"');
            if ($pos === false) {
                DB::table($table_name)->where('id', $row->id)->update([
                    'author' => '{"' . $lang_code . '":"' . $row->author . '"}',
                ]);
            }

            $pos = strpos($row->profession, '{"');
            if ($pos === false) {
                DB::table($table_name)->where('id', $row->id)->update([
                    'profession' => '{"' . $lang_code . '":"' . $row->profession . '"}',
                ]);
            }
        }
    }

    public function down()
    {
        //
    }
}
