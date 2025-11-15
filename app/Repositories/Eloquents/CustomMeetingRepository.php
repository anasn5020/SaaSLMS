<?php

namespace App\Repositories\Eloquents;

use App\Repositories\Interfaces\CustomMeetingRepositoryInterface;
use Carbon\Carbon;
use App\Traits\UploadMedia;
use Modules\VirtualClass\Entities\CustomMeeting;

class CustomMeetingRepository implements CustomMeetingRepositoryInterface
{
    use UploadMedia;
    public function update(object $request): bool
    {
        $datetime = Carbon::createFromFormat('m-d-Y' . ' ' . 'h:i A', $request->date . " " . $request->time)->format("Y-m-d h:i A");
        $id = $request->meeting_id;
        $class = CustomMeeting::find($id);

        $class->topic = $request->topic;
        $class->description = $request->description;
        $class->duration = $request->duration;
        $class->host = $request->host;
        $class->link = null;
        $class->date = $request->date;
        $class->time = $request->time;
        $class->datetime = strtotime($datetime);
        $class->datetime_utc = Carbon::createFromFormat('m-d-Y' . ' ' . 'h:i A', $request->date . " " . $request->time)->setTimezone('UTC')->toDateTimeString();
        $class->save();


        $this->removeLink($class->id, get_class($class));
        if ($request->video && $request->host == 'Self') {
            $class->link = $this->generateLink($request->video, $class->id, get_class($class), 'link');
        } elseif ($request->link && $request->host != 'Self') {
            $class->link = $request->link;
        } else {
            $class->link = $request->link;
        }
        $class->save();

        return true;
    }
}
