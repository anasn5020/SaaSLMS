<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMigrationColumnInVersionTable extends Migration
{
    public function up()
    {
        Schema::table('version_histories', function (Blueprint $table) {
            if (!Schema::hasColumn('version_histories', 'migrations')) {
                $table->longText('migrations')->nullable();
            }
        });
    }

    public function down()
    {

    }
}
