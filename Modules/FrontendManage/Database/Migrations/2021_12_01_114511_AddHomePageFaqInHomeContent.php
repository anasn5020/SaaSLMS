<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Storage;
use Modules\FrontendManage\Entities\HomeContent;

class AddHomePageFaqInHomeContent extends Migration
{

    public function up()
    {
        DB::table('home_contents')
            ->insert([
                'key' => 'home_page_faq_title',
                'value' => 'FAQ',
            ]);

        DB::table('home_contents')
            ->insert([
                'key' => 'show_home_page_faq',
                'value' => '0',
            ]);

        DB::table('home_contents')
            ->insert([
                'key' => 'home_page_faq_sub_title',
                'value' => 'Some common question & answer',
            ]);

    }

    public function down()
    {
        //
    }
}
