<?php

namespace Modules\Setting\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;

class UserBadge extends Model
{
    protected $guarded = ['id'];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withDefault();
    }

    public function badge()
    {
        return $this->belongsTo(Badge::class, 'badge_id', 'id')->withDefault();
    }
}
