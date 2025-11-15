<?php

namespace App\Http\Resources\api\v2\Conversation;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'message_id' => $this->id,
            'sender' => $this->sender_id == auth()->id(),
            'reciever' => $this->reciever_id == auth()->id(),
            'message' => $this->message,
            'seen_status' => $this->seen > 0,
            'message_time' => $this->messageFormat,
        ];
    }
}
