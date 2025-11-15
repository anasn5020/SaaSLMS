<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFrontendLanguageTranslate extends Migration
{

    public function up()
    {
        DB::table('business_settings')->insert(
            [
                'id' => 3,
                'type' => 'frontend_language_translation',
                'status' => 0,
            ]
        );

        UpdateGeneralSetting('frontend_language_translation',0);
        UpdateGeneralSetting('youtube_default_player',1);
    }


    public function down()
    {
        //
    }
}
