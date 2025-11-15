<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSubscriptionSectionHomeContent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('home_contents', function ($table) {
            if (!Schema::hasColumn('home_contents', 'show_subscription_plan')) {
                $table->integer('show_subscription_plan')->default(1)->nullable();
            }
            if (!Schema::hasColumn('home_contents', 'subscription_title')) {
                $table->string('subscription_title')->default('Pricing Plan & Package')->nullable();
            }
            if (!Schema::hasColumn('home_contents', 'subscription_sub_title')) {
                $table->string('subscription_sub_title')->default('Choose from over 100,000 online video courses with new')->nullable();
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
