<?php

use Illuminate\Database\Migrations\Migration;

class PermissionMenuAdd extends Migration
{
    public function up()
    {
        $routes = [
            ['name' => 'Custom CSS & JS', 'route' => 'frontend.customJsCss', 'type' => 2, 'parent_route' => 'frontend_CMS'],
        ];
        permissionUpdateOrCreate($routes);
    }

    public function down()
    {
        //
    }
}
