<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAssistantInstructorColumnInCourse extends Migration
{


    public function up()
    {
        Schema::table('courses', function ($table) {
            if (!Schema::hasColumn('courses', 'assistant_instructors')) {
                $table->text('assistant_instructors')->nullable();
            }
        });
    }

    public function down()
    {
        //
    }
}
