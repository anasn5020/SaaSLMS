<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Storage;
use Modules\Setting\Model\GeneralSetting;

class ChangeGeneralSettingToKeyValue extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $setting = Schema::getColumnListing('general_settings');

        if (($key = array_search('id', $setting)) !== false) {
            unset($setting[$key]);
        }
        if (($key = array_search('created_at', $setting)) !== false) {
            unset($setting[$key]);
        }
        if (($key = array_search('updated_at', $setting)) !== false) {
            unset($setting[$key]);
        }

        $generalSettings = GeneralSetting::first();

        $newSetting = [];
        foreach ($setting as $column) {
            $newSetting[] = [
                'key' => $column,
                'value' => $generalSettings->$column,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        $homepage_block_positions = DB::table('homepage_block_positions')->orderBy('order', 'asc')->get();

        $newSetting[] = [
            'key' => 'homepage_block_positions',
            'value' => json_encode($homepage_block_positions),
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $newSetting[] = [
            'key' => 'offer_type',
            'value' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        $newSetting[] = [
            'key' => 'offer_amount',
            'value' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        $newSetting[] = [
            'key' => 'preloader_status',
            'value' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $newSetting[] = [
            'key' => 'show_seek_bar',
            'value' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        Schema::dropIfExists('general_settings');
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->longText('value')->nullable();
            $table->index('key');
            $table->timestamps();
        });

        DB::table('general_settings')->insert($newSetting);

        Schema::table('general_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('general_settings', 'last_updated_date')) {
                $table->text('last_updated_date')->nullable();
            }
            if (!Schema::hasColumn('general_settings', 'system_version')) {
                $table->text('system_version')->nullable();
            }
        });
        AddLmsId();
        GenerateGeneralSetting('main');

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
