<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Storage;
use Modules\FrontendManage\Entities\HomeContent;

class ChangeHomeContentToKeyValue extends Migration
{

    public function up()
    {
        app()->setLocale('en');
        $content = Schema::getColumnListing('home_contents');

        if (($key = array_search('id', $content)) !== false) {
            unset($content[$key]);
        }
        if (($key = array_search('created_at', $content)) !== false) {
            unset($content[$key]);
        }
        if (($key = array_search('updated_at', $content)) !== false) {
            unset($content[$key]);
        }


        $homePageContent = HomeContent::first();

        $newSetting = [];
        foreach ($content as $column) {
            $newSetting[] = [
                'key' => $column,
                'value' => $homePageContent->$column,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Schema::dropIfExists('home_contents');
        Schema::create('home_contents', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->longText('value')->nullable();
            $table->index('key');
            $table->timestamps();
        });

        DB::table('home_contents')->insert($newSetting);

        DB::table('home_contents')
            ->insert([
                'key'=>'offer_page_banner',
                'value'=>'public/frontend/infixlmstheme/img/banner/cta_bg.jpg',
            ]);

        DB::table('home_contents')
            ->insert([
                'key'=>'offer_page_title',
                'value'=>'Offer Page',
            ]);

        DB::table('home_contents')
            ->insert([
                'key'=>'offer_page_sub_title',
                'value'=>'Limitless learning and more possibilities',
            ]);
    }


    public function down()
    {
        //
    }
}
