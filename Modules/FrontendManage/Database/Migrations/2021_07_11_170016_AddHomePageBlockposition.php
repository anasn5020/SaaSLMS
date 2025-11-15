<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHomePageBlockposition extends Migration
{
    public function up()
    {
        Schema::create('homepage_block_positions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('block_name');
            $table->integer('order');
            $table->timestamps();
        });


        DB::table('homepage_block_positions')->insert([
            [
                'block_name' => 'Homepage Banner',
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'block_name' => 'Key Feature',
                'order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'block_name' => 'Category Section',
                'order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'block_name' => 'Instructor Section',
                'order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'block_name' => 'Course Section',
                'order' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'block_name' => 'Best Category Section',
                'order' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'block_name' => 'Quiz Section',
                'order' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'block_name' => 'Testimonial Section',
                'order' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'block_name' => 'Sponsor Section',
                'order' => 9,
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'block_name' => 'Article Section',
                'order' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'block_name' => 'Become Instructor Section',
                'order' => 11,
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'block_name' => 'Subscribe Section',
                'order' => 12,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }


    public function down()
    {
        Schema::dropIfExists('homepage_block_positions');
    }
}
