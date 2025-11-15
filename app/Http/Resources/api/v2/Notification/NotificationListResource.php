<?php

namespace App\Http\Resources\api\v2\Notification;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'            => (string)$this->id,
            'title'         => (string)$this->data['title'],
            'body'          => (string)$this->data['body'],
            'created_at'    => (string)date('Y-m-d', strtotime($this->created_at)),
            'ago'           => (string)$this->created_at->diffForHumans(),
        ];
    }
}
