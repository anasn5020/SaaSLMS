<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsedMediaTable extends Migration
{
    public function up()
    {
        Schema::create('used_media', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('media_id');
            $table->unsignedBigInteger('usable_id');
            $table->string('usable_type');
            $table->string('used_for');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('used_media');
    }
}
