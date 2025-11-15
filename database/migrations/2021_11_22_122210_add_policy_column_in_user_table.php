<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPolicyColumnInUserTable extends Migration
{

    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'policy_id')) {
                $table->integer('policy_id')->nullable();
            }
        });
    }


    public function down()
    {
    }
}
