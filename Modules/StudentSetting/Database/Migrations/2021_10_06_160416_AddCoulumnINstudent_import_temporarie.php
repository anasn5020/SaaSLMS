<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCoulumnINstudentImportTemporarie extends Migration
{
    public function up()
    {
        Schema::table('student_import_temporaries', function ($table) {
            if (!Schema::hasColumn('courses', 'country')) {
                $table->integer('country')->nullable();
            }
        });

    }


    public function down()
    {
        //
    }
}
