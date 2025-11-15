<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ChangeDefaultLengthForFloat extends Migration
{

    public function up()
    {
        Schema::table('users', function ($table) {
            $table->float("balance", 20, 2)->nullable()->default(0.00)->change();
        });
//        $sqls[] = "ALTER TABLE `users` CHANGE `balance` `balance` DOUBLE(20,2) NOT NULL DEFAULT '0.00';";
        if (Schema::hasTable('checkouts')) {
            Schema::table('checkouts', function ($table) {
                $table->float("discount", 20, 2)->nullable()->default(0.00)->change();
                $table->float("purchase_price", 20, 2)->nullable()->default(0.00)->change();
                $table->float("price", 20, 2)->nullable()->default(0.00)->change();
            });
//            $sqls[] = "ALTER TABLE `checkouts` CHANGE `discount` `discount` DOUBLE(20,2) NOT NULL DEFAULT '0.00';";
//            $sqls[] = "ALTER TABLE `checkouts` CHANGE `purchase_price` `purchase_price` DOUBLE(20,2) NOT NULL DEFAULT '0.00';";
//            $sqls[] = "ALTER TABLE `checkouts` CHANGE `price` `price` DOUBLE(20,2) NOT NULL DEFAULT '0.00';";
        }

        if (Schema::hasTable('coupons')) {
            Schema::table('coupons', function ($table) {
                $table->float("value", 20, 2)->nullable()->default(0.00)->change();
                $table->float("min_purchase", 20, 2)->nullable()->default(0.00)->change();
                $table->float("max_discount", 20, 2)->nullable()->default(0.00)->change();
            });
//            $sqls[] = "ALTER TABLE `coupons` CHANGE `value` `value` DOUBLE(20,2) NOT NULL DEFAULT '0.00';";
//            $sqls[] = "ALTER TABLE `coupons` CHANGE `min_purchase` `min_purchase` DOUBLE(20,2) NOT NULL DEFAULT '0.00';";
//            $sqls[] = "ALTER TABLE `coupons` CHANGE `max_discount` `max_discount` DOUBLE(20,2) NOT NULL DEFAULT '0.00';";
        }

        if (Schema::hasTable('courses')) {
            Schema::table('courses', function ($table) {
                $table->float("reveune", 20, 2)->nullable()->default(0.00)->change();
            });
//            $sqls[] = "ALTER TABLE `courses` CHANGE `reveune` `reveune` DOUBLE(20,2) NOT NULL DEFAULT '0.00';";
        }

        if (Schema::hasTable('course_enrolleds')) {

            Schema::table('course_enrolleds', function ($table) {
                $table->float("purchase_price", 20, 2)->nullable()->default(0.00)->change();
                $table->float("discount_amount", 20, 2)->nullable()->default(0.00)->change();
                $table->float("reveune", 20, 2)->nullable()->default(0.00)->change();
            });
//            $sqls[] = "ALTER TABLE `course_enrolleds` CHANGE `purchase_price` `purchase_price` DOUBLE(20,2) NOT NULL DEFAULT '0.00';";
//            $sqls[] = "ALTER TABLE `course_enrolleds` CHANGE `discount_amount` `discount_amount` DOUBLE(20,2) NOT NULL DEFAULT '0.00';";
//            $sqls[] = "ALTER TABLE `course_enrolleds` CHANGE `reveune` `reveune` DOUBLE(20,2) NOT NULL DEFAULT '0.00';";
        }

        if (Schema::hasTable('offline_payments')) {
            Schema::table('offline_payments', function ($table) {
                $table->float("amount", 20, 2)->nullable()->default(0.00)->change();
                $table->float("after_bal", 20, 2)->nullable()->default(0.00)->change();
            });
//            $sqls[] = "ALTER TABLE `offline_payments` CHANGE `amount` `amount` DOUBLE(20,2) NOT NULL DEFAULT '0.00';";
//            $sqls[] = "ALTER TABLE `offline_payments` CHANGE `after_bal` `after_bal` DOUBLE(20,2) NOT NULL DEFAULT '0.00';";
        }
        if (Schema::hasTable('carts')) {

            Schema::table('carts', function ($table) {
                $table->float("price", 20, 2)->nullable()->default(0.00)->change();
            });
//            $sqls[] = "ALTER TABLE `carts` CHANGE `price` `price` DOUBLE(20,2) NOT NULL DEFAULT '0.00';";
        }

        if (Schema::hasTable('withdraws')) {

            Schema::table('withdraws', function ($table) {
                $table->float("amount", 20, 2)->nullable()->default(0.00)->change();
            });
//            $sqls[] = "ALTER TABLE `withdraws` CHANGE `amount` `amount` DOUBLE(20,2) NOT NULL DEFAULT '0.00';";
        }

        if (Schema::hasTable('instructor_payouts')) {
            Schema::table('instructor_payouts', function ($table) {
                $table->float("reveune", 20, 2)->nullable()->default(0.00)->change();
            });
//            $sqls[] = "ALTER TABLE `instructor_payouts` CHANGE `reveune` `reveune` DOUBLE(20,2) NOT NULL DEFAULT '0.00';";
        }

//        foreach ($sqls as $sql) {
//            DB::statement($sql);
//        }

    }

    public function down()
    {
        //
    }
}
