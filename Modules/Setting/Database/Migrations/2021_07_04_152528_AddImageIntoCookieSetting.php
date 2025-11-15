<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddImageIntoCookieSetting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cookie_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('cookie_settings', 'image')) {
                $table->string('image')->default('public/frontend/infixlmstheme/img/icon/cookies_icon.svg');
            }
        });

        $setting = \Modules\Setting\Entities\CookieSetting::first();
        $setting->btn_text ='I Accept';
        $setting->text_color ='#F8D4BE';
        $setting->bg_color ='#FFEDE2';
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
