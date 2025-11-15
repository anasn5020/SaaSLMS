<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class AddBgColorInThemeCustomize extends Migration
{
    public function up()
    {
        Schema::table('theme_customizes', function ($table) {
            if (!Schema::hasColumn('theme_customizes', 'bg_color')) {
                $table->string('bg_color')->default('#ffffff')->nullable();
            }
        });
    }

    public function down()
    {
        //
    }
}
