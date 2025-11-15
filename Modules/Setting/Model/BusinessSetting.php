<?php

namespace Modules\Setting\Model;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;

class BusinessSetting extends Model
{
    use Tenantable;
    protected $guarded = ['id'];
}
