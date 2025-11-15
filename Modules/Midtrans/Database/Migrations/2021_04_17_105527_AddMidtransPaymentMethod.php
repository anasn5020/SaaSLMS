<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\PaymentMethodSetting\Entities\PaymentMethod;

class AddMidtransPaymentMethod extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        PaymentMethod::withoutEvents(function () {
            PaymentMethod::create([
                'method' => 'Midtrans',
                'type' => 'System',
                'active_status' => 0,
                'module_status' => 1,
                'logo' => 'public/demo/gateway/midtrans.png',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
