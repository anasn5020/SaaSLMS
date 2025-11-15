<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrderCompleteColumnInCourseTable extends Migration
{

    public function up()
    {
        Schema::table('courses', function (Blueprint $table) {
            if (!Schema::hasColumn('courses', 'complete_order')) {
//                1= complete as order 0 = complete not order
                $table->tinyInteger('complete_order')->default(0);
            }

        });
    }

    public function down()
    {
        //
    }
}
