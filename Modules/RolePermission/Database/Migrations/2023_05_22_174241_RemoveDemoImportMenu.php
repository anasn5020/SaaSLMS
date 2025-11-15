<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\RolePermission\Entities\Permission;
use Modules\SidebarManager\Http\Controllers\SidebarManagerController;

class RemoveDemoImportMenu extends Migration
{
    public function up()
    {
        try {
            Permission::where('route', 'appearance.themes.demo')->delete();
        } catch (\Exception $e) {

        }
        $sidebar = new SidebarManagerController();
        $sidebar->resetMenu();
    }

    public function down()
    {
        //
    }
}
