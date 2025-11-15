<?php

namespace App\Http\Resources\api\v2\Course;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LevelListResource extends JsonResource
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
        ];
    }
}
