<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\RolePermission\Entities\Permission;

class AddNewPermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Permission::withoutEvents(function () {
            if (!Permission::find(292)) {
                $sql = [
                    ['id' => 292, 'module_id' => 12, 'parent_id' => 12, 'name' => 'Update', 'route' => 'setting.updateSystem', 'type' => 2],

                ];
                DB::table('permissions')->insert($sql);
            }


            if (!Permission::find(293)) {
                $sql = [
                    ['id' => 293, 'module_id' => 12, 'parent_id' => 292, 'name' => 'Update System Submit', 'route' => 'setting.updateSystem.submit', 'type' => 3],
                    //last  286
                ];
                DB::table('permissions')->insert($sql);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('', function (Blueprint $table) {

        });
    }
}
