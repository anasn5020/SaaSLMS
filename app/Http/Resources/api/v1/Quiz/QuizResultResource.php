<?php

namespace App\Http\Resources\api\v1\Quiz;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizResultResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            // "id" => (int)$this->id,
            // "user_id" => (int)$this->user_id,
            // "course_id" => (int)$this->course_id,
            // "quiz_id" => (int)$this->quiz_id,
            // "pass" => (int)$this->pass,
            // "duration" => (string)$this->duration,
            // "publish" => (int)$this->publish,
            // "quiz_type" => (int)$this->quiz_type,
            // "focus_lost" => (int)$this->focus_lost,
            // "comment" => (string)$this->comment,
            // "warning" => (int)$this->warning,
            // "extra_time" => (int)$this->extra_time,
            // "continue_do_test" => (int)$this->continue_do_test,
            // "state" => (int)$this->state,
            "id" => (int)$this->id,
            "user_id" => (int)$this->user_id,
            "course_id" => (int)$this->course_id,
            "quiz_id" => (int)$this->quiz_id,
            "pass" => (int)$this->pass,
            "start_at" => (string)$this->start_at,
            "end_at" => (string)$this->end_at,
            "duration" => (string)$this->duration,
            "publish" => (int)$this->publish,
            "quiz_type" => (int)$this->quiz_type,
            "result" => $this->result,
        ];
    }
}
