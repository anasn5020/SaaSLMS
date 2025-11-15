<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHomePageBlocPosition2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::table('homepage_block_positions')->insert([            [
                'block_name' => 'Live Class',
                'order' => 13,
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'block_name' => 'About LMS',
                'order' => 14,
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'block_name' => 'Subscription Section',
                'order' => 15,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
