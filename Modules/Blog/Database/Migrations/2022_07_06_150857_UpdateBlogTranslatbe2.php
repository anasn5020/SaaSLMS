<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateBlogTranslatbe2 extends Migration
{
    public function up()
    {
        $lang_code = 'en';
        $table_name = 'blogs';

        $rows = DB::table($table_name)->get();
        foreach ($rows as $row) {

            $description = $row->description;
            $pos = strpos($description, '{"en":"');
            if (!is_bool($pos)) {
                $description = str_replace('{"en":"', '', $description);
                $description = str_replace('"}', '', $description);
                DB::table($table_name)->where('id', $row->id)->update([
                    'description' => json_encode([$lang_code => $description]),
                ]);
            }
        }
    }
    public function down()
    {
        //
    }
}
