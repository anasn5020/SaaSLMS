<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSaasColumnInPermissionTable extends Migration
{

    public function up()
    {
        Schema::table('permissions', function (Blueprint $table) {
            if (!Schema::hasColumn('permissions', 'power')) {
                $table->tinyInteger('power')->default(0);
            }
        });

        $routes = [
            'utility',
            'setting.maintenance',
            'setting.utilities',
            'ipBlock.index',
            'setting.geoLocation',
            'setting.error_log',
            'modulemanager.index',
            'setting.updateSystem',
            'backup.index',
        ];

        foreach ($routes as $route) {
            DB::table('permissions')
                ->where('route', $route)
                ->update(['power' => 1]);
        }
    }

    public function down()
    {
        //
    }
}
