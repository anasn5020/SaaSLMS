<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddQuizTypeColumnInQuizTest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quiz_tests', function ($table) {
            if (!Schema::hasColumn('quiz_tests', 'quiz_type')) {
                $table->tinyInteger('quiz_type')->default(1)->comment('1=course, 2= quiz');
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
