<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class AddExplanationColumnInQuestionBank extends Migration
{

    public function up()
    {
        Schema::table('question_banks', function ($table) {
            if (!Schema::hasColumn('question_banks', 'explanation')) {
                $table->text('explanation')->nullable();
            }
        });
    }

    public function down()
    {
        //
    }
}
