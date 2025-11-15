<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Setting\Entities\UsedMedia;
use Modules\Setting\Model\TimeZone;

class UserInfo extends Model
{

    protected $guarded = ["id"];

    public function timezone()
    {
        return $this->belongsTo(TimeZone::class, 'timezone_id')->withDefault([
            'time_zone' => ' '
        ]);
    }

    public function cover_photo_media()
    {
        return $this->morphOne(UsedMedia::class, 'usable')->where('used_for', 'cover_photo');
    }
}
