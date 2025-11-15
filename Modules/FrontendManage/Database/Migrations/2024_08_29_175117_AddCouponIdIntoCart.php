<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddCouponIdIntoCart extends Migration
{
    public function up()
    {
        Schema::table('carts', function ($table) {
            if (!Schema::hasColumn('carts', 'coupon_id')) {
                $table->integer('coupon_id')->nullable();
            }
        });
    }

    public function down()
    {
        //
    }
}
