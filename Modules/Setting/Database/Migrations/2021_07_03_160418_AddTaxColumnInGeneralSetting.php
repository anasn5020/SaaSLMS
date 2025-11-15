<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTaxColumnInGeneralSetting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('general_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('general_settings', 'tax_status')) {
                $table->integer('tax_status')->default(1);
            }


            if (!Schema::hasColumn('general_settings', 'tax_percentage')) {
                $table->integer('tax_percentage')->default(20);
            }


            if (!Schema::hasColumn('general_settings', 'category_show')) {
                $table->integer('category_show')->default(1);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
