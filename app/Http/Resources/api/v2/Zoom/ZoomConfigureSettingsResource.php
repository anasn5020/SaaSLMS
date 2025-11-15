<?php

namespace App\Http\Resources\api\v2\Zoom;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ZoomConfigureSettingsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $approval = null;
        if (isset($this->approval_type)) {
            switch ($this->approval_type) {
                case 0:
                    $approval = [
                        'id' => 0,
                        'name' => 'Automatically',
                    ];
                    break;
                case 1:
                    $approval = [
                        'id' => 1,
                        'name' => 'Manually Approve',
                    ];
                case 2:
                    $approval = [
                        'id' => 2,
                        'name' => 'No Registration Required',
                    ];
                    break;

                default:
                    $approval = null;
                    break;
            }
        }

        $recording = null;
        if (isset($this->auto_recording)) {
            switch ($this->auto_recording) {
                case 'none':
                    $recording = [
                        'id' => 'none',
                        'name' => 'None',
                    ];
                    break;
                case 'local':
                    $recording = [
                        'id' => 'local',
                        'name' => 'Local',
                    ];
                    break;
                case 'cloud':
                    $recording = [
                        'id' => 'cloud',
                        'name' => 'Cloud',
                    ];
                    break;

                default:
                    $recording = null;
                    break;
            }
        }

        $audio = null;
        if (isset($this->audio)) {
            switch ($this->audio) {
                case 'both':
                    $audio = [
                        'id' => 'both',
                        'name' => 'Both',
                    ];
                    break;
                case 'telephony':
                    $audio = [
                        'id' => 'telephony',
                        'name' => 'Telephony',
                    ];
                    break;
                case 'value':
                    $audio = [
                        'id' => 'voip',
                        'name' => 'Voip',
                    ];
                    break;

                default:
                    $audio = null;
                    break;
            }
        }

        $package = null;
        if (isset($this->package_id)) {
            switch ($this->package_id) {
                case 1:
                    $package = [
                        'id' => 1,
                        'name' => 'Basic (Free)',
                    ];
                    break;
                case 2:
                    $package = [
                        'id' => 2,
                        'name' => 'Pro',
                    ];
                    break;
                case 3:
                    $package = [
                        'id' => 3,
                        'name' => 'Business',
                    ];
                    break;
                case 4:
                    $package = [
                        'id' => 4,
                        'name' => 'Enterprise',
                    ];
                    break;

                default:
                    $package = null;
                    break;
            }
        }

        return [
            'class_join_approval' => $approval,
            'auto_recording' => $recording,
            'audio_option' => $audio,
            'package' => $package,
            'zoom_account_id' => isset($this->zoom_account_id) ? (string) $this->zoom_account_id : null,
            'zoom_client_id' => isset($this->zoom_client_id) ? (string) $this->zoom_client_id : null,
            'zoom_client_secret' => isset($this->zoom_client_secret) ? (string) $this->zoom_client_secret : null,
            'host_video' => isset($this->host_video) ? (bool) $this->host_video : null,
            'participant_video' => isset($this->participant_video) ? (bool) $this->participant_video : null,
            'join_before_host' => isset($this->join_before_host) ? (bool) $this->join_before_host : null,
            'waiting_room' => isset($this->waiting_room) ? (bool) $this->waiting_room : null,
            'mute_upon_entry' => isset($this->mute_upon_entry) ? (bool) $this->mute_upon_entry : null,
        ];
    }
}
