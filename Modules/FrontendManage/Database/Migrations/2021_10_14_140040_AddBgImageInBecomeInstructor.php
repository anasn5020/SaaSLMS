<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBgImageInBecomeInstructor extends Migration
{

    public function up()
    {
        Schema::table('become_instructors', function ($table) {
            if (!Schema::hasColumn('become_instructors', 'bg_image')) {
                $table->string('bg_image')->default('public/frontend/infixlmstheme/img/instractor_bg.png');
            }

        });
    }


    public function down()
    {
        //
    }
}
