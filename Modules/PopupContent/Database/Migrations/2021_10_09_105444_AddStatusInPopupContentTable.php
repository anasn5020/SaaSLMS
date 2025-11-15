<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusInPopupContentTable extends Migration
{

    public function up()
    {
        Schema::table('popup_contents', function (Blueprint $table) {
            if (!Schema::hasColumn('popup_contents', 'status')) {
                $table->boolean('status')->default(1);
            }
        });

    }


    public function down()
    {
        //
    }
}
