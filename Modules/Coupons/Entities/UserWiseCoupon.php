<?php

namespace Modules\Coupons\Entities;

use App\User;
use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\Category;

class UserWiseCoupon extends Model
{

use Tenantable;
    protected $table ='user_wise_coupons';
    protected $fillable = [];
    public function invite_byF(){
        return $this->belongsTo(User::class,'invite_by')->withDefault();
    }
    public function invite_accept_byF(){
        return $this->belongsTo(User::class,'invite_accept_by')->withDefault();
    }


    public function category(){

        return $this->belongsTo(Category::class,'category_id','id')->withDefault();
    }

    public function subCategory(){

        return $this->belongsTo(Category::class,'subcategory_id','id')->withDefault();
    }

    public function course(){

        return $this->belongsTo(Course::class,'course_id','id')->withDefault();
    }

}
