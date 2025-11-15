<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEnrollIdToClassComplete extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('class_completes', function ($table) {
            if (!Schema::hasColumn('class_completes', 'enroll_id')) {
                $table->integer('enroll_id')->nullable();
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
        Schema::table('class_complete', function (Blueprint $table) {
            //
        });
    }
}
