<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class UpdateMenuColor extends Migration
{

    public function up()
    {
        $id = \Modules\RolePermission\Entities\Permission::max('id');
        DB::table('permissions')->insert([
            [
                'id' => $id+1,
                'name' => 'Menu Setting',
                'route' => 'frontend.menusetting',
                'parent_route' => 'frontend_CMS',
                'type' => 2,
            ]
        ]);
        UpdateGeneralSetting('menu_bg', '#f8f9fa');
        UpdateGeneralSetting('menu_text', '#2b3d4e');
        UpdateGeneralSetting('menu_hover_text', '#FB1159');
        UpdateGeneralSetting('menu_title_text', '#202E3B');
    }

    public function down()
    {
        //
    }
}
