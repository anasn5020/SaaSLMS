<?php

namespace Modules\Payment\Entities;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;


class InstructorPayout extends Model
{
    use Tenantable;

    protected $fillable = [];
}
