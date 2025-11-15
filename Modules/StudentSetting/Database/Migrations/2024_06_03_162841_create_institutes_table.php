<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstitutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('institutes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('address')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });


        //create a column in users table for institute id if not exist
        if (!Schema::hasColumn('users', 'institute_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->unsignedBigInteger('institute_id')->nullable();
            });
        }


//        Add permission for institute
        $routes = [
            ['name' => 'Institutes', 'route' => 'student.institute.index', 'type' => 2, 'parent_route' => 'students'],
        ];
        permissionUpdateOrCreate($routes);


        //add column for student_custom_fields if not exist (show_institute,required_institute,editable_institute)
        if (!Schema::hasColumn('student_custom_fields', 'show_institute')) {
            Schema::table('student_custom_fields', function (Blueprint $table) {
                $table->boolean('show_institute')->default(0);
                $table->boolean('required_institute')->default(0);
                $table->boolean('editable_institute')->default(1);
            });
        }


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('institutes');
    }
}
