<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Modules\CourseSetting\Entities\Course;

class RecentviewCourse extends Model
{


    public function course(){
        return $this->belongsTo(Course::class,'course_id','id')->withDefault();
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id')->withDefault();
    }
}
