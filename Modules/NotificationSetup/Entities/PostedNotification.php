<?php

namespace Modules\NotificationSetup\Entities;

use Illuminate\Database\Eloquent\Model;
use App\User;

class PostedNotification extends Model
{
    protected $guarded = ["id"];

    public function receivers()
    {
        return $this->hasMany(PostedNotificationReceiver::class, 'notification_id', 'id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id', 'id')->withDefault();
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withDefault();
    }

}
