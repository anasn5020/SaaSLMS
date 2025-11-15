<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogCommentRepliesRepliesTable extends Migration
{
    public function up()
    {
        Schema::create('blog_comment_replies_replies', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->text('name')->nullable();
            $table->text('email')->nullable();
            $table->integer('blog_id')->unsigned();
            $table->integer('comment_id')->unsigned();
            $table->integer('reply_id')->unsigned();
            $table->boolean('status')->default(1);
            $table->text('reply');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('blog_comment_replies_replies');
    }
}
