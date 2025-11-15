<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewBlockForWhyChooseHomePage extends Migration
{

    public function up()
    {
        DB::table('homepage_block_positions')->insert([            [
            'block_name' => 'Continue watching',
            'order' => 18,
            'created_at' => now(),
            'updated_at' => now(),
        ],[
            'block_name' => 'Popular Courses',
            'order' => 19,
            'created_at' => now(),
            'updated_at' => now(),
        ],[
            'block_name' => 'Course level',
            'order' => 20,
            'created_at' => now(),
            'updated_at' => now(),
        ],[
            'block_name' => 'Why Choose',
            'order' => 21,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        ]);
    }

    public function down()
    {
        //
    }
}
