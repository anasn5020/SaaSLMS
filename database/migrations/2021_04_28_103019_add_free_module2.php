<?php

use Illuminate\Database\Migrations\Migration;
use Modules\ModuleManager\Http\Controllers\ModuleManagerController;

class AddFreeModule2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $module = new ModuleManagerController();
        $module->FreemoduleAddOnsEnable('Newsletter');
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
