<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmsGatewaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_gateways', function (Blueprint $table) {
            $table->id();
            $table->string('gateway_name')->nullable();
            $table->string('gateway_url')->nullable();
            $table->string('request_method')->nullable();
            $table->string('set_auth')->nullable();
            $table->string('send_to_parameter_name')->nullable();
            $table->string('message_to_parameter_name')->nullable();
            $table->string('gateway_logo')->nullable();
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sms_gateways');
    }
}
