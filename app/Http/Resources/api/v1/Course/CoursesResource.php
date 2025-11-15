<?php

namespace App\Http\Resources\api\v1\Course;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CoursesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id' => (int)$this->id,
            'title' => (string)$this->title,
            'image' => $this->image ? (string)asset($this->image) : (string)$this->image,
            'thumbnail' => $this->thumbnail ? (string)asset($this->thumbnail) : (string)$this->thumbnail,
            'price' => (float)$this->price,
            'discount_price' => (float)$this->discount_price,
            'assigned_instructor' => (string)trim($this->instructor->name),
            'about'=>(string)$this->about,
            'total_reviews'=>(float)$this->total_rating,
            'level'=>(string)$this->courseLevel->title,
        ];

        if(request()->path() != 'api/get-courses-by-category'){
            $data['purchase_price'] = (float)$this->purchasePrice;
        }

        if(request()->path() == 'api/get-all-quizzes'){
            $data['quiz_id'] = (int)$this->quiz_id;
        }

        return $data;
    }
}
