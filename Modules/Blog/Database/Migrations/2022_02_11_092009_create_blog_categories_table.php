<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateBlogCategoriesTable extends Migration
{

    public function up()
    {
        Schema::create('blog_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('title');
            $table->integer('position_order');
            $table->boolean('status')->default(1);
            $table->integer('parent_id')->default(0);
            $table->integer('lms_id')->default(1);
            $table->text('tags')->nullable();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('blog_categories');
    }
}
