<?php

use Illuminate\Database\Migrations\Migration;

class AddMediaManagerPermission extends Migration
{
    public function up()
    {
        $routes = [
            ['name' => 'Media manager', 'route' => 'setting.media-manager', 'type' => 1, 'parent_route' => null],
            ['name' => 'All files', 'route' => 'setting.media-manager.index', 'type' => 2, 'parent_route' => 'setting.media-manager'],
            ['name' => 'New upload', 'route' => 'setting.media-manager.create', 'type' => 2, 'parent_route' => 'setting.media-manager'],
            ['name' => 'Setting', 'route' => 'setting.media-manager.setting', 'type' => 2, 'parent_route' => 'setting.media-manager'],


        ];
        permissionUpdateOrCreate($routes);

        UpdateGeneralSetting('active_storage', 'LocalStorage');
    }

    public function down()
    {
        //
    }
}
