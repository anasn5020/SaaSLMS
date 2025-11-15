<?php

namespace Modules\CourseSetting\Entities;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{


    protected $guarded = ['id'];

    public function totalDuration()
    {
        $lessons =$this->lessons;
        $duration =0;
        foreach ($lessons as $lesson) {
            if ($lesson->is_quiz==0 || count($lesson->quiz)==0){
                $duration+= (int)$lesson->duration;
            }else{
                $quiz =$lesson->quiz[0];
                $type =$quiz->question_time_type;
                if ($type==0){
                    $duration += (int)$quiz->question_time* (int)$quiz->total_questions;
                }else{
                    $duration += (int)$quiz->question_time;

                }

            }
        }
        return $duration;
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class, 'chapter_id', 'id')->orderBy('position');
    }
}
