<?php

namespace App\Http\Resources\api\v2\Chapter;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChapterContentListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ((bool)$this->is_quiz) {
            $type = 'quiz';
            $id = (int)$this->quiz_id;
            $name = (string)$this->lessonQuiz->title;
        } elseif ((bool)$this->is_assignment) {
            $type = 'assignment';
            $asgn = $this->assignmentInfo;
            $id = (int)$asgn->id;
            $name = (string)$asgn->title;
        } else {
            $type = 'lesson';
            $id = (int)$this->id;
            $name = (string)$this->name;
        }

        return [
            'id' => (int)$this->id,
            'course_id' => (int)$this->course_id,
            'chapter_id' => (int)$this->chapter_id,
            'type' => (string)ucwords($type),
            $type . '_id' => $id == 0 ? null : $id,
            'title' => $name,
            'lock' => (bool)$this->is_lock,
        ];
    }
}
