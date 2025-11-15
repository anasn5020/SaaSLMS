<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsOnCourseCanceledsTable extends Migration
{

    public function up()
    {
        Schema::table('course_canceleds', function (Blueprint $table) {
            if (!Schema::hasColumn("course_canceleds", 'status')) {
                $table->integer('status')->default(1);
            }

            if (!Schema::hasColumn("course_canceleds", 'request_by')) {
                $table->unsignedBigInteger('request_by')->nullable();
            }

            if (!Schema::hasColumn("course_canceleds", 'request_from')) {
                $table->string('request_from')->default('admin');
            }

            if (!Schema::hasColumn("course_canceleds", 'enroll_id')) {
                $table->unsignedBigInteger('enroll_id')->nullable();
            }

            if (!Schema::hasColumn("course_canceleds", 'reason')) {
                $table->text('reason')->nullable();
            }

            if (!Schema::hasColumn("course_canceleds", 'cancel_reason')) {
                $table->text('cancel_reason')->nullable();
            }

            if (!Schema::hasColumn("course_canceleds", 'approved_date')) {
                $table->date('approved_date')->nullable();
            }

        });
    }


    public function down()
    {
        Schema::table('course_canceleds', function (Blueprint $table) {
            if (Schema::hasColumn("course_canceleds", 'status')) {
                $table->dropColumn('status');
            }

            if (Schema::hasColumn("course_canceleds", 'request_by')) {
                $table->dropColumn('request_by');
            }

            if (Schema::hasColumn("course_canceleds", 'request_from')) {
                $table->dropColumn('request_from');
            }

            if (Schema::hasColumn("course_canceleds", 'enroll_id')) {
                $table->dropColumn('enroll_id');
            }

            if (Schema::hasColumn("course_canceleds", 'reason')) {
                $table->dropColumn('reason');
            }

            if (Schema::hasColumn("course_canceleds", 'approved_date')) {
                $table->dropColumn('approved_date');
            }

            if (Schema::hasColumn("course_canceleds", 'cancel_reason')) {
                $table->dropColumn('cancel_reason');
            }


        });
    }
}
