<?php

use Illuminate\Database\Migrations\Migration;

class AddPusherSettingPermission extends Migration
{
    public function up()
    {
//        dashboard.total_student_by_each_course
        $routes = [
            ['name' => 'Pusher Setting', 'route' => 'pusher.setting', 'type' => 2, 'parent_route' => 'settings'],
            ['name' => 'Total Student By Each Course', 'route' => 'dashboard.total_student_by_each_course', 'type' => 2, 'parent_route' => 'dashboard'],
        ];
        if (function_exists('permissionUpdateOrCreate')) {
            permissionUpdateOrCreate($routes);
        }
    }

    public function down()
    {
        //
    }
}
