<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentImportTemporariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_import_temporaries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email', 100)->unique();
            $table->string('phone', 100)->nullable();
            $table->string('dob')->nullable();
            $table->string('company')->nullable();
            $table->string('gender')->nullable();
            $table->string('student_type')->nullable();
            $table->string('identification_number')->nullable();
            $table->string('job_title')->nullable();
            $table->integer('created_by')->nullable();
           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_import_temporaries');
    }
}
