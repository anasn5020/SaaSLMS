<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddShuffleColumnInQuestionBank extends Migration
{
    public function up()
    {
        Schema::table('question_banks', function ($table) {
            if (!Schema::hasColumn('question_banks', 'shuffle')) {
                $table->tinyInteger('shuffle')->default(1);
            }
        });
    }

    public function down()
    {
        //
    }
}
