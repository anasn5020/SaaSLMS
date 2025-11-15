<?php

use Illuminate\Database\Migrations\Migration;

class AddQuestionAnswerPermission extends Migration
{
    public function up()
    {
        $routes = [
            ['name' => 'Q&A', 'route' => 'qa', 'type' => 1, 'parent_route' => null,'section_id'=>6],
            ['name' => 'Question List', 'route' => 'qa.questions', 'type' => 2, 'parent_route' => 'qa','section_id'=>6],
            ['name' => 'Edit', 'route' => 'qa.questions.edit', 'type' => 3, 'parent_route' => 'qa.questions','section_id'=>6],
            ['name' => 'View', 'route' => 'qa.questions.show', 'type' => 3, 'parent_route' => 'qa.questions','section_id'=>6],
            ['name' => 'Delete', 'route' => 'qa.questions.delete', 'type' => 3, 'parent_route' => 'qa.questions','section_id'=>6],
            ['name' => 'Change Status', 'route' => 'qa.questions.status', 'type' => 3, 'parent_route' => 'qa.questions','section_id'=>6],
            ['name' => 'Question Settings', 'route' => 'qa.setting', 'type' => 2, 'parent_route' => 'qa','section_id'=>6],

            ['name' => 'My Questions', 'route' => 'myQA', 'type' => 1, 'parent_route' => null, 'backend' => 0],
        ];
        if (function_exists('permissionUpdateOrCreate')) {
            permissionUpdateOrCreate($routes);
        }
    }

    public function down()
    {
        //
    }
}
