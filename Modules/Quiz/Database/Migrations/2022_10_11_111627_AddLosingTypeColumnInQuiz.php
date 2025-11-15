<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLosingTypeColumnInQuiz extends Migration
{
    public function up()
    {
        Schema::table('quize_setups', function ($table) {
            if (!Schema::hasColumn('quize_setups', 'losing_type')) {
                $table->integer('losing_type')->default(1);
            }
        });

        Schema::table('online_quizzes', function ($table) {
            if (!Schema::hasColumn('online_quizzes', 'losing_type')) {
                $table->integer('losing_type')->default(1);
            }
        });

    }

    public function down()
    {
        //
    }
}
