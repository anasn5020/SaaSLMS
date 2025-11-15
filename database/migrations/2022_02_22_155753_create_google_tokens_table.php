<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoogleTokensTable extends Migration
{

    public function up()
    {

        Schema::create('google_tokens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('google_email')->nullable();
            $table->string('refresh_token')->nullable();
            $table->string('token')->nullable();
            $table->string('expires_in')->nullable();
            $table->string('backup_folder_id')->nullable();
            $table->string('backup_folder_name')->nullable();
            $table->string('attendance_folder_id')->nullable();
            $table->string('attendance_folder_name')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('google_tokens');
    }
}
