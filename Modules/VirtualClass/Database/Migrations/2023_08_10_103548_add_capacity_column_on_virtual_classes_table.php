<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCapacityColumnOnVirtualClassesTable extends Migration
{
    public function up()
    {
        Schema::table('virtual_classes', function (Blueprint $table) {
            if (!Schema::hasColumn("virtual_classes", 'capacity')) {
                $table->integer('capacity')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('virtual_classes', function (Blueprint $table) {
            if (Schema::hasColumn("virtual_classes", 'capacity')) {
                $table->dropColumn('capacity');
            }
        });
    }
}
