<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSettingInVirtaulClass extends Migration
{
    public function up()
    {
        Schema::table('virtual_classes', function ($table) {
            if (!Schema::hasColumn('virtual_classes', 'host_setting')) {
                $table->text('host_setting')->nullable();
            }
        });
    }

    public function down()
    {
        //
    }
}
