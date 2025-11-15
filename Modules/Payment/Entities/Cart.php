<?php

namespace Modules\Payment\Entities;

use App\Traits\Tenantable;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Modules\BundleSubscription\Entities\BundleCoursePlan;
use Modules\CourseSetting\Entities\Course;
use Modules\Gift\Entities\GiftRecord;
use Modules\Installment\Entities\InstallmentPurchaseRequest;
use Modules\Store\Entities\ProductSku;

class Cart extends Model
{
    use Tenantable;

    protected $fillable = ['course_id', 'user_id', 'price', 'qty', 'is_store', 'instructor_id', 'tracking', 'pre_booking_amount'];
    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            Cache::forget('login_user_cart_sum'.$model->user_id . SaasDomain());

        });
        self::updated(function ($model) {
            Cache::forget('login_user_cart_sum'.$model->user_id . SaasDomain());
        });
        self::deleted(function ($model) {
            Cache::forget('login_user_cart_sum'.$model->user_id . SaasDomain());
        });
    }



    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function bundle()
    {
        return $this->belongsTo(BundleCoursePlan::class, 'bundle_course_id', 'id');
    }

    public function schedule()
    {
        return $this->belongsTo('Modules\Appointment\Entities\Schedule', 'schedule_id', 'id')->withDefault();
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id', 'id')->withDefault();
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withDefault();
    }

    public function cart_gift()
    {
        return $this->belongsTo(GiftRecord::class, 'gift_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withDefault();
    }

    public function installmentPurchase()
    {
        return $this->belongsTo(InstallmentPurchaseRequest::class, 'purchase_id', 'id')->withDefault();
    }

    public function sku()
    {
        return $this->belongsTo(ProductSku::class,'sku_id');
    }

    public function getQtyAttribute()
    {
        if (isModuleActive('Store') && $this->attributes['qty'] > 0){
            return $this->attributes['qty'];
        }else{
            return 1;
        }
    }

}
