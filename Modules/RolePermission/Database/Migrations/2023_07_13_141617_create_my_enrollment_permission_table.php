<?php

use Illuminate\Database\Migrations\Migration;
use Modules\RolePermission\Entities\Permission;

return new class extends Migration {
    public function up()
    {
        $routes = [
            ['name' => 'My Panel', 'route' => 'users.my_panel.index', 'type' => 1, 'parent_route' => null],
            ['name' => 'My Topics', 'route' => 'users.my_topics.index', 'type' => 2, 'parent_route' => 'users.my_panel.index'],
            ['name' => 'Deposit', 'route' => 'users.deposit.index', 'type' => 2, 'parent_route' => 'users.my_panel.index'],
            ['name' => 'My Certificate', 'route' => 'users.my_certificates.index', 'type' => 2, 'parent_route' => 'users.my_panel.index'],
            ['name' => 'Logged In Device', 'route' => 'users.logged_in_devices.index', 'type' => 2, 'parent_route' => 'users.my_panel.index'],
            ['name' => 'Referral', 'route' => 'users.my_referral.index', 'type' => 2, 'parent_route' => 'users.my_panel.index'],
            ['name' => 'Purchase History', 'route' => 'users.my_purchase.index', 'type' => 2, 'parent_route' => 'users.my_panel.index'],
            ['name' => 'Refund & Cancellation', 'route' => 'users.my_refund.index', 'type' => 2, 'parent_route' => 'users.my_panel.index'],

            ['name' => 'Payout Settings', 'route' => 'admin.payout.settings', 'type' => 2, 'parent_route' => 'payments'],

        ];
        permissionUpdateOrCreate($routes);

    }


};
