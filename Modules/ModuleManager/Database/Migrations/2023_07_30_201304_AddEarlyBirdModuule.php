<?php

use Illuminate\Support\Facades\DB;
use Modules\ModuleManager\Entities\Module;
use Illuminate\Database\Migrations\Migration;

class AddEarlyBirdModuule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $totalCount = DB::table('modules')->count();
        $newModule = new Module();
        $newModule->name = 'EarlyBird';
        $newModule->details = 'The EarlyBird Module will enable the admin to manage multiple price plan offer for course, quiz or live class. Student can purchase the course at a discounted price for a limited time.';
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
