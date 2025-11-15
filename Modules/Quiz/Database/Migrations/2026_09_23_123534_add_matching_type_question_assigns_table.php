<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('matching_type_question_assigns')){
            Schema::create('matching_type_question_assigns', function (Blueprint $table) {
                $table->id();
                $table->integer('question_id')->default(0);
                $table->integer('option_id')->default(0);
                $table->integer('answer_id')->default(0);
                $table->timestamps();
            });
        }else{
            Schema::table('matching_type_question_assigns', function ($table) {
                if (!Schema::hasColumn('matching_type_question_assigns', 'question_id')) {
                    $table->integer('question_id')->default(0);
                }

                if (!Schema::hasColumn('matching_type_question_assigns', 'option_id')) {
                    $table->integer('option_id')->default(0);
                }

                if (!Schema::hasColumn('matching_type_question_assigns', 'answer_id')) {
                    $table->integer('answer_id')->default(0);
                }
            });
        }

    }


    public function down()
    {
        Schema::dropIfExists('matching_type_question_assigns');
    }
};
