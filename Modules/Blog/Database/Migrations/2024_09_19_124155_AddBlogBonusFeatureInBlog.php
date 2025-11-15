<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddBlogBonusFeatureInBlog extends Migration
{
    public function up()
    {
        Schema::table('blogs', function ($table) {
            if (!Schema::hasColumn('blogs', 'words_count')) {
                $table->integer('words_count')->default(0)->nullable();
            }
            if (!Schema::hasColumn('blogs', 'get_bonus')) {
                $table->boolean('get_bonus')->default(0);
            }
        });
    }
    public function down()
    {
        //
    }
}
