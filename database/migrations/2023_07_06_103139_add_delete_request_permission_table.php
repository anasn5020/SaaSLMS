<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\RolePermission\Entities\Permission;

return new class extends Migration {
    public function up()
    {
        $routes = [
            ['name' => 'Delete Request', 'route' => 'admin.user_delete_request.index', 'type' => 2, 'parent_route' => 'user.manager'],
            ['name' => 'Delete', 'route' => 'admin.user_delete_request.destroy', 'type' => 3, 'parent_route' => 'admin.user_delete_request.index'],
            ['name' => 'Reject', 'route' => 'admin.user_delete_request.reject', 'type' => 3, 'parent_route' => 'admin.user_delete_request.index'],

        ];
        permissionUpdateOrCreate($routes);
    }

    public function down()
    {

    }
};
