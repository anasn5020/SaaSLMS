<?php

namespace Modules\RolePermission\Entities;

use App\Traits\Tenantable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\Pivot;

class RolePermission extends Pivot
{
    // use Tenantable;

    protected $fillable = [];
    protected $table = 'role_permission';

    public function permission()
    {
        return $this->belongsTo(Permission::class, 'permission_id')->withDefault();
    }

}
