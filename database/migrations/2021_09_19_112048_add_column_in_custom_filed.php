<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnInCustomFiled extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_custom_fields', function (Blueprint $table) {
            if (!Schema::hasColumn('student_custom_fields', 'show_phone')) {
                $table->boolean('show_phone')->default(1);
            }

            if (!Schema::hasColumn('student_custom_fields', 'required_phone')) {
                $table->boolean('required_phone')->default(0);
            }

            if (!Schema::hasColumn('student_custom_fields', 'editable_phone')) {
                $table->boolean('editable_phone')->default(1);
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
        Schema::table('student_custom_fields', function (Blueprint $table) {
            //
        });
    }
}
