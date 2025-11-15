<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHomePageBlocPosition4 extends Migration
{

    public function up()
    {
        DB::table('homepage_block_positions')->insert([
            'block_name' => 'Homepage FAQ',
            'order' => 17,
            'created_at' => now(),
            'updated_at' => now(),

        ]);
    }


    public function down()
    {
        //
    }
}
