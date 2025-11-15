<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\RolePermission\Entities\RolePermission;

class RolePermissonUpdate2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        RolePermission::withoutEvents(function () {
            \Modules\RolePermission\Entities\RolePermission::insert([
                'permission_id' => 18,
                'role_id' => 2,
            ]);
        });
//        DB::statement("INSERT INTO `role_permission` (`permission_id`, `role_id`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
//                        (18, 2, 1, 1, 1, now(), now())
//                        ");
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
