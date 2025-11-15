<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusColumnToBlogCommentsTable extends Migration
{

    public function up()
    {
        Schema::table('blog_comments', function (Blueprint $table) {
            if (!Schema::hasColumn("blog_comments", 'status')) {
                $table->integer('status')->default(1);
            }
        });
    }

    public function down()
    {
        Schema::table('blog_comments', function (Blueprint $table) {
            if (Schema::hasColumn("blog_comments", 'status')) {
                $table->dropColumn('status');
            }
        });
    }
}
