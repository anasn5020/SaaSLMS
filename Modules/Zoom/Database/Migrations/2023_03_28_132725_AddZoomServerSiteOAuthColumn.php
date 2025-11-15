<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddZoomServerSiteOAuthColumn extends Migration
{
    public function up()
    {
        if (Schema::hasTable('zoom_settings')) {
            Schema::table('zoom_settings', function ($table) {
                if (!Schema::hasColumn('zoom_settings', 'zoom_account_id')) {
                    $table->string('zoom_account_id')->nullable();
                }

                if (!Schema::hasColumn('zoom_settings', 'zoom_client_id')) {
                    $table->string('zoom_client_id')->nullable();
                }

                if (!Schema::hasColumn('zoom_settings', 'zoom_client_secret')) {
                    $table->string('zoom_client_secret')->nullable();
                }
            });
        }

    }

    public function down()
    {
        //
    }
}
