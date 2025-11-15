<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRecurringColumnInVirtualClass extends Migration
{
    public function up()
    {
        Schema::table('virtual_classes', function (Blueprint $table) {
            if (!Schema::hasColumn("virtual_classes", 'is_recurring')) {
                $table->tinyInteger('is_recurring')->nullable()->default(0);
            }
            if (!Schema::hasColumn("virtual_classes", 'recurring_type')) {
                $table->integer('recurring_type')->nullable()->default(0);
            }
            if (!Schema::hasColumn("virtual_classes", 'recurring_repeat_count')) {
                $table->integer('recurring_repeat_count')->nullable()->default(1);
            }
            if (!Schema::hasColumn("virtual_classes", 'recurring_days')) {
                $table->text('recurring_days')->nullable();
            }
        });
    }

    public function down()
    {
        //
    }
}
