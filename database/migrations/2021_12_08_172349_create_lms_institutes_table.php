<?php

use App\Models\LmsInstitute;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Storage;

class CreateLmsInstitutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lms_institutes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('description')->nullable();
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('domain')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('status')->default(1)->nullable();
            $table->timestamp('deleted_at')->nullable();

            $table->timestamps();
        });

        LmsInstitute::withoutEvents(function () {
            $default_lms = new LmsInstitute();
            $default_lms->name = 'Infix Lms';
            $default_lms->description = 'Infix Lms';
            $default_lms->address = '';
            $default_lms->domain = 'main';
            $default_lms->user_id = 1;
            $default_lms->save();


            $setting_array['main'] = DB::table('general_settings')->get(['key', 'value'])->pluck('value', 'key')->toArray();
            file_put_contents(Storage::path('settings.json'), json_encode($setting_array, JSON_PRETTY_PRINT));


            $setting_array['main'] = DB::table('home_contents')->get(['key', 'value'])->pluck('value', 'key')->toArray();
            file_put_contents(Storage::path('homeContent.json'), json_encode($setting_array, JSON_PRETTY_PRINT));
        });

    }


    public function down()
    {
        Schema::dropIfExists('lms_institutes');
    }
}
