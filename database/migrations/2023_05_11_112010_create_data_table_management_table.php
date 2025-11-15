<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataTableManagementTable extends Migration
{
    public function up()
    {
        Schema::create('data_table_management', function (Blueprint $table) {
            $table->id();
            $table->string('table_name')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('column_label')->nullable();
            $table->string('column_name')->nullable();
            $table->boolean('is_visible')->nullable()->default(1);
            $table->boolean('is_default')->nullable()->default(0);
            $table->integer('order')->nullable();
            $table->integer('original_order')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('data_table_management');
    }
}
