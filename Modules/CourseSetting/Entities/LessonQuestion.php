<?php

namespace Modules\CourseSetting\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;

class LessonQuestion extends Model
{
    protected $guarded = ['id'];

    public function course()
    {
        return $this->belongsTo(Course::class)->withDefault();
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class, 'lesson_id')->withDefault();
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function child()
    {
        return $this->hasMany(LessonQuestion::class, 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(LessonQuestion::class, 'id', 'parent_id')->withDefault();
    }
}
