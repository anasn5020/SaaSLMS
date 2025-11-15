<?php

namespace Modules\StudentSetting\Http\Controllers;


use App\Events\OneToOneConnection;
use App\Http\Controllers\Controller;
use App\Jobs\SendGeneralEmail;
use App\Models\UserDocument;
use App\Models\UserInstantMessage;
use App\StudentCustomField;
use App\Subscription;
use App\Traits\SendNotification;
use App\Traits\UploadMedia;
use App\User;
use App\UserLogin;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use DrewM\MailChimp\MailChimp;
use Exception;
use GetResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\CourseEnrolled;
use Modules\GoogleCalendar\Events\GoogleCalendarEventAddAttendee;
use Modules\GoogleMeet\Events\MeetingAddAttendeeEvent;
use Modules\Group\Entities\GroupMember;
use Modules\Group\Repositories\GroupRepository;
use Modules\Newsletter\Entities\NewsletterSetting;
use Modules\Newsletter\Http\Controllers\AcelleController;
use Modules\Org\Entities\OrgPosition;
use Modules\Organization\Entities\OrganizationFinance;
use Modules\Organization\Events\CourseSellCommissionEvent;
use Modules\OrgSubscription\Http\Controllers\AutoEnrollmentController;
use Modules\Payment\Entities\InstructorPayout;
use Modules\SkillAndPathway\Entities\GroupStudent;
use Modules\StudentSetting\Entities\Institute;
use Modules\Survey\Entities\Survey;
use Modules\Survey\Http\Controllers\SurveyController;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class StudentSettingController extends Controller
{
    use UploadMedia, SendNotification;

    public function index()
    {
        try {
            $students = [];

            if (isModuleActive('Org')) {
                $data['positions'] = OrgPosition::getAllData();
                $data['branches'] = [];
                return view('org::students.org_student_list', $data);

            }
            return view('studentsetting::student_list', compact('students'));

        } catch (Exception $e) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        if (saasPlanCheck('student')) {
            Toastr::error('You have reached student limit', trans('common.Failed'));
            return redirect()->back();
        }
        Session::flash('type', 'store');

        if (demoCheck()) {
            return redirect()->back();
        }
        $rules = [
            'name' => 'required',
            'phone' => 'nullable|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:5|unique:users,phone,' . Auth::user()->lms_id,
            'password' => 'required|min:8|confirmed',
        ];

        if (isModuleActive('Org')) {
            $rules['position'] = 'required';
            $rules['branch'] = 'required';
            $rules['email'] = 'nullable|email|required_without:username|unique:users,email';
            $rules['username'] = 'nullable|required_without:email|unique:users,username';
        } else {
            $rules['email'] = 'required|email|unique:users,email';

        }

        $this->validate($request, $rules, validationMessage($rules));

        try {

            $success = trans('lang.Student') . ' ' . trans('lang.Added') . ' ' . trans('lang.Successfully');


            $user = new User;
            $user->name = $request->name;
            $user->institute_id = $request->institute_id;
            $user->password = bcrypt($request->password);
            $user->about = $request->about;

            if (empty($request->email)) {
                $user->email = null;
            } else {
                $user->email = $request->email;
            }
            if (empty($request->username)) {
                $user->username = null;
            } else {
                $user->username = $request->username;
            }

            if (empty($request->phone)) {
                $user->phone = null;
            } else {
                $user->phone = $request->phone;
            }

            $user->dob = getPhpDateFormat($request->dob);
            $user->facebook = $request->facebook;
            $user->twitter = $request->twitter;
            $user->linkedin = $request->linkedin;
            $user->youtube = $request->youtube;
            $user->instagram = $request->instagram;
            $user->gender = $request->gender;
            $user->company = $request->company;

            if (isModuleActive('Org')) {
                $user->org_position_code = $request->position;
                $branch = $request->branch;
                $branch = explode('/', $branch);
                $user->org_chart_code = end($branch);
                $user->start_working_date = getPhpDateFormat($request->start_working_date);
                $user->employee_id = $request->employee_id;
            }

            $user->language_id = Settings('language_id');
            $user->language_code = Settings('language_code');
            $user->language_name = Settings('language_name');
            $user->language_rtl = Settings('language_rtl');
            $user->country = Settings('country_id');
            $user->teach_via = 1;

            if (isModuleActive('LmsSaas')) {
                $user->lms_id = app('institute')->id;
            } else {
                $user->lms_id = 1;
            }
            $user->added_by = Auth::user()->id;
            $user->email_verify = 1;
            $user->email_verified_at = now();
            $user->referral = Str::random(10);
            $user->role_id = 3;

            if (isModuleActive('Organization') && Auth::user()->isOrganizationUser()) {
                $user->organization_id = Auth::user()->userOrganization()->id;
            }
            $user->save();

            if ($request->image) {
                $user->image = $this->generateLink($request->image, $user->id, get_class($user), 'image');
            }
            $user->save();

            applyDefaultRoleToUser($user);
            if (Schema::hasTable('users') && Schema::hasTable('chat_statuses')) {
                if (isModuleActive('Chat')) {
                    userStatusChange($user->id, 0);
                }
            }
            $mailchimpStatus = saasEnv('MailChimp_Status') ?? false;
            $getResponseStatus = saasEnv('GET_RESPONSE_STATUS') ?? false;
            $acelleStatus = saasEnv('ACELLE_STATUS') ?? false;
            if (hasTable('newsletter_settings')) {
                $setting = NewsletterSetting::getData();

                if ($setting->student_status == 1) {
                    $list = $setting->student_list_id;
                    if ($setting->student_service == "Mailchimp") {

                        if ($mailchimpStatus) {
                            try {
                                $MailChimp = new MailChimp(saasEnv('MailChimp_API'));
                                $MailChimp->post("lists/$list/members", [
                                    'email_address' => $user->email,
                                    'status' => 'subscribed',
                                ]);

                            } catch (Exception $e) {
                            }
                        }
                    } elseif ($setting->student_service == "GetResponse") {
                        if ($getResponseStatus) {

                            try {
                                $getResponse = new GetResponse(saasEnv('GET_RESPONSE_API'));
                                $getResponse->addContact(array(
                                    'email' => $user->email,
                                    'campaign' => array('campaignId' => $list),
                                ));
                            } catch (Exception $e) {

                            }
                        }
                    } elseif ($setting->instructor_service == "Acelle") {
                        if ($acelleStatus) {

                            try {
                                $email = $user->email;
                                $make_action_url = '/subscribers?list_uid=' . $list . '&EMAIL=' . $email;
                                $acelleController = new AcelleController();
                                $response = $acelleController->curlPostRequest($make_action_url);
                            } catch (Exception $e) {

                            }
                        }
                    } elseif ($setting->student_service == "Local") {
                        try {
                            $check = Subscription::where('email', '=', $user->email)->first();
                            if (empty($check)) {
                                $subscribe = new Subscription();
                                $subscribe->email = $user->email;
                                $subscribe->type = 'Student';
                                $subscribe->save();
                            } else {
                                $check->type = "Student";
                                $check->save();
                            }
                        } catch (Exception $e) {

                        }
                    }
                }


            }

            $this->sendNotification('New_Student_Reg', $user, [
                'time' => Carbon::now()->format('d-M-Y, g:i A'),
                'name' => $user->name,
            ]);


            Session::forget('type');
            Toastr::success($success, trans('common.Success'));
            return redirect()->route('student.student_list');


        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function field()
    {
        $field = StudentCustomField::getData();

        return view('studentsetting::field_setting', compact('field'));
    }

    public function fieldStore(Request $request)
    {


        try {
            $entry = StudentCustomField::first();
            if ($entry) {
                $entry->delete();
            }

            $request = $this->editableConfig($request);


            StudentCustomField::create($request->all());

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function editableConfig(Request $request): Request
    {
        $request['editable_company'] = $request->editable_company ? 1 : 0;
        $request['editable_gender'] = $request->editable_gender ? 1 : 0;
        $request['editable_student_type'] = $request->editable_student_type ? 1 : 0;
        $request['editable_identification_number'] = $request->editable_identification_number ? 1 : 0;
        $request['editable_job_title'] = $request->editable_job_title ? 1 : 0;
        $request['editable_dob'] = $request->editable_dob ? 1 : 0;
        $request['editable_name'] = 1;
        $request['editable_phone'] = $request->editable_phone ? 1 : 0;
        $request['editable_institute'] = $request->editable_institute ? 1 : 0;

        $request['show_company'] = $request->show_company ? 1 : 0;
        $request['show_gender'] = $request->show_gender ? 1 : 0;
        $request['show_student_type'] = $request->show_student_type ? 1 : 0;
        $request['show_identification_number'] = $request->show_identification_number ? 1 : 0;
        $request['show_job_title'] = $request->show_job_title ? 1 : 0;
        $request['show_dob'] = $request->show_dob ? 1 : 0;
        $request['show_name'] = 1;
        $request['show_phone'] = $request->show_phone ? 1 : 0;
        $request['show_institute'] = $request->show_institute ? 1 : 0;

        $request['required_company'] = $request->required_company ? 1 : 0;
        $request['required_gender'] = $request->required_gender ? 1 : 0;
        $request['required_student_type'] = $request->required_student_type ? 1 : 0;
        $request['required_identification_number'] = $request->required_identification_number ? 1 : 0;
        $request['required_job_title'] = $request->required_job_title ? 1 : 0;
        $request['required_dob'] = $request->required_dob ? 1 : 0;
        $request['required_name'] = 1;
        $request['required_phone'] = $request->required_phone ? 1 : 0;
        $request['required_institute'] = $request->required_institute ? 1 : 0;
        return $request;
    }

    public function create()
    {
        try {
            $institutes = Institute::where('status',1)->get();
            return view('studentsetting::student_create',compact('institutes'));

        } catch (Exception $e) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }

    public function show($id)
    {
        $data['instant_messages'] = UserInstantMessage::where('user_id', $id)->get();
        $data['passport_document'] = UserDocument::where('user_id', $id)->where('name', 'passport')->first();
        $data['nid_document'] = UserDocument::where('user_id', $id)->where('name', 'nid')->first();
        $data['others_documents'] = UserDocument::where('user_id', $id)->whereNotIn('name', ['nid', 'passport'])->get();
        $data['user'] = User::with('currency', 'userInfo', 'userInfo.timezone', 'userEducations', 'userSkill', 'userPayoutAccount')->findOrFail($id);

        return view('studentsetting::student_show', $data);
    }

    public function edit($id)
    {

        $data['user'] = User::with('currency', 'userInfo', 'userInfo.timezone', 'userEducations', 'userSkill', 'userPayoutAccount')->findOrFail($id);
        $data['institutes']        = Institute::where('status',1)->get();

        return view('studentsetting::student_create', $data);

    }

    public function destroy(Request $request)
    {
        $rules = [
            'id' => 'required'
        ];

        $this->validate($request, $rules, validationMessage($rules));



        if (demoCheckById($request->id,[3,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40])) {
            return redirect()->back();
        }

        $user = User::findOrFail($request->id);

        try {
            $success = trans('lang.Student') . ' ' . trans('lang.Deleted') . ' ' . trans('lang.Successfully');

            $user->delete();

            Toastr::success($success, trans('common.Success'));
            return redirect()->route('student.student_list');

        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function getAllStudentData(Request $request)
    {
        $user = Auth::user();
        $query = User::query();
        if (isModuleActive('LmsSaas')) {
            $query->where('lms_id', app('institute')->id);
        } else {
            $query->where('lms_id', 1);
        }
        if (isModuleActive('UserType')) {
            $query->whereHas('userRoles', function ($q) {
                $q->where('role_id', 3);
            });
        } else {
            $query->where('role_id', 3);
        }
        if (isModuleActive('Organization') && $user->isOrganization()) {
            $query->where('organization_id', $user->id);
        }


        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('image', function ($query) {
                return view('backend.partials._td_image', compact('query'));
            })->editColumn('name', function ($query) {
                $title = $query->name;
                $link = $query->username ? route('profileUniqueUrl', $query->username) : '';
                return view('studentsetting::partials._td_link', compact('query', 'link', 'title'));
//                return $query->name;

            })->editColumn('email', function ($query) {
                return $query->email;

            })
            ->editColumn('phone', function ($query) {
                return translatedNumber($query->phone);

            })
            ->editColumn('gender', function ($query) {
                return ucfirst($query->gender);

            })
            ->editColumn('dob', function ($query) {
                return showDate($query->dob);

            })
            ->addColumn('start_working_date', function ($query) {
                if (isModuleActive('Org')) {
                    return showDate($query->start_working_date);
                } else {
                    return '';
                }

            })
            ->editColumn('country', function ($query) {
                return $query->userCountry->name;

            })
            ->addColumn('status', function ($query) {
                $route = 'student.change_status';
                return view('backend.partials._td_status', compact('query', 'route'));


            })->addColumn('course_count', function ($query) {
                return view('studentsetting::partials._td_course_count', compact('query'));


            })->addColumn('action', function ($query) {
                return view('studentsetting::partials._td_action', compact('query'));

            })->rawColumns(['status', 'image', 'course_count', 'action', 'name'])
            ->make(true);
    }

    public function studentAssignedCourses($id)
    {
        try {
            $user = User::with('enrollCourse', 'studentCourses')->find($id);
            $courses = $user->enrollCourse;
            $instance = $user->studentCourses;
            $notEnrolled = Course::where('status', 1)->whereNotIn('id', $courses->pluck('id')->toArray())->get();
            return view('studentsetting::student_courses', compact('user', 'courses', 'instance', 'notEnrolled'));
        } catch (Throwable $th) {
            GettingError($th->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }

    }

    public function newEnroll()
    {

        try {

            $query = Course::where('status', 1)->whereIn('type',[1,2,3]);

            if (isModuleActive('Organization') && Auth::user()->isOrganization()) {
                $query->whereHas('user', function ($q) {
                    $q->where('organization_id', Auth::id());
                    $q->orWhere('id', Auth::id());
                });
            }

            $courses = $query->select('id', 'title', 'type')->get();

            $query = User::where('status', 1)->select('id', 'name');
            if (isModuleActive('LmsSaas')) {
                $query->where('lms_id', app('institute')->id);
            } else {
                $query->where('lms_id', 1);
            }
            if (isModuleActive('UserType')) {
                $query->whereHas('userRoles', function ($q) {
                    $q->where('role_id', 3);
                });
            } else {
                $query->where('role_id', 3);
            }
            if (isModuleActive('Organization') && Auth::user()->isOrganization()) {
                $query->where('organization_id', Auth::id());
            }
            $students = $query->get();
            return view('studentsetting::new_enroll', compact('courses', 'students'));

        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function newEnrollSubmit(Request $request)
    {

        if (demoCheck()) {
            return redirect()->back();
        }
        $rules = [
            'student' => 'required|array',
            'course' =>'required|array',

        ];

        $this->validate($request, $rules, validationMessage($rules));
        try {
            $students = $request->student;
            $courses = $request->course;

            foreach ($students as $student) {
                $user = User::find((int)$student);
                if ($user) {
                    foreach ($courses as $course) {
                        $course = Course::find((int)$course);
                        if (!$course) {
                            continue;
                        }
                        $instractor = (isModuleActive('Organization') && $course->isOrganizationCourse()) ? $course->courseOrganization() : User::find($course->user_id);

                        $check = CourseEnrolled::where('user_id', $user->id)->where('course_id', $course->id)->first();
                        if ($check) {
                            Toastr::error($user->name . ' '.trans('frontend.has already been enrolled').' ' . $course->title . ' ' , trans('common.Success'));

                        } else {
                            if ($course->type == 3 && $course->class->capacity && $course->total_enrolled >= $course->class->capacity) {
                                Toastr::error(trans('virtual-class.Enrollment limit for this course has been reached'), trans('common.Failed'));
                                continue;
                            }

                            if (isModuleActive('Group')) {
                                if ($course->isGroupCourse) {
                                    $groupRepo = new GroupRepository();
                                    $group = $groupRepo->find($course->isGroupCourse->id);

                                    $studentLimit = true;
                                    if ($group->maximum_enroll) {
                                        $studentLimit = $group->maximum_enroll > $group->members->where('user_role_id', 3)->count();
                                    }

                                    if ($group && $studentLimit) {
                                        GroupMember::create([
                                            'group_id' => $course->isGroupCourse->id,
                                            'user_id' => $user->id,
                                            'user_role_id' => 3,
                                        ]);
                                        if ($group->maximum_enroll <= $group->members->where('user_role_id', 3)->count() || $studentLimit == true) {
                                            $group->update(['quota_status' => 1]);
                                        } else {
                                            $group->update(['quota_status' => 0]);
                                        }
                                        Toastr::success(trans('frontend.User Add To Group Successfully'));
                                    } else {
                                        Toastr::warning(trans('frontend.Group Member Can not exceed Maximum Limit'));
                                    }

                                }
                            }


                            $enrolled = $course->total_enrolled;
                            $course->total_enrolled = ($enrolled + 1);
                            $enrolled = new CourseEnrolled();
                            $enrolled->user_id = $user->id;
                            $enrolled->course_id = $course->id;
                            $enrolled->purchase_price = $course->discount_price != null ? $course->discount_price : $course->price;
                            $enrolled->save();


                            $itemPrice = $enrolled->purchase_price;


                            if (isModuleActive('UserGroup') && $instractor->userGroup && $instractor->userGroup->group->status && $instractor->userGroup->group->commission) {
                                $commission = $instractor->userGroup->group->commission;
                                $reveune = ($itemPrice * $commission) / 100;
                                $enrolled->reveune = $reveune;
                            } elseif (!is_null($course->special_commission) && $course->special_commission != 0) {

                                $commission = $course->special_commission;
                                $reveune = ($itemPrice * $commission) / 100;
                                $enrolled->reveune = $reveune;
                            } elseif (!is_null($instractor->special_commission) && $instractor->special_commission != 0) {
                                $commission = $instractor->special_commission;
                                $reveune = ($itemPrice * $commission) / 100;
                                $enrolled->reveune = $reveune;
                            } else {
                                $commission = 100 - Settings('commission');
                                $reveune = ($itemPrice * $commission) / 100;
                                $enrolled->reveune = $reveune;
                            }

                            if (isModuleActive('Organization') && $course->isOrganizationCourse()) {
                                // organization profit
                                $organization_commission_data = [
                                    'user_id' => $course->courseOrganization()->id,
                                    'amount' => $reveune,
                                    'status' => true,
                                    'type' => OrganizationFinance::$credit,
                                    'description' => OrganizationFinance::$course_sale_description,
                                    'course_id' => $course->id,
                                    'data_type' => OrganizationFinance::$type_income,
                                    'payment_type' => OrganizationFinance::$payment_pending,
                                ];
                                event(new CourseSellCommissionEvent($organization_commission_data));

                                // admin profit
                                $admin_commission_data = [
                                    'user_id' => 0,
                                    'amount' => $itemPrice - $reveune,
                                    'status' => true,
                                    'type' => OrganizationFinance::$credit,
                                    'description' => OrganizationFinance::$course_sale_description,
                                    'course_id' => $course->id,
                                    'data_type' => OrganizationFinance::$type_income,
                                    'payment_type' => OrganizationFinance::$payment_completed,
                                ];
                                event(new CourseSellCommissionEvent($admin_commission_data));
                            } else {
                                $payout = new InstructorPayout();
                                $payout->instructor_id = (int)$course->user_id;
                                $payout->reveune = $reveune;
                                $payout->status = 0;
                                $payout->save();
                            }


                            $this->sendNotification('Course_Enroll_Payment', $user, [
                                'time' => \Illuminate\Support\Carbon::now()->format('d-M-Y, g:i A'),
                                'course' => $course->title,
                                'currency' => $user->currency->symbol ?? '$',
                                'price' => ($user->currency->conversion_rate * $itemPrice),
                                'instructor' => $course->user->name,
                                'gateway' => 'Offline',
                            ]);


                            if (isModuleActive('GoogleCalendar') && $course->type == 3 && $course->class->host != 'GoogleMeet') {
                                Event::dispatch(new GoogleCalendarEventAddAttendee($course->class_id, $user->email));
                            }

                            if (isModuleActive('GoogleMeet') && $course->type == 3 && $course->class->host == 'GoogleMeet') {
                                Event::dispatch(new MeetingAddAttendeeEvent($course->class_id, $user->email));
                            }

                            $this->sendNotification('Enroll_notify_Instructor', $instractor, [
                                'time' => Carbon::now()->format('d-M-Y, g:i A'),
                                'course' => $course->title,
                                'currency' => $instractor->currency->symbol ?? '$',
                                'price' => ($instractor->currency->conversion_rate * $itemPrice),
                                'rev' => @$reveune,
                            ]);


                            $enrolled->save();

                            $course->reveune = (($course->reveune) + ($enrolled->reveune));

                            $course->save();


                            if (isModuleActive('Chat')) {
                                event(new OneToOneConnection($instractor, $user, $course));
                            }

                            if (isModuleActive('Survey')) {
                                $hasSurvey = Survey::where('course_id', $course->id)->get();
                                foreach ($hasSurvey as $survey) {
                                    $surveyController = new SurveyController();
                                    $surveyController->assignSurvey($survey, $user);
                                }
                            }
                            if (isModuleActive('GoogleCalendar') && $course->type == 3 && $course->class->host != 'GoogleMeet') {
                                Event::dispatch(new GoogleCalendarEventAddAttendee($course->class_id, $user->email));
                            }

                            if (isModuleActive('GoogleMeet') && $course->type == 3 && $course->class->host == 'GoogleMeet') {
                                Event::dispatch(new MeetingAddAttendeeEvent($course->class_id, $user->email));
                            }
                            //start email subscription
                            if ($instractor->subscription_api_status == 1) {
                                try {
                                    if ($instractor->subscription_method == "Mailchimp") {
                                        $list = $course->subscription_list;
                                        $MailChimp = new MailChimp($instractor->subscription_api_key);
                                        $MailChimp->post("lists/$list/members", [
                                            'email_address' => Auth::user()->email,
                                            'status' => 'subscribed',
                                        ]);

                                    } elseif ($instractor->subscription_method == "GetResponse") {

                                        $list = $course->subscription_list;
                                        $getResponse = new GetResponse($instractor->subscription_api_key);
                                        $getResponse->addContact(array(
                                            'email' => Auth::user()->email,
                                            'campaign' => array('campaignId' => $list),

                                        ));
                                    }
                                } catch (Exception $exception) {
                                    GettingError($exception->getMessage(), url()->current(), request()->ip(), request()->userAgent(), true);

                                }
                            }
                            Toastr::success($user->name . ' '.trans('frontend.Successfully Enrolled').' '.$course->title, trans('common.Success'));
                        }
                    }


                }

            }


            return redirect()->to(route('admin.enrollLogs'));

        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function update(Request $request)
    {
        Session::flash('type', 'update');

        if (demoCheck()) {
            return redirect()->back();
        }

        $rules = [
            'name' => 'required',
            'phone' => 'nullable|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:1|unique:users,phone,' . $request->id,
            'password' => 'bail|nullable|min:8|confirmed',

        ];

        if (isModuleActive('Org')) {
            $rules['email'] = 'nullable|email|required_without:username|unique:users,email,' . $request->id;
            $rules['username'] = 'nullable|required_without:email|unique:users,username,' . $request->id;
        } else {
            $rules['email'] = 'required|email|unique:users,email,' . $request->id;

        }

        $this->validate($request, $rules, validationMessage($rules));

        $user = User::findOrFail($request->id);
        try {
            if (Config::get('app.app_sync')) {
                Toastr::error('For demo version you can not change this !', 'Failed');
                return redirect()->back();
            } else {

                $user->name = $request->name;
                $user->institute_id = $request->institute_id;
                if (empty($request->email)) {
                    $user->email = null;
                } else {
                    $user->email = $request->email;
                }
                if (empty($request->username)) {
                    $user->username = null;
                } else {
                    $user->username = $request->username;
                }
                if (empty($request->phone)) {
                    $user->phone = null;
                } else {
                    $user->phone = $request->phone;
                }
                $user->dob = getPhpDateFormat($request->dob);
                $user->facebook = $request->facebook;
                $user->twitter = $request->twitter;
                $user->linkedin = $request->linkedin;
                $user->youtube = $request->youtube;
                $user->instagram = $request->instagram;
                $user->about = $request->about;
                if (isModuleActive('Org')) {
                    $user->org_position_code = $request->position;
                    $user->start_working_date = getPhpDateFormat($request->start_working_date);
                    $user->employee_id = $request->employee_id;
                }
                $user->email_verify = 1;
                $user->gender = $request->gender;
                $user->company = $request->company;
                if ($request->password) {
                    $user->password = bcrypt($request->password);
                }

                $user->role_id = 3;
                $user->image = null;
                $user->save();

                $this->removeLink($user->id, get_class($user));
                if ($request->image) {
                    $user->image = $this->generateLink($request->image, $user->id, get_class($user), 'image');
                }
                $user->save();


            }
            Session::forget('type');
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));

            if ($user->teach_via == 2) {
                return redirect()->route('offline.student_list');
            }else{
                return redirect()->route('student.student_list');
            }


        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function Skill_group($id)
    {
        if (isModuleActive('SkillAndPathway')) {
            $groups = GroupStudent::where('student_id', $id)->get();
            return view('skillandpathway::group.student-group', compact('groups'));
        }
        return null;
    }

    public function studentLoginActivity($user_id)
    {
        try {
            $logins = UserLogin::with('user')->where('user_id', $user_id)->latest()->get();
            return view('studentsetting::activitylog', compact('logins'));

        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());

        }
    }
}
