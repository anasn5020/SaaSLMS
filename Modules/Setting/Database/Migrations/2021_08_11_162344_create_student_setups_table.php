<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentSetupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_setups', function (Blueprint $table) {
            $table->id();
            $table->integer('show_recommended_section')->default(0)->nullable();
            $table->integer('show_running_course_thumb')->default(0)->nullable();

            $table->timestamps();
        });
        DB::table('student_setups')->insert([
            [
                'show_running_course_thumb' => 0,
                'show_recommended_section' => 0,
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_setups');
    }
}
