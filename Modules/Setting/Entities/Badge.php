<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    protected $guarded = ['id'];

    public function image_media()
    {
        return $this->morphOne(UsedMedia::class, 'usable')->where('used_for', 'image');
    }

}
