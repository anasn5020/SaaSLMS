<?php

namespace App\Http\Resources\api\v2\Badge;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActiveBadgeListResource extends JsonResource
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
            'title' => (string)$this->title,
            'svg' => file_exists($this->image) ? (string)asset($this->image) : (string)null,
        ];
    }
}
