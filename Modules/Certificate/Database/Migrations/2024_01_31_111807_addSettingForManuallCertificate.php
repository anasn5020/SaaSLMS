<?php

use Illuminate\Database\Migrations\Migration;

class AddSettingForManuallCertificate extends Migration
{
    public function up()
    {
        $routes = [
            ['name' => 'Certificate Setting', 'route' => 'certificate.setting', 'type' => 2, 'parent_route' => 'certificate'],
        ];
        if (function_exists('permissionUpdateOrCreate')) {
            permissionUpdateOrCreate($routes);
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
