<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMultiAttendCounterColumnInQuizSetup extends Migration
{

    public function up()
    {
        Schema::table('quize_setups', function ($table) {
            if (!Schema::hasColumn('quize_setups', 'multiple_attend_count')) {
                $table->integer('multiple_attend_count')->default(0);
            }
        });

        Schema::table('online_quizzes', function ($table) {
            if (!Schema::hasColumn('online_quizzes', 'multiple_attend_count')) {
                $table->integer('multiple_attend_count')->default(0);
            }
        });
    }

    public function down()
    {
        //
    }
}
