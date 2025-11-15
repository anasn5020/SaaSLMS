<?php

namespace Modules\BankPayment\Entities;

use App\User;
use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;

class BankPaymentRequest extends Model
{
    use Tenantable;
    protected $fillable = [];

    public function user(){
        return $this->belongsTo(User::class,'user_id')->withDefault();
    }
}
