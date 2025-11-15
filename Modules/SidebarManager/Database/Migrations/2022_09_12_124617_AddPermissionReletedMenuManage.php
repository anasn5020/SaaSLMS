<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPermissionReletedMenuManage extends Migration
{
    public function up()
    {
        Schema::table('permissions', function (Blueprint $table) {
            if (!Schema::hasColumn('permissions', 'icon')) {
                $table->string('icon')->default("fas fa-th");
            }

            if (!Schema::hasColumn('permissions', 'menu_status')) {
                $table->integer('menu_status')->default(1);
            }

            if (!Schema::hasColumn('permissions', 'old_name')) {
                $table->string('old_name')->nullable();
            }
            if (!Schema::hasColumn('permissions', 'old_type')) {
                $table->integer('old_type')->nullable();
            }
            if (!Schema::hasColumn('permissions', 'old_parent_route')) {
                $table->string('old_parent_route')->nullable();
            }

            if (!Schema::hasColumn('permissions', 'position')) {
                $table->integer('position')->default(99999);
            }
            if (!Schema::hasColumn('permissions', 'module')) {
                $table->string('module')->nullable();
            }
            if (!Schema::hasColumn('permissions', 'theme')) {
                $table->string('theme')->nullable();
            }

            if (!Schema::hasColumn('permissions', 'not_module')) {
                $table->string('not_module')->nullable();
            }
            if (!Schema::hasColumn('permissions', 'not_theme')) {
                $table->string('not_theme')->nullable();
            }
            if (!Schema::hasColumn('permissions', 'section_id')) {
                $table->integer('section_id')->default(1);
            }
        });
    }

    public function down()
    {
        //
    }
}
