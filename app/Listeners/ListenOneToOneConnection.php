<?php

namespace App\Listeners;

use App\Events\OneToOneConnection;
use Modules\Chat\Entities\Group;
use Modules\Chat\Entities\GroupUser;
use Modules\Chat\Entities\Invitation;

class ListenOneToOneConnection
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  OneToOneConnection  $event
     * @return void
     */
    public function handle(OneToOneConnection $event)
    {
        if ($event->course->type == 1){
            $groupName = $this->groupName($event);

            $group = Group::where('name', 'LIKE', '%'.$groupName.'%')->first();
            if ($group){

                if (!is_null($event->student)){
                    GroupUser::updateOrcreate(
                        [
                            'group_id' => $group->id,
                            'user_id' => $event->student->id,
                        ],[
                        'group_id' => $group->id,
                        'user_id' => $event->student->id,
                        'added_by' => $event->instructor->id,
                        'role' => 3
                    ]);
                }

            }else{
                $group = Group::create([
                    'name' => $groupName,
                    'created_by' => $event->instructor->id,
                ]);

                $this->groupUserCreate($group->id, $event->instructor->id, $event->instructor->id, 1);

                if (!is_null($event->student)){
                    $this->groupUserCreate($group->id, $event->student->id, $event->instructor->id);
                }
            }

            if (!is_null($event->student) && !$event->instructor->connectedWithLoggedInUser()){
                Invitation::create([
                    'from' => $event->instructor->id,
                    'to' => $event->student->id,
                    'status' => 1,
                ]);
            }
        }

    }

    public function groupName(OneToOneConnection $event)
    {
        $event->course;
        $code = $event->course->id.$event->instructor->id;

        return $event->course->title. '-('.$code.')';
    }

    public function groupUserCreate($groupId, $userId, $addedById, $role =3)
    {
        GroupUser::create([
            'group_id' => $groupId,
            'user_id' => $userId,
            'added_by' => $addedById,
            'role' => $role
        ]);
    }
}
