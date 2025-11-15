<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\RolePermission\Entities\Permission;

class AddLoginActivityForStudent extends Migration
{

    public function up()
    {
        $routes = [
            ['name' => 'Login Activity', 'route' => 'student.loginActivity', 'type' => 3, 'parent_route' => 'student.student_list'],

        ];
        permissionUpdateOrCreate($routes);
    }


    public function down()
    {
        //
    }
}
