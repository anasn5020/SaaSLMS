<?php

namespace App\Repositories\Eloquents;

use App\Http\Resources\api\v2\Conversation\ChatResource;
use App\Http\Resources\api\v2\Conversation\UserListResource;
use App\Repositories\Interfaces\ConversationRepositoryInterface;
use App\User;
use Modules\SystemSetting\Entities\Message;

class ConversationRepository implements ConversationRepositoryInterface
{
    public function list(object $request): object
    {
        $users = User::whereHas('receivedLastMessages')
            ->whereNot('id', auth()->id())
            ->when($request->search, function ($query) use ($request) {
                $query->whereLike('name', $request->search);
            })->get();

        return UserListResource::collection($users);
    }

    public function contactList(object $request): object
    {
        $query = User::query();
        if (auth()->user()->role_id == 1) {
            $query->whereNot('id', auth()->id())->where('role_id', 2);
        } else {
            $query->whereNot('id', auth()->id())->where(function ($query) {
                $query->where('role_id', 1)->orWhereHas('enrollStudents');
            });
        }
        $query->when($request->search, function ($search) use ($request) {
            $search->whereLike('name', $request->search);
        });
        $users = $query->get();

        return UserListResource::collection($users);
    }

    public function messages(object $request): object
    {
        $receiver = User::find($request->opponent_id);
        $messages = Message::whereIn('reciever_id', [auth()->id(), $receiver->id])
            ->whereIn('sender_id', [auth()->id(), $receiver->id])->get();
        Message::where('seen', 0)
            ->where('sender_id', $receiver->id)
            ->where('reciever_id', auth()->id())
            ->update(['seen' => 1]);

        return ChatResource::collection($messages);
    }

    public function storeMessage(object $request): object
    {
        $message = new Message;
        $message->sender_id     = auth()->id();
        $message->reciever_id   = (int)$request->opponent_id;
        $message->message       = $request->message;
        $message->type          = auth()->id() == 1 ? 1 : 0;
        $message->seen          = 0;
        $message->save();

        return new ChatResource($message);
    }
}
