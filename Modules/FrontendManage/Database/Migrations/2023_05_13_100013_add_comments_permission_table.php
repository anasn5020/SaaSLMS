<?php

use Illuminate\Database\Migrations\Migration;
use Modules\RolePermission\Entities\Permission;

class AddCommentsPermissionTable extends Migration
{
    public function up()
    {
        $routes = [
            ['name' => 'Comments', 'route' => 'comments', 'type' => 1, 'parent_route' => null],
            ['name' => 'Blog Comments', 'route' => 'blogs.comments.index', 'type' => 2, 'parent_route' => 'comments'],
            ['name' => 'delete', 'route' => 'blogs.comments.destroy', 'type' => 3, 'parent_route' => 'blogs.comments.index'],
            ['name' => 'reply', 'route' => 'blogs.comments.reply', 'type' => 3, 'parent_route' => 'blogs.comments.index'],
            ['name' => 'Topic Comments', 'route' => 'topics.comments.index', 'type' => 2, 'parent_route' => 'comments'],
            ['name' => 'delete', 'route' => 'topics.comments.destroy', 'type' => 3, 'parent_route' => 'topics.comments.index'],
            ['name' => 'reply', 'route' => 'topics.comments.reply', 'type' => 3, 'parent_route' => 'topics.comments.index'],

        ];
        permissionUpdateOrCreate($routes);

    }

    public function down()
    {

    }
}
