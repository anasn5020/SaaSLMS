<?php

namespace Modules\Paytm\Entities;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;

class Paytm extends Model
{
    use Tenantable;
    protected $fillable = ['name','mobile','email','status','fee','order_id','transaction_id'];
    //status = 0, failed,
    //status = 1, success,
    //status = 2, processing
}
