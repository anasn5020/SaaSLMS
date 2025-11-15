<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Artisan;
use Modules\ModuleManager\Http\Controllers\ModuleManagerController;

class AddAoraPageBuilderModule extends Migration
{
    public function up()
    {
        $module = new ModuleManagerController();
        $module->FreemoduleAddOnsEnable('AoraPageBuilder');
    }

    public function down()
    {
        //
    }
}
