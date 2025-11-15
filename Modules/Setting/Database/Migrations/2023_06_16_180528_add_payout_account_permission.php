<?php

use Illuminate\Database\Migrations\Migration;
use Modules\RolePermission\Entities\Permission;

class AddPayoutAccountPermission extends Migration
{
    public function up()
    {
        $routes = [
            ['name' => 'Payout Account', 'route' => 'admin.payout_accounts.index', 'type' => 2, 'parent_route' => 'settings'],
            ['name' => 'Create', 'route' => 'admin.payout_accounts.store', 'type' => 3, 'parent_route' => 'admin.payout_accounts.index'],
            ['name' => 'Edit', 'route' => 'admin.payout_accounts.update', 'type' => 3, 'parent_route' => 'admin.payout_accounts.index'],
            ['name' => 'Delete', 'route' => 'admin.payout_accounts.destroy', 'type' => 3, 'parent_route' => 'admin.payout_accounts.index'],
            ['name' => 'Course Commission Delete', 'route' => 'setting.courseCommission.delete', 'type' => 3, 'parent_route' => 'setting.setCommission'], //delete course commission permission


        ];
        permissionUpdateOrCreate($routes);
    }
}
