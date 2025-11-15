<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\ModuleManager\Http\Controllers\ModuleManagerController;

class AddBackupodule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $module = new ModuleManagerController();
        $module->FreemoduleAddOnsEnable('Backup');
        $module->FreemoduleAddOnsEnable('Pesapal');

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
