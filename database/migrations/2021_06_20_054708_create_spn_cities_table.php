<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpnCitiesTable extends Migration
{
    public function up()
    {
        Schema::create('spn_cities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100)->nullable();
            $table->integer('state_id')->nullable();
            $table->integer('country_id')->nullable();
            $table->tinyInteger('flag')->nullable();
            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::dropIfExists('spn_cities');
    }
}
