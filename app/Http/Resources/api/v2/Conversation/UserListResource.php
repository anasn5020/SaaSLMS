<?php

namespace App\Http\Resources\api\v2\Conversation;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\SystemSetting\Entities\Message;

class UserListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'opponent_id' => $this->id,
            'opponent_image' =>getProfileImage($this->image,$this->name),
            'opponent_name' => $this->name,
            'last_message' => @$this->receivedLastMessages->message,
            'sent_time' => @$this->receivedLastMessages->messageFormat,
            'active_status'=> $this->is_active > 0,
            'new_messages' => Message::where('seen', 0)->where('reciever_id', auth()->id())->count()
        ];
    }
}
