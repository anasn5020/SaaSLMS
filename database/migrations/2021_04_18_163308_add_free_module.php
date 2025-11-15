<?php

use Illuminate\Database\Migrations\Migration;
use Modules\ModuleManager\Http\Controllers\ModuleManagerController;

class AddFreeModule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $module = new ModuleManagerController();
        $module->FreemoduleAddOnsEnable('Instamojo');
        $module->FreemoduleAddOnsEnable('Midtrans');


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
