<?php

use App\StudentCustomField;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentCustomFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_custom_fields', function (Blueprint $table) {
            $table->id();
            $table->boolean('show_company')->default(0);
            $table->boolean('show_gender')->default(0);
            $table->boolean('show_student_type')->default(0);
            $table->boolean('show_identification_number')->default(0);
            $table->boolean('show_job_title')->default(0);
            $table->boolean('show_dob')->default(0);
            $table->boolean('show_name')->default(1);
            $table->boolean('required_company')->default(0);
            $table->boolean('required_gender')->default(0);
            $table->boolean('required_student_type')->default(0);
            $table->boolean('required_identification_number')->default(0);
            $table->boolean('required_job_title')->default(0);
            $table->boolean('required_dob')->default(0);
            $table->boolean('required_name')->default(1);
            $table->boolean('editable_company')->default(1);
            $table->boolean('editable_gender')->default(1);
            $table->boolean('editable_student_type')->default(1);
            $table->boolean('editable_identification_number')->default(1);
            $table->boolean('editable_job_title')->default(1);
            $table->boolean('editable_dob')->default(1);
            $table->boolean('editable_name')->default(1);

            $table->timestamps();
        });

        StudentCustomField::create([
            'show_company' => 0
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_custom_fields');
    }
}
