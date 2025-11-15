<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeHostDataTypeInVirtuleClass extends Migration
{
    public function up()
    {
        try {
            Schema::table('virtual_classes', function ($table) {
                $table->string("host", 191)->nullable()->default('Zoom')->change();
            });
//            DB::statement("ALTER TABLE `virtual_classes` CHANGE `host` `host` VARCHAR(50)   NULL DEFAULT 'Zoom';");

        } catch (\Exception $exception) {

        }
    }

    public function down()
    {
        //
    }
}
