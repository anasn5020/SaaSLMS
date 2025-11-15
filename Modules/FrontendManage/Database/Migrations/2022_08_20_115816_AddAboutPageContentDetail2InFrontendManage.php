<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAboutPageContentDetail2InFrontendManage extends Migration
{
    public function up()
    {
        Schema::table('about_pages', function ($table) {
            if (!Schema::hasColumn('about_pages', 'about_page_content_details2')) {
                $table->text('about_page_content_details2')->nullable();
            }
        });
    }

    public function down()
    {
        //
    }
}
