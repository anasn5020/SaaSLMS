<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIAPinCourseTable extends Migration
{
    public function up()
    {
        Schema::table('courses', function ($table) {
            if (!Schema::hasColumn('courses', 'iap_product_id')) {
                $table->text('iap_product_id')->nullable();
            }
        });
    }

    public function down()
    {
        //
    }
}
