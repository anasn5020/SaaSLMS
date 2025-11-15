<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class AddSponserTtileColumnInHomeConent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('home_contents', function ($table) {

            if (!Schema::hasColumn('home_contents', 'sponsor_title')) {
                $table->string('sponsor_title')->default('Trusted by companies of all sizes');
            }
            if (!Schema::hasColumn('home_contents', 'sponsor_sub_title')) {
                $table->string('sponsor_sub_title')->default('Thousands of students already add more focus to their work with InfixLMS.');
            }

            if (!Schema::hasColumn('home_contents', 'contact_page_body_image')) {
                $table->string('contact_page_body_image')->nullable();
            }


            if (!Schema::hasColumn('home_contents', 'contact_page_content_title')) {
                $table->string('contact_page_content_title')->default('Want to become an educator?');
            }


            if (!Schema::hasColumn('home_contents', 'contact_page_content_details')) {
                $table->text('contact_page_content_details')->nullable();
            }


            if (!Schema::hasColumn('home_contents', 'contact_page_phone')) {
                $table->string('contact_page_phone')->default('public/frontend/edume/img/lms_cat/1.png');
            }
            if (!Schema::hasColumn('home_contents', 'contact_page_email')) {
                $table->string('contact_page_email')->default('public/frontend/edume/img/lms_cat/2.png');
            }

            if (!Schema::hasColumn('home_contents', 'contact_page_address')) {
                $table->string('contact_page_address')->default('public/frontend/edume/img/lms_cat/3.png');
            }




        });


        DB::table('home_contents')
            ->where('id', '=',1)
            ->update([
                'contact_page_content_title'     => 'Want to become an educator?',
                'contact_page_content_details'     => 'Areana ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim eros elementum tristique. Duis cursus, mi quis viverra ornare, eros dolor interdum nulla, ut commodo diam libero vitae erat. Aenean faucibus nibh et justo cursus id rutrum lorem imperdiet. Nunc ut sem vitae risus tristique posuere.',
            ]);

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
