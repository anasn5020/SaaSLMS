<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMegamenuColumnInHeaderMenu extends Migration
{

    public function up()
    {
        Schema::table('header_menus', function (Blueprint $table) {
            if (!Schema::hasColumn('header_menus', 'mega_menu')) {
                $table->tinyInteger('mega_menu')->default(0);
            }

            if (!Schema::hasColumn('header_menus', 'mega_menu_column')) {
                $table->integer('mega_menu_column')->default(2);
            }
        });
    }

    public function down()
    {
        //
    }
}
