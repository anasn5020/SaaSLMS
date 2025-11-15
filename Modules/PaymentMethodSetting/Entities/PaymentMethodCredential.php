<?php

namespace Modules\PaymentMethodSetting\Entities;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;

class PaymentMethodCredential extends Model
{
    use Tenantable;
    protected $fillable = ['lms_id'];
    protected $hidden = ['id','created_at', 'updated_at'];
}
