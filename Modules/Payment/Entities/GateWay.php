<?php

namespace Modules\Payment\Entities;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;


class GateWay extends Model
{
    use Tenantable;

    protected $fillable = [];
    protected $table = 'gateways';
}
