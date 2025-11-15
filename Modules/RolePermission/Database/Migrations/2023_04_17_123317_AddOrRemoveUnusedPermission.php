<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\RolePermission\Entities\Permission;

class AddOrRemoveUnusedPermission extends Migration
{
    public function up()
    {


        $notForTheme = [
            'frontend.AboutPage',
            'frontend.ContactPageContent'
        ];
        Permission::whereIn('route', $notForTheme)->update([
            'not_theme' => 'infixlmstheme'
        ]);

        Permission::where('route', 'appearance.themes-customize.index')->update([
            'name' => 'Theme color scheme'
        ]);
        $routes = [
            ['name' => 'Department',
                'route' => 'hr.department.index',
                'parent_route' => 'user.manager',
                'status' => 1,
                'type' => 2,
                'menu_status' => 1,
            ]
        ];

        permissionUpdateOrCreate($routes);

    }

    public function down()
    {
        //
    }
}
