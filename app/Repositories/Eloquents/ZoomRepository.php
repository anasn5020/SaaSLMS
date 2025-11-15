<?php

namespace App\Repositories\Eloquents;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Modules\Zoom\Entities\ZoomMeeting;
use Modules\Zoom\Entities\ZoomSetting;
use Modules\Zoom\Entities\ZoomMeetingUser;
use App\Repositories\Interfaces\ZoomRepositoryInterface;
use App\Http\Resources\api\v2\Zoom\ZoomConfigureSettingsResource;

class ZoomRepository implements ZoomRepositoryInterface
{
    protected $account_id, $client_id, $password;

    public function __construct()
    {
        if (auth()->check()) {
            $setting = ZoomSetting::where('user_id', auth()->id())->first();
            $this->account_id = $setting->zoom_account_id ?? '';
            $this->client_id = $setting->zoom_client_id ?? '';
            $this->password = $setting->zoom_client_secret ?? '';
        }
    }

    public function createZoomToken()
    {
        $response = Http::withBasicAuth($this->client_id, $this->password)->post('https://zoom.us/oauth/token?grant_type=account_credentials&account_id=' . $this->account_id)->json();
        return $response['access_token'] ?? '';
    }

    public function configure(object $request): bool
    {
        ZoomSetting::updateOrCreate([
            'user_id' => auth()->id() ?? 1,
        ], [
            'user_id' => auth()->id() ?? 1,
            'zoom_account_id' => $request['zoom_account_id'],
            'zoom_client_id' => $request['zoom_client_id'],
            'zoom_client_secret' => $request['zoom_client_secret'],
        ]);

        return true;
    }

    public function settings(object $request): bool
    {
        ZoomSetting::updateOrCreate([
            'user_id' => auth()->id() ?? 1,
        ], [
            'user_id' => auth()->id() ?? 1,
            'package_id' => $request['package_id'] ?? 1,
            'host_video' => $request['host_video'] ?? 0,
            'participant_video' => $request['participant_video'] ?? 0,
            'join_before_host' => $request['join_before_host'] ?? 0,
            'audio' => $request['audio'] ?? 'both',
            'auto_recording' => $request['auto_recording'] ?? 'none',
            'approval_type' => $request['approval_type'] ?? 0,
            'mute_upon_entry' => $request['mute_upon_entry'] ?? 0,
            'waiting_room' => $request['waiting_room'] ?? 0,
        ]);

        return true;
    }

    public function getConfigSetting(): object
    {
        return new ZoomConfigureSettingsResource(ZoomSetting::where('user_id', auth()->id() ?? 1)->first());
    }

    public function approvelTypes(): array
    {
        return [
            [
                'id' => 0,
                'name' => 'Automatically'
            ],
            [
                'id' => 1,
                'name' => 'Manually Approve'
            ],
            [
                'id' => 2,
                'name' => 'No Registration Required'
            ],
        ];
    }

    public function autoRecordings(): array
    {
        return [
            [
                'id' => 'none',
                'name' => 'None',
            ],
            [
                'id' => 'local',
                'name' => 'Local',
            ],
            [
                'id' => 'cloud',
                'name' => 'Cloud',
            ],
        ];
    }

    public function audios(): array
    {
        return [
            [
                'id' => 'both',
                'name' => 'Both',
            ],
            [
                'id' => 'telephony',
                'name' => 'Telephony',
            ],
            [
                'id' => 'voip',
                'name' => 'Voip',
            ],
        ];
    }

    public function packages(): array
    {
        return [
            [
                'id' => 1,
                'name' => 'Basic (Free)'
            ],
            [
                'id' => 2,
                'name' => 'Pro'
            ],
            [
                'id' => 3,
                'name' => 'Business'
            ],
            [
                'id' => 4,
                'name' => 'Enterprise'
            ],
        ];
    }

    public function createClass($class, $date, $request, $fileName): array
    {
        $data = [];
        $data['instructor_id'] = auth()->user()->id;
        $data['class_id'] = $class->id;
        $data['topic'] = $class->getTranslation('title', app()->getLocale());
        $data['date'] = $date;
        $data['description'] = $class->course->getTranslation('about', app()->getLocale());
        $data['password'] = $request->password;
        $data['attached_file'] = $fileName;
        $data['time'] = $request->time;
        $data['duration'] = $request->duration;
        $data['is_recurring'] = $request->is_recurring;
        $data['recurring_type'] = $request->recurring_type;
        $data['recurring_repect_day'] = $request->recurring_repect_day;
        $data['recurring_end_date'] = $request->recurring_end_date;

        $setting = ZoomSetting::getData();

        $data['approval_type'] = $setting->approval_type;
        $data['auto_recording'] = $setting->auto_recording;
        $data['waiting_room'] = $setting->waiting_room;
        $data['audio'] = $setting->audio;
        $data['mute_upon_entry'] = $setting->mute_upon_entry;
        $data['host_video'] = $setting->host_video;
        $data['participant_video'] = $setting->participant_video;
        $data['join_before_host'] = $setting->join_before_host;

        $token = $this->createZoomToken();

        // return $meeting->classStore($token, $data);

        $start_date = Carbon::parse($data['date'])->format('Y-m-d') . ' ' . date("H:i:s", strtotime($data['time']));
        $zoomData = [
            "topic" => $data['topic'],
            "type" => $data['is_recurring'] == 1 ? 8 : 2,
            "duration" => $data['duration'],
            "timezone" => Settings('active_time_zone'),
            "password" => $data['password'],
            "start_time" => new Carbon($start_date),
            "agenda" => 'LiveClass',
            "settings" => [
                'join_before_host' => $this->setTrueFalseStatus($data['join_before_host']),
                'host_video' => $this->setTrueFalseStatus($data['host_video']),
                'participant_video' => $this->setTrueFalseStatus($data['participant_video']),
                'mute_upon_entry' => $this->setTrueFalseStatus($data['mute_upon_entry']),
                'waiting_room' => $this->setTrueFalseStatus($data['waiting_room']),
                'audio' => $data['audio'],
                'auto_recording' => $data['auto_recording'] ? $data['auto_recording'] : 'none',
                'approval_type' => $data['approval_type'],
            ]
        ];


        if ($data['is_recurring'] == 1) {
            $end_date = Carbon::parse($data['recurring_end_date'])->endOfDay();
            $zoomData['recurrence'] = [
                'type' => $data['recurring_type'],
                'repeat_interval' => $data['recurring_repect_day'],
                'end_date_time' => $end_date
            ];
        }

        $meeting_details = (object) Http::withToken($token)->post('https://api.zoom.us/v2/users/me/meetings', $zoomData)->json();

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
            $system_meeting->is_recurring = $data['is_recurring'];
            $system_meeting->recurring_type = $data['is_recurring'] == 1 ? $data['recurring_type'] : null;
            $system_meeting->recurring_repect_day = $data['is_recurring'] == 1 ? $data['recurring_repect_day'] : null;
            $system_meeting->recurring_end_date = $data['is_recurring'] == 1 ? $data['recurring_end_date'] : null;
            $system_meeting->meeting_id = strval($meeting_id);
            $system_meeting->password = $data['password'];
            $system_meeting->start_time = Carbon::parse($start_date)->toDateTimeString();
            $system_meeting->end_time = Carbon::parse($start_date)->addMinute((int)$data['duration'])->toDateTimeString();
            $system_meeting->attached_file = $data['attached_file'];
            $system_meeting->created_by = auth()->user()->id;
            $system_meeting->save();

            $user = new ZoomMeetingUser();
            $user->meeting_id = $system_meeting->id;
            $user->user_id = auth()->user()->id;
            $user->host = 1;
            $user->save();
        }

        if ($system_meeting) {
            $result['message'] = '';
            $result['type'] = true;
        }
        return $result;
    }

    private function setTrueFalseStatus($value)
    {
        if ($value == 1) {
            return true;
        }
        return false;
    }
}
