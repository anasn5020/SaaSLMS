<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveDublicateRoleInPermission extends Migration
{

    public function up()
    {
        $permissions = \Modules\RolePermission\Entities\Permission::where('route', 'myClasses')->get();
        if (count($permissions) == 2) {
            $permissions[1]->delete();
        }
        Cache::forget('PermissionList');
    }

    public function down()
    {
        //
    }
}
