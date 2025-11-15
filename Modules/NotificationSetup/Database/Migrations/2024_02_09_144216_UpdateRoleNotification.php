<?php

use Illuminate\Database\Migrations\Migration;

class UpdateRoleNotification extends Migration
{
    public function up()
    {
        \Modules\NotificationSetup\Entities\RoleEmailTemplate::where('template_act', 'OffLine_Payment')->delete();
        $roles = [2, 3];
        foreach ($roles as $role) {
            \Modules\NotificationSetup\Entities\RoleEmailTemplate::create([
                'template_act' => 'OffLine_Payment',
                'role_id' => $role,
            ]);
        }

    }

    public function down()
    {
        //
    }
}
