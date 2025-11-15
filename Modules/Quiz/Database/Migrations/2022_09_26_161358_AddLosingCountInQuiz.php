<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLosingCountInQuiz extends Migration
{
    public function up()
    {
        Schema::table('quize_setups', function ($table) {
            if (!Schema::hasColumn('quize_setups', 'losing_focus_acceptance_number')) {
                $table->integer('losing_focus_acceptance_number')->default(0);
            }
        });

        Schema::table('online_quizzes', function ($table) {
            if (!Schema::hasColumn('online_quizzes', 'losing_focus_acceptance_number')) {
                $table->integer('losing_focus_acceptance_number')->default(0);
            }
        });
    }

    public function down()
    {
        //
    }
}
