<?php

namespace Modules\VirtualClass\Http\Controllers;

use App\Events\CustomMeetingMeetingEvent;
use App\Http\Controllers\Controller;
use App\Traits\UploadMedia;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Modules\VirtualClass\Entities\CustomClassMessage;
use Modules\VirtualClass\Entities\CustomMeeting;

class CustomMeetingController extends Controller
{
    use  UploadMedia;

    public function classStore($data)
    {
        try {
            $local_meeting = CustomMeeting::create([
                'instructor_id' => $data['instructor_id'],
                'class_id' => $data['class_id'],
                'topic' => $data['topic'],
                'date' => $data['date'],
                'time' => $data['time'],
                'duration' => $data['duration'] ?? 0,
                'datetime' => strtotime($data['date'] . " " . $data['time']),
                'datetime_utc' => Carbon::createFromFormat(getActivePhpDateFormat() . ' ' . 'h:i A', $data['date'] . " " . $data['time'])->setTimezone('UTC')->toDateTimeString(),
                'description' => $data['description'],
                'created_by' => Auth::id(),
            ]);

            if ($local_meeting) {
                $result['message'] = '';
                $result['type'] = true;
            } else {
                $result['message'] = '';
                $result['type'] = false;
            }
        } catch (\Exception $e) {
            $result['type'] = false;
            $result['message'] = $e->getMessage();
        }
        return $result;
    }

    public function edit($id)
    {
        $class = CustomMeeting::findOrFail($id);
        $video_list = [];
        return view('virtualclass::class.edit', compact('class', 'video_list'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'topic' => 'required',
            'duration' => 'required',
            'host' => 'required',
            'date' => 'required',
            'time' => 'required',
        ];

        $this->validate($request, $rules, validationMessage($rules));


        $class = CustomMeeting::findOrFail($id);


        $class->topic = $request->topic;
        $class->description = $request->description;
        $class->duration = $request->duration;
        $class->host = $request->host;
        $class->link = null;
        $class->date = $request->date;
        $class->time = $request->time;
        $class->datetime = strtotime($request->date . " " . $request->time);
        $class->datetime_utc = Carbon::createFromFormat(getActivePhpDateFormat() . ' ' . 'h:i A', $request->date . " " . $request->time)->setTimezone('UTC')->toDateTimeString();
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

        Toastr::success(trans('class.Class Update Successfully'), trans('common.Success'));
        return redirect()->route('virtual-class.details', [$class->class_id]);
    }

    public function destroy($id)
    {
        $meeting = CustomMeeting::findOrFail($id);
        $meeting->delete();
        Toastr::success(trans('class.Class Delete Successfully'), trans('common.Success'));
        return redirect()->back();
    }

    public function show($id)
    {

        try {
            $class = CustomMeeting::with('class')->find($id);
            $course = $class->class->course;
            $messages = CustomClassMessage::where('class_id', $id)->with('user')->get();
            if ($course) {
                if (!$course->isLoginUserEnrolled) {
                    Toastr::error(trans('frontend.You are not enrolled for this course'), trans('common.Failed'));
                    return redirect()->back();
                }
            }
            return view(theme('pages.custom-class'), compact('class', 'course', 'messages'));

        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function submitMsg($id, Request $request)
    {
        $this->validate($request, [
            'message' => 'required',
        ]);
        $user = Auth::user();
        $msg = CustomClassMessage::create([
            'user_id' => $user->id,
            'msg' => $request->message,
            'class_id' => $id
        ]);
//        $msg->created_at->format('Y-m-d H:i:s')
        event(new CustomMeetingMeetingEvent([
            'id' => $id,
            'user_id' => $user->id,
            'img' => getProfileImage($user->image, $user->name),
            'name' => $user->name,
            'date' => $msg->created_at->format('Y-m-d H:i:s'),
            'text' => $msg->msg
        ]));
        return 1;
    }
}
