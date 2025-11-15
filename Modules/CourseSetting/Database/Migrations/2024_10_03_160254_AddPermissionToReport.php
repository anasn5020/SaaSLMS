<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPermissionToReport extends Migration
{
    public function up()
    {
        $routes = [
             ['name' => 'Institution wise User', 'route' => 'admin.institutionWiseUser', 'type' => 2, 'parent_route' => 'reports'],
             ['name' => 'Institution wise Performance', 'route' => 'admin.institutionWisePerformance', 'type' => 2, 'parent_route' => 'reports'],
             ['name' => 'User wise Performance', 'route' => 'admin.userWisePerformance', 'type' => 2, 'parent_route' => 'reports'],

        ];
        permissionUpdateOrCreate($routes);
    }

    public function down()
    {
        //
    }
}
