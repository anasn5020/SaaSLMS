<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMenuAsTranslateable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $lang_code = 'en';

        $menus = DB::table('header_menus')->get();
        foreach ($menus as $menu) {
            $pos = strpos($menu->title, '{"');
            if ($pos === false) {
                DB::table('header_menus')->where('id', $menu->id)->update([
                    'title' => '{"' . $lang_code . '":"' . $menu->title . '"}'
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
