<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateHomeContentTableTranslateable extends Migration
{

    public function up()
    {

        $lang_code = 'en';
        $table_name = 'home_contents';

        $rows = DB::table($table_name)->get();
        foreach ($rows as $row) {

            $pos = strpos($row->value, '{"');
            if ($pos === false) {
                DB::table($table_name)->where('id', $row->id)->update([
                    'value' => '{"' . $lang_code . '":"' . $row->value . '"}',
                ]);
            }
        }
    }

    public function down()
    {
        //
    }
}
