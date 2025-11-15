<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Storage;
use Modules\FrontendManage\Entities\HomeContent;

class AddSaasPlanPageContent extends Migration
{

    public function up()
    {

        DB::table('home_contents')
            ->insert([
                [
                    'key' => 'saas_title',
                    'value' => 'Saas Plans',
                ],
                [
                    'key' => 'saas_sub_title',
                    'value' => 'Buy Saas Plan For Single Price',
                ],
                [
                    'key' => 'saas_banner',
                    'value' => "public/frontend/infixlmstheme/img/banner/bradcam_bg_1.jpg",
                ]
            ]);

        $homepage_block_positions = DB::table('homepage_block_positions')->orderBy('order', 'asc')->get();

        $check = DB::table('home_contents')->where('key', 'homepage_block_positions')->first();
        if ($check) {
            DB::table('home_contents')
                ->where('key', 'homepage_block_positions')
                ->update(['value' => json_encode($homepage_block_positions)]);
        } else {
            DB::table('home_contents')
                ->insert([
                    'key' => 'homepage_block_positions',
                    'value' => json_encode($homepage_block_positions),
                ]);
        }


        $setting_array['main'] = DB::table('home_contents')->get(['key', 'value'])->pluck('value', 'key')->toArray();
        file_put_contents(Storage::path('homeContent.json'), json_encode($setting_array, JSON_PRETTY_PRINT));
    }

    public function down()
    {
        //
    }
}
