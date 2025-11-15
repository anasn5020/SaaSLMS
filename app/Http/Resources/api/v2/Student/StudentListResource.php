<?php

namespace App\Http\Resources\api\v2\Student;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'student_id'    => (int)$this->id,
            'full_name'     => (string)$this->name,
            'email'         => (string)$this->email,
            'student_image' =>getProfileImage($this->image,$this->name),
            'status'        => (bool)$this->status
        ];
    }
}
