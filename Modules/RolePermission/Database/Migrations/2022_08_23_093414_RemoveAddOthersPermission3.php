<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\RolePermission\Entities\Permission;

class RemoveAddOthersPermission3 extends Migration
{
    public function up()
    {
        Permission::where('route', 'enrollLogs.change_status')->delete();


        $quizReport = Permission::where('route', 'quizResult')->first();
        if ($quizReport) {
            $quizReport->parent_route = 'reports';
            $quizReport->save();
        }
        Permission::insert([
            [
                'name' => 'Canceled Student',
                'route' => 'admin.cancelLogs',
                'parent_route' => 'students',
                'type' => 2,
            ], [
                'name' => 'Change Status',
                'route' => 'course-level.changeStatus',
                'parent_route' => 'course-level.index',
                'type' => 3,
            ]
        ]);
    }

    public function down()
    {
        //
    }
}
