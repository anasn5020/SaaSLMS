<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstructorTotalPayoutsTable extends Migration
{

    public function up()
    {
        Schema::create('instructor_total_payouts', function (Blueprint $table) {
            $table->id();
            $table->integer('instructor_id');
            $table->string('amount')->default(0);
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('instructor_total_payouts');
    }
}
