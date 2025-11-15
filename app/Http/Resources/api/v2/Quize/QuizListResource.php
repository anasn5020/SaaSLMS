<?php

namespace App\Http\Resources\api\v2\Quize;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (int)$this->id,
            'name' => (string)$this->title,
            'status' => (bool)$this->status,
            'number_of_group' => isModuleActive('AdvanceQuiz') ? (int)$this->group_assigns->count() : 0,
            'category_name' => (string)$this->category->name,
        ];
    }
}
