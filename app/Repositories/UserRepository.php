<?php

namespace App\Repositories;


use App\Models\LmsInstitute;
use App\Subscription;
use App\Traits\ImageStore;
use App\User;
use DrewM\MailChimp\MailChimp;
use Exception;
use GetResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Affiliate\Repositories\AffiliateRepository;
use Modules\Coupons\Entities\UserWiseCoupon;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\CourseEnrolled;
use Modules\LmsSaas\Http\Controllers\LmsSaasController as LmsSaasController;
use Modules\LmsSaasMD\Http\Controllers\LmsSaasController as LmsSaasControllerMD;
use Modules\Newsletter\Entities\NewsletterSetting;
use Modules\Newsletter\Http\Controllers\AcelleController;
use Modules\Payment\Entities\Cart;
use Modules\RegistrationBonus\Repositories\RegistrationbonusRepositroy;
use Modules\RolePermission\Entities\Role;
use Modules\SystemSetting\Entities\Staff;
use Modules\SystemSetting\Entities\StaffDocument;
use Modules\TwoFA\Entities\UserOtpCode;

class UserRepository implements UserRepositoryInterface
{
    use ImageStore;

    public function __construct()
    {
        if (isModuleActive('RegistrationBonus')) {
            $this->bonus = new RegistrationbonusRepositroy();
        }
    }

    public function create(array $data)
    {
        $user = User::create($data);
        if (isModuleActive('Appointment')) {
            $slug = Str::slug($data['name']);
            $exitUser = User::where('slug', $slug)->first();
            if ($exitUser) {
                $title = $data['name'] . '-' . substr(str_shuffle("qwertyuiopasdfghjklzxcvbnm"), 0, 4);
                $slug = Str::slug($title);
            }
            $user->slug = $slug;
            $user->save();
        }
//        $user->dob = $data['dob'] ?? null;
//        $user->gender = $data['gender'] ?? null;
//        $user->student_type = $data['student_type'] ?? null;
//        $user->job_title = $data['job_title'] ?? null;
//        $user->identification_number = $data['identification_number'] ?? null;
//        $user->company_id = $data['company_id'] ?? null;
        if (isModuleActive('Org') && !empty(Settings('org_student_default_branch'))) {
            $user->org_chart_code = Settings('org_student_default_branch');
        }

        if (isModuleActive('TwoFA')) {
            $user->two_step_verification = (int)Settings('default_two_fa');
        }

        $user->referral = generateUniqueId();
        $user->level = $data['level'];
        $user->save();


        if ($user->role_id == 3) {
            if (session()->get('cart') != null && count(session()->get('cart')) > 0) {

                foreach (session()->get('cart') as $key => $session_cart) {
                    $checkHasCourse = Course::find($session_cart['course_id']);
                    if ($checkHasCourse) {
                        $enolledCousrs = CourseEnrolled::where('user_id', $user->id)->where('course_id', $session_cart['course_id'])->first();
                        if (!$enolledCousrs) {
                            $hasInCart = Cart::where('course_id', $session_cart['course_id'])->where('user_id', $user->id)->first();
                            if (!$hasInCart) {
                                if ($checkHasCourse->discount_price != null) {
                                    $price = $checkHasCourse->discount_price;
                                } else {
                                    $price = $checkHasCourse->price;
                                }
                                if (hasCouponApply($checkHasCourse->id)) {
                                    $price = getCouponPrice($checkHasCourse->id);
                                }
                                $cart = new Cart();
                                $cart->user_id = $user->id;
                                $cart->instructor_id = $session_cart['instructor_id'];
                                $cart->course_id = $session_cart['course_id'];
                                $cart->tracking = getTrx();
                                $cart->price = $price;
                                $cart->save();
                            }

                        }

                    }

                }
            }
        }

        applyDefaultRoleToUser($user);

        if (isModuleActive('Affiliate')) {
            $affiliateRepo = new AffiliateRepository();

            if (isset($data['referral_code']) && !empty($data['referral_code'])) {
                $affiliateRepo->affiliateUserByCode($data['referral_code']);
            }else{
                $affiliateRepo->affiliateUser($user->id);
            }

        }
        assignStaffToUser($user);

        if (isset($data['is_lms_signup'])) {
            $institute = new LmsInstitute();
            $institute->name = $data['institute_name'];
            $institute->domain = $data['domain'];
            $institute->user_id = $user->id;
            if (isModuleActive("LmsSaasMD")) {
                if (config('lmssaasmd.db_setup') == 'automatic') {
                    $institute_status = 1;
                } else {
                    $institute_status = 0;
                }
                $user->is_active = 0;
            } else {
                $institute_status = 1;
            }
            $institute->status = $institute_status;
            $institute->save();
            $user->lms_id = $institute->id;
            $user->update();

            if (isModuleActive("LmsSaasMD") && config('lmssaasmd.db_setup') == 'automatic') {
                $saas_controller = new LmsSaasControllerMD();
                $saas_controller->newDbCreate($institute->id);
            }
            if (isModuleActive("LmsSaas")) {
                $saas_controller = new LmsSaasController();
                $saas_controller->lmsSetup($institute->id);
            }

        } else {
            if (session::get('referral') != null) {
                $invited_by = User::where('referral', session::get('referral'))->first();
                $invites = !empty($invited_by->total_referrer_users) ? $invited_by->total_referrer_users : 0;
                $total_reffer = $invites + 1;
                $invited_by->total_referrer_users = $total_reffer;
                $invited_by->save();

                if (isModuleActive('RegistrationBonus')) {
                    $this->bonus->referralBonus($invited_by);
                }

                $user_coupon = new UserWiseCoupon();
                $user_coupon->invite_by = $invited_by->id;
                $user_coupon->invite_accept_by = $user->id;
                $user_coupon->invite_code = session::get('referral');
                $user_coupon->save();
            }

            $mailchimpStatus = saasEnv('MailChimp_Status') ?? false;
            $getResponseStatus = saasEnv('GET_RESPONSE_STATUS') ?? false;
            $acelleStatus = saasEnv('ACELLE_STATUS') ?? false;
            if (hasTable('newsletter_settings')) {
                $setting = NewsletterSetting::getData();
                if ($data['role_id'] == 2) {

                    if ($setting->instructor_status == 1) {
                        $list = $setting->instructor_list_id;
                        if ($setting->instructor_service == "Mailchimp") {

                            if ($mailchimpStatus) {
                                try {
                                    $MailChimp = new MailChimp(saasEnv('MailChimp_API'));
                                    $MailChimp->post("lists/$list/members", [
                                        'email_address' => $data['email'],
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
                                        'email' => $data['email'],
                                        'campaign' => array('campaignId' => $list),
                                    ));
                                } catch (Exception $e) {

                                }
                            }
                        } elseif ($setting->instructor_service == "Acelle") {
                            if ($acelleStatus) {

                                try {
                                    $email = $data['email'];
                                    $make_action_url = '/subscribers?list_uid=' . $list . '&EMAIL=' . $email;
                                    $acelleController = new AcelleController();
                                    $response = $acelleController->curlPostRequest($make_action_url);
                                } catch (Exception $e) {

                                }
                            }
                        } elseif ($setting->instructor_service == "Local") {
                            try {
                                $check = Subscription::where('email', '=', $data['email'])->first();
                                if (empty($check)) {
                                    $subscribe = new Subscription();
                                    $subscribe->email = $data['email'];
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


                } elseif ($data['role_id'] == 3) {
                    if ($setting->student_status == 1) {
                        $list = $setting->student_list_id;
                        if ($setting->student_service == "Mailchimp") {

                            if ($mailchimpStatus) {
                                try {
                                    $MailChimp = new MailChimp(saasEnv('MailChimp_API'));
                                    $MailChimp->post("lists/$list/members", [
                                        'email_address' => $data['email'],
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
                                        'email' => $data['email'],
                                        'campaign' => array('campaignId' => $list),
                                    ));
                                } catch (Exception $e) {

                                }
                            }
                        } elseif ($setting->student_service == "Acelle") {
                            if ($acelleStatus) {

                                try {
                                    $email = $data['email'];
                                    $make_action_url = '/subscribers?list_uid=' . $list . '&EMAIL=' . $email;
                                    $acelleController = new AcelleController();
                                    $response = $acelleController->curlPostRequest($make_action_url);
                                } catch (Exception $e) {

                                }
                            }
                        } elseif ($setting->student_service == "Local") {
                            try {
                                $check = Subscription::where('email', '=', $data['email'])->first();
                                if (empty($check)) {
                                    $subscribe = new Subscription();
                                    $subscribe->email = $data['email'];
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
            }

        }


        if (Settings('email_verification') != 1 || config('app.demo_mode')) {
            $user->email_verified_at = date('Y-m-d H:m:s');
            $user->save();
        } else {
            if (isModuleActive('LmsSaas') && !empty($user->institute) && $user->institute->domain != SaasDomain()) {
                Storage::put(md5($user->email), $user->email);
            } else {
                $user->sendEmailVerificationNotification();
            }
//            $user->sendEmailVerificationNotification();
        }

        if (isModuleActive('RegistrationBonus')) {
            $this->bonus->instantBonus($user);
        }

        if (isModuleActive('TwoFA') && Settings('default_two_fa')) {
            $verification_code = $this->storeVerificationCode($user->email);

            if ($verification_code) {
                $mailData = [
                    'otp_code' => $verification_code->otp_code,
                    'email' => $verification_code->email,
                    'expired_time' => $verification_code->expired_time
                ];
                if ($user->two_step_verification == 1) {
                    send_email($user, 'Two_Factor_Authentication', $mailData);
                } elseif ($user->two_step_verification == 3) {
                    send_sms_notification($user, 'Two_Factor_Authentication', $mailData);
                } elseif ($user->two_step_verification == 4) {
                    send_mobile_notification($user, 'Two_Factor_Authentication', $mailData);
                }
            }
            return redirect()->route('two_step_verification')->send();

        }
        if ($user->role_id == 2) {
            $user->status =(int)Settings('instructor_registration_auto_approval');
            $user->save();
        }elseif($user->role_id == 3) {
            $user->status =(int)Settings('student_registration_auto_approval');
            $user->save();
        }

        return $user;
    }

    public function find($id)
    {
        return Staff::with('user')->findOrFail($id);
    }

    public function update(array $data, $id)
    {
        $user = User::findOrFail($id);
        if (Hash::check($data['password'], Auth::user()->password)) {
            if (isset($data['photo'])) {
                $data = Arr::add($data, 'avatar', $this->saveAvatar($data['photo']));
                $user->image = $data['avatar'];
            }
            $user->name = $data['name'];
            $user->username = $data['username'];
            $user->role_id = $data['role_id'];
            $user->password = Hash::make($data['password']);
            if ($user->save()) {
                $staff = $user->staff;
                $staff->user_id = $user->id;
                $staff->department_id = $data['department_id'];
                $staff->employee_id = $data['employee_id'];
                $staff->showroom_id = $data['showroom_id'];
                // $staff->warehouse_id = $data['warehouse_id'];
                $staff->phone = $data['phone'];
                if ($staff->save()) {
                    if (Settings('email_verification') != 1) {
                        $user->email_verified_at = date('Y-m-d H:m:s');
                        $user->save();
                    } else {
                        $user->sendEmailVerificationNotification();
                    }
                }
                return $user;
            }
        }
    }


    ///////


    public function user()
    {
        return User::with('leaves', 'leaveDefines')->latest()->get();
    }

    public function storeVerificationCode($email)
    {
        $v_code = new UserOtpCode();
        $v_code->email = $email;
        $v_code->user_id = User::where('email', $email)->first()->id;
        $v_code->otp_code = rand(1111, 9999);
        $v_code->expired_time = User::where('email', $email)->first()->two_fa_expired_time;
        $v_code->save();

        return $v_code;
    }

    public function store(array $data)
    {
        $user = new User;
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->username = $data['username'];
        $user->role_id = $data['role_id'];
        $user->country = $data['country'];
        if (isset($data['photo'])) {
            $data = Arr::add($data, 'avatar', $this->saveAvatar($data['photo']));
            $user->image = $data['avatar'];
        }
        $user->password = Hash::make($data['password']);
        if (Settings('email_verification') != 1) {
            $user->email_verified_at = date('Y-m-d H:m:s');
            $user->save();
        } else {
            $user->sendEmailVerificationNotification();
        }
        return $user;
    }

    public function all($relational_keyword = [])
    {
        if (count($relational_keyword) > 0) {
            return Staff::latest()->get();
        } else {
            return Staff::latest()->get();
        }

    }

    public function findUser($id)
    {
        return User::findOrFail($id);
    }

    public function findDocument($id)
    {
        return StaffDocument::where('staff_id', $id)->get();
    }

    public function updateProfile(array $data, $id)
    {
        $user = User::findOrFail($id);
        if (isset($data['avatar'])) {
            $user->avatar = $this->saveAvatar($data['avatar'], 60, 60);
        }
        $user->name = $data['name'];
        if (isset($data['password']) and $data['password']) {
            $user->password = bcrypt($data['password']);
        }

        $result = $user->save();
        $staff = $user->staff;
        if ($result) {
            $staff->phone = $data['phone'];
            if ($user->role_id != 1) {
                $staff->bank_name = $data['bank_name'];
                $staff->bank_branch_name = $data['bank_branch_name'];
                $staff->bank_account_name = $data['bank_account_name'];
                $staff->bank_account_no = $data['bank_account_no'];
                $staff->current_address = $data['current_address'];
                $staff->permanent_address = $data['permanent_address'];
            }

            $staff->save();
        }
        return $staff;
    }

    public function statusUpdate($data)
    {
        $user = User::find($data['id']);
        $user->is_active = $data['status'];
        $user->status = $data['status'];
        $user->save();
    }

    public function deleteStaffDoc($id)
    {
        $document = StaffDocument::findOrFail($id)->delete();
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        if ($user->staff) {
            if (isModuleActive('HumanResource')) {
                if ($user->staff->payrolls) {
                    $user->staff->payrolls()->delete();
                }
            }
            $user->staff->delete();
        }
        $user->delete();
    }

    public function normalUser()
    {
        $normal_roles_id = Role::where('type', 'regular_user')->pluck('id');
        return User::where('id', Auth::id())->orwhereIn('role_id', $normal_roles_id)->get();
    }

    public function roleUsers($role_id)
    {
        return User::where('role_id', $role_id)->where('is_active', 1)->get();
    }


}
