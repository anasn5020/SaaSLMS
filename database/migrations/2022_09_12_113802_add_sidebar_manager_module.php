<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Modules\ModuleManager\Http\Controllers\ModuleManagerController;
use Modules\RolePermission\Entities\Permission;

class AddSidebarManagerModule extends Migration
{
    public function up()
    {
        if (config('database.default') == 'pgsql') {
            $id = Permission::max('id');
            DB::statement("ALTER SEQUENCE permissions_id_seq RESTART WITH " . ++$id);
        }
        try {
            $module = new ModuleManagerController();
            $module->FreemoduleAddOnsEnable('SidebarManager');
        } catch (\Exception $e) {

        }
    }

    public function down()
    {
        //
    }
}
