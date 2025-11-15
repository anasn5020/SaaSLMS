<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateBlogTranslatabe extends Migration
{
    public function up()
    {
        Schema::table('blog_categories', function($table){
            $table->longText("title")->nullable()->change();
        });
//        DB::statement('ALTER TABLE `blog_categories`
//    CHANGE `title` `title` LONGTEXT  NULL DEFAULT NULL;');

        $lang_code = 'en';
        $table_name = 'blog_categories';

        $rows = DB::table($table_name)->get();
        foreach ($rows as $row) {
            $pos = strpos($row->title, '{"');
            if ($pos === false) {
                DB::table($table_name)->where('id', $row->id)->update([
                    'title' => '{"' . $lang_code . '":"' . $row->title . '"}'
                ]);
            }
        }

        Schema::table('blogs', function($table){
            $table->longText("title")->nullable()->change();
            $table->longText("description")->nullable()->change();
        });
//        DB::statement('ALTER TABLE `blogs`
//    CHANGE `title` `title` LONGTEXT  NULL DEFAULT NULL,
//    CHANGE `description` `description` LONGTEXT NULL DEFAULT NULL;');

        $lang_code = 'en';
        $table_name = 'blogs';

        $rows = DB::table($table_name)->get();
        foreach ($rows as $row) {
            $pos = strpos($row->title, '{"');
            if ($pos === false) {
                DB::table($table_name)->where('id', $row->id)->update([
                    'title' => '{"' . $lang_code . '":"' . $row->title . '"}',
                ]);
            }

            $pos2 = strpos($row->description, '{"');
            if ($pos2 === false) {
                DB::table($table_name)->where('id', $row->id)->update([
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
