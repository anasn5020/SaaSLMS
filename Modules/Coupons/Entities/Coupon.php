<?php

namespace Modules\Coupons\Entities;

use App\User;
use App\Traits\Tenantable;
use Modules\CourseSetting\Entities\Category;
use Modules\CourseSetting\Entities\Course;
use Modules\Payment\Entities\Checkout;
use Illuminate\Database\Eloquent\Model;
use Modules\Subscription\Entities\SubscriptionCheckout;

class Coupon extends Model
{
    use Tenantable;

    protected $guarded = ['id', 'created_at'];
    protected $dates = [
        'end_date',
        'start_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function coupon_user()
    {
        return $this->belongsTo(User::class, 'coupon_user_id')->withDefault();
    }

    public function totalUsed()
    {
        return $this->hasMany(Checkout::class, 'coupon_id');
    }

    public function loginUserTotalUsed()
    {
        return $this->hasMany(Checkout::class, 'coupon_id')->where('user_id', auth()->id())->count();
    }

    public function loginUserTotalSubscriptionUsed()
    {
        return $this->hasMany(SubscriptionCheckout::class, 'coupon_id')->where('user_id', auth()->id())->count();
    }

    public function isOrganizationCoupon()
    {
        if ($this->user->role_id == 5 || $this->user->organization_id != null) {
            return true;
        }
        return false;
    }

    public function couponOrganization()
    {
        if ($this->user->role_id == 5) {
            return $this->user;
        } elseif ($this->user->organization_id) {
            return User::find($this->user->organization_id);
        }
        return null;
    }

    public function course()
    {
        return $this->belongsTo(Course::class,'course_id')->withDefault();
    }

    public function getCategory()
    {
        return $this->belongsTo(Category::class,'category_id')->withDefault();
    }

    public function getSubCategory()
    {
        return $this->belongsTo(Category::class,'subcategory_id')->withDefault();

    }

}
