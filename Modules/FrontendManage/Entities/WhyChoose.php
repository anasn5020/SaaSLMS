<?php

namespace Modules\FrontendManage\Entities;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;

class WhyChoose extends Model
{
    protected $guarded = [];
    use Tenantable;
}
