<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Modules\ModuleManager\Entities\Module;

class AddUserTypeModule extends Migration
{

    public function up()
    {
        $totalCount = DB::table('modules')->count();

        $newModule = new Module();
        $newModule->name = 'UserType';
        $newModule->details = 'UserType Module For InfixLMS. ';
        $newModule->status = 0;
        $newModule->order = $totalCount;
        $newModule->save();
    }

    public function down()
    {

    }
}
