<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Model;

class UserPayoutAccount extends Model
{
    protected $guarded = ["id"];

    public function payoutAccount()
    {
        return $this->belongsTo(PayoutAccount::class, 'payout_accounts_id')->withDefault();
    }

}
