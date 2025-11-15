<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Modules\FrontendManage\Entities\PrivacyPolicy;

class AddColumnInPrivacyPolices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('privacy_policies', function ($table) {


            if (!Schema::hasColumn('privacy_policies', 'page_banner_status')) {
                $table->integer('page_banner_status')->default(1);
            }

            if (!Schema::hasColumn('privacy_policies', 'page_banner')) {
                $table->string('page_banner')->default('public/frontend/infixlmstheme/img/banner/cta_bg.jpg');
            }


            if (!Schema::hasColumn('privacy_policies', 'page_banner_title')) {
                $table->string('page_banner_title')->default('Privacy Policies');
            }

            if (!Schema::hasColumn('privacy_policies', 'page_banner_sub_title')) {
                $table->string('page_banner_sub_title')->default('We’re here with you every step way!');
            }

            if (!Schema::hasColumn('privacy_policies', 'details')) {
                $table->longText('details')->nullable();
            }
        });
        app()->setLocale('en');
        PrivacyPolicy::withoutEvents(function () {
            $privacy = PrivacyPolicy::first();
            $privacy->details = "Plus, you'll also learn Justin's go-to camera settings, must-have gear, and recommendations on a budget. By the end, you'll know how to master your settings, shoot in manual mode for total control. Transfers of Personal Data: The Services are hosted and operated in the United States (“U.S.”) through Skillshare and its service providers, and if you do not reside in the U.S., laws in the U.S. may differ from the laws where you reside. By using the Services, you acknowledge that any Personal Data about you.";
            $privacy->save();
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
