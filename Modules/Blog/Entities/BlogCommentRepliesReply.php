<?php

namespace Modules\Blog\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;

class BlogCommentRepliesReply extends Model
{
    protected $fillable = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
