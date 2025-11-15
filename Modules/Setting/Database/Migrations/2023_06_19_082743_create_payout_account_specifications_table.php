<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayoutAccountSpecificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payout_account_specifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payout_accounts_id');
            $table->foreign('payout_accounts_id')
                ->references('id')->on('payout_accounts')
                ->onDelete('cascade');
            $table->string('title')->nullable();
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
        Schema::dropIfExists('payout_account_specifications');
    }
}
