<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserIdInCategory extends Migration
{

    public function up()
    {
        Schema::table('categories', function ($table) {
            if (!Schema::hasColumn('categories', 'user_id')) {
                $table->integer('user_id')->default(1);
            }
        });
    }


    public function down()
    {
        //
    }
}
