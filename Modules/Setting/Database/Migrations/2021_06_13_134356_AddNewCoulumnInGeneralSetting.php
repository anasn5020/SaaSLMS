<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Setting\Model\GeneralSetting;

class AddNewCoulumnInGeneralSetting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('general_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('general_settings', 'frontend_active_theme')) {
                $table->string('frontend_active_theme')->default('infixlmstheme');
            }

            if (!Schema::hasColumn('general_settings', 'language_code')) {
                $table->string('language_code')->default('en');
            }
            if (!Schema::hasColumn('general_settings', 'language_rtl')) {
                $table->string('language_rtl')->default('0');
            }

            if (!Schema::hasColumn('general_settings', 'language_name')) {
                $table->string('language_name')->default('English');
            }

            if (!Schema::hasColumn('general_settings', 'currency_symbol')) {
                $table->string('currency_symbol')->default('$');
            }

            if (!Schema::hasColumn('general_settings', 'currency_code')) {
                $table->string('currency_code')->default('USD');
            }

            if (!Schema::hasColumn('general_settings', 'active_date_format')) {
                $table->string('active_date_format')->nullable();
            }

            if (!Schema::hasColumn('general_settings', 'active_time_zone')) {
                $table->string('active_time_zone')->nullable();
            }

            if (!Schema::hasColumn('general_settings', 'maintenance_status')) {
                $table->tinyInteger('maintenance_status')->default(0);
            }

            if (!Schema::hasColumn('general_settings', 'cookie_status')) {
                $table->tinyInteger('cookie_status')->default(1);
            }

            if (!Schema::hasColumn('general_settings', 'email_verification')) {
                $table->tinyInteger('email_verification')->default(1);
            }

            if (!Schema::hasColumn('general_settings', 'language_translation')) {
                $table->tinyInteger('language_translation')->default(1);
            }


        });

        $setting = GeneralSetting::first();
        $setting->language_code = $setting->language->code;
        $setting->language_name = $setting->language->name;
        $setting->currency_symbol = $setting->currency->symbol;
        $setting->currency_code = $setting->currency->code;
        $setting->active_date_format = $setting->date_format->format;
        $setting->active_time_zone = $setting->timeZone->code;
        $setting->language_rtl = $setting->language->rtl;
        $setting->save();
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
