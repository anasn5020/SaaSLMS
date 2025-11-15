<?php

use Illuminate\Support\Facades\DB;
use Modules\ModuleManager\Entities\Module;
use Illuminate\Database\Migrations\Migration;

class AddCashbackModule extends Migration
{
    public function up()
    {
        $totalCount = DB::table('modules')->count();
        $newModule = new Module();
        $newModule->name = 'Cashback';
        $newModule->details = 'Cashback Module for InfixLMS to provide cashback to students on course purchase or recharge amount to wallet.';
        $newModule->status = 0;
        $newModule->order = $totalCount;
        $newModule->save();
    }


    public function down()
    {
        //
    }
}
