<?php

namespace Modules\Certificate\Entities;

use App\Traits\Tenantable;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Modules\Setting\Entities\UsedMedia;

class Certificate extends Model
{
    use Tenantable;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by')->withDefault();
    }

    public function image_media()
    {
        return $this->morphOne(UsedMedia::class, 'usable')->where('used_for', 'image');
    }

    public function signature_media()
    {
        return $this->morphOne(UsedMedia::class, 'usable')->where('used_for', 'signature');
    }

}
