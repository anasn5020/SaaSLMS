<?php

namespace Modules\CourseSetting\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;

class LessonFile extends Model
{
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'updated_by')->withDefault();
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class, 'lesson_id')->withDefault();
    }
}
