<?php

namespace App\Http\Controllers\Api\V2;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Notifications\DatabaseNotification;
use App\Repositories\Interfaces\UserNotificationRepositoryInterface;

class UserNotificationController extends Controller
{
    protected $notification;

    public function __construct(UserNotificationRepositoryInterface $notification)
    {
        $this->notification = $notification;
    }

    public function notificationList(Request $request): object
    {
        return response()->json([
            'success'   => true,
            'data'      => $this->notification->notificationList($request),
            'message'   => trans('api.Notification list')
        ]);
    }

    public function markAllRead(): object
    {
        if (auth()->user()->unreadNotifications->count() < 1) {
            $response = [
                'success'   => false,
                'message'   => trans('api.Notification empty')
            ];
            $status = 404;
        } else {
            $this->notification->markAllAsRead();
            $response = [
                'success'   => true,
                'message'   => trans('api.Notifications marked as read')
            ];
        }
        return response()->json($response, $status ?? 200);
    }
}
