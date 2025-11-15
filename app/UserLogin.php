<?php

namespace App;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;

class UserLogin extends Model
{

use Tenantable;

    protected $fillable = ['user_id', 'ip', 'os', 'browser', 'token', 'login_at', 'logout_at', 'location', 'api_token'];

    protected $casts = ['location' => 'object'];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }
}
