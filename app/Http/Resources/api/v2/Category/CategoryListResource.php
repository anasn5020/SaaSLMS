<?php

namespace App\Http\Resources\api\v2\Category;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'    => (int)$this->id,
            'name'  => (string)$this->name,
            'status'  => (bool)$this->status,
            'position'  => (int)$this->position_order,
        ];
    }
}
