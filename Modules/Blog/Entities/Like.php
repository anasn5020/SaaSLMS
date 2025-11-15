<?php

namespace Modules\Blog\Entities;

use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

//use Overtrue\LaravelLike\Events\Liked;
//use Overtrue\LaravelLike\Events\Unliked;

class Like extends Model
{
    protected $guarded = [];

//    protected $dispatchesEvents = [
//        'created' => Liked::class,
//        'deleted' => Unliked::class,
//    ];

    public function __construct(array $attributes = [])
    {
        $this->table = 'likes';

        parent::__construct($attributes);
    }

    protected static function boot()
    {
        parent::boot();

        self::saving(function ($like) {
            $userForeignKey = 'user_id';
            $like->{$userForeignKey} = $like->{$userForeignKey} ?: auth()->id();
        });
    }

    public function likeable()
    {
        return $this->morphTo();
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function liker()
    {
        return $this->user();
    }

    public function scopeWithType(Builder $query, string $type)
    {
        return $query->where('likeable_type', app($type)->getMorphClass());
    }
}
