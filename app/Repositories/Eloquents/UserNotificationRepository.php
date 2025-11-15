<?php

namespace App\Repositories\Eloquents;

use App\User;
use Illuminate\Notifications\DatabaseNotification;
use App\Http\Resources\api\v2\Notification\NotificationListResource;
use App\Repositories\Interfaces\UserNotificationRepositoryInterface;

class UserNotificationRepository implements UserNotificationRepositoryInterface
{
    public function notificationList(object $request): object
    {
        $notifications = User::find(auth()->id())
            ->morphMany(DatabaseNotification::class, 'notifiable')
            ->unread()
            ->latest()
            ->paginate((int)$request->perpage ?? 15);
        return NotificationListResource::collection($notifications);
    }
    public function markAllAsRead(): bool
    {
        auth()->user()->unreadNotifications->markAsRead();
        return true;
    }
}
