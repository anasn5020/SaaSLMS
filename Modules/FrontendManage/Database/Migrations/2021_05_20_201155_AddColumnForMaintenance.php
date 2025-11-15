<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddColumnForMaintenance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('home_contents', function ($table) {

            if (!Schema::hasColumn('home_contents', 'maintenance_banner')) {
                $table->string('maintenance_banner')->default('public/frontend/infixlmstheme/img/banner/maintenance.jpg');
            }
            if (!Schema::hasColumn('home_contents', 'maintenance_title')) {
                $table->string('maintenance_title')->default('We will be back soon!');
            }
            if (!Schema::hasColumn('home_contents', 'maintenance_sub_title')) {
                $table->string('maintenance_sub_title')->default('Sorry for the inconvenience but we&rsquo;re performing some maintenance at the moment.');
            }
            if (!Schema::hasColumn('home_contents', 'maintenance_status')) {
                $table->integer('maintenance_status')->default(0);
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
