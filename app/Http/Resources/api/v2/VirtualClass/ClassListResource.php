<?php

namespace App\Http\Resources\api\v2\VirtualClass;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClassListResource extends JsonResource
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
            'status' => (bool)$this->course->status,
            'host' =>(string)$this->host,
            'start_date' =>(string)$this->start_date,
            'end_date' =>(string)$this->end_date,
            'time' =>(string)$this->time,
            'is_recurring' =>(bool)$this->is_recurring,
        ];
    }
}
