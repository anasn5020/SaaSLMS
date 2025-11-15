<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDefaultSettingInOnlineQuiz extends Migration
{

    public function up()
    {
        Schema::table('online_quizzes', function ($table) {
            if (!Schema::hasColumn('online_quizzes', 'default_setting')) {
                $table->tinyInteger('default_setting')->default(1);
            }
        });
    }

    public function down()
    {
        //
    }
}
