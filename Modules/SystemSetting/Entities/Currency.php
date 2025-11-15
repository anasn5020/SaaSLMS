<?php

namespace Modules\SystemSetting\Entities;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;


class Currency extends Model
{

    use Tenantable;

    protected $fillable = [];

    protected $hidden = ['id', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->hasOne('App\User', 'currency_id', 'id');
    }
}
