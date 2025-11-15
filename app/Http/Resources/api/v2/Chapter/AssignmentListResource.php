<?php

namespace App\Http\Resources\api\v2\Chapter;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssignmentListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'content_id'            => (int)$this->id,
            'course_id'             => (int)$this->course_id,
            'chapter_id'            => (int)$this->chapter_id,
            'assignment_id'         => (int)$this->assignmentInfo->id,
            'title'                 => (string)$this->assignmentInfo->title,
            'marks'                 => (float)$this->assignmentInfo->marks,
            'min_percentage'        => (float)$this->assignmentInfo->min_parcentage,
            'description'           => (string)$this->assignmentInfo->description,
            'last_date_submission'  => (string)date('m-d-Y', strtotime($this->assignmentInfo->last_date_submission)),
            'privacy'               => (int)$this->is_lock,
            'file'                  => $this->assignmentInfo->attachment ? (string)asset($this->assignmentInfo->attachment) : '',
        ];
    }
}
