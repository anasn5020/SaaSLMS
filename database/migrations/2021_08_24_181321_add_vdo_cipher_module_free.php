<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\ModuleManager\Http\Controllers\ModuleManagerController;

class AddVdoCipherModuleFree extends Migration
{

    public function up()
    {
        $module = new ModuleManagerController();
        $module->FreemoduleAddOnsEnable('VdoCipher');
    }


    public function down()
    {
        //
    }
}
