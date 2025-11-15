<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCustomListInFooterWidget extends Migration
{

    public function up()
    {
        Schema::table('footer_widgets', function ($table) {
            if (!Schema::hasColumn('footer_widgets', 'custom')) {
                $table->tinyInteger('custom')->default(0);
            }

            if (!Schema::hasColumn('footer_widgets', 'custom_link')) {
                $table->text('custom_link')->nullable();
            }
        });
    }


    public function down()
    {
        //
    }
}
