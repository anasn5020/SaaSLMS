<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddUserTableCouseSubscriptionColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function ($table) {
            if (!Schema::hasColumn('users', 'subscription_method')) {
                $table->string('subscription_method')->nullable();
            }

            if (!Schema::hasColumn('users', 'subscription_api_key')) {
                $table->string('subscription_api_key')->nullable();
            }
            if (!Schema::hasColumn('users', 'subscription_api_status')) {
                $table->boolean('subscription_api_status')->default(false);
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
