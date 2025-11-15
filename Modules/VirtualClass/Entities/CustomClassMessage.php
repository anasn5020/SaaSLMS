<?php

namespace Modules\VirtualClass\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;

class CustomClassMessage extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
