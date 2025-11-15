<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnInAboutPage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('about_pages', function ($table) {

            if (!Schema::hasColumn('about_pages', 'about_page_content_title')) {
                $table->string('about_page_content_title')->default('Online Learning Platform');
            }
            if (!Schema::hasColumn('about_pages', 'about_page_content_details')) {
                $table->text('about_page_content_details')->nullable();
            }


            if (!Schema::hasColumn('about_pages', 'live_class_title')) {
                $table->string('live_class_title')->default('Get Personal Learning Recommendations');
            }

            if (!Schema::hasColumn('about_pages', 'live_class_title')) {
                $table->text('live_class_details')->nullable();
            }

            if (!Schema::hasColumn('about_pages', 'live_class_image')) {
                $table->string('live_class_image')->default('public/frontend/edume/img/lms_udemy/become_ins2.png');
            }

            if (!Schema::hasColumn('about_pages', 'counter_bg')) {
                $table->string('counter_bg')->default('public/frontend/edume/img/about/counter_bg.png');
            }

            if (!Schema::hasColumn('about_pages', 'sponsor_title')) {
                $table->string('sponsor_title')->default('Trusted By');
            }

            if (!Schema::hasColumn('about_pages', 'sponsor_sub_title')) {
                $table->string('sponsor_sub_title')->default('Thousands of students already add more focus to their work with InfixLMS.');
            }


        });
        app()->setLocale('en');
        $about = \App\AboutPage::first();
        if ($about) {
            $about->about_page_content_details = 'Areana ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim eros elementum tristique. Duis cursus, mi quis viverra ornare, eros dolor interdum nulla, ut commodo diam libero vitae erat. Aenean faucibus nibh et justo cursus id rutrum lorem imperdiet. Nunc ut sem vitae risus tristique posuere.';
            $about->live_class_details = 'Unlimited access to world-class learning from your laptop tablet, or phone. Join over 15,000+ students';
            $about->save();
        }
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
