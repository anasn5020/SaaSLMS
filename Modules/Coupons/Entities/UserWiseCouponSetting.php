<?php

namespace Modules\Coupons\Entities;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;
use Modules\RolePermission\Entities\Role;

class UserWiseCouponSetting extends Model
{

    use Tenantable;

    protected $table = 'user_wise_coupon_settings';
    protected $fillable = [];


    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id')->withDefault();
    }
}
