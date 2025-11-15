<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Model;

class UserPayoutAccountSpecification extends Model
{
    protected $guarded = ["id"];

    public function specification()
    {
        return $this->belongsTo(PayoutAccountSpecification::class, 'specification_id')->withDefault();
    }

}
