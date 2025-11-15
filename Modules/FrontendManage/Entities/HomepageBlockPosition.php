<?php

namespace Modules\FrontendManage\Entities;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;

class HomepageBlockPosition extends Model
{
    use Tenantable;
    protected $fillable = [];
}
