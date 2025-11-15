<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOverViewMediaColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courses', function ($table) {
            if (!Schema::hasColumn('courses', 'show_overview_media')) {
                $table->integer('show_overview_media')->nullable()->default(0);
            }

            if (!Schema::hasColumn('courses', 'show_mode_of_delivery')) {
                $table->integer('show_mode_of_delivery')->nullable()->default(1);
            }

            if (!Schema::hasColumn('courses', 'mode_of_delivery')) {
                $table->integer('mode_of_delivery')->nullable()->default(1)->comment('1=Online, 2= Distance Learning, 3= Face to Face');
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
