<?php

namespace Modules\Mobilpay\Entities;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;

class MobilPayOrder extends Model
{
    use Tenantable;
    protected $fillable = [];
}
