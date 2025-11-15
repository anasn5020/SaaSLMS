<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('gender')->nullable();
            $table->string('student_type')->nullable();
            $table->string('identification_number')->nullable();
            $table->string('job_title')->nullable();
            $table->string('company_id')->nullable();
            $table->string('student_group_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'gender')) {
                $table->dropColumn('gender');
            }

            if (Schema::hasColumn('users', 'student_type')) {
                $table->dropColumn('student_type');
            }
            if (Schema::hasColumn('users', 'identification_number')) {
                $table->dropColumn('identification_number');
            }
            if (Schema::hasColumn('users', 'job_title')) {
                $table->dropColumn('job_title');
            }
            if (Schema::hasColumn('users', 'company')) {
                $table->dropColumn('company');
            }
        });
    }
}
