<?php

use Illuminate\Database\Migrations\Migration;

class AddAnalyticsSetting extends Migration
{
    public function up()
    {
        $routes = [
            ['name' => 'Analytics Tool', 'route' => 'settings.analytics.index', 'type' => 2, 'parent_route' => 'settings'],
        ];
        permissionUpdateOrCreate($routes);
    }

    public function down()
    {
        //
    }
}
