<?php

namespace Modules\VirtualClass\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Notifications\GeneralNotification;
use App\Traits\UploadMedia;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Schema;
use Modules\BBB\Entities\BbbMeeting;
use Modules\BBB\Entities\BbbMeetingUser;
use Modules\Certificate\Entities\Certificate;
use Modules\CertificatePro\Entities\CertificateTemplate;
use Modules\CourseSetting\Entities\Category;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\CourseEnrolled;
use Modules\CourseSetting\Entities\CourseLevel;
use Modules\Forum\Services\ForumService;
use Modules\GoogleCalendar\Entities\GoogleCalendarEvent;
use Modules\GoogleCalendar\Events\GoogleCalendarDeleteEvent;
use Modules\GoogleCalendar\Events\GoogleCalendarSyncEvent;
use Modules\GoogleMeet\Entities\GoogleMeetMeeting;
use Modules\GoogleMeet\Events\MeetingDeleteEvent;
use Modules\GoogleMeet\Events\MeetingSyncEvent;
use Modules\InAppLiveClass\Entities\InAppLiveClassMeeting;
use Modules\InAppLiveClass\Entities\InAppLiveClassMeetingUser;
use Modules\Jitsi\Entities\JitsiMeeting;
use Modules\Jitsi\Entities\JitsiMeetingUser;
use Modules\Localization\Entities\Language;
use Modules\Membership\Repositories\Interfaces\MembershipVirtualClassRepositoryInterface;
use Modules\Payment\Entities\Cart;
use Modules\VirtualClass\Entities\ClassComplete;
use Modules\VirtualClass\Entities\ClassSetting;
use Modules\VirtualClass\Entities\CustomMeeting;
use Modules\VirtualClass\Entities\VirtualClass;
use Modules\VirtualClass\Services\CreateClass;
use Modules\Zoom\Entities\ZoomMeeting;
use Modules\Zoom\Entities\ZoomMeetingUser;
use Yajra\DataTables\Facades\DataTables;

class VirtualClassController extends Controller
{
    use UploadMedia;

    public $createClass;

    public function __construct()
    {
        $this->createClass = new CreateClass();
    }

    public function store(Request $request)
    {
        if (saasPlanCheck('meeting')) {
            Toastr::error(trans('frontend.You have reached valid class limit'), trans('common.Failed'));
            return redirect()->back();
        }
        if (demoCheck()) {
            return redirect()->back();
        }
        $code = auth()->user()->language_code ?? 'en';

        $rules = [
            'title.' . $code => 'required|max:255',
            'duration' => 'required',
            'category' => 'required',
            'lang_id' => 'required',
            'host' => 'required',
            'time' => 'required',
            'start_date' => 'required',
            'recurring_type' => 'required_if:is_recurring,1',
            'recurring_repeat_count' => 'required_if:is_recurring,1',
            'recurring_days' => 'required_if:recurring_type,2',
            'end_date' => 'required_if:is_recurring,1',
            'password' => 'required_if:host,==,Zoom',
            'attendee_password' => 'required_if:host,==,BBB',
            'moderator_password' => 'required_if:host,==,BBB',
            'attached_file' => 'nullable|mimes:jpeg,png,jpg,doc,docx,pdf,xls,xlsx',
        ];

        $this->validate($request, $rules, validationMessage($rules));

        if (!$request->free && showEcommerce()) {
            $rules = [
                'fees' => 'required',
            ];
            $this->validate($request, $rules, validationMessage($rules));
        }


        try {
            $class = new VirtualClass();
            if (isModuleActive('Membership') && $request->filled('is_membership')) {
                $class->is_membership = 1;

            }
            foreach ($request->title as $key => $title) {
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

            $class->is_recurring = (int)$request->is_recurring;
            $class->recurring_type = (int)$request->recurring_type;
            $class->recurring_repeat_count = (int)$request->recurring_repeat_count;
            $class->recurring_days = json_encode((array)$request->recurring_days);

            $startDate = Carbon::createFromFormat(getActivePhpDateFormat(), $request->start_date)->format('Y-m-d');
            $class->start_date = $startDate;

            if ((int)$request->is_recurring) {
                $endDate = !empty($request->end_date) ? Carbon::createFromFormat(getActivePhpDateFormat(), $request->end_date)->format('Y-m-d') : $startDate;
            } else {
                $endDate = $startDate;
            }

            $class->end_date = $endDate;
            $class->time = !empty($request->time) ? date("H:i", strtotime($request->time)) : null;
            $class->show_record = (int)$request->get('show_record', 0);
            $class->record_validity = (int)$request->get('record_validity', 0);
            $class->save();

            $course = new Course();
            $course->scope = (int)$request->scope;
            $course->level = (int)$request->level;
            $course->class_id = $class->id;
            $course->user_id = Auth::id();
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

            foreach ($request->title as $key => $title) {
                $course->setTranslation('title', $key, $title);
            }

            foreach ($request->description as $key => $about) {
                $course->setTranslation('about', $key, $about);
            }

            if (isModuleActive('Org')) {
                $course->required_type = (int)$request->required_type;
            } else {
                $course->required_type = 0;
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
            $course->type = 3;
            $course->save();

            if ($request->image) {
                $image = $this->generateLink($request->image, $course->id, get_class($course), 'image');
                $course->image = $image;
                $course->thumbnail = $image;
            }

            $course->price_text=$request->price_text;
            $course->save();

            $days = $this->getDates($class);

            $class->duration = $request->duration;
            $class->total_class = count($days);

            $class->save();

            if (isModuleActive('Forum')) {
                $forumService = new ForumService();
                $forumService->autoTopic('topic', $course);
            }

            if (count($days) == 0) {
                Toastr::error(__('virtual-class.No Class created'), trans('common.Error'));
                return back();
            }
            $result = null;
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
                    $result = $this->createClass->createClassWithZoom($class, $new_date, $request, $fileName);


                } elseif ($class->host == "BBB") {
                    if (isModuleActive('BBB')) {
                        $result = $this->createClass->createClassWithBBB($class, $new_date, $request);
                    } else {
                        Toastr::error(trans('frontend.Module not installed yet'), trans('common.Error'));
                        return back();
                    }

                } elseif ($class->host == "Jitsi") {

                    if (isModuleActive('Jitsi')) {
                        $result = $this->createClass->createClassWithJitsi($class, $new_date, $request);
                    } else {
                        Toastr::error(trans('frontend.Module not installed yet'), trans('common.Error'));
                        return back();
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
                        $result = $this->createClass->createClassWithInAppLiveClass($class, $new_date, $request);
                    } else {
                        Toastr::error(trans('frontend.Module not installed yet'), trans('common.Error'));
                        return back();
                    }
                } elseif ($class->host == "GoogleMeet") {
                    if (isModuleActive('GoogleMeet')) {
                        $response = Event::dispatch(new MeetingSyncEvent($class->id, $new_date));
                        $result = $response[0];
                    } else {
                        Toastr::error(trans('frontend.Module not installed yet'), trans('common.Error'));
                        return back();
                    }

                } elseif ($class->host == "Custom") {
                    $result = $this->createClass->createClassWithCustom($class, $new_date, $request);
                } else {
                    $result = null;
                }

                if (isModuleActive('Membership')) {
                    $request->merge([
                        'virtual_class_id' => $class->id,
                    ]);

                    $membershipInterface = App::make(MembershipVirtualClassRepositoryInterface::class);
                    $membershipInterface->storeVirtualClassMember($request->except(['_token', 'url']));
                }

            }

                if (is_array($result)) {
                    if (isset($result['type']) && $result['type']) {
                        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                    } else {
                        Toastr::error($result['message'], trans('common.Failed'));
                    }
                } else {
                    Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
                }



            return redirect()->route('virtual-class.index');
        } catch (Exception $e) {
            Toastr::error(trans('common.Something Went Wrong'), trans('common.Failed'));
            return back();
        }

    }

    public function getDates($class)
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
                        $dayIndex = $daysMap[$day??0];
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

    public function getDays()
    {
        return ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

    }

    public function create()
    {
        $data = [
            'languages' => getLanguageList(),
            'levels' => CourseLevel::where('status', 1)->get(['title', 'id']),
            'categories' => Category::with('childs')->where('status', 1)->orderBy('position_order', 'ASC')->get(),
        ];
        $data['instructors'] = User::whereIn('role_id', [1, 2])->where('status', 1)->select('name', 'id')->get();
        if (isModuleActive('CertificatePro') && Settings('use_certificate_template') == 'pro') {
            if (Auth::user()->role_id == 1) {
                $certificates_query = CertificateTemplate::query();
            } else {
                $certificates_query = CertificateTemplate::query()->where('created_by', Auth::user()->id);
            }
        } else {
            if (Auth::user()->role_id == 1) {
                $certificates_query = Certificate::query();
            } else {
                $certificates_query = Certificate::query()->where('created_by', Auth::user()->id);
            }
        }

        if (isModuleActive('Organization') && Auth::user()->isOrganization()) {
            $certificates_query->whereHas('user', function ($q) {
                $q->where('organization_id', Auth::id());
                $q->orWhere('id', Auth::id());
            });
        }

        $data['certificates'] = $certificates_query->latest()->get();

        if (isModuleActive('Membership')) {
            $interface = App::make(MembershipVirtualClassRepositoryInterface::class);
            $data += $interface->index();
        }
        $data['days'] = $this->getDays();
        return view('virtualclass::class.virtual_class_form', $data);
    }

    public function index()
    {
        $user = Auth::user();
        if ($user->role_id == 2) {
            $classes = VirtualClass::with('category', 'subCategory', 'language')->whereHas('course', function ($query) {
                $query->where('user_id', '=', Auth::user()->id);
            })->latest()->get();

        } else {
            $classes = VirtualClass::with('category', 'subCategory', 'language')->latest()->get();
        }

//        $data = [
//            'languages' => getLanguageList(),
//            'classes' => $classes,
//            'levels' => CourseLevel::where('status', 1)->get(['title', 'id']),
//            'categories' => Category::with('childs')->where('status', 1)->orderBy('position_order', 'ASC')->get(),
//        ];
//        $data['instructors'] = User::whereIn('role_id', [1, 2])->where('status', 1)->select('name', 'id')->get();
//        if (isModuleActive('CertificatePro') && Settings('use_certificate_template') == 'pro') {
//            if (Auth::user()->role_id == 1) {
//                $certificates_query = CertificateTemplate::query();
//            } else {
//                $certificates_query = CertificateTemplate::query()->where('created_by', Auth::user()->id);
//            }
//        } else {
//            if (Auth::user()->role_id == 1) {
//                $certificates_query = Certificate::query();
//            } else {
//                $certificates_query = Certificate::query()->where('created_by', Auth::user()->id);
//            }
//        }
//
//        if (isModuleActive('Organization') && Auth::user()->isOrganization()) {
//            $certificates_query->whereHas('user', function ($q) {
//                $q->where('organization_id', Auth::id());
//                $q->orWhere('id', Auth::id());
//            });
//        }
//
//        $data['certificates'] = $certificates_query->latest()->get();
//
//        if (isModuleActive('Membership')) {
//            $interface = App::make(MembershipVirtualClassRepositoryInterface::class);
//            $data += $interface->index();
//        }
//        $data['days']=$this->getDays();
        return view('virtualclass::class.index', compact('classes'));
    }

    public function edit($id)
    {

        $data = [
            'languages' => Language::where('status', 1)->get(),
            'class' => VirtualClass::with('course')->find($id),
            'levels' => CourseLevel::where('status', 1)->get(['title', 'id']),
            'categories' => Category::where('status', 1)->orderBy('position_order', 'ASC')->get()
        ];
        if (isModuleActive('CertificatePro') && Settings('use_certificate_template') == 'pro') {
            if (Auth::user()->role_id == 1) {
                $certificates_query = CertificateTemplate::query();
            } else {
                $certificates_query = CertificateTemplate::query()->where('created_by', Auth::user()->id);
            }
        } else {
            if (Auth::user()->role_id == 1) {
                $certificates_query = Certificate::query();
            } else {
                $certificates_query = Certificate::query()->where('created_by', Auth::user()->id);
            }
        }

        if (isModuleActive('Organization') && Auth::user()->isOrganization()) {
            $certificates_query->whereHas('user', function ($q) {
                $q->where('organization_id', Auth::id());
                $q->orWhere('id', Auth::id());
            });
        }

        $data['certificates'] = $certificates_query->latest()->get();

        if (isModuleActive('Membership')) {
            $interface = App::make(MembershipVirtualClassRepositoryInterface::class);
            $data += $interface->index();
        }
        $data['instructors'] = User::whereIn('role_id', [1, 2])->where('status', 1)->select('name', 'id')->get();
        $data['days'] = $this->getDays();
        return view('virtualclass::class.virtual_class_form')->with($data);
    }

    public function update(Request $request, $id)
    {
        if (demoCheck()) {
            return redirect()->back();
        }

        $code = auth()->user()->language_code;

        $rules = [
            'title.' . $code => 'required|max:255',
            'duration' => 'required',
            'category' => 'required',
            'lang_id' => 'required',
            'host' => 'required',
            'time' => 'required',
            'start_date' => 'required',
            'recurring_type' => 'required_if:is_recurring,1',
            'recurring_repeat_count' => 'required_if:is_recurring,1',
            'recurring_days' => 'required_if:recurring_type,2',
            'end_date' => 'required_if:is_recurring,1',
        ];
        $this->validate($request, $rules, validationMessage($rules));

        if (!$request->free && showEcommerce()) {
            $rules = [
                'fees' => 'required',
            ];
            $this->validate($request, $rules, validationMessage($rules));
        }

        $class = VirtualClass::findOrFail($id);
        $course = Course::where('class_id', $id)->where('type', 3)->first();
        if (!$course) {
            $course = new Course();
            $course->class_id = $id;
            $course->type = 3;
        }
        try {
            foreach ($request->title as $key => $title) {
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


            $startDate = Carbon::createFromFormat(getActivePhpDateFormat(), $request->start_date)->format('Y-m-d');
            $class->start_date = $startDate;
            $class->end_date = !empty($request->end_date) ? Carbon::createFromFormat(getActivePhpDateFormat(), $request->end_date)->format('Y-m-d') : $startDate;
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
                    $course->support = true;
                } else {
                    $course->support = false;
                }
            }

            $course->lang_id = 1;
            foreach ($request->title as $key => $title) {
                $course->setTranslation('title', $key, $title);
            }

            foreach ($request->description as $key => $about) {
                $course->setTranslation('about', $key, $about);
            }
            $course->price = $class->fees;

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


            $this->removeLink($course->id, get_class($course));
            if ($request->image) {
                $userImage = $this->generateLink($request->image, $course->id, get_class($course), 'image');
                $course->image = $userImage;
                $course->thumbnail = $userImage;
            }
            $course->price_text=$request->price_text;

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
                        Toastr::error(trans('frontend.Module not installed yet'), trans('common.Error'));
                        return back();
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
                        Toastr::error(trans('frontend.Module not installed yet'), trans('common.Error'));
                        return back();
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
                        Toastr::error(trans('frontend.Module not installed yet'), trans('common.Error'));
                        return back();
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
                Notification::send($receiver, new GeneralNotification($details));
            }


            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->route('virtual-class.index');
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function deleteClassComplete($course_id, $class_id)
    {
        $completes = ClassComplete::where('course_id', $course_id)->where('class_id', $class_id)->get();
        foreach ($completes as $complete) {
            $complete->delete();
        }
        return true;
    }

//    public function createMeetingStore(Request $request, $class_id)
//    {
//        if (demoCheck()) {
//            return redirect()->back();
//        }
//        $class = VirtualClass::findOrFail($class_id);
//
//        if ($class->type == 0) {
//            if (strtotime($class->start_date) != strtotime($request->date)) {
//                Toastr::error(trans('frontend.Date is not correct'), trans('common.Failed'));
//                return back();
//            }
//        } else {
//            if (strtotime($class->start_date) > strtotime($request->date) || (strtotime($request->date) > strtotime($class->end_date))) {
//                Toastr::error(trans('frontend.Date is not correct'), trans('common.Failed'));
//                return back();
//            }
//        }
//
//
//        $instructor_id = Auth::user()->id;
//        $rules = [
//            'topic' => 'required',
//            'description' => 'nullable',
//            'password' => 'required',
//            'attached_file' => 'nullable|mimes:jpeg,png,jpg,doc,docx,pdf,xls,xlsx',
//            'time' => 'required',
//            'durration' => 'required',
//            'join_before_host' => 'required',
//            'host_video' => 'required',
//            'participant_video' => 'required',
//            'mute_upon_entry' => 'required',
//            'waiting_room' => 'required',
//            'audio' => 'required',
//            'auto_recording' => 'nullable',
//            'approval_type' => 'required',
//            'is_recurring' => 'required',
//            'recurring_type' => 'required_if:is_recurring,1',
//            'recurring_repeat_count' => 'required_if:is_recurring,1',
//            'end_date' => 'required_if:is_recurring,1',
//        ];
//        $this->validate($request, $rules, validationMessage($rules));
//
//        try {
//            //Available time check for classs
//            if ($this->isTimeAvailableForMeeting($request, $id = 0)) {
//                Toastr::error('Virtual class time is not available for teacher!', 'Failed');
//                return redirect()->back();
//            }
//
//            //Chekc the number of api request by today max limit 100 request
//            if (ZoomMeeting::whereDate('created_at', Carbon::now())->count('id') >= 100) {
//                Toastr::error('You can not create more than 100 meeting within 24 hour!', 'Failed');
//                return redirect()->back();
//            }
//
//
//            $users = Zoom::user()->where('status', 'active')->setPaginate(false)->setPerPage(300)->get()->toArray();
//
//            $profile = $users['data'][0];
//            $start_date = Carbon::parse($request['date'])->format('Y-m-d') . ' ' . date("H:i:s", strtotime($request['time']));
//            $meeting = Zoom::meeting()->make([
//                "topic" => $request['topic'],
//                "type" => $request['is_recurring'] == 1 ? 8 : 2,
//                "duration" => $request['durration'],
//                "timezone" => Settings('active_time_zone'),
//                "password" => $request['password'],
//                "start_time" => new Carbon($start_date),
//            ]);
//
//            $meeting->settings()->make([
//                'join_before_host' => $this->setTrueFalseStatus($request['join_before_host']),
//                'host_video' => $this->setTrueFalseStatus($request['host_video']),
//                'participant_video' => $this->setTrueFalseStatus($request['participant_video']),
//                'mute_upon_entry' => $this->setTrueFalseStatus($request['mute_upon_entry']),
//                'waiting_room' => $this->setTrueFalseStatus($request['waiting_room']),
//                'audio' => $request['audio'],
//                'auto_recording' => $request->has('auto_recording') ? $request['auto_recording'] : 'none',
//                'approval_type' => $request['approval_type'],
//            ]);
//
//            if ($request['is_recurring'] == 1) {
//                $end_date = Carbon::parse($request['end_date'])->endOfDay();
//                $meeting->recurrence()->make([
//                    'type' => $request['recurring_type'],
//                    'repeat_interval' => $request['recurring_repeat_count'],
//                    'end_date_time' => $end_date
//                ]);
//            }
//            $meeting_details = Zoom::user()->find($profile['id'])->meetings()->save($meeting);
//
//
//            $fileName = "";
//            if ($request->file('attached_file') != "") {
//                $file = $request->file('attached_file');
//                $ignore = strtolower($file->getClientOriginalExtension());
//                if ($ignore != 'php') {
//                    $fileName = $request['topic'] . time() . "." . $file->getClientOriginalExtension();
//                    $file->move('public/uploads/zoom-meeting/', $fileName);
//                    $fileName = 'public/uploads/zoom-meeting/' . $fileName;
//                }
//            }
//            $system_meeting = ZoomMeeting::create([
//                'topic' => $request['topic'],
//                'class_id' => $class_id,
//                'instructor_id' => $instructor_id,
//                'description' => $request['description'],
//                'date_of_meeting' => $request['date'],
//                'time_of_meeting' => $request['time'],
//                'meeting_duration' => $request['durration'],
//
//                'host_video' => $request['host_video'],
//                'participant_video' => $request['participant_video'],
//                'join_before_host' => $request['join_before_host'],
//                'mute_upon_entry' => $request['mute_upon_entry'],
//                'waiting_room' => $request['waiting_room'],
//                'audio' => $request['audio'],
//                'auto_recording' => $request->has('auto_recording') ? $request['auto_recording'] : 'none',
//                'approval_type' => $request['approval_type'],
//
//                'is_recurring' => $request['is_recurring'],
//                'recurring_type' => $request['is_recurring'] == 1 ? $request['recurring_type'] : null,
//                'recurring_repeat_count' => $request['is_recurring'] == 1 ? $request['recurring_repeat_count'] : null,
//                'end_date' => $request['is_recurring'] == 1 ? $request['end_date'] : null,
//                'meeting_id' => (string)$meeting_details->id,
//                'password' => $meeting_details->password,
//                'start_time' => Carbon::parse($start_date)->toDateTimeString(),
//                'end_time' => Carbon::parse($start_date)->addMinute($request['durration'] ?? 0)->toDateTimeString(),
//                'attached_file' => $fileName,
//                'created_by' => Auth::user()->id,
//            ]);
//
//
//            $user = new ZoomMeetingUser();
//            $user->meeting_id = $system_meeting->id;
//            $user->user_id = $instructor_id;
//            $user->host = 1;
//            $user->save();
//
//            $class->total_class = $class->total_class + 1;
//            $class->save();
//
//            if ($system_meeting) {
//                Toastr::success(trans('common.Operation successful'), trans('common.Success'));
//                return redirect()->route('virtual-class.details', $class_id);
//            } else {
//                Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
//                return redirect()->back();
//            }
//        } catch (Exception $e) {
//            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
//        }
//
//    }

    public function destroy(Request $request)
    {
        $id = $request->id;

        if (demoCheckById($id,[1,2,3,4,5,6,7,8,9,10])) {
            return redirect()->back();
        }

        try {

            $course = Course::where('class_id', $id)->first();
            if ($course) {
                $hasCourse = CourseEnrolled::where('course_id', $course->id)->count();
                if ($hasCourse != 0) {
                    Toastr::error(trans('frontend.Course Already Enrolled By') . ' ' . $hasCourse . ' ' . trans('frontend.Student'), trans('common.Failed'));
                    return redirect()->back();
                }

                $carts = Cart::where('course_id', $course->id)->get();
                foreach ($carts as $cart) {
                    $cart->delete();
                }
            }

            $class = VirtualClass::find($id);
            if ($class) {
                if ($class->host == "BBB") {
                    if (isModuleActive('BBB')) {
                        $bbbClass = BbbMeeting::where('class_id', $id)->get();
                        $bbbClass->each->delete();
                    }
                } elseif ($class->host == 'Zoom') {
                    $zoomClass = ZoomMeeting::where('class_id', $id)->get();

                    foreach ($zoomClass as $cls) {
                        $cls->delete();
                    }
                } elseif ($class->host == 'Jitsi') {
                    if (isModuleActive('Jitsi')) {
                        $JitsiClass = JitsiMeeting::where('class_id', $id)->get();
                        $JitsiClass->each->delete();
                    }
                } elseif ($class->host == 'InAppLiveClass') {
                    if (isModuleActive('InAppLiveClass')) {
                        $inAppClass = InAppLiveClassMeeting::where('class_id', $id)->get();
                        $inAppClass->each->delete();
                    }
                } elseif ($class->host == 'Custom') {
                    $customClass = CustomMeeting::where('class_id', $id)->get();
                    $customClass->each->delete();
                } elseif ($class->host == 'GoogleMeet') {
                    if (isModuleActive('GoogleMeet')) {
                        $all = GoogleMeetMeeting::where('class_id', $id)->get();
                        foreach ($all as $meet) {
                            if ($meet->meetingId) {
                                Event::dispatch(new MeetingDeleteEvent($meet->meetingId));
                            }

                            $meet->delete();
                        }

                    }
                }

            }

            if ($course && $class) {
                $this->deleteClassComplete($course->id, $class->id);
            }

            if ($course) {
                $course->delete();
            }
            if ($class) {
                $class->delete();
            }


            Toastr::success(trans('common.Operation successful'), trans('common.Success'));

            return back();
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function setting(Request $request)
    {
        $setting = ClassSetting::getData();

        return view('virtualclass::class.class_setup', compact('setting'));
    }

    /*   public function createMeeting($id)
       {
           if (demoCheck()) {
               return redirect()->back();
           }
           $class = VirtualClass::findOrFail($id);

           if ($class->host == "Zoom") {
               $data = $this->defaultPageData();
               $data['user'] = Auth::user();
               $data['class'] = $class;
               return view('virtualclass::meeting.zoom_meeting', $data);
           } elseif ($class->host == "BBB") {
               if (!isModuleActive('BBB')) {
                   Toastr::error(trans('frontend.Module not installed yet'), trans('common.Error'));
                   return back();
               }
               $data['env']['security_salt'] = config('bigbluebutton.BBB_SECURITY_SALT');
               $data['env']['server_base_url'] = config('bigbluebutton.BBB_SERVER_BASE_URL');
               $data['class'] = $class;
               return view('virtualclass::meeting.bbb_meeting', $data);
           } elseif ($class->host == "Jitsi") {
               if (!isModuleActive('Jitsi')) {
                   Toastr::error(trans('frontend.Module not installed yet'), trans('common.Error'));
                   return back();
               }
               $data['env']['security_salt'] = config('bigbluebutton.BBB_SECURITY_SALT');
               $data['env']['server_base_url'] = config('bigbluebutton.BBB_SERVER_BASE_URL');
               $data['class'] = $class;
               return view('virtualclass::meeting.jitsi_meeting', $data);
           } else {
               Toastr::error(trans('common.Something Went Wrong'), trans('common.Failed'));
               return back();
           }
       }*/

    /*    private function defaultPageData()
        {
            $user = Auth::user();
            $data['default_settings'] = ZoomSetting::firstOrCreate([
                'user_id' => $user->id
            ], [
                '$user->id' => $user->id,
            ]);

            if (Auth::user()->role_id == 1) {
                $data['meetings'] = ZoomMeeting::orderBy('id', 'DESC')->whereHas('participates', function ($query) {
                    return $query->where('user_id', Auth::user()->id);
                })
                    ->where('status', 1)
                    ->get();
            } else {
                $data['meetings'] = ZoomMeeting::orderBy('id', 'DESC')->get();
            }
            return $data;
        }*/

    /*   public function bbbMeetingStore(Request $request, $class_id)
       {
           if (demoCheck()) {
               return redirect()->back();
           }
           $class = VirtualClass::findOrFail($class_id);
           if ($class->type == 0) {
               if (strtotime($class->start_date) != strtotime($request->date)) {
                   Toastr::error(trans('frontend.Date is not correct'), trans('common.Failed'));
                   return back();
               }
           } else {
               if (strtotime($class->start_date) > strtotime($request->date) || (strtotime($request->date) > strtotime($class->end_date))) {
                   Toastr::error(trans('frontend.Date is not correct'), trans('common.Failed'));
                   return back();
               }
           }
           $topic = $request->get('topic');
           $instructor_id = Auth::user()->id;
           $attendee_password = $request->get('attendee_password');
           $moderator_password = $request->get('moderator_password');
           $date = $request->get('date');
           $time = $request->get('time');

           $welcome_message = $request->get('welcome_message');
           $dial_number = $request->get('dial_number');
           $max_participants = $request->get('max_participants');
           $logout_url = $request->get('logout_url');
           $record = $request->get('record');
           $duration = $request->get('duration');
           $is_breakout = $request->get('is_breakout');
           $moderator_only_message = $request->get('moderator_only_message');
           $auto_start_recording = $request->get('auto_start_recording');
           $allow_start_stop_recording = $request->get('allow_start_stop_recording');
           $webcams_only_for_moderator = $request->get('webcams_only_for_moderator');
           $copyright = $request->get('copyright');
           $mute_on_start = $request->get('mute_on_start');
           $lock_settings_disable_mic = $request->get('lock_settings_disable_mic');
           $lock_settings_disable_private_chat = $request->get('lock_settings_disable_private_chat');
           $lock_settings_disable_public_chat = $request->get('lock_settings_disable_public_chat');
           $lock_settings_disable_note = $request->get('lock_settings_disable_note');
           $lock_settings_locked_layout = $request->get('lock_settings_locked_layout');
           $lock_settings_lock_on_join = $request->get('lock_settings_lock_on_join');
           $lock_settings_lock_on_join_configurable = $request->get('lock_settings_lock_on_join_configurable');
           $guest_policy = $request->get('guest_policy');
           $redirect = $request->get('redirect');
           $join_via_html5 = $request->get('join_via_html5');
           $state = $request->get('state');
           $datetime = $date . " " . $time;
           $datetime = strtotime($datetime);

           $rules = [
               'topic' => 'required',
               'attendee_password' => 'required',
               'moderator_password' => 'required',
               'date' => 'required',
               'time' => 'required',

           ];
           $this->validate($request, $rules, validationMessage($rules));


           try {


               $createMeeting = Bigbluebutton::create([
                   'meetingID' => "spn-" . date('ymd' . rand(0, 100)),
                   'meetingName' => $topic,
                   'attendeePW' => $attendee_password,
                   'moderatorPW' => $moderator_password,
                   'welcomeMessage' => $welcome_message,
                   'dialNumber' => $dial_number,
                   'maxParticipants' => $max_participants,
                   'logoutUrl' => $logout_url,
                   'record' => $record,
                   'duration' => $duration,
                   'isBreakout' => $is_breakout,
                   'moderatorOnlyMessage' => $moderator_only_message,
                   'autoStartRecording' => $auto_start_recording,
                   'allowStartStopRecording' => $allow_start_stop_recording,
                   'webcamsOnlyForModerator' => $webcams_only_for_moderator,
                   'copyright' => $copyright,
                   'muteOnStart' => $mute_on_start,
                   'lockSettingsDisableMic' => $lock_settings_disable_mic,
                   'lockSettingsDisablePrivateChat' => $lock_settings_disable_private_chat,
                   'lockSettingsDisablePublicChat' => $lock_settings_disable_public_chat,
                   'lockSettingsDisableNote' => $lock_settings_disable_note,
                   'lockSettingsLockedLayout' => $lock_settings_locked_layout,
                   'lockSettingsLockOnJoin' => $lock_settings_lock_on_join,
                   'lockSettingsLockOnJoinConfigurable' => $lock_settings_lock_on_join_configurable,
                   'guestPolicy' => $guest_policy,
                   'redirect' => $redirect,
                   'joinViaHtml5' => $join_via_html5,
                   'state' => $state,
               ]);

               if ($createMeeting) {
                   $local_meeting = BbbMeeting::create([
                       'meeting_id' => $createMeeting['meetingID'],
                       'instructor_id' => $instructor_id,
                       'topic' => $topic,
                       'description' => $request->get('description'),
                       'class_id' => $class_id,
                       'attendee_password' => $attendee_password,
                       'moderator_password' => $moderator_password,
                       'date' => $date,
                       'time' => $time,
                       'datetime' => $datetime,
                       'welcome_message' => $welcome_message,
                       'dial_number' => $dial_number,
                       'max_participants' => $max_participants,
                       'logout_url' => $logout_url,
                       'record' => $record,
                       'duration' => $duration,
                       'is_breakout' => $is_breakout,
                       'moderator_only_message' => $moderator_only_message,
                       'auto_start_recording' => $auto_start_recording,
                       'allow_start_stop_recording' => $allow_start_stop_recording,
                       'webcams_only_for_moderator' => $webcams_only_for_moderator,
                       'copyright' => $copyright,
                       'mute_on_start' => $mute_on_start,
                       'lock_settings_disable_mic' => $lock_settings_disable_mic,
                       'lock_settings_disable_private_chat' => $lock_settings_disable_private_chat,
                       'lock_settings_disable_public_chat' => $lock_settings_disable_public_chat,
                       'lock_settings_disable_note' => $lock_settings_disable_note,
                       'lock_settings_locked_layout' => $lock_settings_locked_layout,
                       'lock_settings_lock_on_join' => $lock_settings_lock_on_join,
                       'lock_settings_lock_on_join_configurable' => $lock_settings_lock_on_join_configurable,
                       'guest_policy' => $guest_policy,
                       'redirect' => $redirect,
                       'join_via_html5' => $join_via_html5,
                       'state' => $state,
                       'created_by' => Auth::user()->id,

                   ]);
               }


               $user = new BbbMeetingUser();
               $user->meeting_id = $local_meeting->id;
               $user->user_id = $instructor_id;
               $user->moderator = 1;
               $user->save();


               Toastr::success(trans('common.Operation successful'), trans('common.Success'));
               return redirect()->route('virtual-class.details', $class_id);
           } catch (Exception $e) {
               GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
           }
       }*/

    /*

      public function jitsiMeetingStore(Request $request, $class_id)
      {
          if (demoCheck()) {
              return redirect()->back();
          }
          $class = VirtualClass::findOrFail($class_id);

          if ($class->type == 0) {
              if (strtotime($class->start_date) != strtotime($request->date)) {
                  Toastr::error(trans('frontend.Date is not correct'), trans('common.Failed'));
                  return back();
              }
          } else {
              if (strtotime($class->start_date) > strtotime($request->date) || (strtotime($request->date) > strtotime($class->end_date))) {
                  Toastr::error(trans('frontend.Date is not correct'), trans('common.Failed'));
                  return back();
              }
          }
          $topic = $request->get('topic');
          $instructor_id = Auth::user()->id;
          $date = $request->get('date');
          $time = $request->get('time');


          $datetime = $date . " " . $time;
          $datetime = strtotime($datetime);

          $rules = [
              'topic' => 'required',
              'date' => 'required',
              'time' => 'required',
          ];
          $this->validate($request, $rules, validationMessage($rules));


          try {
              $local_meeting = JitsiMeeting::create([
                  'meeting_id' => date('ymdhmi'),
                  'instructor_id' => $instructor_id,
                  'topic' => $topic,
                  'description' => $request->get('description'),
                  'class_id' => $class_id,
                  'date' => $date,
                  'time' => $time,
                  'datetime' => $datetime,
                  'created_by' => Auth::user()->id,

              ]);

              $user = new JitsiMeetingUser();
              $user->meeting_id = $local_meeting->id;
              $user->user_id = $instructor_id;
              $user->save();


              Toastr::success(trans('common.Operation successful'), trans('common.Success'));
              return redirect()->route('virtual-class.details', $class_id);
          } catch (Exception $e) {
              GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
          }
      }*/

    public function settingUpdate(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        $setting = ClassSetting::first();
        $setting->default_class = $request->class;
        $setting->save();

        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return back();
    }

    public function details($id)
    {

        $class = VirtualClass::findOrFail($id);
        $currency = Settings('currency_symbol');
        $user = Auth::user();
        return view('virtualclass::class.class_details', compact('class', 'currency', 'user'));
    }

    public function getAllVirtualClassData(Request $request)
    {

        $user = Auth::user();
        if ($user->role_id == 2) {
            $query = VirtualClass::with('course', 'category', 'subCategory', 'language')->whereHas('course', function ($query) {
                $query->where('user_id', '=', Auth::user()->id);
                $query->orWhere('assistant_instructors', 'like', '%"{' . Auth::id() . '}"%');
            });
        } else {
            $query = VirtualClass::with('course', 'category', 'subCategory', 'language');

        }

        if (isModuleActive('Organization') && Auth::user()->isOrganization()) {
            $query->whereHas('course.user', function ($q) {
                $q->where('organization_id', Auth::id());
                $q->orWhere('id', Auth::id());
            });
        }


        return Datatables::of($query)
            ->addIndexColumn()
            ->editColumn('title', function ($query) {
                return $query->title;

            })->addColumn('category_name', function ($query) {
                if ($query->category) {
                    return $query->category->name;
                } else {
                    return '';
                }
            })->addColumn('required_type', function ($query) {
                return $query->course->required_type == 1 ? trans('courses.Compulsory') : trans('courses.Open');
            })
            ->addColumn('status', function ($query) {
                if (permissionCheck('course.status_update')) {
                    $status_enable_eisable = "status_enable_disable";
                } else {
                    $status_enable_eisable = "";
                }
                $checked = $query->course->status == 1 ? "checked" : "";
                $view = '<label class="switch_toggle"  >
                                                    <input type="checkbox" class="' . $status_enable_eisable . '"
                                                             value="' . $query->course->id . '"
                                                             ' . $checked . '><i class="slider round"></i></label>';

                return $view;
            })
            ->editColumn('subCategory', function ($query) {
                if ($query->subCategory) {
                    return $query->subCategory->name;
                } else {
                    return '';
                }

            })
            ->editColumn('language', function ($query) {
                if ($query->language) {
                    return $query->language->name;
                } else {
                    return '';
                }

            })
            ->editColumn('duration', function ($query) {
                return MinuteFormat($query->duration);

            })->editColumn('start_date', function ($query) {
                return showDate($query->start_date);

            })->editColumn('end_date', function ($query) {
                return showDate($query->end_date);

            })
            ->editColumn('fees', function ($query) {
                return getPriceFormat($query->fees);

            })->addColumn('scope', function ($query) {

                if ($query->course->scope == 1) {
                    $scope = trans('courses.Public');
                } else {
                    $scope = trans('courses.Private');
                }
                return $scope;

            })->addColumn('level', function ($query) {
                return $query->course?->courseLevel?->title;

            })->editColumn('time', function ($query) {
                return date('h:i A', strtotime($query->time));
            })
            ->addColumn('action', function ($query) {
                return view('virtualclass::class.partials._class_action_td', ['query' => $query]);
            })->rawColumns(['status', 'image', 'action'])->make(true);
    }
}
