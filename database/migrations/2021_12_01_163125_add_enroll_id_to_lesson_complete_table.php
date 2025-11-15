<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEnrollIdToLessonCompleteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::table('lesson_completes', function ($table) {
            if (!Schema::hasColumn('lesson_completes', 'enroll_id')) {
                $table->integer('enroll_id')->nullable();
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
        Schema::table('lesson_complete', function (Blueprint $table) {
            //
        });
    }
}
