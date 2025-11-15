<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsletterSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('newsletter_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('home_status')->default(true);
            $table->string('home_service')->default('Local');
            $table->string('home_list_id')->nullable();


            $table->boolean('student_status')->default(true);
            $table->string('student_service')->default('Local');
            $table->string('student_list_id')->nullable();


            $table->boolean('instructor_status')->default(true);
            $table->string('instructor_service')->default('Local');
            $table->string('instructor_list_id')->nullable();
            $table->timestamps();
        });

        $setting = new \Modules\Newsletter\Entities\NewsletterSetting();
        $setting->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('newsletter_settings');
    }
}
