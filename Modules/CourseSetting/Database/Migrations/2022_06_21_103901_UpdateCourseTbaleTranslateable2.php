<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCourseTbaleTranslateable2 extends Migration
{
    public function up()
    {
        $lang_code = 'en';
        $table_name = 'courses';

        $rows = DB::table($table_name)->get();
        foreach ($rows as $row) {

            $requirements = $row->requirements;
            $pos = strpos($requirements, '{"en":"');
            if (!is_bool($pos)) {
                $requirements = str_replace('{"en":"', '', $requirements);
                $requirements = str_replace('"}', '', $requirements);
                DB::table($table_name)->where('id', $row->id)->update([
                    'requirements' => json_encode([$lang_code => $requirements]),
                ]);
            }


            $outcomes = $row->outcomes;
            $pos = strpos($outcomes, '{"en":"');
            if (!is_bool($pos)) {
                $outcomes = str_replace('{"en":"', '', $outcomes);
                $outcomes = str_replace('"}', '', $outcomes);
                DB::table($table_name)->where('id', $row->id)->update([
                    'outcomes' => json_encode([$lang_code => $outcomes]),
                ]);
            }


            $about = $row->about;
            $pos = strpos($about, '{"en":"');
            if (!is_bool($pos)) {
                $about = str_replace('{"en":"', '', $about);
                $about = str_replace('"}', '', $about);
                DB::table($table_name)->where('id', $row->id)->update([
                    'about' => json_encode([$lang_code => $about]),
                ]);
            }


        }
    }

    public function down()
    {
        //
    }
}
