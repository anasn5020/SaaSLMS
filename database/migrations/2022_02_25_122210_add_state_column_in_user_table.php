<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStateColumnInUserTable extends Migration
{

    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'state')) {
                $table->integer('state')->nullable();
            }
        });

        Schema::table('billing_details', function (Blueprint $table) {
            if (!Schema::hasColumn('billing_details', 'state')) {
                $table->integer('state')->nullable();
            }
        });
    }


    public function down()
    {
    }
}
