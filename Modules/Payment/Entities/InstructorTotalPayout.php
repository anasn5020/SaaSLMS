<?php

namespace Modules\Payment\Entities;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;

class InstructorTotalPayout extends Model
{
    use Tenantable;
    protected $fillable = [];
}
