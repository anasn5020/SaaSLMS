<?php

namespace Modules\VirtualClass\Services;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Modules\BBB\Entities\BbbSetting;
use Modules\BBB\Http\Controllers\BbbMeetingController;
use Modules\InAppLiveClass\Http\Controllers\InAppLiveClassController;
use Modules\Jitsi\Http\Controllers\JitsiMeetingController;
use Modules\VirtualClass\Http\Controllers\CustomMeetingController;
use Modules\Zoom\Entities\ZoomSetting;
use Modules\Zoom\Http\Controllers\MeetingController;

class CreateClass {

    public function createClassWithZoom($class, $date, $request, $fileName)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        $user_id = $class->course->user_id;
        $meeting = new MeetingController($user_id);
        $data = [];
        $data['instructor_id'] = $user_id;
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
        $data['recurring_repeat_count'] = $request->recurring_repeat_count;
        $data['end_date'] = $request->end_date;

        $setting = ZoomSetting::getData();

        $data['approval_type'] = $setting->approval_type;
        $data['auto_recording'] = $setting->auto_recording;
        $data['waiting_room'] = $setting->waiting_room;
        $data['audio'] = $setting->audio;
        $data['mute_upon_entry'] = $setting->mute_upon_entry;
        $data['host_video'] = $setting->host_video;
        $data['participant_video'] = $setting->participant_video;
        $data['join_before_host'] = $setting->join_before_host;

        $token = $meeting->createZoomToken();

        if (empty($token)) {
            Toastr::error(trans('virtual-class.Zoom API Authentication Issue'), trans('common.Failed'));
            return false;
        } else {
            return $meeting->classStore($token, $data);
        }
    }

    public function createClassWithBBB($class, $date, $request)
    {

        $data = [];
        $setting = BbbSetting::getData();
        $data['topic'] = $class->getTranslation('title', app()->getLocale());
        $data['instructor_id'] = Auth::user()->id;
        $data['class_id'] = $class->id;
        $data['attendee_password'] = $request->attendee_password;
        $data['moderator_password'] = $request->moderator_password;
        $data['date'] = $date;
        $data['time'] = $class->time;
        $data['welcome_message'] = $setting->welcome_message;
        $data['dial_number'] = $setting->dial_number;
        $data['max_participants'] = $setting->max_participants;
        $data['logout_url'] = $setting->logout_url;
        $data['record'] = $setting->record;
        $data['duration'] = $request->duration;
        $data['is_breakout'] = $setting->is_breakout;
        $data['moderator_only_message'] = $setting->moderator_only_message;
        $data['auto_start_recording'] = $setting->auto_start_recording;
        $data['allow_start_stop_recording'] = $setting->allow_start_stop_recording;
        $data['webcams_only_for_moderator'] = $setting->webcams_only_for_moderator;
        $data['copyright'] = $setting->copyright;
        $data['mute_on_start'] = $setting->mute_on_start;
        $data['lock_settings_disable_mic'] = $setting->lock_settings_disable_mic;
        $data['lock_settings_disable_private_chat'] = $setting->lock_settings_disable_private_chat;
        $data['lock_settings_disable_public_chat'] = $setting->lock_settings_disable_public_chat;
        $data['lock_settings_disable_note'] = $setting->lock_settings_disable_note;
        $data['lock_settings_locked_layout'] = $setting->lock_settings_locked_layout;
        $data['lock_settings_lock_on_join'] = $setting->lock_settings_lock_on_join;
        $data['lock_settings_lock_on_join_configurable'] = $setting->lock_settings_lock_on_join_configurable;
        $data['guest_policy'] = $setting->guest_policy;
        $data['redirect'] = $setting->redirect;
        $data['join_via_html5'] = $setting->join_via_html5;
        $data['state'] = $setting->state;
        $datetime = $date . " " . $class->time;
        $data['datetime'] = strtotime($datetime);


        $meeting = new BbbMeetingController();
        $result = $meeting->classStore($data);

        return $result;
    }

    public function createClassWithJitsi($class, $date, $request)
    {
        $data = [];
        $data['topic'] = $class->getTranslation('title', app()->getLocale());
        $data['description'] = $class->course->getTranslation('about', app()->getLocale());
        $data['duration'] = $request->duration;
        $data['jitsi_meeting_id'] = $request->jitsi_meeting_id;
        $data['instructor_id'] = Auth::user()->id;
        $data['class_id'] = $class->id;
        $data['date'] = $date;
        $data['time'] = $request->time;

        $meeting = new JitsiMeetingController();
        $result = $meeting->classStore($data);

        return $result;
    }

    public function createClassWithInAppLiveClass($class, $date, $request)
    {
        $data = [];
        $data['topic'] = $class->getTranslation('title', app()->getLocale());
        $data['description'] = $class->course->getTranslation('about', app()->getLocale());
        $data['duration'] = $request->duration;
        $data['jitsi_meeting_id'] = $request->jitsi_meeting_id;
        $data['instructor_id'] = Auth::user()->id;
        $data['class_id'] = $class->id;
        $data['date'] = $date;
        $data['time'] = $request->time;

        $meeting = new InAppLiveClassController();
        $result = $meeting->classStore($data);

        return $result;
    }

    public function createClassWithCustom($class, $date, $request)
    {
        $data['topic'] = $class->getTranslation('title', app()->getLocale());
        $data['description'] = $class->course->getTranslation('about', app()->getLocale());
        $data['duration'] = $request->duration;
        $data['instructor_id'] = Auth::user()->id;
        $data['class_id'] = $class->id;
        $data['date'] = $date;
        $data['time'] = $request->time;

        $meeting = new CustomMeetingController();
        return $meeting->classStore($data);
    }
}
