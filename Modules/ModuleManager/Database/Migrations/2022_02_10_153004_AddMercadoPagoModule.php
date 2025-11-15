<?php

use Illuminate\Database\Migrations\Migration;

class AddMercadoPagoModule extends Migration
{

    public function up()
    {
        $totalCount = \Illuminate\Support\Facades\DB::table('modules')->count();
        $newModule = new \Modules\ModuleManager\Entities\Module();
        $newModule->name = 'MercadoPago';
        $newModule->details = 'MercadoPago module for Infix LMS';
        $newModule->status = 0;
        $newModule->order = $totalCount;
        $newModule->save();
    }


    public function down()
    {
        //
    }
}
