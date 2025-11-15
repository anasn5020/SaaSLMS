<?php

namespace Modules\Payment\Entities;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;
use Modules\CourseSetting\Entities\Package;


class Subscriber extends Model
{

    use Tenantable;

    protected $fillable = [];

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }
}
