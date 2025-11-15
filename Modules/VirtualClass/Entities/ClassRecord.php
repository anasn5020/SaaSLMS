<?php

namespace Modules\VirtualClass\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Setting\Entities\UsedMedia;

class ClassRecord extends Model
{
    protected $guarded = ['id'];

    public function file_media()
    {
        return $this->morphOne(UsedMedia::class, 'usable')->where('used_for', 'file');
    }
}
