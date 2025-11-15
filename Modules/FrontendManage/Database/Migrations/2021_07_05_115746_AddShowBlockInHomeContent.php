<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddShowBlockInHomeContent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('home_contents', function ($table) {
            if (!Schema::hasColumn('home_contents', 'show_banner_section')) {
                $table->boolean('show_banner_section')->default(true);
            }

            if (!Schema::hasColumn('home_contents', 'show_category_section')) {
                $table->boolean('show_category_section')->default(true);
            }

            if (!Schema::hasColumn('home_contents', 'show_instructor_section')) {
                $table->boolean('show_instructor_section')->default(true);
            }

            if (!Schema::hasColumn('home_contents', 'show_course_section')) {
                $table->boolean('show_course_section')->default(true);
            }


            if (!Schema::hasColumn('home_contents', 'show_best_category_section')) {
                $table->boolean('show_best_category_section')->default(true);
            }


            if (!Schema::hasColumn('home_contents', 'show_quiz_section')) {
                $table->boolean('show_quiz_section')->default(true);
            }

            if (!Schema::hasColumn('home_contents', 'show_testimonial_section')) {
                $table->boolean('show_testimonial_section')->default(true);
            }

            if (!Schema::hasColumn('home_contents', 'show_article_section')) {
                $table->boolean('show_article_section')->default(true);
            }

            if (!Schema::hasColumn('home_contents', 'show_subscribe_section')) {
                $table->boolean('show_subscribe_section')->default(true);
            }

            if (!Schema::hasColumn('home_contents', 'show_become_instructor_section')) {
                $table->boolean('show_become_instructor_section')->default(true);
            }

            if (!Schema::hasColumn('home_contents', 'show_sponsor_section')) {
                $table->boolean('show_sponsor_section')->default(true);
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
