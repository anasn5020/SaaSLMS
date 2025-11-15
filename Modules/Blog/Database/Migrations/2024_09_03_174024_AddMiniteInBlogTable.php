<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddMiniteInBlogTable extends Migration
{
    public function up()
    {
        Schema::table('blogs', function ($table) {
            if (!Schema::hasColumn('blogs', 'minutes')) {
                $table->integer('minutes')->default(0)->nullable();
            }
        });
    }

    public function down()
    {
        //
    }
}
