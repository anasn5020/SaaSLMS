<?php

namespace Modules\Blog\Traits;

use App\User;
use Illuminate\Database\Eloquent\Model;

trait Likeable
{
    public function isLikedBy(Model $user): bool
    {
        if (\is_a($user, User::class)) {
            if ($this->relationLoaded('likers')) {
                return $this->likers->contains($user);
            }

            return $this->likers()->where('user_id', $user->getKey())->exists();
        }

        return false;
    }

    public function likers()
    {
        return $this->belongsToMany(
            User::class,
            'likes',
            'likeable_id',
            'user_id'
        )
            ->where('likeable_type', $this->getMorphClass());
    }
}
