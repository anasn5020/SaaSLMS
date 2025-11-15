<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddQuizSubTitleColumnInHomeContent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('home_contents', function ($table) {

            if (!Schema::hasColumn('home_contents', 'quiz_sub_title')) {
                $table->string('quiz_sub_title')->default('You don’t need to be a designer or have any previous of experience with design to take Quillow classes. You just need curiosity and the desire to learn.');
            }
            if (!Schema::hasColumn('home_contents', 'live_class_sub_title')) {
                $table->string('live_class_sub_title')->default('You don’t need to be a designer or have any previous of experience with design to take Quillow classes. You just need curiosity and the desire to learn.');
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
