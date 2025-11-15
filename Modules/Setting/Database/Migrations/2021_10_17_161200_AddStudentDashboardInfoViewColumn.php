<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Storage;
use Modules\Setting\Model\GeneralSetting;

class AddStudentDashboardInfoViewColumn extends Migration
{

    public function up()
    {
        Schema::table('general_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('general_settings', 'student_dashboard_card_view')) {
                $table->integer('student_dashboard_card_view')->default(0);
            }
        });
    }

    public function down()
    {
        //
    }
}
