<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\PopupContent\Entities\PopupContent;

class CreatePopupContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('popup_contents', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->text('title')->nullable();
            $table->text('message')->nullable();
            $table->text('link')->nullable();
            $table->text('btn_txt')->nullable();
            $table->timestamps();
        });

        $popup = new PopupContent();
        $popup->image = 'public/uploads/popup/1.png';
        $popup->title = 'Your Gateway to Knowledge! - Introducing the Infix Learning Management System';
        $popup->message = "Unlock the power of seamless learning with our cutting-edge Infix Learning Management System. Designed to empower individuals and organizations, our platform revolutionizes the way you acquire knowledge, making learning an engaging and transformative experience.";
        $popup->link = '/';
        $popup->btn_txt = 'Visit Website';
        $popup->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('popup_contents');
    }
}
