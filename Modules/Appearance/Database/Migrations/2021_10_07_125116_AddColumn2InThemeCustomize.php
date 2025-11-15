<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Session;

class AddColumn2InThemeCustomize extends Migration
{

    public function up()
    {
        File::delete(File::glob('bootstrap/cache/*.php'));
        Schema::table('theme_customizes', function ($table) {

            if (!Schema::hasColumn('theme_customizes', 'footer_text_hover_color')) {
                $table->string('footer_text_hover_color')->default('#FB1159');;
            }
        });
        Session::forget('color_theme');
    }

    public function down()
    {
        //
    }
}
