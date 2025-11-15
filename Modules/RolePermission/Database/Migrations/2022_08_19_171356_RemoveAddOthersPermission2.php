<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\RolePermission\Entities\Permission;

class RemoveAddOthersPermission2 extends Migration
{
    public function up()
    {

        Permission::insert([
            [
                'name' => 'Branch',
                'route' => 'org.branch',
                'parent_route' => 'students',
                'type' => 2,
            ], [
                'name' => 'Add',
                'route' => 'org.branch.store',
                'parent_route' => 'org.branch',
                'type' => 3,
            ], [
                'name' => 'Edit',
                'route' => 'org.branch.update',
                'parent_route' => 'org.branch',
                'type' => 3,
            ], [
                'name' => 'Delete',
                'route' => 'org.branch.delete',
                'parent_route' => 'org.branch',
                'type' => 3,
            ], [
                'name' => 'Import',
                'route' => 'org.branch.import',
                'parent_route' => 'org.branch',
                'type' => 3,
            ], [
                'name' => 'Export',
                'route' => 'org.branch.export',
                'parent_route' => 'org.branch',
                'type' => 3,
            ], [
                'name' => 'Position',
                'route' => 'org.position',
                'parent_route' => 'students',
                'type' => 2,
            ], [
                'name' => 'Add',
                'route' => 'org.position.store',
                'parent_route' => 'org.position',
                'type' => 3,
            ], [
                'name' => 'Edit',
                'route' => 'org.position.update',
                'parent_route' => 'org.position',
                'type' => 3,
            ], [
                'name' => 'Delete',
                'route' => 'org.position.delete',
                'parent_route' => 'org.position',
                'type' => 3,
            ],
        ]);
    }

    public function down()
    {
        //
    }
}
