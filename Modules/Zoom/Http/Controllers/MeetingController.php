<?php

namespace Modules\Zoom\Http\Controllers;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Modules\VirtualClass\Entities\VirtualClass;
use Modules\Zoom\Entities\ZoomMeeting;
use Modules\Zoom\Entities\ZoomMeetingUser;
use Modules\Zoom\Entities\ZoomSetting;


class MeetingController extends Controller
{
    protected $account_id, $client_id, $password;

    public function __construct($user_id=null)
    {
        if ($user_id){
            $setting = ZoomSetting::where('user_id', $user_id)->firstOrCreate([
                'user_id' => $user_id,
            ], [
                'user_id' => $user_id,
                'zoom_client_id' => '',
                'zoom_account_id' => '',
                'zoom_client_secret' => '',
            ]);

            $this->account_id = $setting->zoom_account_id ?? '';
            $this->client_id = $setting->zoom_client_id ?? '';
            $this->password = $setting->zoom_client_secret ?? '';
        }

    }
    public function meetingStart($id)
    {

        $meeting = ZoomMeeting::where('meeting_id', $id)->first();
        if (!$meeting) {
            Toastr::error(trans('frontend.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
        try {
            if (!$meeting->currentStatus == 'started') {
                Toastr::error(trans('frontend.Class not yet start, try later'), trans('common.Failed'));
                return redirect()->back();
            }
            if (!$meeting->currentStatus == 'closed') {
                Toastr::error(trans('frontend.Class are closed'), trans('common.Failed'));
                return redirect()->back();
            }


            return redirect($meeting->url . '?pwd=' . $meeting->password);

        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function classStore($token, $data)
    {


        try {
            $activeTimeZone = Settings('active_time_zone');
            $start_date = Carbon::parse($data['date'] . ' ' . $data['time'], $activeTimeZone);

            $zoomData = [
                "topic" => $data['topic']??'',
                 "type" =>  2,
                "duration" => $data['duration']??0,
                "timezone" => $activeTimeZone,
                "password" => $data['password'],
                "start_time" => $start_date->setTimezone($activeTimeZone)->format('Y-m-d\TH:i:s'),
                "agenda" => 'Live Class',
                "settings" => [
                    'approval_type' => (int)$data['approval_type'],
                    'host_video' =>(bool)$data['host_video'],
                    'participant_video' =>(bool) $data['participant_video'],
                    'join_before_host' => (bool) $data['join_before_host'],
                    'waiting_room' => (bool) $data['waiting_room'],
                    'mute_upon_entry' => (bool)  $data['mute_upon_entry'],
                    'audio' => $data['audio'],
                    'auto_recording' => $data['auto_recording'],
                ]
            ];



            $meeting_details =(object)Http::withToken($token)->post('https://api.zoom.us/v2/users/me/meetings', $zoomData)->json();
            if (isset($meeting_details->code) && $meeting_details->code == 4711) {
                Toastr::error($meeting_details->message, trans('common.Failed'));
                return redirect()->back()->send();
            }
             $result['message'] = '';
            $result['type'] = false;
            $system_meeting = null;
            if ($meeting_details) {
                $meeting_id = $meeting_details->id ?? null;
                $system_meeting = new ZoomMeeting();
                $system_meeting->topic = $data['topic'];
                $system_meeting->instructor_id = $data['instructor_id'];
                $system_meeting->class_id = $data['class_id'];
                $system_meeting->description = $data['description'];
                $system_meeting->date_of_meeting = $data['date'];
                $system_meeting->time_of_meeting = $data['time'];
                $system_meeting->meeting_duration = $data['duration'];
                $system_meeting->host_video = $data['host_video'];
                $system_meeting->participant_video = $data['participant_video'];
                $system_meeting->join_before_host = $data['join_before_host'];
                $system_meeting->mute_upon_entry = $data['mute_upon_entry'];
                $system_meeting->waiting_room = $data['waiting_room'];
                $system_meeting->audio = $data['audio'];
                $system_meeting->auto_recording = $data['auto_recording'];
                $system_meeting->approval_type = $data['approval_type'];
                $system_meeting->is_recurring = $data['is_recurring']??0;
                $system_meeting->recurring_type = null;
                $system_meeting->recurring_repect_day =  null;
                $system_meeting->recurring_end_date = null;

                $system_meeting->meeting_id = strval($meeting_id);
                $system_meeting->password = $data['password'];
                $system_meeting->start_time = Carbon::parse($start_date)->toDateTimeString();
                $system_meeting->end_time = Carbon::parse($start_date)->addMinute((int)$data['duration'])->toDateTimeString();
                $system_meeting->attached_file = $data['attached_file'];
                $system_meeting->created_by = Auth::user()->id;
                $system_meeting->save();

                $user = new ZoomMeetingUser();
                $user->meeting_id = $system_meeting->id;
                $user->user_id = Auth::user()->id;
                $user->host = 1;
                $user->save();
            }

            if ($system_meeting) {
                $result['message'] = '';
                $result['type'] = true;
            }
            return $result;

        } catch (Exception $e) {
            $result['message'] = $e->getMessage();
            $result['type'] = false;
            return $result;
        }
    }

    public function destroy($id)
    {
        try {
            $localMeeting = ZoomMeeting::findOrFail($id);
            $class = VirtualClass::where('id', $localMeeting->class_id)->first();
            ZoomMeetingUser::where('meeting_id', $id)->delete();
            $localMeeting->delete();
            $class->total_class = $class->total_class - 1;
            $class->save();

            Toastr::success('Class deleted successful', 'Success');
            return redirect()->back();
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function createZoomToken()
    {

        try {
            $response = Http::withBasicAuth($this->client_id, $this->password)->post('https://zoom.us/oauth/token?grant_type=account_credentials&account_id=' . $this->account_id)->json();
            return $response['access_token'] ?? '';
        }catch (Exception $exception){
            Toastr::error($exception->getMessage(),'Zoom API Error');
            return '';
        }
    }

    public function test()
    {
        $token = $this->createZoomToken();
        return view('zoom::test',compact('token'));
  }
}
