<?php

namespace Modules\CourseSetting\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;

class CourseReveiw extends Model
{


    protected $guarded = ['id'];

    public function user()
    {

        return $this->belongsTo(User::class, 'user_id')->select('id', 'role_id', 'name')->withDefault();
    }

    public function course()
    {

      return  $this->belongsTo(Course::class, 'course_id')->withDefault();
    }


}
