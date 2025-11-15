<?php

namespace Modules\Setting\Model;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use Tenantable; 
    protected $guarded = [];
}
