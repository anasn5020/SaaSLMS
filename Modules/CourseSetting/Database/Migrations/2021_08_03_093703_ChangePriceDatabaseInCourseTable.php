<?php

use Doctrine\DBAL\Types\FloatType;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangePriceDatabaseInCourseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('courses', function (Blueprint $table) {
            $table->decimal("price", 20,2)->nullable()->default(0)->change();
            $table->decimal("discount_price", 20,2)->nullable()->default(0)->change();
         });

        Schema::table('virtual_classes', function (Blueprint $table) {
            $table->decimal("fees", 20,2)->nullable()->default(0)->change();
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
