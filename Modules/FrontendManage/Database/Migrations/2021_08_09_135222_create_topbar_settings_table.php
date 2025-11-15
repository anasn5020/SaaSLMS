<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopbarSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topbar_settings', function (Blueprint $table) {
            $table->id();

            $table->integer('is_topbar')->default(1);

            $table->integer('left_side_text_show')->default(1)->nullable();
            $table->string('left_side_text')->default('Company Address')->nullable();
            $table->string('left_side_text_link')->default('Company Address')->nullable();
            $table->string('left_side_logo')->default('Company Address')->nullable();

            $table->integer('right_side_text_1_show')->default(1)->nullable();
            $table->string('right_side_text_1')->default('Company Email')->nullable();
            $table->string('right_side_text_1_link')->nullable();
            $table->string('reight_side_logo_1')->default('Company Email')->nullable();

            $table->integer('right_side_text_2_show')->default(1)->nullable();
            $table->string('right_side_text_2')->default('Company Phone')->nullable();
            $table->string('right_side_text_2_link')->nullable();
            $table->string('reight_side_logo_2')->default('Company Phone')->nullable();

            $table->timestamps();

        });

        DB::table('topbar_settings')->insert([
            [
                'left_side_text_show' => 1,
                'left_side_text' => 'Company Address',
                'left_side_text_link' => null,
                'left_side_logo' => 'fa fa-map-marker',

                'right_side_text_1_show' => 1,
                'right_side_text_1' => 'hello@aorasoft.com',
                'right_side_text_1_link' => null,
                'reight_side_logo_1' => 'fa fa-envelope',

                'right_side_text_2_show' => 1,
                'right_side_text_2' => '0155544448888',
                'right_side_text_2_link' => null,
                'reight_side_logo_2' => 'fa fa-phone',
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
        Schema::dropIfExists('topbar_settings');
    }
}
