<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMobilPayOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('mobil_pay_orders')) {
            Schema::create('mobil_pay_orders', function (Blueprint $table) {
                $table->id();
                $table->integer('user_id');
                $table->integer('checkout_id')->nullable();
                $table->string('orderId');
                $table->string('status')->default('pending');
                $table->string('type')->default('Deposit')->comment('deposit/payment');
                $table->double('amount')->default(0.00);

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mobil_pay_orders');
    }
}
