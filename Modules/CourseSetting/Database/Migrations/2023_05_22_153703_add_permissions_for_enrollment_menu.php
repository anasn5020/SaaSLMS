<?php

use Illuminate\Database\Migrations\Migration;
use Modules\RolePermission\Entities\Permission;

class AddPermissionsForEnrollmentMenu extends Migration
{
    public function up()
    {
        $routes = [
            ['name' => 'Enrollment', 'route' => 'enrollment', 'type' => 1, 'parent_route' => null],
            ['name' => 'Enroll List', 'route' => 'admin.enrollLogs', 'type' => 2, 'parent_route' => 'enrollment'],
            ['name' => 'New Enroll', 'route' => 'student.new_enroll', 'type' => 2, 'parent_route' => 'enrollment'],
            ['name' => 'Refund & Cancellation', 'route' => 'admin.cancelLogs', 'type' => 2, 'parent_route' => 'enrollment'],
            ['name' => 'Approved', 'route' => 'refund.approved', 'type' => 3, 'parent_route' => 'admin.cancelLogs'],
            ['name' => 'Reject', 'route' => 'refund.reject', 'type' => 3, 'parent_route' => 'admin.cancelLogs'],
            ['name' => 'Refund Setting', 'route' => 'refund.settings.create', 'type' => 2, 'parent_route' => 'enrollment'],
            ['name' => 'Refund & Cancellation', 'route' => 'enrollmentCancellation', 'type' => 1, 'parent_route' => null, 'backend' => 0],

        ];
        permissionUpdateOrCreate($routes);

    }

    public function down()
    {

    }
}
