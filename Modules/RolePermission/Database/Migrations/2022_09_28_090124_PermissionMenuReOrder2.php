<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\RolePermission\Entities\Permission;

class PermissionMenuReOrder2 extends Migration
{
    public function up()
    {
        $item = Permission::where('route', 'set-quiz.enrolled-student')->first();
        if (!$item) {
            $item = new Permission();
            $item->name = 'Result View';
            $item->route = 'set-quiz.enrolled-student';
            $item->type = 3;
            $item->parent_route = 'online-quiz';
            $item->save();
        }

        $item = Permission::where('route', 'frontend.page.changeHomepage')->first();
        if (!$item) {
            $item = new Permission();
            $item->name = 'Change Homepage';
            $item->route = 'frontend.page.changeHomepage';
            $item->type = 3;
            $item->parent_route = 'frontend.page.index';
            $item->save();
        }


        $item = Permission::where('route', 'getAllCourse')->first();
        if ($item) {
            $item->name = 'All Courses';
            $item->save();
        }

        $deleted_routes = [
            'virtual-class.list'
        ];
        Permission::whereIn('route', $deleted_routes)->delete();
    }

    public function down()
    {
        //
    }
}
