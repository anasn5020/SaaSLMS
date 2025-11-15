<?php

namespace Modules\Zoom\Entities;

use App\User;
use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;


class ZoomMeetingUser extends Model
{

    use Tenantable;

    protected $fillable = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
