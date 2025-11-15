<?php

namespace App\Http\Resources\api\v2\Category;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryDetailResource extends JsonResource
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
            'status' => (bool)$this->status,
            'category_name' => (string)$this->name,
            'parent' => [
                'id' => (int)$this->parent->id,
                'name' => (string)$this->parent->name,
            ],
            'position_order' => (int)$this->position_order,
            'description' => (string)$this->description,
            'icon' => $this->image ? (string)asset($this->image) : (string)$this->image,
            'thumbnail' => $this->thumbnail ? (string)asset($this->thumbnail) : (string)$this->thumbnail,
        ];
    }
}
