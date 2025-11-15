<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOnlyShowWrongQuestionInAnswer extends Migration
{

    public function up()
    {
        Schema::table('quize_setups', function ($table) {
            if (!Schema::hasColumn('quize_setups', 'show_only_wrong_ans_in_ans_sheet')) {
                $table->tinyInteger('show_only_wrong_ans_in_ans_sheet')->default(0);
            }
        });

        Schema::table('online_quizzes', function ($table) {
            if (!Schema::hasColumn('online_quizzes', 'show_only_wrong_ans_in_ans_sheet')) {
                $table->tinyInteger('show_only_wrong_ans_in_ans_sheet')->default(0);
            }
        });
    }

    public function down()
    {
        //
    }
}
