<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_settings', function (Blueprint $table) {
            $table->id();

            $table->integer('show_mode_of_delivery')->default(1)->nullable();

            $table->integer('show_rating')->default(1)->nullable();
            $table->integer('show_cart')->default(1)->nullable();
            $table->integer('show_enrolled_or_level_section')->default(1)->nullable();
            $table->integer('enrolled_or_level')->default(1)->comment('1 for enrolled and 2 fro course level')->nullable();
            $table->integer('show_cql_left_sidebar')->default(0)->nullable();
            $table->integer('size_of_grid')->default(4)->nullable();
            $table->integer('show_review_option')->default(0)->nullable();
            $table->integer('show_rating_option')->default(0)->nullable();
            $table->integer('show_search_in_category')->default(1)->nullable();
            
            $table->integer('show_instructor_rating')->default(0)->nullable();
            $table->integer('show_instructor_review')->default(0)->nullable();
            $table->integer('show_instructor_enrolled')->default(0)->nullable();
            $table->integer('show_instructor_courses')->default(1)->nullable();

            $table->timestamps();
        });
        DB::table('course_settings')->insert([
            [
                'show_rating' => 1,
                'show_cart' => 1,
                'show_enrolled_or_level_section' => 1,
                'enrolled_or_level' => 1,
                'show_cql_left_sidebar' => 1,
                'size_of_grid' => 4,
                'show_review_option' => 0,
                'show_rating_option' => 0,
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_settings');
    }
}
