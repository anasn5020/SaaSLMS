<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnIntoLoginPage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('login_pages', function ($table) {

            if (!Schema::hasColumn('login_pages', 'reg_title')) {
                $table->string('reg_title')->default('Welcome to Infix Learning Management System');
            }
            if (!Schema::hasColumn('login_pages', 'reg_title')) {
                $table->string('reg_banner')->default('public/frontend/infixlmstheme/img/banner/global.png');
            }
            if (!Schema::hasColumn('login_pages', 'reg_title')) {
                $table->string('reg_slogans1')->default('Excellence');
            }
            if (!Schema::hasColumn('login_pages', 'reg_title')) {
                $table->string('reg_slogans2')->default('Community');
            }
            if (!Schema::hasColumn('login_pages', 'reg_title')) {
                $table->string('reg_slogans3')->default('Excellence');
            }


            if (!Schema::hasColumn('login_pages', 'forget_title')) {
                $table->string('forget_title')->default('Welcome to Infix Learning Management System');
            }
            if (!Schema::hasColumn('login_pages', 'forget_title')) {
                $table->string('forget_banner')->default('public/frontend/infixlmstheme/img/banner/global.png');
            }
            if (!Schema::hasColumn('login_pages', 'forget_title')) {
                $table->string('forget_slogans1')->default('Excellence');
            }
            if (!Schema::hasColumn('login_pages', 'forget_title')) {
                $table->string('forget_slogans2')->default('Community');
            }
            if (!Schema::hasColumn('login_pages', 'forget_title')) {
                $table->string('forget_slogans3')->default('Excellence');
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
