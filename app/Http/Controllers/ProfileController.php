<?php

namespace App\Http\Controllers;

use App\Models\DeleteAccountRequest;
use App\Models\UserDocument;
use App\Models\UserEducation;
use App\Models\UserExperience;
use App\Models\UserFollower;
use App\Models\UserInstantMessage;
use App\Models\UserSkill;
use App\Traits\ImageStore;
use App\Traits\UploadMedia;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;
use Modules\Blog\Entities\Blog;
use Modules\Certificate\Entities\CertificateRecord;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\CourseBadge;
use Modules\CourseSetting\Entities\CourseComment;
use Modules\CourseSetting\Entities\CourseCommentReply;
use Modules\CourseSetting\Entities\CourseEnrolled;
use Modules\CourseSetting\Entities\CourseReveiw;
use Modules\Localization\Entities\Language;
use Modules\Setting\Entities\PayoutAccountSpecification;
use Modules\Setting\Entities\SmsGateway;
use Modules\Setting\Entities\UserPayoutAccount;
use Modules\Setting\Entities\UserPayoutAccountSpecification;
use Modules\Setting\Model\TimeZone;
use Modules\Setting\Repositories\PayoutAccountRepository;
use Modules\SystemSetting\Entities\Currency;
use Modules\Zoom\Entities\ZoomSetting;

/**
 * this controller responsible user profile
 */
class ProfileController extends Controller
{
    use UploadMedia, ImageStore;

    public function __construct()
    {
        $this->middleware('auth')->except(['profile']);

    }

    public function offlineStatusSubmit(Request $request)
    {

        $rules = [
            'offline_message' => 'max:500',
        ];
        $request->validate($rules, validationMessage($rules));


        try {

            $user = Auth::user();

            $user->userInfo->updateOrCreate(
                ['user_id' => Auth::id()],
                [
                    'user_id' => Auth::id(),
                    'offline_message' => $request->offline_message,
                ]
            );
            Toastr::success(trans('common.Operation successful'));
            return redirect()->back();

        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function offlineStatusChange()
    {

        try {

            $user = Auth::user();
            if (!$user->userInfo) {
                $user->userInfo()->create([
                    'user_id' => Auth::id()
                ]);
                $status = true;
            } else {
                $user->userInfo()->update(
                    [
                        'user_id' => Auth::id(),
                        'offline_status' => !($user->userInfo && $user->userInfo->offline_status) || !$user->userInfo->offline_status,
                    ]
                );
                $status = !$user->userInfo->offline_status;
            }

            $msg = trans('common.Operation successful');
            return response()->json(['msg' => $msg, 'status' => $status], 200);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 503);
        }
    }

    /**
     * user profile
     */

    public function profile($id)
    {
        $query = User::with(['userPayoutAccount', 'userInfo', 'userSkill', 'userEducations', 'userExperiences']);

        $route = Route::currentRouteName();
        if ($route == 'profileUniqueUrl') {
            $query->where('username', $id);
        } else {
            $query->where('id', $id);
        }

        $data['user'] = $query->firstOrFail();
        try {

            $id = $data['user']->id;

            $data['total_followers'] = UserFollower::where('following_id', $id)->count();
            $data['total_following'] = UserFollower::where('follower_id', $id)->count();

            $course_comment = CourseComment::where('user_id', $id)->count();
            $course_comment_reply = CourseCommentReply::where('user_id', $id)->count();
            $data['total_comment'] = $course_comment + $course_comment_reply;
            $data['total_review'] = CourseReveiw::where('user_id', $data['user']->id)->count();


            if ($data['user']->userInfo) {
                if ($data['user']->userInfo->show_education) {
                    $data['section_education_tab'] = true;
                } else {
                    $data['section_education_tab'] = false;
                }

                if ($data['user']->userInfo->show_experience) {
                    $data['section_experience_tab'] = true;
                } else {
                    $data['section_experience_tab'] = false;
                }

            } else {
                $data['section_education_tab'] = true;
                $data['section_experience_tab'] = true;
            }


            $data['section_badge'] = false;
            $data['section_review'] = false;
            $data['section_comment'] = false;
            $data['section_total_instructor'] = false;
            $data['section_total_course'] = false;
            $data['section_total_review'] = false;
            $data['section_total_student'] = false;
            $data['section_instructor_tab'] = false;
            $data['section_course_tab'] = false;
            $data['section_blog_tab'] = false;
            $data['section_certificate_tab'] = false;
            $data['total_courses'] = 0;
            $data['total_instructors'] = 0;
            $data['total_students'] = 0;
            $data['total_blogs'] = 0;
            $data['courses'] = collect();
            $data['instructors'] = collect();
            $data['total_blogs'] = Blog::where('user_id', $data['user']->id)->count();
            $data['total_certificates'] = CertificateRecord::where('student_id', $data['user']->id)->count();
            $data['section_course_badge_tab'] = false;

            if ($data['user']->role_id == 3) {
                $data['section_badge'] = true;
                $data['section_total_review'] = true;
                $data['section_total_course'] = true;
                $data['section_blog_tab'] = true;
                $data['section_certificate_tab'] = true;
                $data['section_course_tab'] = true;
                $data['total_courses'] = $data['user']->enrollCourse->count();
                $data['courses'] = $data['user']->enrollCourse;
                $data['badges'] = CourseBadge::where('user_id',$data['user']->id)->with('user:id,name','course:id,course_badge')->get();
                $data['section_course_badge_tab'] = true;


            } elseif ($data['user']->role_id == 2) {
                $data['section_total_course'] = true;
                $data['section_total_review'] = true;
                $data['section_blog_tab'] = true;
                $data['section_total_student'] = true;
                $data['section_badge'] = true;
                $data['total_courses'] = $data['user']->courses->count();
                $data['section_course_tab'] = true;
                $data['courses'] = $data['user']->courses;
                $data['total_review'] = userRating($id)['total'];
                $data['total_students'] = CourseEnrolled::whereHas('course.user', function ($q) use ($data) {
                    $q->where('id', $data['user']->id);
                })->count();
            } elseif ($data['user']->role_id == 4) {
                $data['section_total_course'] = true;
                $data['section_total_review'] = true;
                $data['section_total_student'] = true;
                $data['section_blog_tab'] = true;
                $data['section_badge'] = true;
                $data['total_courses'] = $data['user']->courses->count();
                $data['section_course_tab'] = true;
                $data['courses'] = $data['user']->courses;
                $data['total_review'] = userRating($id)['total'];
                $data['total_students'] = CourseEnrolled::whereHas('course.user', function ($q) use ($data) {
                    $q->where('id', $data['user']->id);
                })->count();
            } elseif ($data['user']->role_id == 5) {
                $data['section_total_course'] = true;
                $data['section_total_instructor'] = true;
                $data['section_total_student'] = true;
                $data['section_badge'] = true;
                $data['section_course_tab'] = true;
                $data['section_total_review'] = true;
                $data['section_instructor_tab'] = true;
                $users = User::query();
                if (isModuleActive('Organization') && $data['user']->isOrganization()) {
                    $course_query = Course::query()->with('category', 'quiz', 'user')->whereHas('user', function ($q) use ($data) {
                        $q->where('organization_id', $data['user']->id);
                        $q->orWhere('id', $data['user']->id);
                    });
                    $organization_course_ids = $course_query->clone()->pluck('id');
                    $data['courses'] = $course_query->clone()->get();
                    $data['total_courses'] = Course::with('category', 'quiz', 'user')->whereHas('user', function ($q) use ($data) {
                        $q->where('organization_id', $data['user']->id);
                        $q->orWhere('id', $data['user']->id);
                    })->count();

                    $data['instructors'] = $users->clone()->where('role_id', 2)->where('organization_id', $data['user']->id)->get();

                    $data['total_students'] = $users->clone()->where('role_id', 3)->where('organization_id', $data['user']->id)->count();
                    $data['total_instructors'] = $users->clone()->where('role_id', 2)->where('organization_id', $data['user']->id)->count();


                    $data['total_review'] = CourseReveiw::whereIn('course_id', $organization_course_ids)->count();
                }
            } elseif ($data['user']->role_id == 1) {
                $data['section_total_course'] = true;
                $data['section_total_review'] = true;
                $data['section_total_student'] = true;
                $data['section_total_instructor'] = true;
                $course_comment = CourseComment::count();
                $course_comment_reply = CourseCommentReply::count();
                $data['total_review'] = $course_comment + $course_comment_reply;
                $users = User::query();
                $data['total_courses'] = Course::count();
                $data['total_students'] = $users->clone()->where('role_id', 3)->count();
                $data['total_instructors'] = $users->clone()->where('role_id', 2)->count();
                $data['total_review'] = userRating($id)['total'];
            }


            if (\auth()->check()) {
                $follow_flag = UserFollower::where('following_id', $id)->where('follower_id', Auth::id())->first();
                if ($follow_flag) {
                    $data['follow_btn_route'] = route('users.unfollow', $id);
                    $data['follow_btn_text'] = trans('profile.following');

                } else {
                    $data['follow_btn_route'] = route('users.follow', $id);
                    $data['follow_btn_text'] = trans('profile.follow');
                }

            } else {
                $data['follow_btn_route'] = route('users.follow', $id);
                $data['follow_btn_text'] = trans('profile.follow');
            }

            return view(theme('profile.profile'), $data);
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    /**
     * user settings page
     */

    public function userSettings()
    {


        try {
            $data['user'] = User::with(['userPayoutAccount', 'userInfo', 'userSkill', 'userEducations', 'userExperiences'])->find(Auth::id());
            $data['currencies'] = Currency::whereStatus('1')->get();
            $data['languages'] = Language::whereStatus('1')->get();
            $data['timezones'] = TimeZone::all();
            $data['countries'] = DB::table('countries')->whereActiveStatus(1)->get();
            $data['states'] = DB::table('states')->where('country_id', $data['user']->country)->where('id', $data['user']->state)->select('id', 'name')->get();
            $data['cities'] = DB::table('spn_cities')->where('state_id', $data['user']->state)->where('id', $data['user']->city)->select('id', 'name')->get();
            $data['passport_document'] = UserDocument::where('user_id', Auth::id())->where('name', 'passport')->first();
            $data['nid_document'] = UserDocument::where('user_id', Auth::id())->where('name', 'nid')->first();
            $data['others_documents'] = UserDocument::where('user_id', Auth::id())->whereNotIn('name', ['nid', 'passport'])->get();
            $data['instant_messages'] = UserInstantMessage::where('user_id', Auth::id())->get();
            $payoutAccountRepo = new PayoutAccountRepository();
            $data['payout_accounts'] = $payoutAccountRepo->getActiveAll();
            $data['zoom_settings'] = ZoomSetting::where('user_id', Auth::id())->first();

            if ($data['user']->userInfo) {
                if ($data['user']->userInfo->show_education) {
                    $data['show_education'] = true;
                    $data['show_education_tooltip'] = 'Hide education info on profile';
                } else {
                    $data['show_education'] = false;
                    $data['show_education_tooltip'] = 'Show education info on profile';
                }

                if ($data['user']->userInfo->show_experience) {
                    $data['show_experience'] = true;
                    $data['show_experience_tooltip'] = 'Hide experience info on profile';
                } else {
                    $data['show_experience'] = false;
                    $data['show_experience_tooltip'] = 'Show experience info on profile';
                }

            } else {
                $data['show_education'] = true;
                $data['show_education_tooltip'] = 'Hide education info on profile';

                $data['show_experience'] = true;
                $data['show_experience_tooltip'] = 'Hide experience info on profile';

            }
            $activeSMS = SmsGateway::where('status', 1)->first();
            if ($activeSMS && !empty($data['user']->phone)) {
                $data['sms'] = true;
            } else {
                $data['sms'] = false;
            }
            if ($data['user']->role_id == 3) {
                $data['is_student'] = true;
                return view(theme('profile.student_settings'), $data);
            } else {
                $data['is_student'] = false;
                return view('backend.profile.settings', $data);
            }


        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    /**
     * profile data toggle hide show
     */

    public function profileDataToggle(Request $request)
    {
        try {

            $user = Auth::user();

            $user->userInfo()->updateOrCreate(
                ['user_id' => Auth::id()],
                [
                    'user_id' => Auth::id(),
                    $request->field => $request->value,
                ]
            );
            $msg = trans('common.Operation successful');
            return response()->json(['msg' => $msg], 200);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 503);
        }
    }

    /**
     * user unfollow function
     */

    public function unfollow($id)
    {
        try {
            $check = UserFollower::where('following_id', $id)->where('follower_id', Auth::id())->first();
            if ($check) {
                $check->delete();
            }
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return back();
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    /**
     * user follow function
     */

    public function follow($id)
    {
        try {
            $check = UserFollower::where('following_id', $id)->where('follower_id', Auth::id())->first();
            if (!$check) {
                UserFollower::create([
                    'following_id' => $id,
                    'follower_id' => Auth::id(),
                ]);
            }
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return back();
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    /**
     * request delete account
     */
    public function deleteAccount(Request $request)
    {

        try {
            if (demoCheck()) {
                return redirect()->back();
            }

            $user = Auth::user();


            if (!empty($user->password) && !Hash::check($request->old_password, $user->password)) {
                Toastr::error(__('student.Password does not match'), __('common.Failed'));
                return redirect()->back();
            }

            $user->update(['status' => 0]);

            DeleteAccountRequest::create(
                [
                    'user_id' => Auth::id()
                ]
            );
            Auth::logoutOtherDevices($request->old_password);
            Auth::logout();

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));

            return back();


        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());

        }
    }

    /**
     * user finance account
     */

    public function financeAccount(Request $request)
    {

        $rules = [
            'account_type' => 'required',
        ];
        $request->validate($rules, validationMessage($rules));


        try {
            DB::beginTransaction();
            UserPayoutAccount::updateOrCreate(
                ['user_id' => Auth::id()],
                [
                    'user_id' => Auth::id(),
                    'payout_accounts_id' => $request->account_type,
                ]
            );

            if ($request->specifications) {
                foreach ($request->specifications as $key => $specification) {
                    UserPayoutAccountSpecification::updateOrCreate(
                        [
                            'user_id' => Auth::id(),
                            'payout_accounts_id' => $request->account_type,
                            'specification_id' => $key,
                        ],
                        [
                            'user_id' => Auth::id(),
                            'payout_accounts_id' => $request->account_type,
                            'specification_id' => $key,
                            'value' => $specification,
                        ]
                    );

                }
            }


            DB::commit();
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (Exception $e) {
            DB::rollBack();
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    /**
     * finance payout data change
     */

    public function payoutAccountType($id)
    {
        try {
            $data['payout_data'] = PayoutAccountSpecification::where('payout_accounts_id', $id)->get();
            $data['payout_account_specifications'] = UserPayoutAccountSpecification::where('user_id', Auth::id())->get(['specification_id', 'value'])->keyBy('specification_id')->toArray();
            if ($this->is_student()) {
                return view(theme('profile.finance.payout_data'), $data);
            }
            return view('backend.profile.finance.payout_data', $data);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 503);
        }
    }

    public function is_student()
    {
        if (Auth::user()->role_id == 3) {
            return true;
        }
        return false;

    }

    /**
     * profile and cover photo update
     */

    public function photoUpdate(Request $request)
    {
        $user = Auth::user();

        if ($user->role_id == 3) {
            $rules = [
                'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480',
                'cover_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480',
            ];
            $request->validate($rules, validationMessage($rules));
        }

        try {
            if ($user->role_id == 3) {
                if ($request->file('profile_picture')) {
                    $profile_url = $this->saveImage($request->file('profile_picture'));
                    if ($user->image) {
                        $this->deleteImage($user->image);
                    }
                    $user->image = $profile_url;
                    $user->save();

                }

                if ($request->file('cover_photo')) {
                    $cover_url = $this->saveImage($request->file('cover_photo'));
                    if ($user->userInfo && $user->userInfo->cover_photo) {
                        $this->deleteImage($user->userInfo->cover_photo);
                    }
                    $user->userInfo()->updateOrCreate(
                        ['user_id' => Auth::id()],
                        [
                            'user_id' => Auth::id(),
                            'cover_photo' => $cover_url,
                        ]
                    );

                }

            } else {
                $user->image = null;
                $user->save();
                $this->removeLink($user->id, get_class($user));

                if ($request->profile_picture) {
                    $user->image = $this->generateLink($request->profile_picture, $user->id, get_class($user), 'image');
                    $user->save();

                }


                $userInfo = $user->userInfo()->updateOrCreate(
                    ['user_id' => Auth::id()], [
                        'cover_photo' => null
                    ]
                );

                $this->removeLink($userInfo->id, get_class($userInfo));

                if ($request->cover_photo) {
                    $userInfo->cover_photo = $this->generateLink($request->cover_photo, $userInfo->id, get_class($userInfo), 'cover_photo');
                    $userInfo->save();

                }
            }


            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    /**
     * basic info update
     */
    public function basicInfoUpdate(Request $request)
    {
        $user = User::find(Auth::id());

        $rules['name'] = ['required', 'max:150'];


        $rules = [
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore(Auth::id()),
            ],
            'phone' => [
                'nullable',
                'regex:/^([0-9\s\-\+\(\)]*)$/',
                Rule::unique('users', 'phone')->ignore(Auth::id()),
            ],
        ];


        $request->validate($rules, validationMessage($rules));



        try {
            DB::beginTransaction();

//            $user->first_name = $request->first_name;
//            $user->last_name = $request->last_name;
            $user->name = $request->name;
            $user->identification_number = $request->identification_number;
            $user->email = $request->email;
            $user->phone = $request->phone != "" ? $request->phone : null;
            $user->currency_id = $request->currency;

            $language = Language::find($request->language);
            if ($language) {
                $user->language_id = $language->id;
                $user->language_code = $language->code;
                $user->language_name = $language->name;
                $user->language_rtl = $language->rtl;
            }
            $user->save();


            $user->userInfo()->updateOrCreate(
                ['user_id' => Auth::id()],
                [
                    'user_id' => Auth::id(),
                    'timezone_id' => $request->timezone,
                ]
            );

            DB::commit();
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (Exception $e) {
            DB::rollBack();
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    /**
     * social info update
     */
    public function socialInfoUpdate(Request $request)
    {

        $request->validate([
            'instant_messaging.*.service' => 'required_with:instant_messaging.*.username',
            'instant_messaging.*.username' => 'required_with:instant_messaging.*.service'
        ]);

        try {
            DB::beginTransaction();
            User::where('id', Auth::id())->update([
                'facebook' => $request->facebook,
                'twitter' => $request->twitter,
                'linkedin' => $request->linkedin,
                'instagram' => $request->instagram,
                'youtube' => $request->youtube,
            ]);

            UserInstantMessage::where('user_id', Auth::id())->delete();
            if ($request->instant_messaging) {
                foreach ($request->instant_messaging as $msg) {
                    if ($msg['service'] && $msg['username']) {
                        UserInstantMessage::create([
                            'user_id' => Auth::id(),
                            'service' => $msg['service'],
                            'username' => $msg['username'],
                        ]);
                    }
                }
            }

            DB::commit();
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (Exception $e) {
            DB::rollBack();
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    /**
     * document delete
     */

    public function documentDelete($id)
    {
        try {
            $flag = UserDocument::find($id);

            if ($flag) {
                $flag->delete();
            }
            return response()->json([
                'msg' => trans('common.Operation successful'),
                'type' => 'reload',
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 503);
        }
    }


    /**
     * document update
     */

    public function documentUpdate(Request $request)
    {
           try {
            $from = $request->get('from');
             $passport = UserDocument::firstOrNew([
                 'user_id' => Auth::id(),
                 'name' => 'passport'
             ]);
           $passport->save();
              if ($from == 'frontend') {
                 if ($request->passport) {
                     $passport->document = $this->saveImage($request->passport);
                     $passport->save();
                 }
             } else {
                 // Set document to null only if no new document is provided
                 if (!$request->passport) {
                     $passport->document = null;
                     $passport->save(); // Save the null document
                 }
                 // Remove any existing link
                 $this->removeLink($passport->id, get_class($passport));

                 // Update document if a new one is provided
                 if ($request->passport) {
                     $passport->document = $this->generateLink($request->passport, $passport->id, get_class($passport), 'document');
                     $passport->save(); // Save the updated document link
                 }
             }

             $nid = UserDocument::firstOrNew(
                 [
                     'user_id' => Auth::id(),
                     'name' => 'nid'
                 ]
             );
               $nid->save();
             if ($from == 'frontend') {
                 if ($request->nid) {
                     $nid->document = $this->saveImage($request->nid);
                     $nid->save();
                 }
             } else {
                 // Set the document to null only if no new document is provided
                 if (!$request->nid) {
                     $nid->document = null;
                     $nid->save(); // Save the null document
                 }

                 // Remove any existing link
                 $this->removeLink($nid->id, get_class($nid));

                 // Generate and assign a new document link if a new nid is provided
                 if ($request->nid) {
                     $nid->document = $this->generateLink($request->nid, $nid->id, get_class($nid), 'document');
                     $nid->save(); // Save the updated document link
                 }
             }



             // Retrieve documents except 'passport' and 'nid'
             $oldDocuments = UserDocument::where('user_id', Auth::id())
                 ->whereNotIn('name', ['passport', 'nid'])
                 ->get();

             if ($from != 'frontend') {
                 foreach ($oldDocuments as $oldDocument) {
                     $oldDocument->document = null;
                     $oldDocument->save();
                     $this->removeLink($oldDocument->id, get_class($oldDocument));
                 }
             }

             //frontend
              if ($request->other_documents) {
                  foreach ($request->other_documents as $key=>$document) {
                     if (!empty($document['document_name'])) {
                         $userDoc = UserDocument::firstOrNew([
                             'user_id' => Auth::id(),
                             'name' => $document['document_name']
                         ]);
                         $userDoc->save();

                         if ($from == 'frontend') {
                             $userDoc->document =   $document['document']? $this->saveImage($document['document']):'';
                         }else{
                             $doc_img=  $request->document_image[$key]??'';
                             $userDoc->document =  $this->generateLink($doc_img, $userDoc->id, get_class($userDoc), 'document');
                         }
                         $userDoc->save();
                     }
                 }
             }

              //admin panel

               if ($request->document_name) {
                   foreach ($request->document_name as $key => $document) {
                       $userDoc = UserDocument::firstOrNew([
                           'user_id' => Auth::id(),
                           'name' => $document
                       ]);
                       $userDoc->save();
                       // Save document image if provided
                       if (isset($request->document_image[$key]) && $request->document_image[$key]) {
                           $userDoc->document = $from == 'frontend'
                               ? $this->saveImage($request->document_image[$key])
                               : $this->generateLink($request->document_image[$key], $userDoc->id, get_class($userDoc), 'document');
                       } elseif (!$userDoc->exists) {
                           // Set to null if new and no image provided
                           $userDoc->document = null;
                       }

                       $userDoc->save();
                   }
               }



             Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    /**
     * extra info update
     */

    public function extraInfoUpdate(Request $request)
    {

        try {
            User::where('id', Auth::id())->update([
                'gender' => isset($request->gender) ? $request->gender : null,
                'dob' => isset($request->dob) ? date('Y-m-d', strtotime($request->dob)) : null,
                'country' => isset($request->country) ? $request->country : null,
                'state' => isset($request->state) ? $request->state : null,
                'city' => isset($request->city) ? $request->city : null,
                'zip' => $request->zip,
                'address' => $request->address,

            ]);
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    /**
     * about settings update
     */

    public function aboutUpdate(Request $request)
    {
        $request->validate([
            'short_description' => 'nullable|max:500',
        ]);

        try {
            DB::beginTransaction();
            $user = User::find(Auth::id());
            $user->update([
                'job_title' => $request->job_title,
                'headline' => $request->headline,
                'about' => $request->about,
                'short_details' => $request->short_description,
            ]);

            $user->userInfo()->updateOrCreate(
                ['user_id' => Auth::id()],
                [
                    'user_id' => Auth::id(),
                    'short_description' => $request->short_description,
                ]
            );
            DB::commit();
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (Exception $e) {
            DB::rollBack();
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    /**
     * skill  create or edit
     */
    public function skillCreate()
    {
        try {
            $user = User::with(['userSkill'])->find(Auth::id());
            $data['exist_skills'] = '';
            if ($user->userSkill && $user->userSkill->skills) {
                $data['exist_skills'] = $user->userSkill->skills;
            }
            if ($this->is_student()) {
                return view(theme('profile.skills.form'), $data);
            }
            return view('backend.profile.skills.form', $data);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 503);
        }
    }

    /**
     * skill  store or update
     */

    public function skillStore(Request $request)
    {
        $request->validate([
            'skills' => 'required',
        ]);

        try {
            UserSkill::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                ],
                [
                    'user_id' => Auth::id(),
                    'skills' => $request->skills,
                ]
            );
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    /**
     * education  create
     */
    public function educationCreate()
    {
        try {
            if ($this->is_student()) {
                return view(theme('profile.education.form'));
            }
            return view('backend.profile.education.form');
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 503);
        }
    }

    /**
     * education  store
     */
    public function educationStore(Request $request)
    {

        $request->validate([
            'institution' => 'required|max:150',
            'degree' => 'required|max:50',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date'
        ]);
        try {
            UserEducation::create([
                'user_id' => Auth::id(),
                'institution' => $request->institution,
                'degree' => $request->degree,
                'start_date' => isset($request->start_date) ? date('Y-m-d', strtotime($request->start_date)) : null,
                'end_date' => isset($request->end_date) ? date('Y-m-d', strtotime($request->end_date)) : null,
            ]);
            $data['user'] = User::with(['userEducations'])->find(Auth::id());
            if ($this->is_student()) {
                return response()->json([
                    'response' => (string)view(theme('profile.education.list'), $data),
                    'msg' => trans('common.Operation successful'),
                ], 200);
            }
            return response()->json([
                'response' => (string)view('backend.profile.education.list', $data),
                'msg' => trans('common.Operation successful'),
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 503);
        }
    }

    /**
     * education  edit
     */
    public function educationEdit($id)
    {
        try {
            $data['education'] = UserEducation::findOrFail($id);
            if ($this->is_student()) {
                return view(theme('profile.education.form'), $data);
            }
            return view('backend.profile.education.form', $data);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 503);
        }
    }

    /**
     * education  update
     */
    public function educationUpdate(Request $request, $id)
    {

        $request->validate([
            'institution' => 'required|max:150',
            'degree' => 'required|max:50',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date'
        ]);
        try {
            UserEducation::where('id', $id)->update([
                'institution' => $request->institution,
                'degree' => $request->degree,
                'start_date' => isset($request->start_date) ? date('Y-m-d', strtotime($request->start_date)) : null,
                'end_date' => isset($request->end_date) ? date('Y-m-d', strtotime($request->end_date)) : null,
            ]);
            $data['user'] = User::with(['userEducations'])->find(Auth::id());
            if ($this->is_student()) {
                return response()->json([
                    'response' => (string)view(theme('profile.education.list'), $data),
                    'msg' => trans('common.Operation successful'),
                ], 200);
            }
            return response()->json([
                'response' => (string)view('backend.profile.education.list', $data),
                'msg' => trans('common.Operation successful'),
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 503);
        }
    }

    /**
     * education  destroy
     */
    public function educationDestroy($id)
    {
        try {
            UserEducation::where('id', $id)->delete();
            $data['user'] = User::with(['userEducations'])->find(Auth::id());
            if ($this->is_student()) {
                return response()->json([
                    'response' => (string)view(theme('profile.education.list'), $data),
                    'msg' => trans('common.Operation successful'),
                    'selector' => '#education_list',
                ], 200);
            }
            return response()->json([
                'response' => (string)view('backend.profile.education.list', $data),
                'msg' => trans('common.Operation successful'),
                'selector' => '#education_list',
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 503);
        }
    }


    /**
     * experience create
     */


    public function experienceCreate()
    {
        try {
            if ($this->is_student()) {
                return view(theme('profile.experience.form'));
            }
            return view('backend.profile.experience.form');
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 503);
        }
    }

    /**
     * experience  store
     */
    public function experienceStore(Request $request)
    {
        $request->validate([
            'title' => 'required|max:150',
            'company_name' => 'required|max:190',
            'start_date' => 'required_with:end_date|nullable|date',
            'end_date' => 'nullable|date|after:start_date',
        ]);
        try {
            UserExperience::create([
                'user_id' => Auth::id(),
                'title' => $request->title,
                'company_name' => $request->company_name,
                'currently_working' => isset($request->is_currently_working) ? true : false,
                'start_date' => isset($request->start_date) ? date('Y-m-d', strtotime($request->start_date)) : null,
                'end_date' => isset($request->end_date) ? date('Y-m-d', strtotime($request->end_date)) : null,
            ]);
            $data['user'] = User::with(['userExperiences'])->find(Auth::id());
            if ($this->is_student()) {
                return response()->json([
                    'response' => (string)view(theme('profile.experience.list'), $data),
                    'msg' => trans('common.Operation successful'),
                ], 200);
            }
            return response()->json([
                'response' => (string)view('backend.profile.experience.list', $data),
                'msg' => trans('common.Operation successful'),
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 503);
        }
    }

    /**
     * experience  edit
     */
    public function experienceEdit($id)
    {
        try {
            $data['experience'] = UserExperience::findOrFail($id);
            if ($this->is_student()) {
                return view(theme('profile.experience.form'), $data);
            }
            return view('backend.profile.experience.form', $data);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 503);
        }
    }

    /**
     * experience  update
     */
    public function experienceUpdate(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:150',
            'company_name' => 'required|max:190',
            'start_date' => 'required_with:end_date|nullable|date',
            'end_date' => 'nullable|date|after:start_date',
        ]);
        try {
            UserExperience::where('id', $id)->update([
                'title' => $request->title,
                'company_name' => $request->company_name,
                'currently_working' => isset($request->is_currently_working) ? true : false,
                'start_date' => isset($request->start_date) ? date('Y-m-d', strtotime($request->start_date)) : null,
                'end_date' => isset($request->end_date) ? date('Y-m-d', strtotime($request->end_date)) : null,
            ]);
            $data['user'] = User::with(['userExperiences'])->find(Auth::id());
            if ($this->is_student()) {
                return response()->json([
                    'response' => (string)view(theme('profile.experience.list'), $data),
                    'msg' => trans('common.Operation successful'),
                ], 200);
            }
            return response()->json([
                'response' => (string)view('backend.profile.experience.list', $data),
                'msg' => trans('common.Operation successful'),
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 503);
        }
    }

    /**
     * experience  destroy
     */
    public function experienceDestroy($id)
    {
        try {
            UserExperience::where('id', $id)->delete();
            $data['user'] = User::with(['userExperiences'])->find(Auth::id());
            if ($this->is_student()) {
                return response()->json([
                    'response' => (string)view(theme('profile.experience.list'), $data),
                    'msg' => trans('common.Operation successful'),
                    'selector' => '#experience_list',
                ], 200);
            }
            return response()->json([
                'response' => (string)view('backend.profile.experience.list', $data),
                'msg' => trans('common.Operation successful'),
                'selector' => '#experience_list',
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 503);
        }
    }

    public function faUpdate(Request $request)
    {
        if (Settings('force_two_fa') && (empty($request->two_step_verification) || $request->two_step_verification == 0)) {
            Toastr::warning(trans('setting.Please select valid two factor authentication method'), trans('common.Warning'));
            return redirect()->back();
        }

        try {
            User::where('id', Auth::id())->update([
                'two_step_verification' => $request->two_step_verification,
                'two_fa_expired_time' => ($request->two_step_verification == 1 || $request->two_step_verification == 3) ? $request->get('two_fa_expired_time', 0) : 0,
            ]);

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (Exception $e) {
            DB::rollBack();
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function courseBadge($user,$id)
    {
        $id =decrypt($id);
        $courseBadge =CourseBadge::with('user','course')->findOrFail($id);
        return view(theme('profile.course-badge'),compact('courseBadge'));
    }
}
