<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstructorSetupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instructor_setups', function (Blueprint $table) {
            $table->id();
            $table->integer('show_instructor_page_banner')->default(1)->nullable();
            $table->timestamps();
        });
        DB::table('instructor_setups')->insert([
            [
                'show_instructor_page_banner' => 1,
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
        Schema::dropIfExists('instructor_setups');
    }
}
