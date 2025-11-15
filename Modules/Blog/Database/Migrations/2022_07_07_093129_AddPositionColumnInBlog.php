<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPositionColumnInBlog extends Migration
{
    public function up()
    {
        Schema::table('blogs', function ($table) {

            if (!Schema::hasColumn('blogs', 'position_audience')) {
                $table->tinyInteger('position_audience')->default(1)->comment('1=public,2=Specify');
            }

        });
    }

    public function down()
    {
        //
    }
}
