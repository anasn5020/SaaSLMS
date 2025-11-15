<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddQtyColumnInCartTable extends Migration
{
    public function up()
    {
        Schema::table('carts', function (Blueprint $table) {
            if (!Schema::hasColumn('carts', 'qty')) {
                $table->integer('qty')->default(1);
            }

            if (!Schema::hasColumn('carts', 'is_store')) {
                $table->boolean('is_store')->default(0);
            }
        });
    }

    public function down()
    {
        //
    }
}
