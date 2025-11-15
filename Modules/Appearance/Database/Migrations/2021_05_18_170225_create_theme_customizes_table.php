<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateThemeCustomizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('theme_customizes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('theme_id')->default(1);
            $table->string('primary_color')->default('');
            $table->string('secondary_color')->default('');
            $table->boolean('is_default')->default(false);
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
        });

        $sql = [[
            'name' => "Default Theme",
            'theme_id' => "1",
            'primary_color' => "#FB1159",
            'secondary_color' => "#202E3B",
            'is_default' => 1,
            'created_by' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]];

        DB::table('theme_customizes')->insert($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('theme_customizes');
    }
}
