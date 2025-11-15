<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCouponLimitColumnInCouponTable extends Migration
{

    public function up()
    {
        Schema::table('coupons', function ($table) {
            if (!Schema::hasColumn('coupons', 'limit')) {
                $table->integer('limit')->default(0);
            }
        });
    }

    public function down()
    {
        //
    }
}
