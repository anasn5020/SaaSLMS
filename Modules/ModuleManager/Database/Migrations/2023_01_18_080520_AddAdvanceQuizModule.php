<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Modules\ModuleManager\Entities\Module;

class AddAdvanceQuizModule extends Migration
{

    public function up()
    {
        $totalCount = DB::table('modules')->count();
        $newModule = new Module();
        $newModule->name = 'AdvanceQuiz';
        $newModule->details = 'AdvanceQuiz Module For InfixLMS.';
        $newModule->status = 0;
        $newModule->order = $totalCount;
        $newModule->save();
    }


    public function down()
    {
        $module = Module::where('name', 'AdvanceQuiz')->first();
        if ($module) {
            $module->delete();
        }
    }
}
