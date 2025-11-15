<?php

namespace Modules\RolePermission\Entities;

use App\Traits\Tenantable;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

use Modules\RolePermission\Entities\SaasPermission;

class Role extends Model
{

    protected $guarded = [''];

    public function permissions()
    {
        if (Auth::check()) {
            $lms_id = Auth::user()->lms_id;
        }elseif(Auth::guard('api')->check()){
            $lms_id = Auth::guard('api')->user()->lms_id;
        }else{
            $lms_id=1;
        }
        return $this->belongsToMany(Permission::class, 'role_permission', 'role_id', 'permission_id')
            ->where('role_permission.lms_id',$lms_id);
    }


    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            Cache::forget('PermissionList_' . SaasDomain());
            Cache::forget('RoleList_' . SaasDomain());
            Cache::forget('AvailableRolesForBadgesRoles' . SaasDomain());
            Cache::forget('PolicyPermissionList_' . SaasDomain());
            Cache::forget('PolicyRoleList_' . SaasDomain());
        });
        self::updated(function ($model) {
            Cache::forget('PermissionList_' . SaasDomain());
            Cache::forget('RoleList_' . SaasDomain());
            Cache::forget('AvailableRolesForBadgesRoles' . SaasDomain());
            Cache::forget('PolicyPermissionList_' . SaasDomain());
            Cache::forget('PolicyRoleList_' . SaasDomain());
        });
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
