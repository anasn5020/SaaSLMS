<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFocusLostInQuizTest extends Migration
{
    public function up()
    {
        Schema::table('quiz_tests', function ($table) {
            if (!Schema::hasColumn('quiz_tests', 'focus_lost')) {
                $table->integer('focus_lost')->default(0);
            }
        });
    }

    public function down()
    {
        //
    }
}
