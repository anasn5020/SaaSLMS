<?php

namespace Modules\SystemSetting\Entities;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;


class EmailSetting extends Model
{
    use Tenantable;

    protected $guarded = ['id'];
    protected $fillable = [];
}
