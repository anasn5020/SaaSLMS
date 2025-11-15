<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Modules\ModuleManager\Entities\Module;

class AddStorageModule extends Migration
{
    public function up()
    {
        $totalCount = DB::table('modules')->count();
        $newModule = new Module();
        $newModule->name = 'Storage';
        $newModule->details = 'DigitalOcean, Wasabi, Backblaze, Dropbox, Contabo storage for InfixLMS';
        $newModule->status = 0;
        $newModule->order = $totalCount;
        $newModule->save();
    }

    public function down()
    {
        //
    }
}
