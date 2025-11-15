<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Modules\RolePermission\Entities\Permission;

class AddUserManageRolePsermission extends Migration
{

    public function up()
    {
        $sql = [
            ['name' => 'User manager', 'route' => 'user.manager', 'parent_route' => null, 'type' => 1],
            ['name' => 'Staff', 'route' => 'staffs.index', 'parent_route' => 'user.manager', 'type' => 2],
            ['name' => 'Create', 'route' => 'staffs.store', 'parent_route' => 'staffs.index', 'type' => 3],
            ['name' => 'Update', 'route' => 'staffs.update', 'parent_route' => 'staffs.index', 'type' => 3],
            ['name' => 'Delete', 'route' => 'staffs.destroy', 'parent_route' => 'staffs.index', 'type' => 3],
//            ['name' => 'View', 'route' => 'staffs.view', 'parent_route' => 'staffs.index', 'type' => 3],
            ['name' => 'Active', 'route' => 'staffs.active', 'parent_route' => 'staffs.index', 'type' => 3],
            ['name' => 'Inactive', 'route' => 'staffs.inactive', 'parent_route' => 'staffs.index', 'type' => 3],
            ['name' => 'Resume', 'route' => 'staffs.resume', 'parent_route' => 'staffs.index', 'type' => 3],

            ['name' => 'Department', 'route' => 'hr.department.index', 'parent_route' => 'user.manager', 'type' => 2],
            ['name' => 'Store', 'route' => 'hr.department.store', 'parent_route' => 'hr.department.index', 'type' => 3]
        ];


        if (config('database.default') == 'pgsql') {
            $id = Permission::max('id');
            DB::statement("ALTER SEQUENCE permissions_id_seq RESTART WITH " . ++$id);
        }

        Permission::withoutEvents(function () use ($sql) {

            foreach ($sql as $item) {
                Permission::updateOrCreate(
                    [
                        'route' => $item['route']
                    ], [
                        'name' => $item['name'],
                        'route' => $item['route'],
                        'parent_route' => $item['parent_route'],
                        'type' => $item['type'],
                    ]
                );
            }

        });
    }

    public function down()
    {
        //
    }
}
