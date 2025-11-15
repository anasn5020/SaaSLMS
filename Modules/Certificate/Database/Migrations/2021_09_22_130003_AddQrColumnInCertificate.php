<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddQrColumnInCertificate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('certificates', function ($table) {
            if (!Schema::hasColumn('certificates', 'qr')) {
                $table->tinyInteger('qr')->default(0);
            }

            if (!Schema::hasColumn('certificates', 'qr_x')) {
                $table->integer('qr_x')->default(0);
            }

            if (!Schema::hasColumn('certificates', 'qr_y')) {
                $table->integer('qr_y')->default(0);
            }

            if (!Schema::hasColumn('certificates', 'qr_height')) {
                $table->integer('qr_height')->nullable();
            }

            if (!Schema::hasColumn('certificates', 'qr_weight')) {
                $table->integer('qr_weight')->default(10);
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
