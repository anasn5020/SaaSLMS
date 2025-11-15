<?php

namespace Modules\Midtrans\Entities;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;

class MidtransOrder extends Model
{
    use Tenantable;
    protected $fillable = [];
}
