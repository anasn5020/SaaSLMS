<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Modules\ModuleManager\Entities\Module;

class AddNewPaymentGatewayModules extends Migration
{
    public function up()
    {
        $totalCount = DB::table('modules')->count();
        $modules = [
            ['name' => 'AuthorizeNet', 'details' => 'AuthorizeNet payment gateway for Infixlms'],
            ['name' => 'Braintree', 'details' => 'Braintree payment gateway for Infixlms'],
            ['name' => 'Flutterwave', 'details' => 'Flutterwave payment gateway for Infixlms'],
            ['name' => 'Mollie', 'details' => 'Mollie payment gateway for Infixlms'],
            ['name' => 'JazzCash', 'details' => 'JazzCash payment gateway for Infixlms'],
            ['name' => 'Coinbase', 'details' => 'Coinbase payment gateway for Infixlms'],
            ['name' => 'CCAvenue', 'details' => 'CCAvenue payment gateway for Infixlms'],
        ];
        foreach ($modules as $key => $module) {
            Module::updateOrCreate([
                'name' => $module['name'],
            ], [
                    'name' => $module['name'],
                    'details' => $module['details'],
                    'status' => 1,
                    'order' => $totalCount + $key
                ]
            );
        }
    }

    public function down()
    {
        //
    }
}
