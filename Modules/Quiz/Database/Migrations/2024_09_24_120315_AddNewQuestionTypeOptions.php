<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewQuestionTypeOptions extends Migration
{
    public function up()
    {
        Schema::table('question_bank_mu_options', function ($table) {
            if (!Schema::hasColumn('question_bank_mu_options', 'position')) {
                $table->integer('position')->default(0);
            }
            if (!Schema::hasColumn('question_bank_mu_options', 'group')) {
                $table->integer('group')->default(0);
            }

            if (!Schema::hasColumn('question_bank_mu_options', 'type')) {
                $table->tinyInteger('type')->comment('1=question, 2=ans')->default(1);
            }

            if (!Schema::hasColumn('question_bank_mu_options', 'option_index')) {
                $table->integer('option_index')->default(0);
            }
        });

        Schema::table('question_banks', function ($table) {
            if (!Schema::hasColumn('question_banks', 'level')) {
                $table->integer('level')->nullable();
            }
            if (!Schema::hasColumn('question_banks', 'pre_condition')) {
                $table->tinyInteger('pre_condition')->default(0);
            }

            if (!Schema::hasColumn('question_banks', 'number_of_qus')) {
                $table->integer('number_of_qus')->default(0);
            }
            if (!Schema::hasColumn('question_banks', 'number_of_ans')) {
                $table->integer('number_of_ans')->default(0);
            }

            if (!Schema::hasColumn('question_banks', 'connection')) {
                $table->text('connection')->nullable();
            }
            if (!Schema::hasColumn('question_banks', 'data')) {
                $table->text('data')->nullable();
            }
        });

        Schema::table('quiz_tests', function (Blueprint $table) {
            if (!Schema::hasColumn('quiz_tests', 'comment')) {
                $table->text('comment')->nullable();
            }
            if (!Schema::hasColumn('quiz_tests', 'warning')) {
                $table->integer('warning')->default(0);
            }
            if (!Schema::hasColumn('quiz_tests', 'extra_time')) {
                $table->integer('extra_time')->default(0);
            }
            if (!Schema::hasColumn('quiz_tests', 'continue_do_test')) {
                $table->integer('continue_do_test')->default(0);
            }
            if (!Schema::hasColumn('quiz_tests', 'state')) {
                $table->integer('state')->default(0);
            }
            if (!Schema::hasColumn('quiz_tests', 'flag')) {
                $table->tinyInteger('flag')->default(0);
            }
        });

    }

    public function down()
    {
        //
    }
}
