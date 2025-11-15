<?php

namespace Modules\CourseSetting\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\User;

class CourseCommentReply extends Model
{


    protected $guarded = ["id"];

    protected $appends = ['replyDate'];


    public function user()
    {

        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function getreplyDateAttribute()
    {
        return Carbon::parse($this->created_at)->diffForHumans();
    }

    public function course()
    {

        return $this->belongsTo(Course::class, 'course_id')->withDefault();
    }

}
