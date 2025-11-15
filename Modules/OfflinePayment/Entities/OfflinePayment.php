<?php

namespace Modules\OfflinePayment\Entities;

use App\User;
use Carbon\Carbon;
use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;

class OfflinePayment extends Model
{
    use Tenantable;

    protected $fillable = [];

    protected $appends =['addedFormat'];


    public function user(){

        return $this->belongsTo(User::class,'user_id')->withDefault();
    }

    public function getaddedFormatAttribute()
    {
        return Carbon::parse($this->created_at)->isoformat('Do MMMM Y H:ss a');
    }
}
