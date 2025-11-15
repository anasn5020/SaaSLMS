<?php

namespace App\Jobs;


use App\Traits\SendNotification;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\UserGroup\Entities\UserGroup;


class UserGroupNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, SendNotification;

    protected $group_id, $user_id = [];

    public function __construct($group_id, $user_id = [])
    {
        $this->group_id = $group_id;
        $this->user_id = $user_id;
    }

    public function handle()
    {

        $group = UserGroup::find($this->group_id);

        $users = User::whereIn('id', $this->user_id)->get();
        if ($users) {

            foreach ($users as $user) {

                $this->sendNotification('USER_GROUP', $user, [
                    'user' => $user->name,
                    'group' => $group->title,
                ]);

            }
        }
    }
}

