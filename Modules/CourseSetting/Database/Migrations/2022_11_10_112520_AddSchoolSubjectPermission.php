<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\RolePermission\Entities\Permission;

class AddSchoolSubjectPermission extends Migration
{
    public function up()
    {
        $routes = [
            ['name' => 'School Subject', 'route' => 'schoolSubject', 'type' => 2, 'parent_route' => 'courses'],
            ['name' => 'Add', 'route' => 'schoolSubject.store', 'type' => 3, 'parent_route' => 'schoolSubject'],
            ['name' => 'Edit', 'route' => 'schoolSubject.edit', 'type' => 3, 'parent_route' => 'schoolSubject'],
            ['name' => 'Delete', 'route' => 'schoolSubject.destroy', 'type' => 3, 'parent_route' => 'schoolSubject'],
        ];

        permissionUpdateOrCreate($routes);


        Schema::table('courses', function ($table) {
            if (!Schema::hasColumn('courses', 'school_subject_id')) {
                $table->integer('school_subject_id')->default(0);
            }
        });
    }

    public function down()
    {
        //
    }
}
