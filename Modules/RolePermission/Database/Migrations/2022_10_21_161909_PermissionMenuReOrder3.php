<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\RolePermission\Entities\Permission;

class PermissionMenuReOrder3 extends Migration
{
    public function up()
    {
        $routes = [
            ['name' => 'Quiz Re-Test', 'route' => 'quizReTest', 'type' => 3, 'parent_route' => 'online-quiz'],
        ];
        permissionUpdateOrCreate($routes);
    }

    public function down()
    {
        //
    }
}
