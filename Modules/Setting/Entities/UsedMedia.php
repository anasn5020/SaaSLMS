<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Model;

class UsedMedia extends Model
{
    protected $guarded = ['id'];

    public function usable()
    {
        return $this->morphTo();
    }
}
