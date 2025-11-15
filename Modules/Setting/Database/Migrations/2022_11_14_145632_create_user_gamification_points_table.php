<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserGamificationPointsTable extends Migration
{
    public function up()
    {
        Schema::create('user_gamification_points', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->default(0);
            $table->string('type')->nullable();
            $table->string('badge_type')->nullable();
            $table->integer('point')->default(0);
            $table->tinyInteger('status')->default(1)->comment('1=earn,2=spent');
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'gamification_points')) {
                $table->integer('gamification_points')->default(0);
            }
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_gamification_points');
    }
}
