<?php

namespace App\Traits;


use Illuminate\Support\Facades\Schema;
use Modules\Chat\Entities\BlockUser;
use Modules\Chat\Entities\Conversation;
use Modules\Chat\Entities\Group;
use Modules\Chat\Entities\Invitation;
use Modules\Chat\Entities\Status;

trait UserChatMethods
{


    public function getFirstNameAttribute()
    {
        if (!empty($this->attributes['first_name'])) {
            return $this->attributes['first_name'];
        } else {
            return $this->attributes['name'];
        }
    }

    public function getLastNameAttribute()
    {
        if (!empty($this->attributes['last_name'])) {
            return $this->attributes['last_name'];
        } else {
            return '';
        }
    }
    public function getAvatarAttribute($value)
    {
        return $this->avatar = $this->image;
    }

    public function activeStatus()
    {
        return $this->hasOne(Status::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'chat_group_users', 'user_id', 'group_id');
    }

    public function connectedWithLoggedInUser()
    {
        return Invitation::where('to', auth()->id())->where('from', $this->id)
            ->orWhere(function ($query) {
                $query->where('from', auth()->id());
                $query->where('to', $this->id);
            })->exists();
    }

    public function activeConnectionWithLoggedInUser()
    {
        return Invitation::where('to', auth()->id())->where('from', $this->id)
            ->orWhere(function ($query) {
                $query->where('from', auth()->id());
                $query->where('to', $this->id);
            })->where('status', 1)->exists();
    }

    public function connectionPending()
    {
        return Invitation::where(function ($query) {
            $query->where('to', auth()->id());
            $query->where('from', $this->id);
            $query->where('status', 0);
        })
            ->orWhere(function ($query) {
                $query->where('from', auth()->id());
                $query->where('to', $this->id);
                $query->where('status', 0);
            })
            ->exists();
    }

    public function connectionSuccess()
    {
        return Invitation::where(function ($query) {
            $query->where('to', auth()->id());
            $query->where('from', $this->id);
            $query->where('status', 1);
        })
            ->orWhere(function ($query) {
                $query->where('from', auth()->id());
                $query->where('to', $this->id);
                $query->where('status', 1);
            })
            ->exists();
    }

    public function connectionBlocked()
    {
        return Invitation::where(function ($query) {
            $query->where('to', auth()->id());
            $query->where('from', $this->id);
            $query->where('status', 2);
        })
            ->orWhere(function ($query) {
                $query->where('from', auth()->id());
                $query->where('to', $this->id);
                $query->where('status', 2);
            })
            ->exists();
    }

    public function blockedByMe()
    {
        if (isModuleActive("Chat")) {
            if (hasTable('chat_block_users')) {

                return BlockUser::where('block_by', auth()->id())->where('block_to', $this->id)->exists();

            } else {
                return false;
            }
        }
    }

    public function getBlockedByMeAttribute()
    {
        return $this->blockedByMe();
    }

    public function ownConversations()
    {
        return $this->hasMany(Conversation::class, 'from_id')->orderBy('created_at', 'desc');
    }

    public function oppositeConversations()
    {
        return $this->hasMany(Conversation::class, 'to_id')->orderBy('created_at', 'desc');
    }

    public function allConversations()
    {
        $first = $this->ownConversations()->latest()->get();
        $second = $this->oppositeConversations()->latest()->get();
        $data = $first->merge($second);

        return $data->sortBy('created_at');
    }

    public function userSpecificConversation($userId)
    {
        return $conversation = Conversation::with('forwardFrom', 'reply', 'fromUser', 'toUser')->where(function ($query) use ($userId) {
            $query->where('from_id', $userId);
            $query->where('to_id', auth()->id());
        })->orWhere(function ($query) use ($userId) {
            $query->where('from_id', auth()->id());
            $query->where('to_id', $userId);
        })
            ->get()
            ->sortByDesc('created_at')
            ->take(20)->toArray();

    }

    public function userSpecificConversationCollection($userId)
    {
        return $conversation = Conversation::with('forwardFrom', 'reply', 'fromUser', 'toUser')->where(function ($query) use ($userId) {
            $query->where('from_id', $userId);
            $query->where('to_id', auth()->id());
        })->orWhere(function ($query) use ($userId) {
            $query->where('from_id', auth()->id());
            $query->where('to_id', $userId);
        })
            ->get();

    }

    public function userSpecificConversationForLoadMore($userId, $ids)
    {
        $conversation = Conversation::with('forwardFrom', 'reply', 'fromUser', 'toUser')
            ->where(function ($query) use ($userId) {
                $query->where('from_id', $userId);
                $query->where('to_id', auth()->id());
            })->orWhere(function ($query) use ($userId) {
                $query->where('from_id', auth()->id());
                $query->where('to_id', $userId);
            })
            ->get()
            ->sortByDesc('created_at');

        return $conversation->filter(function ($value, $key) use ($ids) {
            return !in_array($value->id, json_decode($ids));
        })->take(20);
    }

}
