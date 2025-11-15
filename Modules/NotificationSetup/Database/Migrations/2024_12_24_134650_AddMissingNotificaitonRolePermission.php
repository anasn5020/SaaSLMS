<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $role_templates =[
            [
                'role_id' => 3,
                'template_act'=>'New_Student_Reg',
                'status'=>1
            ]
        ];

        \Modules\NotificationSetup\Entities\RoleEmailTemplate::insert($role_templates);
    }

    public function down(): void
    {
        //
    }
};
