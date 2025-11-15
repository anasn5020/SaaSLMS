<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class AddModuleRouteParentRouteInPermission extends Migration
{

    public function up()
    {
        Schema::table('permissions', function (Blueprint $table) {
            if (!Schema::hasColumn('permissions', 'parent_route')) {
                $table->text('parent_route')->nullable();
            }
        });

        $permissions = DB::table('permissions')->whereNotNull('parent_id')->get(['parent_id', 'route']);
        foreach ($permissions as $permission) {
            $parent_route = null;
            if (!empty($permission->parent_id)) {
                $parent = DB::table('permissions')->where('id', $permission->parent_id)->first();
                if ($parent) {
                    $parent_route = $parent->route;
                }
            }
            DB::table('permissions')
                ->where('route', $permission->route)->update([
                    'parent_route' => $parent_route,
                    'module_id' => null,
                    'parent_id' => null,
                ]);
        }
    }

    public function down()
    {
        //
    }
}
