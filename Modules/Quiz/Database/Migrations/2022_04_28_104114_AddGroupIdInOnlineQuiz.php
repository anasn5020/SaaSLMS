<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGroupIdInOnlineQuiz extends Migration
{

    public function up()
    {
        Schema::table('online_quizzes', function ($table) {
            if (!Schema::hasColumn('online_quizzes', 'group_id')) {
                $table->integer('group_id')->nullable();
            }
        });
    }

    public function down()
    {
        //
    }
}
