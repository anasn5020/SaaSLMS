<?php

namespace Modules\SystemSetting\Entities;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use Tenantable;

    protected $guarded = [];

    protected $table = 'hr_departments';

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'user_id', 'id')->withDefault();
    }
}
