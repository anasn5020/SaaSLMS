<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddShowTitleColumnInCertificate extends Migration
{
    public function up()
    {
        Schema::table('certificates', function ($table) {

            if (!Schema::hasColumn('certificates', 'show_title')) {
                $table->integer('show_title')->default(1);
            }

            if (!Schema::hasColumn('certificates', 'certificate_number_prefix')) {
                $table->text('certificate_number_prefix')->nullable();
            }
        });
    }

    public function down()
    {
        //
    }
}
