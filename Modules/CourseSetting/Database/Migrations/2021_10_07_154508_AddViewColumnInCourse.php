<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddViewColumnInCourse extends Migration
{

    public function up()
    {
        Schema::table('courses', function ($table) {
            if (!Schema::hasColumn('courses', 'view')) {
                $table->integer('view')->default(0);
            }
        });
    }


    public function down()
    {
        //
    }
}
