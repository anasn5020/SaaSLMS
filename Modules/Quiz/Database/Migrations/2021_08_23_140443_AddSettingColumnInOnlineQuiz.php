<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSettingColumnInOnlineQuiz extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('online_quizzes', function ($table) {
            if (!Schema::hasColumn('online_quizzes', 'random_question')) {
                $table->integer('random_question')->default(0);
            }

            if (!Schema::hasColumn('online_quizzes', 'question_time_type')) {
                $table->integer('question_time_type')->default(0)->comment('0=per qus, 1=all qus');
            }

            if (!Schema::hasColumn('online_quizzes', 'question_time')) {
                $table->integer('question_time')->default(1);
            }

            if (!Schema::hasColumn('online_quizzes', 'question_review')) {
                $table->integer('question_review')->default(1);
            }
            if (!Schema::hasColumn('online_quizzes', 'show_result_each_submit')) {
                $table->integer('show_result_each_submit')->default(1);
            }

            if (!Schema::hasColumn('online_quizzes', 'multiple_attend')) {
                $table->integer('multiple_attend')->default(1);
            }
        });


        $setup = \Modules\Quiz\Entities\QuizeSetup::first();

        $quizs = \Modules\Quiz\Entities\OnlineQuiz::all();
        foreach ($quizs as $quiz) {
            if (!empty($setup->time_per_question)) {
                $type = 0;
                $time = $setup->time_per_question;
            } else {
                $type = 1;
                $time = $setup->time_total_question;
            }
            $quiz->random_question = $setup->random_question;
            $quiz->question_time_type = $type;
            $quiz->question_time = $time;
            $quiz->question_review = $setup->question_review;
            $quiz->show_result_each_submit = $setup->show_result_each_submit;
            $quiz->multiple_attend = $setup->multiple_attend;
            $quiz->save();
        }


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
