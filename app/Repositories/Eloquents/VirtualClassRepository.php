<?php

namespace App\Repositories\Eloquents;

use App\User;
use Carbon\Carbon;
use App\Traits\ImageStore;
use App\Traits\UploadMedia;
use Illuminate\Support\Facades\App;
use Modules\BBB\Entities\BbbMeeting;
use Modules\BBB\Entities\BbbSetting;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;
use Modules\Zoom\Entities\ZoomMeeting;
use Modules\BBB\Entities\BbbMeetingUser;
use Modules\Forum\Services\ForumService;
use Modules\Jitsi\Entities\JitsiMeeting;
use App\Notifications\GeneralNotification;
use Modules\CourseSetting\Entities\Course;
use Modules\Zoom\Entities\ZoomMeetingUser;

use Illuminate\Support\Facades\Notification;
use Modules\Jitsi\Entities\JitsiMeetingUser;
use Modules\Certificate\Entities\Certificate;
use Illuminate\Validation\ValidationException;
use Modules\VirtualClass\Services\CreateClass;
use Modules\GoogleMeet\Events\MeetingSyncEvent;
use Modules\VirtualClass\Entities\VirtualClass;
use Modules\VirtualClass\Entities\ClassComplete;
use Modules\GoogleMeet\Events\MeetingDeleteEvent;
use Modules\GoogleMeet\Entities\GoogleMeetMeeting;
use Modules\BBB\Http\Controllers\BbbMeetingController;
use Modules\GoogleCalendar\Entities\GoogleCalendarEvent;
use Modules\GoogleCalendar\Events\GoogleCalendarSyncEvent;
use Modules\Jitsi\Http\Controllers\JitsiMeetingController;
use Modules\GoogleCalendar\Events\GoogleCalendarDeleteEvent;
use App\Http\Resources\api\v2\VirtualClass\ClassListResource;
use Modules\InAppLiveClass\Entities\InAppLiveClassMeetingUser;
use App\Http\Resources\api\v2\VirtualClass\ClassDetailResource;
use App\Repositories\Interfaces\VirtualClassRepositoryInterface;
use App\Http\Resources\api\v2\Certificate\CertificateListResource;
use Modules\VirtualClass\Http\Controllers\CustomMeetingController;
use App\Http\Resources\api\v2\VirtualClass\ClassScheduleListResource;
use Modules\InAppLiveClass\Http\Controllers\InAppLiveClassController;
use Modules\Membership\Repositories\Interfaces\MembershipVirtualClassRepositoryInterface;

class VirtualClassRepository implements VirtualClassRepositoryInterface
{
    use /* UploadMedia */ ImageStore;

    public function __construct(private CreateClass $createClass) {}
    public function store(object $request): bool
    {
        $class = new VirtualClass();
        if (isModuleActive('Membership')) {
            if ($request->filled('is_membership')) {
                $class->is_membership = 1;
            }
        }
        foreach ($request->get('title', []) as $key => $title) {
            $class->setTranslation('title', $key, $title);
        }
        if (showEcommerce()) {
            if ($request->free == 1) {
                $class->fees = 0;
            } else {
                $class->fees = (float)$request->fees;
            }
        } else {
            $class->fees = 0;
        }
        $class->duration = $request->duration;
        $class->category_id = (int)$request->category;
        $class->sub_category_id = (int)$request->sub_category;
        $class->type = (int)$request->get('type', 0);
        $class->host = $request->host;
        $class->lang_id = $request->lang_id;
        $class->capacity = $request->capacity;

        $class->is_recurring = (int) $request->is_recurring;
        $class->recurring_type = (int) $request->recurring_type;
        $class->recurring_repeat_count = (int) $request->recurring_repeat_count;
        $class->recurring_days = $request->recurring_type == 2 ? json_encode((array) $request->recurring_days) : null;

        $startDate = Carbon::createFromFormat('m-d-Y', $request->start_date)->format('Y-m-d');
        $class->start_date = $startDate;
        $class->end_date = $request->end_date ? Carbon::createFromFormat('m-d-Y', $request->end_date)->format('Y-m-d') : $startDate;

        $class->time = $request->time ? date("H:i", strtotime($request->time)) : null;
        $class->show_record = (int)$request->get('show_record', 0);
        $class->record_validity = (int)$request->get('record_validity', 0);

        $class->save();
        $course = new Course();
        $course->scope      = $request->scope;
        $course->class_id   = $class->id;
        $course->user_id    = auth()->id();
        $course->lang_id = $request->lang_id;
        $course->price = $class->fees;

        //for support ticket
        if (isModuleActive('SupportTicket') && Schema::hasColumn('courses', 'support')) {
            if (isset($request->support)) {
                $course->support = true;
            } else {
                $course->support = false;
            }
        }

        foreach ($request->get('title', []) as $key => $title) {
            $course->setTranslation('title', $key, $title);
        }

        foreach ($request->get('description', []) as $key => $about) {
            $course->setTranslation('about', $key, $about);
        }

        $course->required_type = (int)$request->required_type;

        if (Settings('frontend_active_theme') == "edume") {
            $course->what_learn1 = $request->what_learn1;
            $course->what_learn2 = $request->what_learn2;
        }

        if (isModuleActive('CertificatePro') && Settings('use_certificate_template') == 'pro') {
            $course->pro_certificate_id = (int)$request->get('certificate', 0);
        } else {
            $course->certificate_id = (int)$request->get('certificate', 0);
        }

        if (!empty($request->assign_instructor)) {
            $course->user_id = $request->assign_instructor;
        }
        if (!empty($request->assistant_instructors)) {
            $assistants = $request->assistant_instructors;
            if (($key = array_search($course->user_id, $assistants)) !== false) {
                unset($assistants[$key]);
            }
            if ($assistants) {
                $course->assistant_instructors = json_encode(array_values($assistants));
            }
        }
        $course->type = 3;
        $course->save();

        if ($request->image) {
            $image = $this->saveImage($request->image);
            $course->image = $image;
            $course->thumbnail = $image;
        }
        $course->save();
        $days = $this->getDates($class);

        $class->duration = $request->duration;
        $class->total_class = count($days);

        $class->save();
        if (isModuleActive('Forum')) {
            $forumService = new ForumService();
            $forumService->autoTopic('topic', $course);
        }

        // if (count($days) == 0) {
        //     throw ValidationException::withMessages(['message' => __('virtual-class.No Class created')]);
        // }

        foreach ($days as $value) {

            $new_date = Carbon::parse($value)->format('m/d/Y');

            if (isModuleActive('GoogleCalendar') && $class->host != 'GoogleMeet' && isset($request->allow_google_calendar) && $request->allow_google_calendar) {
                $custom_date = [
                    'main_model' => VirtualClass::class,
                    'main_model_id' => $class->id,
                    'sub_model' => null,
                    'sub_model_id' => null,
                ];
                Event::dispatch(new GoogleCalendarSyncEvent([], $custom_date, $class->id, $new_date));
            }

            if ($class->host == "Zoom") {

                $fileName = "";
                if ($request->file('attached_file') != "") {
                    $file = $request->file('attached_file');
                    $ignore = strtolower($file->getClientOriginalExtension());
                    if ($ignore != 'php') {
                        $fileName = $request->topic . time() . "." . $file->getClientOriginalExtension();
                        $file->move('public/uploads/zoom-meeting/', $fileName);
                        $fileName = 'public/uploads/zoom-meeting/' . $fileName;
                    }
                }
                $this->createClass->createClassWithZoom($class, $new_date, $request, $fileName);
            } elseif ($class->host == "BBB") {
                if (isModuleActive('BBB')) {
                    $this->createClass->createClassWithBBB($class, $new_date, $request);
                } else {
                    throw ValidationException::withMessages(['message' => trans('frontend.Module not installed yet')]);
                }
            } elseif ($class->host == "Jitsi") {

                if (isModuleActive('Jitsi')) {
                    $this->createClass->createClassWithJitsi($class, $new_date, $request);
                } else {
                    throw ValidationException::withMessages(['message' => trans('frontend.Module not installed yet')]);
                }
            } elseif ($class->host == "InAppLiveClass") {

                if (isModuleActive('InAppLiveClass')) {
                    $agoraSettings = [
                        'chat' => $request->in_app_chat == 1 ? 1 : 0,
                        'audio' => $request->in_app_audio == 1 ? 1 : 0,
                        'video' => $request->in_app_video == 1 ? 1 : 0,
                        'share_screen' => $request->in_app_share_screen == 1 ? 1 : 0,
                    ];
                    $class->host_setting = json_encode($agoraSettings);
                    $class->save();
                    $this->createClass->createClassWithInAppLiveClass($class, $new_date, $request);
                } else {
                    throw ValidationException::withMessages(['message' => trans('frontend.Module not installed yet')]);
                }
            } elseif ($class->host == "GoogleMeet") {
                if (isModuleActive('GoogleMeet')) {
                    Event::dispatch(new MeetingSyncEvent($class->id, $new_date));
                } else {
                    throw ValidationException::withMessages(['message' => trans('frontend.Module not installed yet')]);
                }
            } elseif ($class->host == "Custom") {
                $this->createClass->createClassWithCustom($class, $new_date, $request);
            }

            if (isModuleActive('Membership')) {
                $request->merge([
                    'virtual_class_id' => $class->id,
                ]);

                $membershipInterface = App::make(MembershipVirtualClassRepositoryInterface::class);
                $membershipInterface->storeVirtualClassMember($request->except(['_token', 'url']));
            }
        }
        return true;
    }

    public function instructors(object $request): object
    {
        return User::whereIn('role_id', [1, 2])
            ->when($search = $request->search, function ($user) use ($search) {
                $user->whereLike('name', $search);
            })->where('status', 1)
            ->select('id', 'name')
            ->paginate($request->per_page ?? 10)->makeHidden('blocked_by_me');
    }

    public function certificateTypes(): object
    {
        return CertificateListResource::collection(Certificate::get());
    }

    public function classList(object $request): object
    {
        $data = VirtualClass::when($request->search, function ($class) use ($request) {
            $class->whereLike('title', $request->search);
        })->paginate($request->per_page ?? 10);

        return ClassListResource::collection($data);
    }

    public function classDetail(object $request): object
    {
        $rules = ['class_id' => 'required|exists:virtual_classes,id'];
        $request->validate($rules, validationMessage($rules));

        $data = VirtualClass::where('status', 1)->find($request->class_id);

        return new ClassDetailResource($data);
    }

    public function classSchedules(object $request): object
    {
        $class = VirtualClass::find($request->class_id);
        return new ClassScheduleListResource($class);
    }
    public function updateClass(object $request): bool
    {
        $class = VirtualClass::find($request->class_id);
        if (!isset($class)) {
            throw ValidationException::withMessages(['class_id' => __('validation.class_id.exists')]);
        }
        $course = Course::where('class_id', $class->id)->where('type', 3)->first();
        if (!$course) {
            $course = new Course();
            $course->class_id = $class->id;
            $course->type = 3;
        }

        foreach ($request->get('title', []) as $key => $title) {
            $class->setTranslation('title', $key, $title);
        }
        $class->duration = $request->duration;
        $class->category_id = $request->category;
        $class->sub_category_id = $request->sub_category;

        if (showEcommerce()) {
            if ($request->free == 1) {
                $class->fees = 0;
            } else {
                $class->fees = (float)$request->fees;
            }
        } else {
            $class->fees = 0;
        }

        $class->type = (int)$request->get('type', 0);

        $class->is_recurring = (int) $request->is_recurring;
        $class->recurring_type = (int) $request->recurring_type;
        $class->recurring_repeat_count = (int) $request->recurring_repeat_count;
        $class->recurring_days = $request->recurring_type == 2 ? json_encode((array) $request->recurring_days) : null;

        $startDate = Carbon::createFromFormat('m-d-Y', $request->start_date)->format('Y-m-d');
        $class->start_date = $startDate;
        $class->end_date = $request->end_date ? Carbon::createFromFormat('m-d-Y', $request->end_date)->format('Y-m-d') : $startDate;

        $class->time = !empty($request->time) ? date("H:i", strtotime($request->time)) : null;

        $class->capacity = $request->capacity;
        $class->show_record = (int)$request->get('show_record', 0);
        $class->record_validity = (int)$request->get('record_validity', 0);
        $class->save();

        $course->scope = (int)$request->scope;
        $course->level = (int)$request->level;
        if (!empty($request->assign_instructor)) {
            $course->user_id = $request->assign_instructor;
        }

        if (!empty($request->assistant_instructors)) {
            $assistants = $request->assistant_instructors;
            if (($key = array_search($course->user_id, $assistants)) !== false) {
                unset($assistants[$key]);
            }
            if (!empty($assistants)) {
                $course->assistant_instructors = json_encode(array_values($assistants));
            }
        }
        if (isModuleActive('Org')) {
            $course->required_type = $request->required_type;
        } else {
            $course->required_type = 0;
        }
        //for support ticket
        if (isModuleActive('SupportTicket') && Schema::hasColumn('courses', 'support')) {
            if (isset($request->support)) {
                $course->support = 1;
            } else {
                $course->support = 0;
            }
        }

        $course->lang_id = 1;
        foreach ($request->get('title', []) as $key => $title) {
            $course->setTranslation('title', $key, $title);
        }

        foreach ($request->get('description', []) as $key => $about) {
            $course->setTranslation('about', $key, $about);
        }

        if (Settings('frontend_active_theme') == "edume") {
            $course->what_learn1 = $request->what_learn1;
            $course->what_learn2 = $request->what_learn2;
        }

        if (isModuleActive('CertificatePro') && Settings('use_certificate_template') == 'pro') {
            $course->pro_certificate_id = (int)$request->get('certificate', 0);
        } else {
            $course->certificate_id = (int)$request->get('certificate', 0);
        }

        $class->category_id = (int)$request->category;
        $class->sub_category_id = (int)$request->sub_category;

        $course->image = null;
        $course->thumbnail = null;
        $course->save();

        if ($request->image) {
            $userImage = $this->saveImage($request->image);
            $course->image = $userImage;
            $course->thumbnail = $userImage;
        }
        $course->save();

        $days = $this->getDates($class);

        if (isModuleActive('GoogleCalendar') && $class->host != 'GoogleMeet') {
            $custom_date = [
                'main_model' => VirtualClass::class,
                'main_model_id' => $class->id,
                'sub_model' => null,
                'sub_model_id' => null,
            ];

            $all_events = GoogleCalendarEvent::where('main_model', VirtualClass::class)->where('main_model_id', $class->id)->get();

            foreach ($all_events as $event) {
                if ($event->google_calendar_id) {
                    Event::dispatch(new GoogleCalendarDeleteEvent($event->google_calendar_id));
                }
                $event->delete();
            }

            foreach ($days as $value) {
                $new_date = Carbon::parse($value)->format('m/d/Y');
                Event::dispatch(new GoogleCalendarSyncEvent([], $custom_date, $class->id, $new_date));
            }
        }

        if ($class->host == "Zoom") {
            $all = $class->zoomMeetings;
            foreach ($all as $zoom) {
                if (file_exists($zoom->attached_file)) {
                    unlink($zoom->attached_file);
                }
                ZoomMeetingUser::where('meeting_id', $zoom->meeting_id)->delete();
                $zoom->delete();
                $class->total_class = $class->total_class - 1;
                $class->save();
            }

            foreach ($days as $value) {
                $new_date = Carbon::parse($value)->format('m/d/Y');
                $this->createClass->createClassWithZoom($class, $new_date, $request, null);
            }
        } elseif ($class->host == "BBB") {
            $all = $class->bbbMeetings;
            foreach ($all as $bbb) {
                BbbMeetingUser::where('meeting_id', $bbb->id)->delete();
                $bbb->delete();
                $class->total_class = $class->total_class - 1;
                $class->save();
            }

            foreach ($days as $value) {
                $new_date = Carbon::parse($value)->format('m/d/Y');
                if (isModuleActive('BBB')) {
                    $this->createClass->createClassWithBBB($class, $new_date, $request);
                } else {
                    throw ValidationException::withMessages(['message' => trans('frontend.Module not installed yet')]);
                }
            }
        } elseif ($class->host == "Jitsi") {
            $all = $class->jitsiMeetings;
            foreach ($all as $jitsi) {
                JitsiMeetingUser::where('meeting_id', $jitsi->id)->delete();
                $jitsi->delete();
                $class->total_class = $class->total_class - 1;
                $class->save();
            }

            foreach ($days as $value) {
                $new_date = Carbon::parse($value)->format('m/d/Y');
                if (isModuleActive('Jitsi')) {
                    $this->createClass->createClassWithJitsi($class, $new_date, $request);
                } else {
                    throw ValidationException::withMessages(['message' => trans('frontend.Module not installed yet')]);
                }
            }
        } elseif ($class->host == "InAppLiveClass") {
            $all = $class->inAppMeetings;
            foreach ($all as $inApp) {
                InAppLiveClassMeetingUser::where('meeting_id', $inApp->id)->delete();
                $inApp->delete();
                $class->total_class = $class->total_class - 1;
                $class->save();
            }

            foreach ($days as $value) {
                $new_date = Carbon::parse($value)->format('m/d/Y');
                if (isModuleActive('InAppLiveClass')) {
                    $this->createClass->createClassWithInAppLiveClass($class, $new_date, $request);
                } else {
                    throw ValidationException::withMessages(['message' => trans('frontend.Module not installed yet')]);
                }
            }
        } elseif ($class->host == "GoogleMeet") {
            $all = $class->googleMeetMeetings;
            foreach ($all as $meet) {
                if ($meet->meetingId) {
                    Event::dispatch(new MeetingDeleteEvent($meet->meetingId));
                }

                $meet->delete();
                $class->total_class = $class->total_class - 1;
                $class->save();
            }

            foreach ($days as $value) {
                $new_date = Carbon::parse($value)->format('m/d/Y');
                Event::dispatch(new MeetingSyncEvent($class->id, $new_date));
            }
        } elseif ($class->host == "Custom") {
            $all = $class->customMeetings;
            foreach ($all as $custom) {
                $custom->delete();
                $class->total_class = $class->total_class - 1;
                $class->save();
            }

            foreach ($days as $value) {
                $new_date = Carbon::parse($value)->format('m/d/Y');
                $this->createClass->createClassWithCustom($class, $new_date, $request);
            }
        }

        $this->deleteClassComplete($course->id, $class->id);

        $class->total_class = count($days);
        $class->save();


        $receivers = $class->course->enrollUsers;
        if ($class->type == 0) {
            $message = "Your virtual class " . $class->getTranslation('title', app()->getLocale()) . " has been updated. Date :" . showDate($class->start_date) . "and Time is :" . $class->time;
        } else {
            $message = "Your virtual class " . $class->getTranslation('title', app()->getLocale()) . " has been updated. Date :" . showDate($class->start_date) .
                "To " . showDate($class->end_date) . "and Time is :" . $class->time;
        }

        foreach ($receivers as $key => $receiver) {
            $details = [
                'title' => 'Virtual Class Update ',
                'body' => $message,
                'actionText' => 'Visit',
                'actionURL' => route('classDetails', $class->course->slug),
            ];
            try {
                Notification::send($receiver, new GeneralNotification($details));
            } catch (\Exception) {
            }
        }

        return true;
    }

    public function changeStatus(object $request): bool
    {
        VirtualClass::find($request->class_id)->course()->update([
            'status' => (int)$request->status,
        ]);
        return true;
    }

    public function deleteClass(object $request): bool
    {
        $virtualClass = VirtualClass::find($request->class_id);

        if (!empty($virtualClass->course->carts)) {
            foreach ($virtualClass->course->carts as $cart) {
                $cart->delete();
            }
        }

        if ($virtualClass) {
            if ($virtualClass->host == "BBB") {
                if (isModuleActive('BBB')) {
                    $bbbClass = BbbMeeting::where('class_id', $virtualClass->id)->get();
                    $bbbClass->each->delete();
                }
            } elseif ($virtualClass->host == 'Zoom') {
                $zoomClass = ZoomMeeting::where('class_id', $virtualClass->id)->get();

                foreach ($zoomClass as $cls) {
                    $cls->delete();
                }
            } elseif ($virtualClass->host == 'Jitsi') {
                if (isModuleActive('Jitsi')) {
                    $JitsiClass = JitsiMeeting::where('class_id', $virtualClass->id)->get();
                    $JitsiClass->each->delete();
                }
            } elseif ($virtualClass->host == 'GoogleMeet') {
                if (isModuleActive('GoogleMeet')) {
                    $all = GoogleMeetMeeting::where('class_id', $virtualClass->id)->get();
                    foreach ($all as $meet) {
                        if ($meet->meetingId) {
                            Event::dispatch(new MeetingDeleteEvent($meet->meetingId));
                        }
                        $meet->delete();
                    }
                }
            }
        }
        $course = $virtualClass->course;

        if ($course && $virtualClass) {
            $this->deleteClassComplete($course->id, $virtualClass->id);
        }

        if ($course) {
            $course->delete();
        }

        if ($virtualClass) {
            $virtualClass->delete();
        }

        return true;
    }

    public function deleteSchedule(object $request): bool
    {
        $class = VirtualClass::findOrFail($request->class_id);
        switch ($class->host) {
            case 'Zoom':
                $schedule = $class->zoomMeetings->where('class_id', $request->class_id)->find($request->schedule_id);
                break;
            case 'BBB':
                $schedule = $class->zoomMeetings->find($request->schedule_id);
                break;
            case 'Jitsi':
                $schedule = $class->jitsiMeetings->find($request->schedule_id);
                break;
            case 'InAppLiveClass':
                $schedule = $class->inAppMeetings->find($request->schedule_id);
                break;
            default:
                $schedule = $class->customMeetings->find($request->schedule_id);
                break;
        }

        $schedule->delete();

        return true;
    }
    public function addPricePlan(object $request): bool
    {
        $rules = ['class_id' => 'required|exists:virtual_classes,id'];
        $request->validate($rules, validationMessage($rules));

        $request->replace([
            'course_id' => VirtualClass::find($request->class_id)->course->id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'title' => $request->title,
            'discount' => $request->discount,
            'capacity' => $request->capacity,
        ]);
        (new CoursePricePlanRepository)->storePlan($request);
        return true;
    }

    public function deletePricePlan(object $request): bool
    {
        $request->replace([
            'course_id' => VirtualClass::find($request->class_id)->course->id,
            'price_plan_id' => $request->price_plan_id,
        ]);
        (new CoursePricePlanRepository)->deletePlan($request);
        return true;
    }

    public function updatePricePlan(object $request): bool
    {
        $request->replace([
            'course_id' => VirtualClass::find($request->class_id)->course->id,
            'price_plan_id' => $request->price_plan_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'title' => $request->title,
            'discount' => $request->discount,
            'capacity' => $request->capacity,
        ]);
        (new CoursePricePlanRepository)->updatePlan($request);
        return true;
    }

    /* private function createClassWithZoom($class, $date, $request, $fileName)
    {
        (new ZoomRepository)->createClass($class, $date, $request, $fileName);
    } */

    private function createClassWithBBB($class, $date, $request)
    {
        $data = [];
        $setting                                            = BbbSetting::getData();
        $data['topic']                                      = $class->getTranslation('title', app()->getLocale());
        $data['instructor_id']                              = auth()->user()->id;
        $data['class_id']                                   = $class->id;
        $data['attendee_password']                          = $request->attendee_password;
        $data['moderator_password']                         = $request->moderator_password;
        $data['date']                                       = $date;
        $data['time']                                       = $class->time;
        $data['welcome_message']                            = $setting->welcome_message;
        $data['dial_number']                                = $setting->dial_number;
        $data['max_participants']                           = $setting->max_participants;
        $data['logout_url']                                 = $setting->logout_url;
        $data['record']                                     = $setting->record;
        $data['duration']                                   = $request->duration;
        $data['is_breakout']                                = $setting->is_breakout;
        $data['moderator_only_message']                     = $setting->moderator_only_message;
        $data['auto_start_recording']                       = $setting->auto_start_recording;
        $data['allow_start_stop_recording']                 = $setting->allow_start_stop_recording;
        $data['webcams_only_for_moderator']                 = $setting->webcams_only_for_moderator;
        $data['copyright']                                  = $setting->copyright;
        $data['mute_on_start']                              = $setting->mute_on_start;
        $data['lock_settings_disable_mic']                  = $setting->lock_settings_disable_mic;
        $data['lock_settings_disable_private_chat']         = $setting->lock_settings_disable_private_chat;
        $data['lock_settings_disable_public_chat']          = $setting->lock_settings_disable_public_chat;
        $data['lock_settings_disable_note']                 = $setting->lock_settings_disable_note;
        $data['lock_settings_locked_layout']                = $setting->lock_settings_locked_layout;
        $data['lock_settings_lock_on_join']                 = $setting->lock_settings_lock_on_join;
        $data['lock_settings_lock_on_join_configurable']    = $setting->lock_settings_lock_on_join_configurable;
        $data['guest_policy']                               = $setting->guest_policy;
        $data['redirect']                                   = $setting->redirect;
        $data['join_via_html5']                             = $setting->join_via_html5;
        $data['state']                                      = $setting->state;
        $datetime                                           = $date . " " . $class->time;
        $data['datetime']                                   = strtotime($datetime);

        $meeting    = new BbbMeetingController();
        $result     = $meeting->classStore($data);
        return $result;
    }

    private function createClassWithJitsi($class, $date, $request)
    {
        $data                       = [];
        $data['topic']              = $class->getTranslation('title', app()->getLocale());
        $data['description']        = $class->course->getTranslation('about', app()->getLocale());
        $data['duration']           = $request->duration;
        $data['jitsi_meeting_id']   = $request->jitsi_meeting_id;
        $data['instructor_id']      = auth()->user()->id;
        $data['class_id']           = $class->id;
        $data['date']               = $date;
        $data['time']               = $request->time;

        $meeting    = new JitsiMeetingController();
        $result     = $meeting->classStore($data);
        return $result;
    }

    private function createClassWithInAppLiveClass($class, $date, $request)
    {
        $data                       = [];
        $data['topic']              = $class->getTranslation('title', app()->getLocale());
        $data['description']        = $class->course->getTranslation('about', app()->getLocale());
        $data['duration']           = $request->duration;
        $data['jitsi_meeting_id']   = $request->jitsi_meeting_id;
        $data['instructor_id']      = auth()->user()->id;
        $data['class_id']           = $class->id;
        $data['date']               = $date;
        $data['time']               = $request->time;

        $meeting    = new InAppLiveClassController();
        $result     = $meeting->classStore($data);
        return $result;
    }

    private function createClassWithCustom($class, $date, $request)
    {
        $data['topic']          = $class->getTranslation('title', app()->getLocale());
        $data['description']    = $class->course->getTranslation('about', app()->getLocale());
        $data['duration']       = $request->duration;
        $data['instructor_id']  = auth()->user()->id;
        $data['class_id']       = $class->id;
        $data['date']           = $date;
        $data['time']           = $request->time;

        $meeting = new CustomMeetingController();
        return $meeting->classStore($data);
    }

    private function deleteClassComplete($course_id, $class_id)
    {
        $completes = ClassComplete::where('course_id', $course_id)->where('class_id', $class_id)->get();
        foreach ($completes as $complete) {
            $complete->delete();
        }
        return true;
    }


    private function getDates($class): array
    {
        $startDate = Carbon::parse($class->start_date);
        $endDate = Carbon::parse($class->end_date);
        $type = (int)$class->recurring_type;
        $interval = (int)$class->recurring_repeat_count;
        $daysOfWeek = (array)json_decode($class->recurring_days);
        $currentDate = $startDate->copy();
        $dates = [];

        switch ($type) {
            case 1:
                while ($currentDate <= $endDate) {
                    $dates[] = $currentDate->toDateString();
                    $currentDate->addDays($interval);
                }
                break;

            case 2:
                $daysMap = $this->getDays();


                if ($currentDate <= $endDate && !in_array($currentDate->toDateString(), $dates)) {
                    $dates[] = $currentDate->toDateString();
                }
                while ($currentDate <= $endDate) {
                    foreach ($daysOfWeek as $day) {
                        $dayIndex = $daysMap[$day];
                        $nextDate = $currentDate->copy()->next($dayIndex);
                        if ($nextDate <= $endDate && !in_array($nextDate->toDateString(), $dates)) {
                            $dates[] = $nextDate->toDateString();
                        }
                    }
                    $currentDate->addWeeks($interval);
                }

                break;

            case 3:
                while ($currentDate <= $endDate) {
                    $dates[] = $currentDate->toDateString();
                    $currentDate->addMonths($interval);
                }
                break;

            default:
                break;
        }
        sort($dates);
        return array_unique($dates);
    }


    private function getDays()
    {
        return ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    }
}
