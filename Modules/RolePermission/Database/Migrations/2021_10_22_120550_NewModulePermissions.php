<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NewModulePermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = [

            // // Main Module

            //Study Material
            ['id' => 375, 'module_id' => 375, 'parent_id' => null, 'name' => 'Study Material', 'route' => 'homework_list', 'type' => 1],

            ['id' => 376, 'module_id' => 375, 'parent_id' => 375, 'name' => 'Study Material List', 'route' => 'homework_list', 'type' => 2],

            ['id' => 377, 'module_id' => 375, 'parent_id' => 376, 'name' => 'Add', 'route' => 'homework_add', 'type' => 3],
            ['id' => 378, 'module_id' => 375, 'parent_id' => 376, 'name' => 'Edit', 'route' => 'homework_edit', 'type' => 3],
            ['id' => 379, 'module_id' => 375, 'parent_id' => 376, 'name' => 'Delete', 'route' => 'homework_delete', 'type' => 3],
            ['id' => 380, 'module_id' => 375, 'parent_id' => 376, 'name' => 'Marking', 'route' => 'homework_marking', 'type' => 3],

            ['id' => 381, 'module_id' => 375, 'parent_id' => 375, 'name' => 'Student List', 'route' => 'homework_student_list', 'type' => 2],

            //Communicate
            ['id' => 390, 'module_id' => 390, 'parent_id' => null, 'name' => 'Communicate', 'route' => 'communicate', 'type' => 1],

            ['id' => 395, 'module_id' => 390, 'parent_id' => 390, 'name' => 'Event', 'route' => 'event', 'type' => 2],

            ['id' => 396, 'module_id' => 390, 'parent_id' => 395, 'name' => 'Add', 'route' => 'event-store', 'type' => 3],
            ['id' => 397, 'module_id' => 390, 'parent_id' => 395, 'name' => 'Edit', 'route' => 'event-edit', 'type' => 3],
            ['id' => 398, 'module_id' => 390, 'parent_id' => 395, 'name' => 'Delete', 'route' => 'delete-event', 'type' => 3],

            //Notification Setup
            ['id' => 13, 'module_id' => 13, 'parent_id' => null, 'name' => 'Notification', 'route' => 'notification_setup_list', 'type' => 1],
            ['id' => 196, 'module_id' => 13, 'parent_id' => 13, 'name' => 'Notification Setup', 'route' => 'notification_setup_list', 'type' => 2],
            ['id' => 197, 'module_id' => 13, 'parent_id' => 13, 'name' => 'User Notification Setup', 'route' => 'UserNotificationControll', 'type' => 2],
            ['id' => 198, 'module_id' => 13, 'parent_id' => 197, 'name' => 'Update', 'route' => 'UpdateUserNotificationControll', 'type' => 3],

            //Calendar
            ['id' => 550, 'module_id' => 550, 'parent_id' => null, 'name' => 'Calendar', 'route' => 'calendar_show', 'type' => 1],
            ['id' => 551, 'module_id' => 550, 'parent_id' => 550, 'name' => 'View', 'route' => 'calendar_show', 'type' => 2],

        ];


        DB::table('permissions')->insert($sql);
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
