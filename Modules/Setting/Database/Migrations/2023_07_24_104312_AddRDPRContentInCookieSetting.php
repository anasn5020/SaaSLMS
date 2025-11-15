<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Setting\Entities\CookieSetting;

class AddRDPRContentInCookieSetting extends Migration
{
    public function up()
    {
        Schema::table('cookie_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('cookie_settings', 'customize_btn_text')) {
                $table->string('customize_btn_text')->nullable();
            }
            if (!Schema::hasColumn('cookie_settings', 'gdpr_details')) {
                $table->text('gdpr_details')->nullable();
            }

            if (!Schema::hasColumn('cookie_settings', 'gdpr_strictly')) {
                $table->text('gdpr_strictly')->nullable();
            }
            if (!Schema::hasColumn('cookie_settings', 'gdpr_performance')) {
                $table->text('gdpr_performance')->nullable();
            }
            if (!Schema::hasColumn('cookie_settings', 'gdpr_functional')) {
                $table->text('gdpr_functional')->nullable();
            }
            if (!Schema::hasColumn('cookie_settings', 'gdpr_targeting')) {
                $table->text('gdpr_targeting')->nullable();
            }

            if (!Schema::hasColumn('cookie_settings', 'gdpr_confirm_choice_btn_text')) {
                $table->string('gdpr_confirm_choice_btn_text')->nullable();
            }
            if (!Schema::hasColumn('cookie_settings', 'gdpr_accept_all_btn_text')) {
                $table->string('gdpr_accept_all_btn_text')->nullable();
            }
        });

        $setting = CookieSetting::first();
        if ($setting) {
            $setting->customize_btn_text = 'Customize Setting';
            $setting->gdpr_details = 'When you visit any of our websites, it may store or retrieve information on your browser, mostly in the form of cookies. This information might be about you, your preferences or your device and is mostly used to make the site work as you expect it to. The information does not usually directly identify you, but it can give you a more personalized web experience. Because we respect your right to privacy, you can choose not to allow some types of cookies. Click on the different category headings to find out more and manage your preferences. Please note, that blocking some types of cookies may impact your experience of the site and the services we are able to offer';
            $setting->gdpr_strictly = 'These cookies are necessary for our website to function properly and cannot be switched off in our systems. They are usually only set in response to actions made by you that amount to a request for services, such as setting your privacy preferences, logging in or filling in forms, or where they’re essential to providing you with a service you have requested. You cannot opt out of these cookies. You can set your browser to block or alert you about these cookies, but if you do, some parts of the site will not then work. These cookies do not store any personally identifiable information';
            $setting->gdpr_performance = 'These cookies allow us to count visits and traffic sources so we can measure and improve the performance of our site. They help us to know which pages are the most and least popular and see how visitors move around the site, which helps us optimize your experience. All information these cookies collect is aggregated and therefore anonymous. If you do not allow these cookies we will not be able to use your data in this way.';
            $setting->gdpr_functional = 'These cookies enable the website to provide enhanced functionality and personalization. They may be set by us or by third-party providers whose services we have added to our pages. If you do not allow these cookies then some or all of these services may not function properly.';
            $setting->gdpr_targeting = 'These cookies may be set through our site by our advertising partners. They may be used by those companies to build a profile of your interests and show you relevant adverts on other sites. They do not store directly personal information but are based on uniquely identifying your browser and internet device. If you do not allow these cookies, you will experience less targeted advertising.';
            $setting->gdpr_confirm_choice_btn_text = 'Confirm My Choices';
            $setting->gdpr_accept_all_btn_text = 'Accept All';
            $setting->save();
        }

    }

    public function down()
    {
        //
    }
}
