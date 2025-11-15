<?php

namespace Modules\NotificationSetup\Repositories;


use Illuminate\Support\Facades\Auth;
use Modules\NotificationSetup\Entities\PostedNotification;
use Modules\NotificationSetup\Entities\PostedNotificationReceiver;

class PostedNotificationRepository
{

    public function store(array $data)
    {
        $notification = PostedNotification::create([
            'title' => $data['title'],
            'type' => $data['type'],
            'message' => $data['message'],
            'status' => 0,
            'sender_id' => (int)Auth::id(),
            'course_id' => isset($data['course']) ? (int)$data['course'] : 0,
            'user_id' => isset($data['user']) ? (int)$data['user'] : 0,
        ]);

        if ($data['type'] == 'Specific Users' && isset($data['specific_users'])) {
            foreach ($data['specific_users'] as $user) {
                PostedNotificationReceiver::create([
                    'notification_id' => (int)$notification->id,
                    'receiver_id' => (int)$user,
                ]);
            }
        }

        return $notification;

    }

    public function query($data = [])
    {

        $query = PostedNotification::query()->with(['sender']);

        if (isModuleActive('LmsSaas')) {
            $query->where('lms_id', app('institute')->id);
        } else {
            $query->where('lms_id', 1);
        }

        if (isModuleActive('Organization') && Auth::user()->isOrganization()) {
            $query->whereHas('sender', function ($q) {
                $q->where('organization_id', Auth::id());
                $q->orWhere('id', Auth::id());
            });
        }

        $query->with(['receivers', 'sender', 'receiver'])->select('posted_notifications.*');

        return $query;

    }

    public function delete($id)
    {
        $query = PostedNotification::find($id);
        if ($query) {
            $query->delete();
        }
    }

}
