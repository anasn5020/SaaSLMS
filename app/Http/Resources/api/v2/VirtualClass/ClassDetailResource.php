<?php

namespace App\Http\Resources\api\v2\VirtualClass;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Membership\Entities\MembershipLevel;
use Modules\Membership\Entities\MembershipMember;

class ClassDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $assistantInstructors = null;
        if ($this->course->assistantInstructorsIds) {
            foreach ($this->course->assistantInstructorsIds as $id) {
                $assistantInstructors[] = User::select('id', 'name')->find($id);
            }
        }

        $hostData = null;
        switch ($this->host) {
            case 'Zoom':
                $host = 'zoom';
                foreach ($this->zoomMeetings as $zoom) {
                    $hostData = [
                        'zoom_password' => (string) $zoom->password
                    ];
                }
                break;

            case 'BBB':
                $host = 'bbb';
                foreach ($this->bbbMeetings as $bbb) {
                    $hostData = [
                        'attendee_password' => (string) $bbb->attendee_password,
                        'moderator_password' => (string) $bbb->moderator_password,
                    ];
                }
                break;

            case 'Jitsi':
                $host = 'jitsi';
                foreach ($this->jitsiMeetings as $jitsi) {
                    $hostData = [
                        'jitsi_meeting_id' => (string) $jitsi->meeting_id,
                    ];
                }
                break;

            case 'InAppLiveClass':
                $host = 'in-app-live';
                $hostSetting = json_decode($this->host_setting);
                foreach ($this->inAppMeetings as $app) {
                    $hostData = [
                        'chat' => (bool) $hostSetting->chat,
                    ];
                }
                break;

            default:
                $host = 'zoom';
                foreach ($this->zoomMeetings as $zoom) {
                    $hostData = [
                        'zoom_password' => (string) $zoom->password
                    ];
                }
                break;
        }

        $level = null;
        if ($this->course->level) {
            $level = [
                'id' => $this->course->courseLevel->id,
                'name' => $this->course->courseLevel->title,
            ];
        }

        $certificate = null;
        if ($this->course->certificate_id) {
            $certificate = [
                'id' => (int) $this->course->certificate->id,
                'name' => (string) $this->course->certificate->title,
            ];
        }

        $membership_level = null;
        if (isModuleActive('Membership') && !empty($this->membership_level_id)) {
            $level = MembershipLevel::find($this->membership_level_id);
            $membership_level = [
                'id' => (int) $level->id,
                'name' => (string) $level->title,
            ];
        }

        $membership = null;
        if (isModuleActive('Membership') && !empty($this->membershipLevel->id)) {
            $user = $this->membershipLevel->user_id;
            $member = MembershipMember::where('user_id', $user)->member;
            $membership = [
                'id' => (int) $member->id,
                'name' => (string) $member->name,
            ];
        }

        $recurringDays = null; // null
        if ($this->recurring_type == 2) {
            foreach (json_decode($this->recurring_days) as $day) {
                $recurringDays[] = (int)$day;
            }
        }

        return [
            'class_id' => (int) $this->id,
            'title' => (string) $this->title,
            'description' => (string) $this->course->about,
            'assign_instructor' => [
                'id' => (int) $this->course->instructor->id,
                'name' => (string) $this->course->instructor->name,
            ],
            'assistant_instructor' => $assistantInstructors,
            'category' => [
                'id' => (int) $this->category->id,
                'name' => (string) $this->category->name,
            ],
            'subcategory' => [
                'id' => (int) $this->subCategory->id,
                'name' => (string) $this->subCategory->name,
            ],
            'language' => [
                'id' => (int) $this->language->id,
                'name' => (string) $this->language->name,
            ],
            'is_free_class' => $this->fees < 1,
            'fee' => (float) $this->fees,
            'image' => $this->course->image ? (string) asset($this->course->image) : '',
            'view_scope' => (int) $this->course->scope,
            'start_date' => $this->start_date ? (string) date('m-d-Y', strtotime($this->start_date)) : null,
            'time' => (string) date('h:i A', strtotime($this->time)),
            'host' => (string) ucwords($host),
            $host => $hostData,
            'certificate' => $certificate,
            'capacity' => (int) $this->capacity,
            'support' => (bool) $this->course->support,
            'level' => $level,
            'duration' => (float) $this->duration,
            'all_member' => (bool) $this->is_all_member,
            'membership_level' => $membership_level,
            'members' => $membership,
            'is_recurring' => (bool)$this->is_recurring,
            'recurring_type' => (int)$this->recurring_type,
            'end_recurrence_date' => $this->end_date ? (string)date('m-d-Y', strtotime($this->end_date)) : null,
            'recurring_days' => $recurringDays,
        ];
    }
}
