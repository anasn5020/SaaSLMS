<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Model;

class SmsGateway extends Model
{
    protected $guarded = ["id"];

    public function params()
    {
        return $this->hasMany(SmsGatewayParameter::class, 'gateway_id', 'id');
    }
}
