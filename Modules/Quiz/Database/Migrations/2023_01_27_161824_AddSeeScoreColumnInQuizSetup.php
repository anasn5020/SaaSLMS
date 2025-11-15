<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSeeScoreColumnInQuizSetup extends Migration
{

    public function up()
    {
        Schema::table('quize_setups', function ($table) {
            if (!Schema::hasColumn('quize_setups', 'show_score_result')) {
                $table->tinyInteger('show_score_result')->default(1);
            }
        });

        Schema::table('online_quizzes', function ($table) {
            if (!Schema::hasColumn('online_quizzes', 'show_score_result')) {
                $table->tinyInteger('show_score_result')->default(1);
            }
        });
    }


    public function down()
    {
        //
    }
}
