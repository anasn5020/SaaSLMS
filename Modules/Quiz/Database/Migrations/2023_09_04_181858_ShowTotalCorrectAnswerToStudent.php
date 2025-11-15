<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ShowTotalCorrectAnswerToStudent extends Migration
{
    public function up()
    {
        Schema::table('quize_setups', function ($table) {
            if (!Schema::hasColumn('quize_setups', 'show_total_correct_answer')) {
                $table->tinyInteger('show_total_correct_answer')->default(0);
            }
        });

        Schema::table('online_quizzes', function ($table) {
            if (!Schema::hasColumn('online_quizzes', 'show_total_correct_answer')) {
                $table->tinyInteger('show_total_correct_answer')->default(0);
            }
        });
    }

    public function down()
    {
        //
    }
}
