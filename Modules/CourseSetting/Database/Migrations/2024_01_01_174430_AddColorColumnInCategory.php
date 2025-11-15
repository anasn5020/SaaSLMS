<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddColorColumnInCategory extends Migration
{
    public function up()
    {
        Schema::table('categories', function ($table) {
            if (!Schema::hasColumn('categories', 'color')) {
                $table->string('color')->nullable();
            }
        });
    }

    public function down()
    {
        //
    }
}
