<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCoulmunInThemeCustomize extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('theme_customizes', function ($table) {
            if (!Schema::hasColumn('theme_customizes', 'footer_background_color')) {
                $table->string('footer_background_color')->default('#1E2147');;
            }

            if (!Schema::hasColumn('theme_customizes', 'footer_headline_color')) {
                $table->string('footer_headline_color')->default('#ffffff');;
            }

            if (!Schema::hasColumn('theme_customizes', 'footer_text_color')) {
                $table->string('footer_text_color')->default('#5B5C6E');;
            }
        });

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
