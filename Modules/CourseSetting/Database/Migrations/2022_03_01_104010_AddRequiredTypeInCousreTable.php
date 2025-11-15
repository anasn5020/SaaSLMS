<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRequiredTypeInCousreTable extends Migration
{
    public function up()
    {

        Schema::table('courses', function ($table) {
            if (!Schema::hasColumn('courses', 'required_type')) {
                $table->tinyInteger('required_type')->default(0);
            }
        });
    }

    public function down()
    {
        //
    }
}
