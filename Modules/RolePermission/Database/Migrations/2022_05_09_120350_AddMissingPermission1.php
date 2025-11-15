<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class AddMissingPermission1 extends Migration
{

    public function up()
    {
        $id =\Modules\RolePermission\Entities\Permission::max('id');
        DB::table('permissions')->insert([
            [
                'id'=>$id+1,
                'name' => 'Regular Student Import',
                'route' => 'regular_student_import',
                'parent_route' => 'students',
                'type' => 2,
            ], [
                'id'=>$id+2,
                'name' => 'New Enroll',
                'route' => 'student.new_enroll',
                'parent_route' => 'students',
                'type' => 2,
            ], [
                'id'=>$id+3,
                'name' => 'Setting',
                'route' => 'student.student_field',
                'parent_route' => 'students',
                'type' => 2,
            ],
        ]);
    }

    public function down()
    {
        //
    }
}
