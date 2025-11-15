<?php

namespace Modules\FrontendManage\Entities;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;
use Modules\CourseSetting\Entities\Course;
use Modules\Setting\Entities\UsedMedia;

class Slider extends Model
{
    use Tenantable;

    protected $guarded = [];

    public function course()
    {
        return $this->belongsTo(Course::class)->withDefault();
    }

    public function image_media()
    {
        return $this->morphOne(UsedMedia::class, 'usable')->where('used_for', 'image');
    }


    public function btn_image1_media()
    {
        return $this->morphOne(UsedMedia::class, 'usable')->where('used_for', 'btn_image1');
    }

    public function btn_image2_media()
    {
        return $this->morphOne(UsedMedia::class, 'usable')->where('used_for', 'btn_image2');
    }


}
