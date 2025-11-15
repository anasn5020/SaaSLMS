<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSaasSkillAndPathwayModule extends Migration
{

    public function up()
    {
        $totalCount = \Illuminate\Support\Facades\DB::table('modules')->count();

        $newModule = new \Modules\ModuleManager\Entities\Module();
        $newModule->name = 'SkillAndPathway';
        $newModule->details = 'Skill and pathway module helps to make a pathway with some course/quiz/classes. Upon completion of a pathway assigned skill badge appear in student my skills page.';
        $newModule->status = 0;
        $newModule->order = $totalCount;
        $newModule->save();

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
