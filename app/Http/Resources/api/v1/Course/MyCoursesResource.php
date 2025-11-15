<?php

namespace App\Http\Resources\api\v1\Course;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MyCoursesResource extends JsonResource
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
            "title" => (string)($this->title[app()->getLocale()]??''),
            "image" => $this->image ? (string)asset($this->image) : '',
            "thumbnail" => $this->thumbnail ? (string)asset($this->thumbnail) : '',
            "price" => (float)$this->price,
            "discount_price" => (float)$this->discount_price,
            "purchase_price" => (float)$this->purchase_price,
            "assigned_instructor" => (string)$this->user->name,
            "totalCompletePercentage" => (float)$this->totalCompletePercentage,
        ];
    }
}
