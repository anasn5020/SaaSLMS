<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RolePermissionUpdate3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = [
            ['id' => 355, 'module_id' => 1, 'parent_id' => 1, 'name' => 'User Login Chart By Date', 'route' => 'userLoginChartByDays', 'type' => 2],
            ['id' => 356, 'module_id' => 1, 'parent_id' => 1, 'name' => 'User Login Chart By Time', 'route' => 'userLoginChartByTime', 'type' => 2],

            ['id' => 357, 'module_id' => 12, 'parent_id' => 12, 'name' => 'VdoCipher Configuration', 'route' => 'vdocipher.setting', 'type' => 2],
            ['id' => 358, 'module_id' => 12, 'parent_id' => 357, 'name' => 'Update', 'route' => 'vdocipher.settingUpdate', 'type' => 3],

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
