<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Model;

class MediaManager extends Model
{
    protected $guarded = ['id'];

    public function used_media()
    {
        return $this->hasMany(UsedMedia::class, 'media_id', 'id');
    }
}
