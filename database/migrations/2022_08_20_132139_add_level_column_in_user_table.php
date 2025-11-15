<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddLevelColumnInUserTable extends Migration
{
    public function up()
    {
        Schema::table('users', function ($table) {
            if (!Schema::hasColumn('users', 'level')) {
                $table->text('level')->nullable();
            }
        });

        try {
            Schema::table('users', function ($table) {
                $table->dropColumn("city");
            });

            Schema::table('users', function ($table) {
                $table->integer("city")->nullable();
            });
//            DB::statement("ALTER TABLE `users` CHANGE `city` `city` INT NULL DEFAULT NULL;");
        } catch (\Exception $e) {

        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user', function (Blueprint $table) {
            //
        });
    }
}
