<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddShowExplineQuizAnsSetting extends Migration
{

    public function up()
    {
        Schema::table('quize_setups', function ($table) {
            if (!Schema::hasColumn('quize_setups', 'show_ans_with_explanation')) {
                $table->tinyInteger('show_ans_with_explanation')->default(0);
            }
        });

        Schema::table('online_quizzes', function ($table) {
            if (!Schema::hasColumn('online_quizzes', 'show_ans_with_explanation')) {
                $table->tinyInteger('show_ans_with_explanation')->default(0);
            }
        });
    }

    public function down()
    {
        //
    }
}
