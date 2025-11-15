<?php

namespace Modules\VirtualClass\Entities;

use App\Notifications\GeneralNotification;
use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Modules\BBB\Entities\BbbMeeting;
use Modules\CourseSetting\Entities\Category;
use Modules\CourseSetting\Entities\Course;
use Modules\GoogleCalendar\Entities\GoogleCalendarEvent;
use Modules\GoogleMeet\Entities\GoogleMeetMeeting;
use Modules\InAppLiveClass\Entities\InAppLiveClassMeeting;
use Modules\Jitsi\Entities\JitsiMeeting;
use Modules\Localization\Entities\Language;
use Modules\Membership\Entities\MembershipLevel;
use Modules\Zoom\Entities\ZoomMeeting;
use App\Traits\HasTranslations;


class VirtualClass extends Model
{
    use Tenantable;

    public $translatable = ['title'];

    use HasTranslations;
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            saasPlanManagement('meeting', 'create');
        });

        static::deleting(function ($virtualClass) {
            saasPlanManagement('meeting', 'delete');
            $receivers = $virtualClass->course->enrollUsers;
            $message = "Your virtual class " . $virtualClass->title . " has been deleted";
            foreach ($receivers as $key => $receiver) {
                $details = [
                    'title' => 'Virtual Class Deleted ',
                    'body' => $message,
                    'actionText' => '',
                    'actionURL' => '',
                ];
                Notification::send($receiver, new GeneralNotification($details));
            }
        });

    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id')->withDefault();
    }

    public function subCategory()
    {
        return $this->belongsTo(Category::class, 'sub_category_id')->withDefault(
            [
                'name' => ''
            ]
        );
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'lang_id')->withDefault();
    }

    public function zoomMeetings()
    {
        return $this->hasMany(ZoomMeeting::class, 'class_id')->orderBy('start_time', 'asc');
    }

    public function bbbMeetings()
    {
        return $this->hasMany(BbbMeeting::class, 'class_id')->orderBy('datetime', 'asc');
    }

    public function jitsiMeetings()
    {
        return $this->hasMany(JitsiMeeting::class, 'class_id')->orderBy('datetime', 'asc');
    }

    public function customMeetings()
    {
        return $this->hasMany(CustomMeeting::class, 'class_id')->orderBy('datetime', 'asc');
    }

    public function inAppMeetings()
    {
        return $this->hasMany(InAppLiveClassMeeting::class, 'class_id')->orderBy('datetime', 'asc');
    }

    public function googleMeetMeetings()
    {
        return $this->hasMany(GoogleMeetMeeting::class, 'class_id');
    }

    public function googleEvents()
    {
        return $this->morphMany(GoogleCalendarEvent::class, 'eventale', 'main_model', 'main_model_id');
    }

    public function totalClass()
    {
        $total = 0;
        if ($this->host == "Zoom") {
            $total = count($this->zoomMeetings);
        } elseif ($this->host == "BBB") {
            $total = count($this->bbbMeetings);
        } elseif ($this->host == "Jitsi") {
            $total = count($this->jitsiMeetings);
        }elseif ($this->host == "InAppLiveClass") {
            $total = count($this->inAppMeetings);
        }elseif ($this->host == "GoogleMeet") {
            $total = count($this->googleMeetMeetings);
        }elseif ($this->host == "Custom") {
            $total = count($this->customMeetings);
        }
        return $total;
    }

    public function course()
    {
        return $this->hasOne(Course::class, 'class_id')->withDefault();
    }

    public function getSlugAttribute()
    {
        return Str::slug($this->title) == "" ? str_replace(' ', '-', $this->title) : Str::slug($this->title);

    }

    public function records()
    {
       return $this->hasMany(ClassRecord::class, 'class_id');
    }
    public function membershipLevel(){
        return $this->belongsTo(MembershipLevel::class,'membership_level_id', 'id')->withDefault();
    }

}
