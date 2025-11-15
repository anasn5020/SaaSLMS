<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlidersTable extends Migration
{

    public function up()
    {
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('sub_title')->nullable();
            $table->string('image')->nullable();
            $table->string('btn_title1')->nullable();
            $table->string('btn_link1')->nullable();
            $table->string('btn_image1')->nullable();
            $table->boolean('btn_type1')->default(1);
            $table->boolean('btn_type2')->default(1);

            $table->string('btn_title2')->nullable();
            $table->string('btn_link2')->nullable();
            $table->string('btn_image2')->nullable();

            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('sliders');
    }
}
