<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Modules\ModuleManager\Entities\Module;

class AddHLSModule extends Migration
{
    public function up()
    {
        $totalCount = DB::table('modules')->count();
        $newModule = new Module();
        $newModule->name = 'HLS';
        $newModule->details = 'HTTP live streaming (HLS) is a widely used video streaming protocol that can run on almost any server and is supported by most devices. HLS allows client devices to seamlessly adapt to changing network conditions by raising or lowering the quality of the stream.';
        $newModule->status = 0;
        $newModule->order = $totalCount;
        $newModule->save();
    }

    public function down()
    {
        //
    }
}
