<?php

use Illuminate\Database\Migrations\Migration;
use Modules\RolePermission\Entities\Permission;

class AddNewPermissionForNewFeature02 extends Migration
{
    public function up()
    {
        $routes = [
            ['name' => 'Cookie/GDPR Setting', 'route' => 'setting.cookieSetting', 'type' => 2, 'parent_route' => 'settings'],
            ['name' => 'Theme Font', 'route' => 'appearance.themes-font.index', 'type' => 2, 'parent_route' => 'appearance'],
            ['name' => 'Class Details', 'route' => 'virtual-class.details', 'type' => 3, 'parent_route' => 'virtual-class.index'],
            ['name' => 'Class Edit', 'route' => 'custom.meetings.edit', 'type' => 3, 'parent_route' => 'virtual-class.details'],
        ];

        permissionUpdateOrCreate($routes);


        $maintenance = Permission::where('route', 'setting.maintenance')->first();
        if ($maintenance) {
            $parentSection = Permission::where('route', $maintenance->parent_route)->first();
            if (!empty($parentSection)) {
                $section_id = $parentSection->section_id;
            } else {
                $section_id = 1;
            }
            $maintenance->section_id = $section_id;
            $maintenance->save();
        }


    }

    public function down()
    {
        //
    }
}
