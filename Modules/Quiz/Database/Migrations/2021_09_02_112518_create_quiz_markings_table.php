<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuizMarkingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_markings', function (Blueprint $table) {
            $table->id();
            $table->integer('quiz_id')->nullable();
            $table->integer('quiz_test_id')->nullable();
            $table->integer('student_id')->nullable();
            $table->integer('marked_by')->default(0)->nullable();
            $table->integer('marking_status')->default(0)->nullable();
            $table->double('marks')->default(0)->nullable();

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
        Schema::dropIfExists('quiz_markings');
    }
}
