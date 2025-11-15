<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\RolePermission\Entities\Permission;

class AddSecretLoginPermission extends Migration
{
    public function up()
    {
        $routes = [
            ['name' => 'Secret Login', 'route' => 'instructor.secretLogin', 'type' => 3, 'parent_route' => 'allInstructor'],
            ['name' => 'Secret Login', 'route' => 'student.secretLogin', 'type' => 3, 'parent_route' => 'student.student_list'],
            ['name' => 'Secret Login', 'route' => 'staffs.secretLogin', 'type' => 3, 'parent_route' => 'staffs.index'],
            ['name' => 'Secret Login', 'route' => 'organization.secretLogin', 'type' => 3, 'parent_route' => 'organization.index'],
        ];

        permissionUpdateOrCreate($routes);
    }

    public function down()
    {
        //
    }
}
