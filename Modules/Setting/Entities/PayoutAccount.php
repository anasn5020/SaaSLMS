<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Model;

class PayoutAccount extends Model
{
    protected $guarded = ["id"];

    public function specifications()
    {
        return $this->hasMany(PayoutAccountSpecification::class, 'payout_accounts_id');
    }

    public function logo_media()
    {
        return $this->morphOne(UsedMedia::class, 'usable')->where('used_for', 'logo');
    }

}
