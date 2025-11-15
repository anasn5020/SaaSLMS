<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLiveClassSectionInHomeContent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('home_contents', function ($table) {

            if (!Schema::hasColumn('home_contents', 'show_live_class_section')) {
                $table->boolean('show_live_class_section')->default(true);
            }
            if (!Schema::hasColumn('home_contents', 'live_class_title')) {
                $table->string('live_class_title')->default('Explore popular Live Classes');
            }
            if (!Schema::hasColumn('home_contents', 'show_about_lms_section')) {
                $table->integer('show_about_lms_section')->default(1);
            }
            if (!Schema::hasColumn('home_contents', 'about_lms_header')) {
                $table->string('about_lms_header')->default('About LMS')->nullable();
            }
            if (!Schema::hasColumn('home_contents', 'about_lms')) {
                $table->longText('about_lms')->nullable();
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
