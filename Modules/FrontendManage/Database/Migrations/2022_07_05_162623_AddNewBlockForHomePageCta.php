<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class AddNewBlockForHomePageCta extends Migration
{
    public function up()
    {
        DB::table('homepage_block_positions')->insert([[
            'block_name' => 'Call To Action',
            'order' => 22,
            'created_at' => now(),
            'updated_at' => now(),
        ]]);
    }

    public function down()
    {
        //
    }
}
