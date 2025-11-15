<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEdumeThemeInThemeCustomize extends Migration
{

    public function up()
    {
        $sql = [[
            'name' => "Edume Theme",
            'theme_id' => 2,
            'primary_color' => "#171D27",
            'secondary_color' => "#D0ECF5",
            'footer_background_color' => "#EEFBFB",
            'footer_headline_color' => "#161C27",
            'footer_text_color' => "#171D27",
            'footer_text_hover_color' => "#171D27",
            'is_default' => 1,
            'created_by' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]];

        DB::table('theme_customizes')->insert($sql);
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
