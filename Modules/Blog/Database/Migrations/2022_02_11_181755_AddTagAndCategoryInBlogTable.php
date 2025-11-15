<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTagAndCategoryInBlogTable extends Migration
{

    public function up()
    {
        Schema::table('blogs', function ($table) {
            if (!Schema::hasColumn('blogs', 'tags')) {
                $table->text('tags')->nullable();
            }

            if (!Schema::hasColumn('blogs', 'category_id')) {
                $table->integer('category_id')->default(0);
            }
        });
    }


    public function down()
    {
        //
    }
}
