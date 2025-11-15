<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;


class CreateGeneralSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_title')->nullable()->default('Infix LMS');
            $table->longText('company_info')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('vat_number')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->integer('currency_id')->nullable()->default(2);
            $table->string('logo')->nullable();
            $table->string('logo2')->nullable();
            $table->string('favicon')->nullable();
            $table->string('system_version')->nullable()->default('1.0');
            $table->integer('active_status')->nullable()->default(1);
            $table->string('website_url')->nullable();
            $table->integer('ttl_rtl')->default(2);
            $table->integer('phone_number_privacy')->default(1)->comments('1 = enable, 0 = disable');
            $table->integer('language_id')->nullable()->default(19)->unsigned();
            $table->integer('date_format_id')->nullable()->default(1)->unsigned();
            $table->string('software_version', 100)->nullable();
            $table->string('mail_signature')->nullable();
            $table->string('mail_header')->nullable();
            $table->string('mail_footer')->nullable();
            $table->string('mail_protocol', 100)->nullable();
            $table->integer('time_zone_id')->nullable()->default(83);
            $table->integer('country_id')->nullable()->default(19);
            $table->string('city')->nullable()->default('Dhaka');
            $table->string('state')->nullable()->default('Dhaka');
            $table->string('fb')->default('https://facebook.com/');
            $table->string('twitter')->default('https://twitter.com/');
            $table->string('youtube')->default('https://youtube.com/');
            $table->string('linkedin')->default('https://www.linkedin.com/');
            $table->string('copyright_text')->default('Copyright © 2024 InfixLMS. All rights reserved');
            $table->float('commission')->default(40.00);
            $table->boolean('recapthca')->default(0);
            $table->string('recaptcha_key')->nullable();
            $table->string('recaptcha_secret')->nullable();
            $table->tinyInteger('template_id')->default(3)->comment('1 => Default Template, 2 => Dark Template & 3 => Dark Two Template');
            $table->boolean('instructor_reg')->default(1);
            $table->text('email_template')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('currency_conversion')->default('Fixer');
            $table->integer('device_limit')->default(0);

            $table->boolean('email_notification')->default(0); //send notification
            $table->boolean('show_drip')->default(0)->comment('0 = all; 1=only unlocked');
            $table->boolean('AmazonS3')->default(1);
            $table->boolean('BBB')->default(0);
            $table->boolean('Sslcommerz')->default(0);
            $table->boolean('Zoom')->default(1);

            $table->string('lat')->nullable()->default('23.597506547242276')->comment('Latitude');
            $table->string('lng')->nullable()->default('58.42824308465575')->comment('Longitude');
            $table->string('zoom_level')->nullable()->default('11')->comment('Zoom Level');
            $table->string('gmap_key')->nullable()->default('AIzaSyA7nx22ZmINYk9TGiXDEXGVxghC43Ox6qA')->comment('Google Api Key');
            $table->string('fixer_key')->nullable()->default('0bd244e811264242d56e1759c93a3f1a')->comment('Fixer Api Key');

            // footer module column start
            $table->string('footer_about_title')->default('About');
            $table->text('footer_about_description')->nullable();
            $table->text('footer_copy_right')->nullable();
            $table->string('footer_section_one_title')->default('Support Zone');
            $table->string('footer_section_two_title')->default('Company Info');
            $table->string('footer_section_three_title')->default('Explore Services');
            // footer module column end

            $table->timestamps();
        });


        $version = '9.0.0';

        DB::table('general_settings')->insert([
            [
                'id' => 1,
                'site_title' => 'Infix LMS',
                'address' => 'Al Khuwair, Muscat, Oman',
                'phone' => '+968 9700 2784',
                'email' => 'hello@aorasoft.com',
                'logo' => 'public/uploads/settings/logo.png',
                'logo2' => 'public/uploads/settings/logo.png',
                'favicon' => 'public/uploads/settings/favicon.png',
                'system_version' => $version,
                'zip_code' => '1205',
                'active_status' => '1',
                'copyright_text' => 'Copyright © 2024 InfixLMS. All rights reserved | Made By CodeThemes ',
                'footer_copy_right' => 'Copyright © 2024 InfixLMS. All rights reserved | Made By  <a href="https://aorasoft.com" target="_blank"><span style="color:var(--system_primery_gredient1, #BF37FF)">CodeThemes</span></a>',                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('general_settings');
    }
}
