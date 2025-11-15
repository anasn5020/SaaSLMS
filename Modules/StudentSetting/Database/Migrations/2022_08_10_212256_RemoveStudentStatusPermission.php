<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Migrations\Migration;
use Modules\RolePermission\Entities\Permission;

class RemoveStudentStatusPermission extends Migration
{
    public function up()
    {
        $routes = [
            'student.enable_disable'
        ];
        Permission::whereIn('route', $routes)->delete();
        Cache::forget('PermissionList_' . SaasDomain());
        Cache::forget('RoleList_' . SaasDomain());
        Cache::forget('PolicyPermissionList_' . SaasDomain());
        Cache::forget('PolicyRoleList_' . SaasDomain());
    }

    public function down()
    {
        //
    }
}
