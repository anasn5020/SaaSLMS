<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddNullableEmailInUser extends Migration
{
    public function up()
    {
        try {

            Schema::table('users', function ($table) {
                $table->string("email", 191)->nullable()->change();
            });
//            DB::statement("ALTER TABLE `users` CHANGE `email` `email` VARCHAR(191) NULL DEFAULT NULL;");
        } catch (\Exception $e) {

        }
    }

    public function down()
    {

    }
}
