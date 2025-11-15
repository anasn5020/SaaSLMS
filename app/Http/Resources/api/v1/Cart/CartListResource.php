<?php

namespace App\Http\Resources\api\v1\Cart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $course = null;
        if (!empty($this->course)) {
            $cours = $this->course;
            $course = [
                "id" => $cours->id,
                "title" => (string)$cours->title,
                "image" => $cours->image ? (string)asset($cours->image) : '',
                "thumbnail" => $cours->image ? (string)asset($cours->image) : '',
                "price" => (float)$cours->price,
                "discount_price" => (float)$cours->discount_price,
                "purchasePrice" => (float)$cours->purchasePrice,
                "intructor_name" => (string)trim($cours->instructor->name),
            ];
        }
        
        return [
            "id" => (int)$this->id,
            "course_id" => (int)$this->course_id,
            "tracking" => (string)$this->tracking,
            "price" => (float)$this->price,
            "qty" => (int)$this->qty,
            "course" => $course,
        ];
    }
}
