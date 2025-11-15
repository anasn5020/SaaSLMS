<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSearchBoxHideColumnInHomeContent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('home_contents', function (Blueprint $table) {
            if (!Schema::hasColumn('home_contents', 'show_menu_search_box')) {
                $table->integer('show_menu_search_box')->default(1);
            }

            if (!Schema::hasColumn('home_contents', 'show_banner_search_box')) {
                $table->integer('show_banner_search_box')->default(1);
            }

            if (!Schema::hasColumn('home_contents', 'show_map')) {
                $table->integer('show_map')->default(1);
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
