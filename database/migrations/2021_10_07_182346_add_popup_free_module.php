<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\ModuleManager\Http\Controllers\ModuleManagerController;
use Modules\Setting\Http\Controllers\UpdateController;

class AddPopupFreeModule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $module = new ModuleManagerController();
        $module->FreemoduleAddOnsEnable('PopupContent');
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
