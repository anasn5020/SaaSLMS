<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRtlColumnInCertificateFont extends Migration
{
    public function up()
    {
        Schema::table('certificate_fonts', function ($table) {
            if (!Schema::hasColumn('certificate_fonts', 'rtl')) {
                $table->tinyInteger('rtl')->default(0);
            }
        });
    }

    public function down()
    {
        //
    }
}
