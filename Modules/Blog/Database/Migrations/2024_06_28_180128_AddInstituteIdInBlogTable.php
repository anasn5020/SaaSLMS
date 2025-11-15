<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddInstituteIdInBlogTable extends Migration
{
    public function up()
    {
        Schema::table('blogs', function ($table) {
            if (!Schema::hasColumn('blogs', 'institute_id')) {
                $table->integer('institute_id')->nullable();
            }
        });
    }

    public function down()
    {
        //
    }
}
