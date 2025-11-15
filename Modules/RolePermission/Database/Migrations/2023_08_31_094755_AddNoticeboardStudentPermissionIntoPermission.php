<?php

use Illuminate\Database\Migrations\Migration;
use Modules\RolePermission\Entities\Permission;

class AddNoticeboardStudentPermissionIntoPermission extends Migration
{

    public function up()
    {
        $routes = [
            ['name' => 'Notification Setup', 'route' => 'myNotificationSetup', 'type' => 1, 'parent_route' => null, 'backend' => 0],
        ];
        foreach ((array)$routes as $key => $route) {
            try {
                $parentSection = Permission::where('route', $route['parent_route'] ?? '')->first();
                if (!empty($parentSection)) {
                    $section_id = $parentSection->section_id;
                } else {
                    $section_id = 1;
                }
                Permission::where('route', $route['route'])->delete();
                Permission::create([
                    'name' => $route['name'],
                    'route' => $route['route'],
                    'parent_route' => $route['parent_route'] ?? null,
                    'type' => $route['type'] ?? 1,

                    'old_name' => $route['old_name'] ?? $route['name'],
                    'old_parent_route' => $route['old_parent_route'] ?? $route['parent_route'],
                    'old_type' => $route['old_type'] ?? $route['type'],


                    'backend' => $route['backend'] ?? 1,
                    'ecommerce' => $route['ecommerce'] ?? 0,
                    'icon' => $route['icon'] ?? 'fas fa-th',
                    'module' => $route['module'] ?? null,
                    'not_module' => $route['not_module'] ?? null,
                    'theme' => $route['theme'] ?? null,
                    'not_theme' => $route['not_theme'] ?? null,
                    'section_id' => $section_id,
                    'power' => $route['power'] ?? 0,
                    'status' => $route['status'] ?? 1,
                ]);
            } catch (\Exception $e) {
                Log::error($e->getMessage());
            }
        }

    }


    public function down()
    {
        //
    }
}
