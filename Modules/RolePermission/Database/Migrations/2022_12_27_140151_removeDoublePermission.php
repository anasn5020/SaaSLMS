<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveDoublePermission extends Migration
{
    public function up()
    {
        $roles = \Modules\RolePermission\Entities\Permission::where('route', 'permission.roles.index')->get();
        if (count($roles) > 1) {
            $roles[0]->delete();
        }

        \Modules\RolePermission\Entities\Permission::where('route', 'permission.student-roles')->delete();


    }

    public function down()
    {
        //
    }
}
