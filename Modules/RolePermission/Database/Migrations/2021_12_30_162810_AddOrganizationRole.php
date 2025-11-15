<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\RolePermission\Entities\Role;

class AddOrganizationRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!DB::table('roles')->find(5)) {
            DB::table('roles')->insert([
                [
                    'id' => 5,
                    'name' => 'Organization',
                    'type' => 'System',
                ]
            ]);
        }
        if (!DB::table('roles')->find(4)) {

            DB::table('roles')->insert([
                [
                    'id' => 4,
                    'name' => 'Staff',
                    'type' => 'System',
                ]
            ]);
        }
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
