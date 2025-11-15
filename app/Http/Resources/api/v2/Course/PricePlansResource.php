<?php

namespace App\Http\Resources\api\v2\Course;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PricePlansResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (int) $this->id,
            'course_id' => (int) $this->price_planable_id,
            'tile' => (string) $this->title,
            'discount' => (float) $this->discount_amount,
            'start_date' => (string) $this->start_date,
            'end_date' => (string) $this->end_date,
            'capacity' => $this->capacity ? (int)$this->capacity : null,
        ];
    }
}
