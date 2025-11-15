<?php

namespace App\Http\Resources\api\v2\Lesson;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DripContentListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => (int)$this->id,
            "course_id" => (int)$this->course_id,
            "lesson_name" => (string)$this->name,
            "duration" => (string)$this->duration,
            "specific_date" => $this->unlock_date ? (string)date('m-d-Y', strtotime($this->unlock_date)) : null,
            "drip_type" => !empty($this->unlock_date) ? 1 : (empty($this->unlock_date) ? 2 : null),
            "lesson_day" => $this->unlock_days ? (int)$this->unlock_days : null,
        ];
    }
}
