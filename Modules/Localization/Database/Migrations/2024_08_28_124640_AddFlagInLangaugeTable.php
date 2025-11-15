<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFlagInLangaugeTable extends Migration
{
    public function up()
    {
        Schema::table('languages', function ($table) {
            if (!Schema::hasColumn('languages', 'flag')) {
                $table->string('flag')->nullable();
            }
        });
    }
    public function down()
    {
        //
    }
}
