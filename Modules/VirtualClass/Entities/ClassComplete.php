<?php

namespace Modules\VirtualClass\Entities;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;

class ClassComplete extends Model
{
    use Tenantable;
    protected $fillable = [];
}
