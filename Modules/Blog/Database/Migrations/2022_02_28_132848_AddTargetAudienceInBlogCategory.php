<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTargetAudienceInBlogCategory extends Migration
{
    public function up()
    {
        Schema::table('blogs', function ($table) {
            if (!Schema::hasColumn('blogs', 'authored_time')) {
                $table->text('authored_time')->nullable();
            }

            if (!Schema::hasColumn('blogs', 'audience')) {
                $table->tinyInteger('audience')->default(1)->comment('1=public,2=Specify');
            }

        });
    }

    public function down()
    {
        //
    }
}
