<?php

namespace App\Http\Resources\api\v1\Quiz;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizResultPreviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $questions = null;
        if (!empty($this->questions)) {
            foreach ($this->questions as $question) {
                $options = null;
                if (!empty($question['option'])) {
                    foreach ($question['option'] as $option) {
                        $options[] = [
                            "title" => (string)$option['title'],
                            "right" => (bool)$option['right'],
                        ];
                    }
                }
                $questions[] = [
                    "qus" => (string)$question['qus'],
                    "type" => (string)$question['type'],
                    "isSubmit" => (bool)$question['isSubmit'],
                    "isWrong" => (bool)$question['isWrong'],
                    "option" => $options,
                ];
            }
        }

        return [
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
            "created_at" => (string)$this->created_at,
            "updated_at" => (string)$this->updated_at,
            "questions" => $questions,
        ];
    }
}
