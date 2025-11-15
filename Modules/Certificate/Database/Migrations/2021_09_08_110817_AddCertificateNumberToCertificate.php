<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCertificateNumberToCertificate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('certificates', function ($table) {

            if (!Schema::hasColumn('certificates', 'certificate_no')) {
                $table->integer('certificate_no')->nullable();
            }
            if (!Schema::hasColumn('certificates', 'certificate_no_position_x')) {
                $table->integer('certificate_no_position_x')->nullable();
            }
            if (!Schema::hasColumn('certificates', 'certificate_no_position_y')) {
                $table->integer('certificate_no_position_y')->nullable();
            }
            if (!Schema::hasColumn('certificates', 'certificate_no_font_family')) {
                $table->string('certificate_no_font_family')->nullable();
            }
            if (!Schema::hasColumn('certificates', 'certificate_no_font_size')) {
                $table->string('certificate_no_font_size')->nullable();
            }
            if (!Schema::hasColumn('certificates', 'certificate_no_font_color')) {
                $table->string('certificate_no_font_color')->nullable();
            }
            if (!Schema::hasColumn('certificates', 'created_by')) {
                $table->integer('created_by')->nullable();
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
