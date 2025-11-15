<?php

namespace Modules\Blog\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;

class BlogComment extends Model
{
    protected $guarded = ["id"];

    public function replies()
    {
        return $this->hasMany(BlogComment::class, 'comment_id')->where('status',1)->orderByDesc('id');
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function blog()
    {
        return $this->belongsTo(Blog::class, 'blog_id')->withDefault();
    }

    public function second_replies()
    {
        return $this->hasMany(BlogCommentRepliesReply::class, 'reply_id', 'id')->orderByDesc('id');
    }

}
