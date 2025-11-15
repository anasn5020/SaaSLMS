<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFileSizeColumnToLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('lessons', function ($table) {
            if (!Schema::hasColumn('lessons', 'file_size')) {
                $table->double('old_file_size')->nullable();
            }
            if (!Schema::hasColumn('lessons', 'file_size')) {
                $table->double('file_size')->nullable();
            }
        });
       Schema::table('course_exercises', function ($table) {
            if (!Schema::hasColumn('course_exercises', 'file_size')) {
                $table->double('old_file_size')->nullable();
            }
            if (!Schema::hasColumn('course_exercises', 'file_size')) {
                $table->double('file_size')->nullable();
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
