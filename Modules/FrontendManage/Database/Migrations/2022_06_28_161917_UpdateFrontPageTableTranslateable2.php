<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFrontPageTableTranslateable2 extends Migration
{
    public function up()
    {

        $lang_code = 'en';
        $table_name = 'front_pages';

        $rows = DB::table($table_name)->get();
        foreach ($rows as $row) {

            $details = $row->details;
            $pos = strpos($details, '{"en":"');
            if (!is_bool($pos)) {
                $details = str_replace('{"en":"', '', $details);
                $details = str_replace('"}', '', $details);
                DB::table($table_name)->where('id', $row->id)->update([
                    'details' => json_encode([$lang_code => $details]),
                ]);
            }


        }
    }

    public function down()
    {
        //
    }
}
