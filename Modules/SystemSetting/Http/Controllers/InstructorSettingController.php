<?php

namespace Modules\SystemSetting\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\UserDocument;
use App\Models\UserInstantMessage;
use App\Subscription;
use App\Traits\UploadMedia;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use DrewM\MailChimp\MailChimp;
use Exception;
use GetResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Modules\Appointment\Entities\InstructorEducation;
use Modules\Appointment\Entities\InstructorSocial;
use Modules\Appointment\Repositories\Interfaces\AppointmentRepositoryInterface;
use Modules\Newsletter\Entities\NewsletterSetting;
use Modules\Newsletter\Http\Controllers\AcelleController;
use Yajra\DataTables\Facades\DataTables;


class InstructorSettingController extends Controller
{
    use UploadMedia;

    public function index()
    {

        try {
            $instructors = [];

            return view('systemsetting::instructor', compact('instructors'));

        } catch (Exception $e) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }

    public function create()
    {

        try {
            return view('systemsetting::instructor_create');

        } catch (Exception $e) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }


    public function store(Request $request)
    {
        if (saasPlanCheck('instructor')) {
            Toastr::error(trans('frontend.You have reached instructor limit'), trans('common.Failed'));
            return redirect()->back();
        }
        Session::flash('type', 'store');

        if (demoCheck()) {
            return redirect()->back();
        }


        $rules = [
            'name' => 'required',
            'phone' => 'nullable|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:5|unique:users,phone',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ];
        if (isModuleActive('Appointment')) {
            $rules['headline'] = 'required';
            $rules['type'] = 'required';
            $rules['available_message'] = 'required';
        }

        $this->validate($request, $rules, validationMessage($rules));


        try {

            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->username = null;
            $user->password = bcrypt($request->password);
            $user->about = $request->about;
            $user->dob = getPhpDateFormat($request->dob);
            $user->role_id = 2;
            $user->special_commission = null;

            if (empty($request->phone)) {
                $user->phone = null;
            } else {
                $user->phone = $request->phone;
            }
            $user->language_id = Settings('language_id');
            $user->language_code = Settings('language_code');
            $user->language_name = Settings('language_name');
            $user->language_rtl = Settings('language_rtl');
            $user->country = Settings('country_id');
            $user->facebook = $request->facebook;
            $user->twitter = $request->twitter;
            $user->linkedin = $request->linkedin;
            $user->instagram = $request->instagram;
            $user->added_by = Auth::user()->id;
            $user->email_verify = 1;
            $user->email_verified_at = now();
            $user->referral = generateUniqueId();
            if (isModuleActive('LmsSaas')) {
                $user->lms_id = app('institute')->id;
            } else {
                $user->lms_id = 1;
            }
            $user->save();

            if ($request->image) {
                $user->image = $this->generateLink($request->image, $user->id, get_class($user), 'image');
            }
            $user->save();
            if (isModuleActive('Appointment')) {

                $slug = Str::slug($request->name);
                $exitUser = User::where('slug', $slug)->first();
                if ($exitUser) {
                    $title = $request->name . '-' . substr(str_shuffle("qwertyuiopasdfghjklzxcvbnm"), 0, 4);
                    $slug = Str::slug($title);
                }

                $age = $request->dob
                    ? Carbon::parse($request->dob)->diff(Carbon::now())->y : 0;

                $user->slug = $slug;
                $user->age = $age;
                $user->gender = $request->gender;
                $user->hour_rate = $request->hour_rate;
                $user->types = json_encode($request->type);
                $user->is_available = $request->available ? 1 : 0;
                $user->headline = $request->headline;
                $user->short_video_link = $request->video_link;
                $user->available_msg = $request->available_message;

                $interface = App::make(AppointmentRepositoryInterface::class);
                $interface->instructorStoreData($request->all(), $user->id);
            }
            if (isModuleActive('Organization') && Auth::user()->isOrganizationUser()) {
                $user->organization_id = Auth::user()->userOrganization()->id;
            }

            $user->save();


            applyDefaultRoleToUser($user);
            assignStaffToUser($user);

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


                if ($setting->instructor_status == 1) {
                    $list = $setting->instructor_list_id;
                    if ($setting->instructor_service == "Mailchimp") {

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
                    } elseif ($setting->instructor_service == "GetResponse") {
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
                    } elseif ($setting->instructor_service == "Local") {
                        try {
                            $check = Subscription::where('email', '=', $user->email)->first();
                            if (empty($check)) {
                                $subscribe = new Subscription();
                                $subscribe->email = $user->email;
                                $subscribe->type = 'Instructor';
                                $subscribe->save();
                            } else {
                                $check->type = "Instructor";
                                $check->save();
                            }
                        } catch (Exception $e) {

                        }
                    }
                }
            }

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->route('allInstructor');

        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function show($id)
    {
        $data['instant_messages'] = UserInstantMessage::where('user_id', $id)->get();
        $data['passport_document'] = UserDocument::where('user_id', $id)->where('name', 'passport')->first();
        $data['nid_document'] = UserDocument::where('user_id', $id)->where('name', 'nid')->first();
        $data['others_documents'] = UserDocument::where('user_id', $id)->whereNotIn('name', ['nid', 'passport'])->get();
        $data['user'] = User::with('currency', 'userInfo', 'userInfo.timezone', 'userEducations', 'userSkill', 'userPayoutAccount')->findOrFail($id);

        if (isModuleActive('Appointment')) {
        $data['socials'] = InstructorSocial::where('instructor_id', $id)->get();

        }

        return view('systemsetting::instructor_show', $data);
    }

    public function edit($id)
    {
        $data['user'] = User::with('currency', 'userInfo', 'userInfo.timezone', 'userEducations', 'userSkill', 'userPayoutAccount')->findOrFail($id);

        return view('systemsetting::instructor_create', $data);
    }

    public function update(Request $request)
    {
        Session::flash('type', 'update');

        if (demoCheck()) {
            return redirect()->back();
        }
        $rules = [
            'id' => 'required',
            'name' => 'required',
            'phone' => 'nullable|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:1|unique:users,phone,' . $request->id,
            'email' => 'required|email|unique:users,email,' . $request->id,
            'password' => 'bail|nullable|min:8|confirmed',

        ];

        $this->validate($request, $rules, validationMessage($rules));


        $user = User::findOrFail($request->id);

        try {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->facebook = $request->facebook;
            $user->twitter = $request->twitter;
            $user->linkedin = $request->linkedin;
            $user->instagram = $request->instagram;
            $user->about = $request->about;
            $user->dob = getPhpDateFormat($request->dob);
            if (empty($request->phone)) {
                $user->phone = null;
            } else {
                $user->phone = $request->phone;
            }
            if ($request->password) {
                $user->password = bcrypt($request->password);
            }
            $user->image = null;
            if (isModuleActive('Appointment')) {
                if (!$user->slug && ($request->name != $user->name)) {
                    $user->slug = Str::slug($request->name, '-');
                }
                $user->hour_rate = $request->hour_rate;
                $user->types = json_encode($request->type);
                $user->is_available = $request->available == 'on' ? 1 : 0;
                $user->headline = $request->headline;
                $user->short_video_link = $request->video_link;
                $user->available_msg = $request->available_message;
            }
            $user->role_id = 2;
            $user->save();


            if (isModuleActive('Appointment')) {
                $interface = App::make(AppointmentRepositoryInterface::class);
                $storeInstructorData = $interface->instructorStoreData($request->all(), $user->id);
            }

            $this->removeLink($user->id, get_class($user));
            if ($request->image) {
                $user->image = $this->generateLink($request->image, $user->id, get_class($user), 'image');
            }
            $user->save();

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->route('allInstructor');

        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function destroy(Request $request)
    {

        $rules = [
            'id' => 'required'
        ];

        $this->validate($request, $rules, validationMessage($rules));


        if (demoCheck()) {
            return redirect()->back();
        }
        try {

            $user = User::with('courses')->findOrFail($request->id);
            if (count($user->courses) > 0) {
                Toastr::error($user->name . ' '.trans('frontend.has course/quiz/class. Please remove it first'), trans('common.Failed'));
                return back();
            }
            $user->delete();

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->route('allInstructor');

        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function getAllInstructorData(Request $request)
    {
        $user = Auth::user();
        $with = [];
        if (isModuleActive('OrgInstructorPolicy')) {
            $with[] = 'policy';
        }
        $query = User::query();
        if (isModuleActive('LmsSaas')) {
            $query->where('lms_id', app('institute')->id);
        } else {
            $query->where('lms_id', 1);
        }
        if (isModuleActive('UserType')) {
            $query->whereHas('userRoles', function ($q) {
                $q->where('role_id', 2);
            });
        } else {
            $query->where('role_id', 2);
        }

        if (isModuleActive('Organization') && $user->isOrganization()) {
            $query->where('organization_id', $user->id);
        }
        $query->with($with);
        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('image', function ($query) {
                return view('backend.partials._td_image', compact('query'));
            })->editColumn('name', function ($query) {
                return $query->name;

            })->editColumn('email', function ($query) {
                return $query->email;

            })->addColumn('group_policy', function ($query) {
                $policy = '';
                if (isModuleActive('OrgInstructorPolicy')) {
                    $policy = $query->policy->name;
                }
                return $policy;

            })->addColumn('status', function ($query) {
                $route = 'instructor.change_status';
                return view('backend.partials._td_status', compact('query', 'route'));

            })->addColumn('action', function ($query) {
                return view('systemsetting::partials._td_action', compact('query'));
            })->rawColumns(['status', 'image', 'action'])->make(true);
    }

}
