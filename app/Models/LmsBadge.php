<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\CourseSetting\Entities\Course;
use Modules\SkillAndPathway\Entities\Pathway;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LmsBadge extends Model
{
    use HasFactory;

    public function badgeable(){
        return $this->morphTo();
    }
    public function course(){
        return $this->hasOne(Course::class, 'badgeable_id','id')->where('type','!=',4);
    }
    public function topic(){
        if ($this->type==4) {
            return $this->hasOne(Pathway::class,'id','badgeable_id');
        } else {
            return $this->hasOne(Course::class,'id','badgeable_id');
        }


    }

}
