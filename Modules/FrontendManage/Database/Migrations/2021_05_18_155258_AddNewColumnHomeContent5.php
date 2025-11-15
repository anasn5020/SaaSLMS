<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddNewColumnHomeContent5 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('home_contents', function ($table) {

            if (!Schema::hasColumn('home_contents', 'blog_page_banner')) {
                $table->string('blog_page_banner')->default('public/frontend/infixlmstheme/img/banner/cta_bg.jpg');
            }
            if (!Schema::hasColumn('home_contents', 'blog_page_title')) {
                $table->string('blog_page_title')->default('Limitless learning and more possibilities');
            }
            if (!Schema::hasColumn('home_contents', 'blog_page_sub_title')) {
                $table->string('blog_page_sub_title')->default('Choose from over 100,000 online video courses with new');
            }
        });
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
