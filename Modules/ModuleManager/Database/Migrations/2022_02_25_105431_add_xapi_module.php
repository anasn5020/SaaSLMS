<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Modules\ModuleManager\Entities\Module;

class AddXAPIModule extends Migration
{

    public function up()
    {
        $totalCount = DB::table('modules')->count();

        $newModule = new Module();
        $newModule->name = 'XAPI';
        $newModule->details = 'xAPI Module For InfixLMS. ';
        $newModule->status = 0;
        $newModule->order = $totalCount;
        $newModule->save();
    }

    public function down()
    {

    }
}
