<?php

use Illuminate\Database\Migrations\Migration;

class AddHeaderFooterInFrontend extends Migration
{
    public function up()
    {
        $routes = [
            ['name' => 'Header/Footer Style', 'route' => 'frontend.header-footer-style.index', 'type' => 2, 'parent_route' => 'frontend_CMS'],

        ];
        permissionUpdateOrCreate($routes);
    }


    public function down()
    {
        //
    }
}
