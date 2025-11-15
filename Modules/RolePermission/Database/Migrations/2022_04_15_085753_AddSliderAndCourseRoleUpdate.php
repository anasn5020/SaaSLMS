<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSliderAndCourseRoleUpdate extends Migration
{

    public function up()
    {
        DB::table('permissions')->where('route', 'getActiveCourse')->delete();
        DB::table('permissions')->where('route', 'getPendingCourse')->delete();

        $id =\Modules\RolePermission\Entities\Permission::max('id');
        DB::table('permissions')->insert([
            [
                'id'=>$id+1,
                'name' => 'Slider',
                'route' => 'frontend.sliders',
                'parent_route' => 'frontend_CMS',
                'type' => 2,
            ], [
                'id'=>$id+2,
                'name' => 'List',
                'route' => 'frontend.sliders.index',
                'parent_route' => 'frontend.sliders',
                'type' => 3,
            ], [
                'id'=>$id+3,
                'name' => 'Setting',
                'route' => 'frontend.sliders.setting',
                'parent_route' => 'frontend.sliders',
                'type' => 3,
            ],
        ]);
    }


    public function down()
    {
        //
    }
}
