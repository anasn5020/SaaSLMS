<?php

namespace App\Http\Resources\api\v2\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExperienceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                => (int)$this->id,
            'title'             => (string)$this->title,
            'company_name'      => (string)$this->company_name,
            'currently_working' => (bool)$this->currently_working,
            'start_date'    => $this->start_date?(string)date('m-d-Y',strtotime($this->start_date)):null,
            'end_date'      => $this->end_date?(string)date('m-d-Y',strtotime($this->end_date)):null,
        ];
    }
}
