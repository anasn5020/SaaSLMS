<?php

namespace App\Http\Resources\api\v2\VirtualClass;

use Illuminate\Http\Request;
use Modules\BBB\Entities\BbbMeeting;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\VirtualClass\Entities\ClassComplete;
use JoisarJignesh\Bigbluebutton\Facades\Bigbluebutton;
use Modules\InAppLiveClass\Entities\InAppLiveClassMeeting;
use Modules\InAppLiveClass\Http\Controllers\InAppLiveClassController;

class ClassScheduleListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $hostData = [];
        switch ($this->host) {
            case 'Zoom':
                foreach ($this->zoomMeetings as $zoom) {
                    $hostData[] = [
                        'id' => (int) $zoom->id,
                        'topic' => (string) $zoom->topic,
                        'date' => (string) $zoom->date_of_meeting,
                        'time' => (string) date('h:i A', strtotime($this->time)),
                        'duration' => (int) $zoom->meeting_duration,
                        'datetime' => (string) strtotime($zoom->date_of_meeting . $zoom->time_of_meeting),
                        'host' => (string) $this->host,
                        'zoom' => [
                            'meeting_id' => $zoom->meeting_id,
                            'password' => $zoom->password
                        ],
                    ];
                }
                break;

            case 'BBB':
                foreach ($this->bbbMeetings as $bbb) {
                    $meeting = Bigbluebutton::getMeetingInfo([
                        'meetingID' => $bbb->meeting_id,
                    ]);
                    $localBbbMeeting = BbbMeeting::where('meeting_id', $bbb->meeting_id)->first();

                    if (count($meeting) == 0) {
                        Bigbluebutton::create([
                            'meetingID' => $localBbbMeeting->meeting_id,
                            'meetingName' => $localBbbMeeting->topic,
                            'attendeePW' => $localBbbMeeting->attendee_password,
                            'moderatorPW' => $localBbbMeeting->moderator_password,
                            'welcomeMessage' => $localBbbMeeting->welcome_message,
                            'dialNumber' => $localBbbMeeting->dial_number,
                            'maxParticipants' => $localBbbMeeting->max_participants,
                            'logoutUrl' => $localBbbMeeting->logout_url,
                            'record' => $localBbbMeeting->record,
                            'duration' => $localBbbMeeting->duration,
                            'isBreakout' => $localBbbMeeting->is_breakout,
                            'moderatorOnlyMessage' => $localBbbMeeting->moderator_only_message,
                            'autoStartRecording' => $localBbbMeeting->auto_start_recording,
                            'allowStartStopRecording' => $localBbbMeeting->allow_start_stop_recording,
                            'webcamsOnlyForModerator' => $localBbbMeeting->webcams_only_for_moderator,
                            'copyright' => $localBbbMeeting->copyright,
                            'muteOnStart' => $localBbbMeeting->mute_on_start,
                            'lockSettingsDisableMic' => $localBbbMeeting->lock_settings_disable_mic,
                            'lockSettingsDisablePrivateChat' => $localBbbMeeting->lock_settings_disable_private_chat,
                            'lockSettingsDisablePublicChat' => $localBbbMeeting->lock_settings_disable_public_chat,
                            'lockSettingsDisableNote' => $localBbbMeeting->lock_settings_disable_note,
                            'lockSettingsLockedLayout' => $localBbbMeeting->lock_settings_locked_layout,
                            'lockSettingsLockOnJoin' => $localBbbMeeting->lock_settings_lock_on_join,
                            'lockSettingsLockOnJoinConfigurable' => $localBbbMeeting->lock_settings_lock_on_join_configurable,
                            'guestPolicy' => $localBbbMeeting->guest_policy,
                            'redirect' => $localBbbMeeting->redirect,
                            'joinViaHtml5' => $localBbbMeeting->join_via_html5,
                            'state' => $localBbbMeeting->state,
                        ]);

                        $meeting = Bigbluebutton::getMeetingInfo([
                            'meetingID' => $bbb->meeting_id,
                        ]);
                    }
                    $url = Bigbluebutton::start([
                        'meetingID' => $bbb->meeting_id,
                        'password' => $meeting['moderatorPW'],
                        'userName' => auth()->user()->name,
                    ]);

                    $hostData[] = [
                        'id' => (int) $bbb->id,
                        'topic' => (string) $bbb->topic,
                        'date' => (string) $bbb->date,
                        'time' => (string) date('h:i A', strtotime($bbb->time)),
                        'duration' => (int) $bbb->duration,
                        'datetime' => (string) $bbb->datetime,
                        'host' => (string) $this->host,
                        'bbb' => [
                            'attendee_password' => $bbb->attendee_password,
                            'moderator_password' => $bbb->moderator_password,
                            'url' => $url
                        ],
                    ];
                }
                break;

            case 'Jitsi':
                foreach ($this->jitsiMeetings as $jitsi) {
                    $hostData[] = [
                        'id' => (int) $jitsi->id,
                        'topic' => (string) $jitsi->topic,
                        'date' => (string) $jitsi->date,
                        'time' => (string) date('h:i A', strtotime($jitsi->time)),
                        'duration' => (int) $jitsi->duration,
                        'datetime' => (string) $jitsi->datetime,
                        'host' => (string) $this->host,
                        'jitsi' => [
                            'meeting_id' => (string) $jitsi->meeting_id
                        ],
                    ];
                }
                break;

            case 'InAppLiveClass':
                $controller = new InAppLiveClassController;
                $hostSetting = json_decode($this->host_setting);
                $rtmToken = $controller->getRTMToken('Account');
                $appId = $controller->appId;
                foreach ($this->inAppMeetings as $app) {
                    $channelName = "session_$app->id";
                    $rtcToken = $controller->getRTCToken($channelName, true);
                    $hostData[] = [
                        'id' => (int) $app->id,
                        'topic' => (string) $app->topic,
                        'date' => (string) $app->date,
                        'time' => (string) date('h:i A', strtotime($app->time)),
                        'duration' => (int) $app->duration,
                        'datetime' => (string) $app->datetime,
                        'host' => (string) $this->host,
                        'inAppLiveClass' => [
                            'chat' => (bool) $hostSetting->chat,
                            'appId' => $appId,
                            'channelName' => $channelName,
                            'rtcToken' => $rtcToken,
                            'rtmToken' => $rtmToken,
                        ],
                    ];
                }
                break;

            case 'Custom':
                $hostSetting = json_decode($this->host_setting);
                foreach ($this->customMeetings as $custom) {
                    $hostData[] = [
                        'id' => (int) $custom->id,
                        'topic' => (string) $custom->topic,
                        'date' => (string) $custom->date,
                        'time' => (string) date('h:i A', strtotime($custom->time)),
                        'duration' => (int) $custom->duration,
                        'datetime' => (string) $custom->datetime,
                        'host' => (string) $this->host,
                        'custom' => [
                            'host' => $custom->host ? (string) $custom->host : null,
                            'link' => $custom->link ? (string) $custom->link : null,
                            'description' => $custom->description ? (string) $custom->description : null,
                        ]
                    ];
                }
                break;

            default:
                break;
        }

        return $hostData;
    }
}
