<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewColumnInAboutPage extends Migration
{
    public function up()
    {
        Schema::table('about_pages', function ($table) {
            if (!Schema::hasColumn('about_pages', 'registered_students')) {
                $table->text('registered_students')->nullable();
            }

            if (!Schema::hasColumn('about_pages', 'questions_answers')) {
                $table->text('questions_answers')->nullable();
            }

            if (!Schema::hasColumn('about_pages', 'quality_content')) {
                $table->text('quality_content')->nullable();
            }


            if (!Schema::hasColumn('about_pages', 'our_mission')) {
                $table->text('our_mission')->nullable();
            }

            if (!Schema::hasColumn('about_pages', 'our_vision')) {
                $table->text('our_vision')->nullable();
            }
        });
    }

    public function down()
    {
        //
    }
}
