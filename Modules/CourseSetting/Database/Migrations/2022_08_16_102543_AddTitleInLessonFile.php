<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTitleInLessonFile extends Migration
{
    public function up()
    {
        Schema::table('lesson_files', function ($table) {
            if (!Schema::hasColumn('lesson_files', 'title')) {
                $table->text('title')->nullable();
            }
        });
    }

    public function down()
    {
        //
    }
}
