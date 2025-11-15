<?php

namespace App\Http\Resources\api\v2\Quize;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $typeName =getQuestionType($this->type);

        return [
            'id' => (int)$this->id,
            'type_name' => (string)$typeName,
            'type' => (string)$this->type,
            'question' => (string)$this->question,
        ];
    }
}
