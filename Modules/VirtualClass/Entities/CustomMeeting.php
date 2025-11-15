<?php

namespace Modules\VirtualClass\Entities;

use App\Traits\Tenantable;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Modules\Setting\Entities\UsedMedia;

class CustomMeeting extends Model
{
    use Tenantable;

    protected $guarded = [];

    public function class()
    {
        return $this->belongsTo(VirtualClass::class, 'class_id')->withDefault();
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id')->withDefault();
    }

    public function link_media()
    {
        return $this->morphOne(UsedMedia::class, 'usable')->where('used_for', 'link');
    }

    public function records()
    {
        return $this->hasMany(ClassRecord::class,'meeting_id');
    }
}
