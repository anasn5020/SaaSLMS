<?php

namespace Modules\Zoom\Entities;

use App\User;
use Carbon\Carbon;
use App\Traits\Tenantable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\GeneralNotification;
use Illuminate\Support\Facades\Notification;

use Modules\VirtualClass\Entities\ClassRecord;
use Modules\VirtualClass\Entities\VirtualClass;

class ZoomMeeting extends Model
{
    use Tenantable;

    protected $table = 'zoom_meetings';
    protected $guarded = ['id'];

    public function participates()
    {
        return $this->hasMany(ZoomMeetingUser::class, 'meeting_id', 'id');
    }

    public function class()
    {
        return $this->belongsTo(VirtualClass::class, 'class_id')->withDefault();
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id')->withDefault();
    }


    public function getParticipatesNameAttribute()
    {
        return implode(', ', $this->participates->pluck('full_name')->toArray());
    }

    public function getMeetingDateTimeAttribute()
    {
        return Carbon::parse($this->date_of_meeting . ' ' . $this->time_of_meeting)->format('m-d-Y h:i A');
    }

    public function getCurrentStatusAttribute()
    {
        $now = Carbon::now()->setTimezone(Settings('active_time_zone'));
        if ($this->is_recurring == 1) {
            if ($now->between(Carbon::parse($this->start_time)->addMinute(-10)->format('Y-m-d H:i:s'), Carbon::parse($this->recurring_end_date)->endOfDay()->format('Y-m-d H:i:s'))) {
                return 'started';
            }
            if (!$now->gt(Carbon::parse($this->recurring_end_date)->addMinute(-10))) {
                return 'waiting';
            }
            return 'closed';
        } else {
            if ($now->between(Carbon::parse($this->start_time)->addMinute(-10)->format('Y-m-d H:i:s'), Carbon::parse($this->end_time)->format('Y-m-d H:i:s'))) {
                return 'started';
            }

            if (!$now->gt(Carbon::parse($this->end_time)->addMinute(-10))) {
                return 'waiting';
            }
            return 'closed';
        }
    }

    public function getMeetingEndTimeAttribute()
    {
        return Carbon::parse($this->date_of_meeting . ' ' . $this->time_of_meeting)->addMinute($this->meeting_duration);
    }

    public function getUrlAttribute()
    {
        if (Auth::user()->id == $this->created_by || Auth::user()->role_id == 1) {
            return 'https://zoom.us/wc/' . $this->meeting_id . '/start';
        } else {
            return 'https://zoom.us/wc/' . $this->meeting_id . '/join';
        }
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($zoom_meeting) {
            $virtualClass = VirtualClass::find($zoom_meeting->class_id);
            $receivers = $virtualClass->course->enrollUsers;
            $message = "The scheduled class of " . $virtualClass->title . " for " . showDate($zoom_meeting->date_of_meeting) . " at " . $zoom_meeting->time_of_meeting . " are canceled";
            foreach ($receivers as $key => $receiver) {
                $details = [
                    'title' => $virtualClass->title,
                    'body' => $message,
                    'actionText' => '',
                    'actionURL' => '',
                ];
                Notification::send($receiver, new GeneralNotification($details));
            }
        });
    }

    public function records()
    {
        return $this->hasMany(ClassRecord::class,'meeting_id');
    }

}
