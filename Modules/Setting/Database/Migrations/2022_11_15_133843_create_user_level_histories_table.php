<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserLevelHistoriesTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('user_level_histories')) {
            Schema::create('user_level_histories', function (Blueprint $table) {
                $table->id();
                $table->integer('user_id')->default(0);
                $table->string('type')->nullable()->comment('point|course|badge');
                $table->integer('count')->default(0);
                $table->timestamps();
            });

        }


        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'gamification_total_points')) {
                $table->integer('gamification_total_points')->default(0);
            }

            if (!Schema::hasColumn('users', 'gamification_total_spent_points')) {
                $table->integer('gamification_total_spent_points')->default(0);
            }
            if (!Schema::hasColumn('users', 'user_level')) {
                $table->integer('user_level')->default(1);
            }
            if (!Schema::hasColumn('users', 'user_level_course_complete')) {
                $table->integer('user_level_course_complete')->default(0);
            }

        });
        Schema::table('badges', function (Blueprint $table) {
            if (!Schema::hasColumn('badges', 'status')) {
                $table->integer('status')->default(1);
            }
        });
        Schema::table('user_badges', function (Blueprint $table) {
            if (!Schema::hasColumn('user_badges', 'status')) {
                $table->integer('status')->default(1);
            }
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_level_histories');
    }
}
