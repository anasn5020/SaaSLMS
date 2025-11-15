<?php

namespace Modules\PaymentMethodSetting\Entities;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;


class PaymentMethod extends Model
{
    use Tenantable;

    protected $guarded = ['id'];
}
