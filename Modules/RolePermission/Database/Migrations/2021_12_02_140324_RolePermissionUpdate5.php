<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RolePermissionUpdate5 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = [
            //Course Statustics
            ['id' => 552, 'module_id' => 5, 'parent_id' => 5, 'name' => 'Course Statistics', 'route' => 'course.courseStatistics', 'type' => 2],
            ['id' => 553, 'module_id' => 2, 'parent_id' => 31, 'name' => 'Courses', 'route' => 'student.courses', 'type' => 3],
            ['id' => 554, 'module_id' => 5, 'parent_id' => 60, 'name' => 'Students', 'route' => 'course.enrolled_students', 'type' => 3],
            ['id' => 555, 'module_id' => 5, 'parent_id' => 60, 'name' => 'Send Invitation', 'route' => 'course.courseInvitation', 'type' => 3],
            ['id' => 556, 'module_id' => 5, 'parent_id' => 60, 'name' => 'Notify', 'route' => 'course.courseStudentNotify', 'type' => 3],

        ];


        DB::table('permissions')->insert($sql);
        Cache::forget('PermissionList');
        Cache::forget('RoleList');
        Cache::forget('PolicyPermissionList');
        Cache::forget('PolicyRoleList');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
