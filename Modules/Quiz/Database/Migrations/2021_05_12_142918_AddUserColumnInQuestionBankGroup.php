<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddUserColumnInQuestionBankGroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('question_groups', function ($table) {
            if (!Schema::hasColumn('question_groups', 'user_id')) {
                $table->integer('user_id')->default(1);
            }
        });

        Schema::table('question_banks', function ($table) {
            if (!Schema::hasColumn('question_banks', 'user_id')) {
                $table->integer('user_id')->default(1);
            }
        });
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
