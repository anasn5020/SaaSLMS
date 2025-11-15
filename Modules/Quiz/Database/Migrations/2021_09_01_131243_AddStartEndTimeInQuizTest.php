<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStartEndTimeInQuizTest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quiz_tests', function ($table) {
            if (!Schema::hasColumn('quiz_tests', 'start_at')) {
                $table->timestamp('start_at')->nullable()->default(now());
            }

            if (!Schema::hasColumn('quiz_tests', 'end_at')) {
                $table->timestamp('end_at')->nullable();
            }
            if (!Schema::hasColumn('quiz_tests', 'duration')) {
                $table->decimal('duration', 11, 2)->nullable();
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
