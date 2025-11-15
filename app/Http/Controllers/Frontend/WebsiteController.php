<?php

namespace App\Http\Controllers\Frontend;

use App\AboutPage;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PaymentController;
use App\Jobs\SendGeneralEmail;
use App\LessonComplete;
use App\Subscription;
use App\Traits\GoogleAnalytics4;
use App\Traits\SendNotification;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use DrewM\MailChimp\MailChimp;
use Exception;
use GetResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Modules\BundleSubscription\Entities\BundleCoursePlan;
use Modules\Calendar\Entities\Calendar;
use Modules\Certificate\Entities\Certificate;
use Modules\Certificate\Entities\CertificateRecord;
use Modules\Certificate\Http\Controllers\CertificateController;
use Modules\CertificatePro\Entities\CertificateTemplate;
use Modules\CourseSetting\Entities\Chapter;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\CourseEnrolled;
use Modules\CourseSetting\Entities\CourseLevel;
use Modules\CourseSetting\Entities\Lesson;
use Modules\CourseSetting\Entities\LessonQuestion;
use Modules\Forum\Entities\Forum;
use Modules\FrontendManage\Entities\FrontPage;
use Modules\FrontendManage\Entities\PrivacyPolicy;
use Modules\FrontendManage\Entities\Slider;
use Modules\HLS\Entities\HlsVideo;
use Modules\Localization\Entities\Language;
use Modules\Membership\Http\Controllers\MembershipController;
use Modules\MyClass\Repositories\Interfaces\AddStudentToClassRepositoryInterface;
use Modules\Newsletter\Entities\NewsletterSetting;
use Modules\Newsletter\Http\Controllers\AcelleController;
use Modules\OrgSubscription\Entities\OrgSubscriptionCheckout;
use Modules\Payment\Entities\Cart;
use Modules\Quiz\Entities\OnlineQuiz;
use Modules\Quiz\Entities\QuestionBankMuOption;
use Modules\Quiz\Entities\QuizeSetup;
use Modules\Quiz\Entities\QuizTest;
use Modules\Store\Entities\ProductAttributeValue;
use Modules\Store\Entities\ProductSku;
use Modules\Subscription\Http\Controllers\CourseSubscriptionController;
use Modules\UpcomingCourse\Entities\UpcomingCourseBooking;
use Modules\UpcomingCourse\Entities\UpcomingCourseBookingPayment;
use Modules\VirtualClass\Entities\ClassComplete;
use Modules\VirtualClass\Entities\ClassRecord;
use Modules\VirtualClass\Entities\VirtualClass;

class WebsiteController extends Controller
{
    use GoogleAnalytics4, SendNotification;

    public function __construct()
    {
        $this->middleware(['maintenanceMode']);
        $this->middleware(['onlyAppMode'])->except('frontPage', 'privacy');
    }


    public function aboutData()
    {
        try {
            if (hasDynamicPage()) {
                $row = FrontPage::where('slug', '/about-us')->first();
                $details = dynamicContentAppend($row->details);
                return view('aorapagebuilder::pages.show', compact('row', 'details'));
            } else {
                $about = AboutPage::first();
                return view(theme('pages.about'), compact('about'));
            }
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function ajaxCounterCity(Request $request)
    {
        try {
            $cities = DB::table('spn_cities')->select('id', 'name')->where('name', 'like', '%' . $request->search . '%')->where('state_id', '=', $request->id)->paginate(10);

            $response = [];
            foreach ($cities as $item) {
                $response[] = [
                    'id' => $item->id,
                    'text' => $item->name
                ];
            }
            if (count($response) == 0) {
                $data['pagination'] = ["more" => false];
            } else {
                $data['pagination'] = ["more" => true];
            }
            $data['results'] = $response;
            return response()->json($data);
        } catch (Exception $e) {
            return response()->json("", 404);
        }
    }

    public function ajaxCounterState(Request $request)
    {
        try {
            $states = DB::table('states')->select('id', 'name')->where('name', 'like', '%' . $request->search . '%')->where('country_id', '=', $request->id)->paginate(10);

            $response = [];
            foreach ($states as $item) {
                $response[] = [
                    'id' => $item->id,
                    'text' => $item->name
                ];
            }
            $data['results'] = $response;
            if (count($response) == 0) {
                $data['pagination'] = ["more" => false];
            } else {
                $data['pagination'] = ["more" => true];
            }
            return response()->json($data);
        } catch (Exception $e) {
            return response()->json("", 404);
        }
    }

    public function searchCertificate(Request $request)
    {

        try {
            if (hasDynamicPage()) {
                $row = FrontPage::where('slug', 'certificate-verification')->first();
                $details = dynamicContentAppend($row->details);
                return view('aorapagebuilder::pages.show', compact('row', 'details'));
            } else {
                return view(theme('pages.searchCertificate'));
            }

        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }


    }

    public function showCertificate(Request $request)
    {
        try {
            $certificate_record = CertificateRecord::where('certificate_id', $request->certificate_number)->first();
            if ($certificate_record) {
                $course = Course::findOrFail($certificate_record->course_id);

                if ($course->certificate_id != null) {
                    $certificate = Certificate::findOrFail($course->certificate_id);
                } else {
                    if ($course->type == 1) {
                        $certificate = Certificate::where('for_course', 1)->first();
                    } else {
                        $certificate = Certificate::where('for_quiz', 1)->first();
                    }
                }

                if (!$certificate) {
                    Toastr::error(trans('certificate.Certificate Not Found'), trans('common.Failed'));
                    return back();
                }


                $title = $certificate_record->certificate_id . ".jpg";

                $downloadFile = new CertificateController();

                $request->certificate_id = $certificate_record->certificate_id;
                $request->course = $course;
                $request->user = User::find($certificate_record->student_id);
                $certificate = $downloadFile->makeCertificate($certificate->id, $request)['image'] ?? '';


                if ($certificate){
                    $certificate  = $certificate->toPng()->toDataUri();
                }

                return view(theme('pages.searchCertificate'), compact('certificate'));
            } else {
                return Redirect::back()->withErrors([trans('frontend.Invalid Certificate Number')]);
            }


        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function certificateCheck($certificate_number, Request $request)
    {
        try {
            $certificate_record = CertificateRecord::where('certificate_id', $certificate_number)->first();
            $course = Course::findOrFail($certificate_record->course_id);
            if (!hasCourseValidAccess($course)) {
                return redirect()->back();
            }
            if ($course->certificate_id != null) {
                $certificate = Certificate::findOrFail($course->certificate_id);
            } else {
                if ($course->type == 1) {
                    $certificate = Certificate::where('for_course', 1)->first();
                } else {
                    $certificate = Certificate::where('for_quiz', 1)->first();
                }
            }
            if (!$certificate) {
                Toastr::error(trans('certificate.Right Now You Cannot Download The Certificate'), trans('common.Failed'));
                return back();
            }


            $title = $certificate_number . ".jpg";

            $downloadFile = new CertificateController();

            $request->certificate_id = $certificate_record->certificate_id;
            $request->course = $course;
            $request->completed_at = $certificate_record->created_at;
            $request->user = User::find($certificate_record->student_id);
            $certificate = $downloadFile->makeCertificate($certificate->id, $request)['image'] ?? '';


            if ($certificate == null) {
                Toastr::error(trans('frontend.Invalid Certificate Number'), trans('common.Failed'));
                return redirect()->back();
            }
            $certificate = $certificate->toPng()->toDataUri();

            return view(theme('pages.searchCertificate'), compact('certificate'));
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function certificateDownload($certificate_number, Request $request)
    {
        try {

            if (isModuleActive('CertificatePro') && Settings('use_certificate_template') == 'pro') {
                $certificate_record = CertificateRecord::where('certificate_id', $certificate_number)->first();
                $course = Course::findOrFail($certificate_record->course_id);
                if (!empty($course->pro_certificate_id)) {
                    $certificate = CertificateTemplate::find($course->pro_certificate_id);

                } else {
                    if ($course->type == 1) {
                        $certificate = CertificateTemplate::where('default_for', 'c')->first();
                    } elseif ($course->type == 2) {
                        $certificate = CertificateTemplate::where('default_for', 'q')->first();
                    } elseif ($course->type == 3) {
                        $certificate = CertificateTemplate::where('default_for', 'l')->first();
                    } else {
                        $certificate = null;
                    }
                }
                if (!hasCourseValidAccess($course)) {
                    return redirect()->back();
                }
                if (!$certificate) {
                    Toastr::error(trans('frontend.Certificate Not Found'), trans('common.Failed'));
                    return back();
                } else {
                    if (!$course->isLoginUserEnrolled) {
                        Toastr::error(trans('certificate.You Are Not Already Enrolled This course. Please Enroll It First'), trans('common.Failed'));
                        return back();
                    }
                    if ($course->type == 1) {
                        $percentage = round($course->loginUserTotalPercentage);
                        if ($percentage < 100) {
                            Toastr::error(trans('certificate.Please Complete The Course First'), trans('common.Failed'));
                            return back();
                        }
                    } elseif ($course->type == 2) {
                        $quiz = QuizTest::where('course_id', $course->id)->where('pass', 1)->first();
                        if (!$quiz) {
                            Toastr::error(trans('certificate.You must pass the quiz'), trans('common.Failed'));
                            return back();
                        }
                    } else {
                        $certificateCanDownload = false;
                        $totalClass = $course->class->total_class;
                        $completeClass = ClassComplete::where('user_id', Auth::id())->where('course_id', $course->id)->where('class_id', $course->class->id)->count();
                        if ($totalClass == $completeClass) {
                            $hasCertificate = $course->pro_certificate_id;
                            if (!empty($hasCertificate)) {
                                $certificate = CertificateTemplate::find($hasCertificate);
                                if ($certificate) {
                                    $certificateCanDownload = true;
                                }
                            } else {
                                $certificate = CertificateTemplate::where('default_for', 'l')->first();
                                if ($certificate) {
                                    $certificateCanDownload = true;
                                }
                            }
                        }
                        if (!$certificateCanDownload) {
                            Toastr::error(trans('certificate.You must attend live class'), trans('common.Failed'));
                            return back();
                        }
                    }

                    $certificate_record = CertificateRecord::where('student_id', Auth::user()->id)->where('course_id', $course->id)->first();
                    $websiteController = new WebsiteController();
                    $percentage = round($course->loginUserTotalPercentage);
                    if (!$certificate_record && $percentage >= 100) {
                        $certificate_record = new CertificateRecord();
                        $certificate_record->certificate_id = $websiteController->generateUniqueCode();
                        $certificate_record->student_id = Auth::user()->id;
                        $certificate_record->course_id = $course->id;
                        $certificate_record->created_by = Auth::user()->id;
                        $certificate_record->save();
                    }
                    return redirect()->route('certificate_pro.student_certificate', [$certificate->id, 'course' => $course->id, 'c_id' => $certificate_record->certificate_id, 'u_id' => Auth::id()]);
                }

            }

            $certificate_record = CertificateRecord::where('certificate_id', $certificate_number)->first();
            $course = Course::findOrFail($certificate_record->course_id);
            if (!hasCourseValidAccess($course)) {
                return redirect()->back();
            }
            if ($course->certificate_id != null) {
                $certificate = Certificate::findOrFail($course->certificate_id);
            } else {
                if ($course->type == 1) {
                    $certificate = Certificate::where('for_course', 1)->first();
                } elseif ($course->type == 2) {
                    $certificate = Certificate::where('for_quiz', 1)->first();
                } elseif ($course->type == 3) {
                    $certificate = Certificate::where('for_class', 1)->first();
                } else {
                    $certificate = null;
                }
            }


            if (!$certificate) {
                Toastr::error(trans('certificate.Right Now You Cannot Download The Certificate'), trans('common.Failed'));
                return back();
            }


            $title = $certificate_number . ".jpg";

            $downloadFile = new CertificateController();

            $request->certificate_id = $certificate_record->certificate_id;
            $request->course = $course;
            $request->user = User::find($certificate_record->student_id);
            $certificate = $downloadFile->makeCertificate($certificate->id, $request)['image'] ?? '';

            if (!$certificate){
                return  '';
            }

            $certificate= $certificate->toJpeg();
            $headers = [
                'Content-Type' => 'image/jpeg',
                'Content-Disposition' => 'attachment; filename=' . $title,
            ];
            return response()->stream(function () use ($certificate) {
                echo $certificate;
            }, 200, $headers);



        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function generateUniqueCode()
    {
        do {
            $referal_code = random_int(100000, 999999);
        } while (CertificateRecord::where("certificate_id", "=", $referal_code)->first());

        return $referal_code;
    }

    public function privacy()
    {
        try {
            if (hasDynamicPage()) {
                $row = FrontPage::where('slug', '/privacy')->first();
                $details = dynamicContentAppend($row->details);
                return view('aorapagebuilder::pages.show', compact('row', 'details'));
            } else {
                $privacy_policy = PrivacyPolicy::getData();
                return view(theme('pages.privacy'), compact('privacy_policy'));
            }
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());

        }
    }


    public function fullScreenView(Request $request, $course_id, $lesson_id)
    {


        $course = Course::find($course_id);


        $lesson = Lesson::where('id', $lesson_id)->first();

        if (!$course || !$lesson) {
            abort('404');
        }
        try {

            $returnUrl =courseDetailsUrl($course->id,$course->type,$course->slug);

            if (isModuleActive('Installment')) {

                if (Settings('installment_disable_all_course') == 1 && \auth()->check() && auth()->user()->installment_eligibility == 0) {
                    Toastr::warning(_trans('installment.You have to pay the installment amount to access any course'));
                    return redirect()->to($returnUrl);
                }

                if (Settings('installment_disable_course') == 1 && \auth()->check() && auth()->user()->installment_eligibility == 0 && auth()->user()->installment_due_course == $course_id) {
                    Toastr::warning(_trans('installment.You have to pay the installment amount to access this course'));
                    return redirect()->to($returnUrl);
                }

            }


            updateEnrolledCourseLastView($course_id);

            if (isModuleActive('OrgSubscription') && Auth::check()) {
                if (!orgSubscriptionCourseValidity($course_id)) {
                    Toastr::warning(trans('org-subscription.Your Subscription Expire'));
                    return redirect()->to($returnUrl);
                }
            }
            if (isModuleActive('OrgSubscription') && Auth::check()) {
                if (!orgSubscriptionCourseSequence($course_id)) {
                    Toastr::warning(trans('org-subscription.You Can Not Continue This . Pls Complete Previous Course'));
                    return redirect()->to($returnUrl);
                }
            }
            if (isModuleActive('BundleSubscription')) {
                if (isBundleExpire($course_id)) {
                    Toastr::error(trans('frontend.Your bundle validity expired'), trans('common.Failed'));
                    return redirect()->to($returnUrl);
                }
            }
            if (isModuleActive('Subscription')) {
                if (Auth::check() && !isSubscriptionExpire()) {
                    Toastr::error(trans('frontend.Your subscription validity expired'), trans('common.Failed'));
                    return redirect()->to($returnUrl);
                }
            }

            $result = [];
            $preResult = [];

            $alreadyJoin = 0;
            if (isset($request->quiz_result_id)) {
                $quizTest = QuizTest::findOrFail($request->quiz_result_id);

                if (Auth::check()) {
                    $user = Auth::user();
                    $all = QuizTest::with('details')->where('quiz_id', $quizTest->quiz_id)->where('course_id', $course_id)->where('user_id', $user->id)->get();
                } else {
                    Toastr::error(trans('frontend.You must login for continue'), trans('common.Failed'));
                    return redirect()->to($returnUrl);
                }

                if (count($all) != 0) {
                    $alreadyJoin = 1;
                }

                foreach ($all as $key => $i) {
                    $onlineQuiz = OnlineQuiz::find($i->quiz_id);
                    $date = showDate($i->created_at);
                    $totalQus = totalQuizQus($i->quiz_id);
                    $totalAns = count($i->details);
                    $totalCorrect = 0;
                    $totalScore = totalQuizMarks($i->quiz_id);
                    $score = 0;
                    if ($totalAns != 0) {
                        foreach ($i->details as $test) {
                            if ($test->status == 1) {
                                $score += $test->mark ?? 1;
                                $totalCorrect++;
                            }

                        }
                    }

                    if ($request->quiz_result_id == $i->id) {

                        $result['start_at'] = $i->start_at;
                        $result['end_at'] = $i->end_at;
                        $result['publish'] = $i->publish;
                        $result['duration'] = $i->duration;
                        $result['totalQus'] = $totalQus;
                        $result['totalAns'] = $totalAns;
                        $result['totalCorrect'] = $totalCorrect;
                        $result['totalWrong'] = $totalAns - $totalCorrect;
                        $result['score'] = $score;
                        $result['totalScore'] = $totalScore;
                        $result['passMark'] = $onlineQuiz->percentage ?? 0;
                        $result['mark'] = $score > 0 ? round($score / $totalScore * 100, 2) : 0;
                        $result['status'] = $result['mark'] >= $result['passMark'] ? "Passed" : "Failed";
                        $result['text_color'] = $result['mark'] >= $result['passMark'] ? "success_text" : "error_text";
                        $i->pass = $result['mark'] >= $result['passMark'] ? "1" : "0";
                        $i->save();
                    } else {
                        $preResult[$key]['quiz_test_id'] = $i->id;
                        $preResult[$key]['totalQus'] = $totalQus;
                        $preResult[$key]['date'] = $date;
                        $preResult[$key]['totalAns'] = $totalAns;
                        $preResult[$key]['totalCorrect'] = $totalCorrect;
                        $preResult[$key]['totalWrong'] = $totalAns - $totalCorrect;
                        $preResult[$key]['score'] = $score;
                        $preResult[$key]['totalScore'] = $totalScore;
                        $preResult[$key]['passMark'] = $onlineQuiz->percentage ?? 0;
                        $preResult[$key]['mark'] = $score > 0 ? round($score / $totalScore * 100, 2) : 0;
                        $preResult[$key]['status'] = $preResult[$key]['mark'] >= $preResult[$key]['passMark'] ? "Passed" : "Failed";
                        $preResult[$key]['text_color'] = $preResult[$key]['mark'] >= $preResult[$key]['passMark'] ? "success_text" : "error_text";
                        $i->pass = $preResult[$key]['mark'] >= $preResult[$key]['passMark'] ? "1" : "0";
                        $i->save();
                    }

                    $check = Lesson::where('course_id', $i->course_id)->where('quiz_id', $i->quiz_id)->first();
                    if ($check && $i->pass == 1) {
                        $lessonComplete = LessonComplete::where('course_id', $i->course_id)->where('lesson_id', $check->id)->where('user_id', Auth::id())->first();
                        if (!$lessonComplete) {
                            checkGamification('each_unit_complete', 'learning');
                            $lessonComplete = new LessonComplete();
                            $lessonComplete->user_id = Auth::id();
                            $lessonComplete->course_id = $i->course_id;
                            $lessonComplete->lesson_id = $check->id;
                        }
                        $lessonComplete->status = 1;
                        $lessonComplete->save();
                    }


                }
            }

            if (isModuleActive('HLS') && $lesson->host == 'm3u8') {

                $extractId = extractId($lesson->video_url);
                if ($extractId) {
                    $m3Video = HlsVideo::where([
                        'id' => $extractId
                    ])->first();
                } else {
                    $m3Links = explode('/', $lesson->video_url);
                    $total = count($m3Links);
                    $m3Video = HlsVideo::where([
                        'playlist' => $m3Links[$total - 1] ?? '',
                        'id' => $m3Links[$total - 2] ?? 0,
                    ])->first();
                }


                if ($m3Video) {
                    $lesson->video_url = $m3Video->live_path;
                }
            }
            //$lesson->is_lock;
            $isEnrolled = false;

            if ($lesson->is_lock == 1) {
                if (!Auth::check()) {
                    Toastr::error(trans('frontend.You are not enrolled for this course'), trans('common.Failed'));
                    return redirect()->to($returnUrl);
                } else {
                    if (isModuleActive('Membership')) {
                        $membershipRepo = new MembershipController();
                        $enrollForMembership = $membershipRepo->hasEnrolled($course->id, auth()->id());
                    } else {
                        $enrollForMembership = false;

                    }

                    if (!$course->isLoginUserEnrolled && !$enrollForMembership) {
                        Toastr::error(trans('frontend.You are not enrolled for this course'), trans('common.Failed'));
                        return redirect()->to($returnUrl);
                    } else {
                        $isEnrolled = true;
                    }
                }

            } else {
                $isEnrolled = true;
            }
            $certificate = $course->certificate;

            if (!$certificate) {
                if ($course->type == 1) {
                    $certificate = Certificate::where('for_course', 1)->first();
                } else {
                    $certificate = Certificate::where('for_quiz', 1)->first();
                }
            }

            if (!hasCourseValidAccess($course)) {
                return redirect()->to($returnUrl);
            }

            //drop content  start

            $today = Carbon::now()->toDateString();
            $showDrip = Settings('show_drip') ?? 0;
            $all = Lesson::where('course_id', $course->id)->with('completed')->orderBy('position', 'asc')->get();

            $lessons = [];
            if ($course->drip == 1) {
                if ($showDrip == 1) {
                    foreach ($all as $key => $data) {
                        $show = false;
                        $unlock_date = $data->unlock_date;
                        $unlock_days = $data->unlock_days;

                        if (!empty($unlock_days) || !empty($unlock_date)) {

                            if (!empty($unlock_date)) {
                                if (strtotime($unlock_date) == strtotime($today)) {
                                    $show = true;
                                }
                            }
                            if (!empty($unlock_days)) {
                                if (Auth::check()) {
                                    $enrolled = DB::table('course_enrolleds')->where('user_id', Auth::user()->id)->where('course_id', $course->id)->where('status', 1)->first();
                                    if (!empty($enrolled)) {
                                        $unlock = Carbon::parse($enrolled->created_at);
                                        $unlock->addDays($data->unlock_days);
                                        $unlock = $unlock->toDateString();

                                        if (strtotime($unlock) <= strtotime($today)) {
                                            $show = true;
                                        }
                                    }

                                }
                            }

                            if ($show) {
                                $lessons[] = $data;
                            }
                        } else {
                            $lessons[] = $data;
                        }


                    }


                } else {
                    $lessons = $all;
                }
            } else {
                $lessons = $all;
            }

            $total = count($lessons);
            // drop content end

            if ($course->drip != 0) {
                $lessonShow = false;
                $unlock_lesson_date = $lesson->unlock_date;
                $unlock_lesson_days = $lesson->unlock_days;
                if (!empty($unlock_lesson_days) || !empty($unlock_lesson_date)) {
                    if (!empty($unlock_lesson_date)) {
                        if (strtotime($unlock_lesson_date) <= strtotime($today)) {
                            $lessonShow = true;
                        }

                    }

                    if (!empty($unlock_lesson_days)) {
                        if (!Auth::check()) {
                            $lessonShow = false;
                        } else {
                            $enrolled = DB::table('course_enrolleds')->where('user_id', Auth::user()->id)->where('course_id', $course_id)->where('status', 1)->first();
                            if (!empty($enrolled)) {
                                $unlock_lesson = Carbon::parse($enrolled->created_at);
                                $unlock_lesson->addDays($lesson->unlock_days);
                                $unlock_lesson = $unlock_lesson->toDateString();

                                if (strtotime($unlock_lesson) <= strtotime($today)) {
                                    $lessonShow = true;

                                }
                            }
                        }

                    }
                } else {
                    $lessonShow = true;
                }
                if (Auth::check() && Auth::user()->role_id == 1) {
                    $lessonShow = true;
                }

                if (!$lessonShow) {
                    Toastr::error(trans('frontend.Lesson currently unavailable'), trans('common.Failed'));
                    return redirect()->to($returnUrl);
                }
            }


            $percentage = round($course->loginUserTotalPercentage);

            $course_reviews = DB::table('course_reveiws')->select('user_id')
                ->where('status',1)
                ->where('course_id', $course->id)->get();

            $reviewer_user_ids = [];
            foreach ($course_reviews as $key => $review) {
                $reviewer_user_ids[] = $review->user_id;
            }
            $chapters = Chapter::where('course_id', $course->id)->orderBy('position', 'asc')->get();
            $quizSetup = QuizeSetup::getData();

            if ($lesson->host == "VdoCipher") {
                $otp = $this->getOTPForVdoCipher($lesson->video_url);
                $lesson->otp = $otp['otp'];
                $lesson->playbackInfo = $otp['playbackInfo'];
            }


            $isAdmin = false;
            if (Auth::check()) {
                if (Auth::user()->role_id == 1) {
                    $isAdmin = true;
                }
            }
            $lesson_ids = [];

            foreach ($chapters as $c) {
                foreach ($all as $item) {
                    if ($c->id == $item->chapter_id) {
                        $lesson_ids[] = $item->id;

                    }
                }
            }
            if (!$isAdmin) {
                if ($course->complete_order == 1) {
                    if (!Auth::check()) {
                        Toastr::error(trans('frontend.You must login for continue'), trans('common.Failed'));
                        return redirect()->to($returnUrl);
                    }

                    $index = array_search($lesson_id, $lesson_ids);


                    $previous = $lesson_ids[$index - 1] ?? null;

                    if ($previous) {
                        $isComplete = DB::table('lesson_completes')->where(function ($q) use($lesson_id,$previous){
                            $q->where('lesson_id', $previous)->orWhere('lesson_id', $lesson_id);
                        })->where('user_id', Auth::id())->select('status')->first();

                        if (!$isComplete || $isComplete->status != 1) {
                            Toastr::error(trans('frontend.At First, You need to complete previous lesson'), trans('Failed'));
                            return redirect()->to($returnUrl);
                        }
                    }
                }
            }

            $quizPass = true;
            if (Auth::check()) {
                $hasQuiz = QuizTest::select('quiz_id')->where('course_id', $course->id)->where('user_id', Auth::user()->id)->groupBy('quiz_id')->get();
                $hasPassQuiz = QuizTest::select('quiz_id')->where('course_id', $course->id)->where('user_id', Auth::user()->id)->where('pass', 1)->groupBy('quiz_id')->get();

                if (count($hasQuiz) != count($hasPassQuiz)) {
                    $quizPass = false;
                }
            }

            if (isModuleActive('Org')) {
                if (!empty($lesson->org_material_id)) {
                    $default = $lesson->orgMaterial->default;
                    $lesson->video_url = $default->link;
                    $lesson->host = $default->type;
                }
            }

            $data = [];
            if (isModuleActive('Org') && isModuleActive('Forum')) {
                $query = Forum::where('forums.topic_type', 1)
                    ->where('forums.course_id', $course_id)
                    ->where('forums.parent_id', 0)
                    ->where(function ($q) {
                        $q->whereHas('course', function ($q2) {
                            $q2->where('status', 1);
                        });
                        $q->orWhereHas('path', function ($q3) {
                            $q3->where('status', 1);
                        });
                    })
                    ->whereNull('forums.deleted_at')
                    ->with('course', 'course.category', 'course.user')
                    ->withCount('threads', 'views', 'replies', 'likes')
                    ->orderBy('pin', 'desc');


                $filter = $request->filter;
                $menu = $request->menu;
                $data['topics'] = $query->first();
            }
            $data['lesson_questions'] = LessonQuestion::where('lesson_id', $lesson->id)->where('course_id', $course_id)->where('parent_id', 0)->where('status', 1)->with(['course', 'lesson', 'user'])->get();
            return view(theme('pages.fullscreen_video'), $data, compact('quizPass', 'alreadyJoin', 'lesson_ids', 'result', 'preResult', 'quizSetup', 'chapters', 'reviewer_user_ids', 'percentage', 'isEnrolled', 'total', 'certificate', 'course', 'lesson', 'lessons'));

        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function getOTPForVdoCipher($video_id)
    {
        $data['otp'] = '';
        $data['playbackInfo'] = '';

        try {
            $url = "https://dev.vdocipher.com/api/videos/" . $video_id . "/otp";

            $curl = curl_init();
            $header = array(
                "Accept: application/json",
                "Authorization:Apisecret " . saasEnv('VDOCIPHER_API_SECRET'),
                "Content-Type: application/json"
            );

            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode([
                    "ttl" => 300,
                ]),
                CURLOPT_HTTPHEADER => $header,
            ));

            $response = json_decode(curl_exec($curl));
            $err = curl_error($curl);

            curl_close($curl);

            if (!$err) {
                $data['otp'] = $response->otp;
                $data['playbackInfo'] = $response->playbackInfo;
            }
        } catch (Exception $e) {

        }
        return $data;
    }


    public function subscribe(Request $request)
    {

        if (demoCheck()) {
            return redirect()->back();
        }

        $validate_rules = [
            'email' => 'required|email',
        ];


        $request->validate($validate_rules, validationMessage($validate_rules));


        try {
            if (!hasTable('newsletter_settings')) {

                $check = Subscription::where('email', '=', $request->email)->first();
                if (empty($check)) {
                    $subscribe = new Subscription();
                    $subscribe->email = $request->email;
                    $subscribe->save();

                    Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                } else {
                    Toastr::error(trans('frontend.Already subscribe'), trans('common.Failed'));
                }
            } else {
                $newsletterSetting = NewsletterSetting::getData();
                if ($newsletterSetting->home_service == "Local") {

                    $check = Subscription::where('email', '=', $request->email)->first();

                    if (empty($check)) {
                        $subscribe = new Subscription();
                        $subscribe->email = $request->email;
                        $subscribe->type = 'Homepage';
                        $subscribe->save();

                        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                    } else {
                        Toastr::error(trans('frontend.Already subscribe'), trans('common.Failed'));
                    }
                    return Redirect::back();

                } elseif ($newsletterSetting->home_service == "Mailchimp") {
                    if (saasEnv('MailChimp_Status') == "true") {
                        $list = $newsletterSetting->home_list_id;
                        $MailChimp = new MailChimp(saasEnv('MailChimp_API'));
                        $result = $MailChimp->post("lists/$list/members", [
                            'email_address' => $request->email,
                            'status' => 'subscribed',
                        ]);
                        if ($MailChimp->success()) {
                            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                            return Redirect::back();
                        } else {
                            Toastr::error(json_decode($MailChimp->getLastResponse()['body'], TRUE)['title'] ?? 'Something Went Wrong', trans('common.Failed'));
                            return Redirect::back();
                        }
                    }
                } elseif ($newsletterSetting->home_service == "GetResponse") {
                    if (saasEnv('GET_RESPONSE_STATUS') == "true") {
                        $list = $newsletterSetting->home_list_id;
                        $getResponse = new GetResponse(saasEnv('GET_RESPONSE_API'));

                        $callback = $getResponse->addContact(array(
                            'email' => $request->email,
                            'campaign' => array('campaignId' => $list),

                        ));


                        if (empty($callback)) {
                            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                            return Redirect::back();
                        } else {
                            Toastr::error($callback->message ?? 'Something Went Wrong', trans('common.Failed'));
                            return Redirect::back();
                        }
                    }
                } elseif ($newsletterSetting->home_service == "Acelle") {
                    if (saasEnv('ACELLE_STATUS') == "true") {

                        $list = $newsletterSetting->home_list_id;
                        $email = $request->email;
                        $make_action_url = '/subscribers?list_uid=' . $list . '&EMAIL=' . $email;
                        $acelleController = new AcelleController();
                        $response = $acelleController->curlPostRequest($make_action_url);

                        if ($response) {
                            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                            return Redirect::back();
                        } else {
                            Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Failed'));
                            return Redirect::back();
                        }
                    }
                }
                Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Failed'));
            }


            return Redirect::back();
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }

    }


    public function myCart()
    {
        $checkout = request()->checkout;
        if ($checkout) {
            if (Auth::check()) {
                return \redirect(route('CheckOut'));
            } else {
                session(['redirectTo' => route('CheckOut')]);
                return \redirect(route('login'));
            }
        }
        try {
            if (Auth::check()) {
                return view(theme('pages.myCart'));
            } else {
                return view(theme('pages.myCart2'));
            }


        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }

    }

    public function buyNow($id, $qty = 1)

    {
        try {
//            if (!Auth::check()) {
//                Toastr::error('You must login', 'Error');
//                return \redirect()->route('login');
//            }
            $course = Course::find($id);

            if (!$course) {
                Toastr::error(trans('frontend.Course not found'), trans('common.Failed'));
                return redirect()->back();
            }
            if ($course->discount_price > 0) {
                $price = $course->discount_price;
            } else {
                $price = $course->price;
            }
            if (hasCouponApply($course->id)){
                $course->price =$price=getCouponPrice($course->id);
            }

            if (isModuleActive('Store') && $course->type == 5) {
                if ($course->product->type == 2 && $course->product->has_variant) {
                    Toastr::info(trans('frontend.Please Select Variant'), trans('common.Info'));
                    return redirect()->route('productDetailsView', $course->slug);
                }
                if ($course->product->stock_manage == 1 && $course->product->stock_quantity == 0) {
                    Toastr::error(trans('frontend.Out of Stock'), trans('common.Failed'));
                    return redirect()->back();
                }
            }

            if (@$course->isLoginUserEnrolled) {
                if ($course->type == 5) {
                    Toastr::error(trans('product.Product already enrolled'), trans('common.Failed'));
                } else {
                    Toastr::error(trans('frontend.Course already enrolled'), trans('common.Failed'));
                }

                return redirect()->back();
            }
            if (isModuleActive('Org')) {
                $type = $course->required_type;
                if ($type == 1) {
                    Toastr::error(trans('org.Unable to add cart'), trans('common.Failed'));
                    return redirect()->back();
                }
            }
            if ($course->type == 3 && $course->class->capacity && $course->total_enrolled >= $course->class->capacity) {
                Toastr::error(trans('virtual-class.Enrollment limit for this course has been reached'), trans('common.Failed'));
                return redirect()->back();
            }


            $user = Auth::user();


            if (Auth::check() && ($user->role_id != 1)) {

                $exist = Cart::where('user_id', $user->id)->where('course_id', $id)->first();
                $oldCart = Cart::where('user_id', $user->id)->when(isModuleActive('Appointment'), function ($query) {
                    $query->whereNotNull('course_id');
                })->first();

                if (isset($exist)) {
                    Toastr::error(trans('frontend.Course already added in your cart'), trans('common.Failed'));

                    return redirect()->route('CheckOut');
                } elseif (Auth::check() && ($user->role_id == 1)) {
                    Toastr::error(trans('frontend.You logged in as admin so can not add cart'), trans('common.Failed'));
                    return redirect()->back();
                } else {

                    if (isModuleActive('EarlyBird')) {
                        $early_bird_price = verifyEarlybirdOffer($course, auth()->user()->id);
                    }

                    if (isset($oldCart)) {

                        $cart = new Cart();
                        $cart->user_id = $user->id;
                        $cart->instructor_id = $course->user_id;
                        $cart->course_id = $id;
                        $cart->tracking = $oldCart->tracking;
                        if ($course->discount_price != null) {
                            $cart->price = $course->discount_price;
                        } else {
                            $cart->price = $course->price;
                        }

                        if (isModuleActive('Store')) {
                            $cart->qty = $qty;
                            $cart->is_store = $course->type == 5;
                        }

                        if (isModuleActive('EarlyBird')) {
                            $cart->price = $early_bird_price['price'];
                            $cart->is_earlybird_offer = 1;
                            $cart->price_plan_id = $early_bird_price['price_plan_id'];
                        }
                        if (isModuleActive('UpcomingCourse') && $course->is_upcoming_course && $course->is_allow_prebooking) {
                            $pre_booking = UpcomingCourseBooking::where('course_id', $course->id)->where('user_id', $user->id)->first();

                            if ($pre_booking) {
                                $pre_booking_amount = UpcomingCourseBookingPayment::where('booking_id', $pre_booking->id)->sum('amount');
                                $cart->pre_booking_amount = $pre_booking_amount;

                            }
                        }

                        if (isModuleActive('UserGroup') && $user->userGroup && $user->userGroup->group->status && $user->userGroup->group->discount) {
                            $cart->group_discount = number_format(($cart->price * $user->userGroup->group->discount) / 100, 2);
                        }

                        $cart->save();

                    } else {
                        $cart = new Cart();
                        $cart->user_id = $user->id;
                        $cart->instructor_id = $course->user_id;
                        $cart->course_id = $id;
                        $cart->tracking = getTrx();
                        if ($course->discount_price != null) {
                            $cart->price = $course->discount_price;
                        } else {
                            $cart->price = $course->price;
                        }

                        if (isModuleActive('Store')) {
                            $cart->qty = $qty;
                            $cart->is_store = $course->type == 5;
                        }

                        if (isModuleActive('EarlyBird')) {
                            $cart->price = $early_bird_price['price'];
                            $cart->is_earlybird_offer = 1;
                            $cart->price_plan_id = $early_bird_price['price_plan_id'];
                        }
                        if (isModuleActive('UpcomingCourse') && $course->is_upcoming_course && $course->is_allow_prebooking) {
                            $pre_booking = UpcomingCourseBooking::where('course_id', $course->id)->where('user_id', $user->id)->first();

                            if ($pre_booking) {
                                $pre_booking_amount = UpcomingCourseBookingPayment::where('booking_id', $pre_booking->id)->sum('amount');
                                $cart->pre_booking_amount = $pre_booking_amount;

                            }

                        }

                        if (isModuleActive('UserGroup') && $user->userGroup && $user->userGroup->group->status && $user->userGroup->group->discount) {
                            $cart->group_discount = number_format(($cart->price * $user->userGroup->group->discount) / 100, 2);
                        }


                        if (hasCouponApply($course->id)) {
                            $cart->price = getCouponPrice($course->id);
                        }
                        $cart->save();
                    }
                    if ($cart->price == 0) {
                        $paymentController = new PaymentController();
                        if ($cart->course->type == 5) {
                            $paymentController->directProductEnroll($cart, $cart->tracking);
                            Toastr::success(trans('product.Product enrolled successfully'), trans('common.Success'));
                            return redirect()->back();
                        } else {
                            $paymentController->directEnroll($cart->course_id, $cart->tracking);
                        }

                    }

                    $this->postEvent([
                        'name' => 'add_to_cart',
                        'params' => [
                            "items" => [
                                [
                                    "item_id" => $course->id,
                                    "item_name" => $course->title,
                                    "price" => $cart->price
                                ]
                            ],
                        ],
                    ]);

                    Toastr::success(trans('frontend.Item Added to your cart'), trans('common.Success'));
                    return redirect()->route('CheckOut')->with('back', courseDetailsUrl(@$course->id, @$course->type, @$course->slug));
                }

            } //If user not logged in then cart added into session

            else {




                $cart = session()->get('cart');
                if (!$cart) {
                    $cart = [
                        $id => [
                            "id" => $course->id,
                            "course_id" => $course->id,
                            "instructor_id" => $course->user_id,
                            "instructor_name" => $course->user->name,
                            "title" => $course->title,
                            "image" => $course->image,
                            "slug" => $course->slug,
                            "type" => $course->type,
                            "price" => $price,
                            "qty" => $qty,
                            "is_store" => $course->type == 5
                        ]
                    ];
                    session()->put('cart', $cart);
                    Toastr::success(trans('frontend.Item Added to your cart'), trans('common.Success'));
                    return redirect()->route('CheckOut');
                } elseif (isset($cart[$id])) {
                    Toastr::error(trans('frontend.Course already added in your cart'), trans('common.Failed'));
                    return redirect()->route('CheckOut');
                } else {

                    $cart[$id] = [

                        "id" => $course->id,
                        "course_id" => $course->id,
                        "instructor_id" => $course->user_id,
                        "instructor_name" => $course->user->name,
                        "title" => $course->title,
                        "image" => $course->image,
                        "slug" => $course->slug,
                        "type" => $course->type,
                        "price" => $price,
                        "qty" => $qty,
                        "is_store" => $course->type == 5

                    ];

                    session()->put('cart', $cart);


                    $this->postEvent([
                        'name' => 'add_to_cart',
                        'params' => [
                            "items" => [
                                [
                                    "item_id" => $course->id,
                                    "item_name" => $course->title,
                                    "price" => $price
                                ]
                            ],
                        ],
                    ]);

                    Toastr::success(trans('frontend.Item Added to your cart'), trans('common.Success'));
                    return redirect()->route('CheckOut');

                }


            }
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function removeItem($id)
    {
        try {
            $success = trans('lang.Cart has been Removed Successfully');
            if (Auth::check()) {

                $item = Cart::find($id);

                $this->postEvent([
                    'name' => 'remove_from_cart',
                    'params' => [
                        "items" => [
                            [
                                "item_id" => $item->course_id,
                                "item_name" => $item->course?->title,
                                "price" => $item->price
                            ]
                        ],
                    ],
                ]);
                if ($item) {
                    $item->delete();
                }
                Toastr::success(trans('frontend.Course removed from your cart'), trans('common.Success'));
                return redirect()->back();
            } else {

                $cart = session()->get('cart');

                if (isset($cart[$id])) {
                    if (count($cart) == 1) {
                        unset($cart[$id]);
                        session()->forget('cart');
                    } else {
                        unset($cart[$id]);
                    }
                    $this->postEvent([
                        'name' => 'remove_from_cart',
                        'params' => [
                            "items" => $cart,
                        ],
                    ]);

                    session()->put('cart', $cart);
                    Toastr::success(trans('frontend.Course removed from your cart'), trans('common.Success'));
                    return redirect()->back();
                }
            }
            return redirect()->back();
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function removeItemAjax($id)
    {
        try {

            if (Auth::check()) {

                $item = Cart::find($id);

                if ($item) {
                    if (isModuleActive('Gift') && $item->is_gift == 1) {
                        $item->cart_gift->delete();
                    }

                    $item->delete();
                }
                return true;
            } else {

                $cart = session()->get('cart');

                if (isset($cart[$id])) {
                    if (count($cart) == 1) {
                        unset($cart[$id]);
                        session()->forget('cart');
                    } else {
                        unset($cart[$id]);
                    }


                    session()->put('cart', $cart);
                    return true;
                }
            }
        } catch (Exception $e) {
            return false;
        }
    }

    public function categoryCourse(Request $request, $id, $name)
    {
        try {

            return view(theme('pages.search'), compact('request', 'id'));
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function subCategoryCourse(Request $request, $id, $name)
    {
        $quiz_id = OnlineQuiz::where('sub_category_id', $id)->get()->pluck('id')->toArray();
        $course_id = Course::where('subcategory_id', $id)->get()->pluck('id')->toArray();
        $class_id = VirtualClass::where('sub_category_id', $id)->get()->pluck('id')->toArray();


        $query = Course::with('user', 'category', 'subCategory', 'enrolls', 'comments', 'reviews', 'lessons', 'quiz', 'class')
            ->where('status', 1)
            ->latest();


        $query->where(function ($q) use ($quiz_id, $course_id, $class_id) {
            $q->whereIn('quiz_id', $quiz_id)
                ->orWhereIn('id', $course_id)
                ->orWhereIn('class_id', $class_id);
        });

        $type = $request->type;
        if (empty($type)) {
            $type = '';
        } else {
            $types = explode(',', $type);
            if (count($types) == 1) {
                foreach ($types as $t) {
                    if ($t == 'free') {
                        $query->where('price', 0);
                    } elseif ($t == 'paid') {
                        $query = $query->where('price', '>', 0);
                    }
                }
            }
        }

        $language = $request->language;
        if (empty($language)) {
            $language = '';
        } else {
            $row_languages = explode(',', $language);
            $languages = [];
            $LanguageList = Language::whereIn('code', $row_languages)->first();
            foreach ($row_languages as $l) {
                $lang = $LanguageList->where('code', $l)->first();
                if ($lang) {
                    $languages[] = $lang->id;
                }
            }
            $query->whereIn('lang_id', $languages);
        }


        $level = $request->level;
        if (empty($level)) {
            $level = '';
        } else {
            $levels = explode(',', $level);
            $query->whereIn('level', $levels);
        }

        $mode = $request->mode;
        if (empty($mode)) {
            $mode = '';
        } else {
            $modes = explode(',', $mode);
            $query->whereIn('mode_of_delivery', $modes);
        }

        $order = $request->order;
        if (empty($order)) {
            $order = '';
        } else {
            if ($order == "price") {
                $query->orderBy('price', 'asc');
            } else {
                $query->latest();
            }
        }

        $courses = $query->paginate(9);
        $total = $courses->total();
        $levels = CourseLevel::select('id', 'title')->where('status', 1)->get();

        return view(theme('pages.search'), compact('levels', 'order', 'level', 'order', 'mode', 'language', 'type', 'total', 'courses', 'request', 'id'));

    }

    public function fetch_course(Request $request)
    {
        if ($request->get('query')) {
            $query = $request->get('query');
            $data = DB::table('courses')
                ->where('title', 'LIKE', "%{$query}%")
                ->get();
            $output = '<ul>';

            foreach ($data as $row) {

                $output .= '
                        <li>
                            <a style="color:black" href="' . courseDetailsUrl(@$row->id, @$row->type, @$row->slug) . '">' . $row->title . '</a>
                        </li>
                        ';

            }
            $output .= '</ul>';
            echo $output;
        }
    }

    public function submitAns(Request $request)
    {
        $setting = QuizeSetup::getData();

        $qusAns = $request->get('qusAns');

        $array = explode('|', $qusAns);
        $ansId = $array[1];
        $qusId = $array[0];
        $userId = Auth::id() ?? 1;

        $question_review = $setting->question_review;
        $show_result_each_submit = $setting->show_result_each_submit;


        if ($request->get('courseId')) {
            $courseId = $request->get('courseId');


            if (!empty($qusAns)) {
                $totalQusSubmit = QuizTest::where('user_id', $userId)->count();
                $test = QuizTest::where('user_id', $userId)->where('course_id', $courseId)->where('question_id', $qusId)->first();

                if (empty($test)) {
                    $test = new QuizTest();
                    $test->user_id = $userId;
                    $test->course_id = $courseId;
                    $test->quiz_id = $request->get('quizId');
                    $test->question_id = $qusId;
                    $test->ans_id = $ansId;
                    $test->status = $question_review == 1 ? 0 : 1;
                    $test->count = $totalQusSubmit + 1;
                    $test->date = date('m/d/Y');
                    $test->save();
                } else {
                    if ($question_review == 1) {
                        $test->ans_id = $ansId;
                        $test->save();
                    } else {
                        return response()->json(['error' => 'Already Submitted'], 500);
                    }

                }

            }

            if ($show_result_each_submit == 1) {
                $ans = QuestionBankMuOption::find($ansId);

                if ($ans->status == 1) {
                    $result = true;
                } else {
                    $result = false;
                }

                return response()->json(['result' => $result], 200);
            } else {
                return response()->json(['submit' => true], 200);

            }


        } else {
            return response()->json(['error' => 'Something Went Wrong'], 500);
        }
    }

    public function getResult($courseId, $quizId)
    {
        $userId = Auth::id() ?? 1;
        $alreadySubmitTest = QuizTest::where('user_id', $userId)->where('course_id', $courseId)->where('quiz_id', $quizId)->distinct()->get();
        $quiz = OnlineQuiz::find($quizId);
        $totalQus = totalQuizQus($quiz->id);
        $totalAns = count($alreadySubmitTest);
        $totalCorrect = 0;
        $totalScore = totalQuizMarks($quizId);
        $score = 0;
        if ($totalAns != 0) {
            $hasResult = true;
            foreach ($alreadySubmitTest as $test) {
                $test->status = 1;
                $test->save();
                $ans = QuestionBankMuOption::find($test->ans_id);

                if (!empty($ans)) {
                    if ($ans->status == 1) {

                        $score += $ans->question->marks ?? 1;
                        $totalCorrect++;
//                        $totalScore +=$ans->
                    }
                }

            }
        } else {
            $hasResult = false;
        }

        $output = '';

        $output .= ' Total Question ' . $totalQus . '<br>';
        $output .= ' Total Ans ' . $totalAns . '<br>';
        $output .= ' Total Correct ' . $totalCorrect . '<br>';
        $output .= ' Score ' . $score . ' out of ' . $totalScore . ' <br>';
        return ['hasResult' => $hasResult, 'output' => $output];
    }

    public function contact()
    {
        try {
            if (hasDynamicPage()) {
                $row = FrontPage::where('slug', '/contact-us')->first();
                $details = dynamicContentAppend($row->details);
                return view('aorapagebuilder::pages.show', compact('row', 'details'));
            } else {
                $page_content = app('getHomeContent');
                return view(theme('pages.contact'), compact('page_content'));
            }
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function contactMsgSubmit(Request $request)
    {

        if (saasEnv('NOCAPTCHA_FOR_CONTACT') == 'true') {
            $validate_rules = [
                'name' => 'required',
                'email' => 'required|email',
                'message' => 'required',
                'subject' => 'required',
                'g-recaptcha-response' => 'required|captcha'
            ];
        } else {
            $validate_rules = [
                'name' => 'required',
                'email' => 'required|email',
                'message' => 'required',
                'subject' => 'required',
            ];
        }

        $request->validate($validate_rules, validationMessage($validate_rules));


        $name = $request->get('name');
        $email = $request->get('email');
        $message = $request->get('message');
        $subject = $request->get('subject');


        $admin = User::where('role_id', 1)->first();


        $send = SendGeneralEmail::dispatch($admin, 'CONTACT_MESSAGE', [
            'name' => $name,
            'email' => $email,
            'message' => $message,
            'subject' => $subject
        ]);


        if ($send) {
            Toastr::success(trans('frontend.Successfully Sent Message'), trans('common.Success'));
            return redirect()->back();

        } else {
            Toastr::error(trans('frontend.Something went wrong'), trans('common.Failed'));
            return redirect()->back();
        }
    }

    public function frontPage($slug)
    {

        $page = $row = FrontPage::where('slug', $slug)->first();
        if (!$row) {
            abort(404);
        }
        try {

            if ($row->status != 1) {
                Toastr::error(trans('frontend.Sorry. Page is not active'), trans('common.Failed'));
                return redirect()->back();
            }

            if (hasDynamicPage() || currentTheme() == 'edume') {
                $details = dynamicContentAppend($row->details);
                return view('aorapagebuilder::pages.show', compact('row', 'details'));
            } else {
                return view(theme('pages.page'), compact('page'));
            }
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }


    }

    public function search(Request $request)
    {
        try {
            $id = 0;
            return view(theme('pages.search'), compact('request', 'id'));
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function enrollOrCart($id)
    {


        $course = Course::findOrFail($id);

        if (isModuleActive('Org')) {
            $type = $course->required_type;
            if ($type == 1) {
                $output['result'] = 'failed';
                $output['message'] = trans('org.Unable to add cart');
                return $output;
            }
        }
        $output = [];

        //add to cart
        $output['type'] = 'addToCart';


        if ($course->type == 3 && $course->class->capacity && $course->total_enrolled >= $course->class->capacity) {
            $output['result'] = 'failed';
            $output['message'] = trans('virtual-class.Enrollment limit for this course has been reached');
            return $output;
        }

        try {
            $user = Auth::user();
            if (Auth::check() && ($user->role_id != 1)) {
                if (!$course->isLoginUserEnrolled) {
                    $exist = Cart::where('user_id', $user->id)
                        ->when(isModuleActive('Invoice'), function ($query) {
                            $query->whereNull('type');
                        })
                        ->where('course_id', $id)->first();
                    $oldCart = Cart::where('user_id', $user->id)
                        ->when(isModuleActive('Invoice'), function ($query) {
                            $query->whereNull('type');
                        })
                        ->first();


                    if (isset($exist)) {
                        $output['result'] = 'failed';
                        $output['message'] = trans('frontend.Course already added in your cart');
                    } elseif (Auth::check() && ($user->role_id == 1)) {
                        $output['result'] = 'failed';
                        $output['message'] = trans('frontend.You logged in as admin so can not add cart');
                    } else {
                        if (isModuleActive('EarlyBird')) {
                            $early_bird_price = verifyEarlybirdOffer($course, auth()->user()->id);
                        }
                        if (isset($oldCart)) {

                            $cart = new Cart();
                            $cart->user_id = $user->id;
                            $cart->instructor_id = $course->user_id;
                            $cart->course_id = $id;
                            $cart->tracking = $oldCart->tracking;
                            if ($course->discount_price != null) {
                                $cart->price = $course->discount_price;
                            } else {
                                $cart->price = $course->price;
                            }
                            if (isModuleActive('EarlyBird')) {
                                $cart->price = $early_bird_price['price'];
                                $cart->is_earlybird_offer = 1;
                                $cart->price_plan_id = $early_bird_price['price_plan_id'];
                            }
                            $cart->save();

                        } else {
                            $cart = new Cart();
                            $cart->user_id = $user->id;
                            $cart->instructor_id = $course->user_id;
                            $cart->course_id = $id;
                            $cart->tracking = getTrx();
                            if ($course->discount_price != null) {
                                $cart->price = $course->discount_price;
                            } else {
                                $cart->price = $course->price;
                            }
                            if (isModuleActive('EarlyBird')) {
                                $cart->price = $early_bird_price['price'];
                                $cart->is_earlybird_offer = 1;
                                $cart->price_plan_id = $early_bird_price['price_plan_id'];
                            }
                            if (hasCouponApply($course->id)) {
                                $cart->price = getCouponPrice($course->id);
                            }
                            $cart->save();
                        }

                        if ($cart->price == 0 && !isModuleActive('Org')) {
                            $output['type'] = 'enroll';
                            $paymentController = new PaymentController();
                            $paymentController->directEnroll($cart->course_id, $cart->tracking);
                            $output['message'] = trans('frontend.Course enrolled successfully');

                        } else {
                            $output['message'] = trans('frontend.Item Added to your cart');
                        }


                        $output['result'] = 'success';
                        $output['total'] = cartItem();
                    }
                } else {
                    $output['result'] = 'failed';
                    $output['message'] = trans('frontend.Already Enrolled');
                }

            } //If user not logged in then cart added into session

            else {

                $course = Course::find($id);
                if (!$course) {
                    $output['result'] = 'failed';
                    $output['message'] = trans('courses.Course not found');

                }

                if ($course->discount_price > 0) {
                    $price = $course->discount_price;
                } else {
                    $price = $course->price;
                }

                if (hasCouponApply($course->id)){
                   $price=getCouponPrice($course->id);
                }
                $cart = session()->get('cart');
                if (!$cart) {
                    $cart = [
                        $id => [
                            "id" => $course->id,
                            "course_id" => $course->id,
                            "instructor_id" => $course->user_id,
                            "instructor_name" => $course->user->name,
                            "title" => $course->title,
                            "image" => $course->image,
                            "slug" => $course->slug,
                            "type" => $course->type,
                            "price" => $price,
                        ]
                    ];
                    session()->put('cart', $cart);

                    $output['result'] = 'success';
                    $output['total'] = cartItem();
                    $output['message'] = trans('frontend.Item Added to your cart');
                } elseif (isset($cart[$id])) {
                    $output['result'] = 'failed';
                    $output['message'] = trans('frontend.Course already added in your cart');
                } else {

                    $cart[$id] = [

                        "id" => $course->id,
                        "course_id" => $course->id,
                        "instructor_id" => $course->user_id,
                        "instructor_name" => $course->user->name,
                        "title" => $course->title,
                        "image" => $course->image,
                        "slug" => $course->slug,
                        "price" => $price,
                    ];

                    session()->put('cart', $cart);

                    $output['result'] = 'success';
                    $output['total'] = cartItem();
                    $output['message'] = trans('frontend.Item Added to your cart');

                }

            }
        } catch (Exception $e) {
            $output['result'] = 'failed';
            $output['message'] = trans('common.Operation failed');

        }


        return json_encode($output);
    }

   /* public function getItemList()
    {
        $carts = [];
        if (Auth::check()) {
            $items = Cart::where('user_id', Auth::id())->with('course', 'course', 'course.user')
                ->when(isModuleActive('Invoice'), function ($query) {
                    $query->whereNull('type');
                })->get();
            if (!empty($items)) {

                foreach ($items as $key => $cart) {
                    $course = Course::find($cart['course_id']);
                    if ($course) {

                        $carts[$key]['id'] = $cart['id'];
                        $carts[$key]['course_id'] = $cart['course_id'];
                        $carts[$key]['instructor_id'] = $cart['instructor_id'];
                        $carts[$key]['title'] = $cart->course->title;
                        $carts[$key]['instructor_name'] = $cart->course->user->name;
                        $carts[$key]['image'] = getCourseImage($cart->course->thumbnail);
                        if (isModuleActive('Installment') && $cart->is_installment == 1) {
                            $carts[$key]['price'] = getPriceFormat(installmentProductPrice($cart->course_id, $cart->plan_id, $cart->course->discount_price ? $cart->course->discount_price : $cart->course->price));
                        } elseif (isModuleActive('EarlyBird') && $cart->is_earlybird_offer == 1) {
                            $carts[$key]['price'] = getPriceFormat(verifyEarlybirdOffer($course, auth()->user()->id, $cart)['price']);
                        } else {
                            if (isModuleActive('Store') && $cart->is_store == 1) {
                                if ($cart['product_sku_label']){
                                    $carts[$key]['title'] = $course->title . ' ('. $cart->product_sku_label.')';
                                }
                                $carts[$key]['price'] = ($cart['qty'] ?? 1) . ' x ' . getPriceFormat($cart['price']) . ' = ' . getPriceFormat($cart['price'] * ($cart['qty'] ?? 1));
                            } else {
                                if ($cart->course->discount_price != null) {
                                    $carts[$key]['price'] = getPriceFormat($cart->course->discount_price);
                                } else {
                                    $carts[$key]['price'] = getPriceFormat($cart->course->price);
                                }
                            }

                        }


                    }

                    if (isModuleActive('BundleSubscription')) {
                        $bundleCheck = BundleCoursePlan::find($cart['bundle_course_id']);
                        if ($bundleCheck) {
                            $carts[$key]['id'] = $cart['id'];
                            $carts[$key]['course_id'] = $cart['course_id'];
                            $carts[$key]['instructor_id'] = $cart['instructor_id'];
                            $carts[$key]['title'] = $bundleCheck->title;
                            $carts[$key]['instructor_name'] = $bundleCheck->user->name;
                            $carts[$key]['image'] = getCourseImage($bundleCheck->icon);
                            $carts[$key]['price'] = getPriceFormat($bundleCheck->price);
                        }
                    }

                }
            }


        } else {
            $items = session()->get('cart');
            if (!empty($items)) {
                foreach ($items as $key => $cart) {
                    $course = Course::find($cart['course_id']);
                    if ($course) {
                        $carts[$key]['id'] = $cart['id'];
                        $carts[$key]['course_id'] = $course->id;
                        $carts[$key]['instructor_id'] = $course->user_id;
                        $carts[$key]['title'] = $course->title;
                        $carts[$key]['type'] = $course->type;
                        $carts[$key]['instructor_name'] = $course->user->name;
                        $carts[$key]['image'] = getCourseImage($course->thumbnail);

                        if (isModuleActive('Store') && ($cart['is_store'] ?? '') == 1) {
                            if ($cart['product_sku_label']){
                                $carts[$key]['title'] = $course->title . ' ('. $cart['product_sku_label'].')';
                            }
                            $carts[$key]['price'] = $cart['qty'] . ' x ' . getPriceFormat($cart['price']) . ' = ' . getPriceFormat($cart['price'] * $cart['qty']);
                        } else {
                            if (hasCouponApply($course->id)) {
                                $carts[$key]['price'] = getPriceFormat(getCouponPrice($course->id));
                            }else{
                                if ($course->discount_price != null) {
                                    $carts[$key]['price'] = getPriceFormat($course->discount_price);
                                } else {
                                    $carts[$key]['price'] = getPriceFormat($course->price);
                                }
                            }

                        }
                    }
                }
            }
        }

        $this->postEvent([
            'name' => 'view_cart',
            'params' => [
                'items' => $carts
            ],
        ]);
        if (\request('responseType') == 'view') {
            return view(theme('partials._cart'), compact('carts'))->render();
        } else {
            return response()->json($carts);
        }
    }
*/

    public function lessonComplete(Request $request)
    {


        try {
            $newLessonComplete = false;
            $lesson = LessonComplete::where('course_id', $request->course_id)->where('lesson_id', $request->lesson_id)->where('user_id', Auth::id())->first();
            $certificateBtn = 0;
            if (!$lesson) {
                $check = Lesson::find($request->lesson_id);
                if ($check) {
                    checkGamification('each_unit_complete', '');
                }
                $newLessonComplete = true;
                $lesson = new LessonComplete();
                $lesson->user_id = Auth::id();
                $lesson->chapter_id = 0;
                $lesson->course_id = $request->course_id;
                $lesson->lesson_id = $request->lesson_id;
            }
            $lesson->status = $request->status;
            if ($request->status == 1)
                $success = trans('frontend.Lesson Marked as Complete');
            else
                $success = trans('frontend.Lesson Marked as Incomplete');
            $lesson->save();

            $course = Course::find($request->course_id);
            if ($course) {
                $percentage = round($course->loginUserTotalPercentage);
                if ($percentage >= 100) {
                    if ($newLessonComplete) {
                        checkGamification('each_course_complete', 'learning', null, isModuleActive('Org') ? $course->org_leaderboard_point : 0);
                        orgLeaderboardPointCheck('Course', $course->org_leaderboard_point, $course->id);

                    }
                    $this->getCertificateRecord($course->id);

                    earnCourseBadge($course->id, auth()->id(), $course->has_badge);

                    $this->sendNotification('Complete_Course', Auth::user(), [
                        'time' => Carbon::now()->translatedFormat('d-M-Y, g:i A'),
                        'course' => $course->getTranslation('title', Auth::user()->language_code ?? config('app.fallback_locale')),

                    ], [
                        'actionText' => trans('common.View'),
                        'actionUrl' => courseDetailsUrl(@$course->id, @$course->type, @$course->slug),
                    ]);

                }
            }
            if (count($lesson->course->lessons) == count($lesson->course->completeLessons->where('status', 1)))
                $certificateBtn = 1;


            $previousUrl = app('url')->previous();

            return redirect()->to($previousUrl . '&' . http_build_query(['done' => 1]));


        } catch (Exception $e) {

            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }

    }

    public function getCertificateRecord($course_id)
    {
        if (Settings('manually_assign_certificate') == 1) {
            return null;
        }

        try {

            $course = Course::find($course_id);

            if (!empty($course->certificate_id)) {
                $certificate = Certificate::find($course->certificate_id);
            } else {
                if ($course->type == 1) {
                    $certificate = Certificate::where('for_course', 1)->first();
                } elseif ($course->type == 2) {
                    $certificate = Certificate::where('for_quiz', 1)->first();
                } elseif ($course->type == 3) {
                    $certificate = Certificate::where('for_class', 1)->first();
                } else {
                    $certificate = null;
                }
            }
            if ($certificate) {
                $certificate_record = CertificateRecord::where('student_id', Auth::user()->id)->where('course_id', $course_id)->first();
                $percentage = round($course->loginUserTotalPercentage);
                if (!$certificate_record && $percentage >= 100) {
                    checkGamification('each_certificate', 'certification', null, isModuleActive('Org') ? $course->org_leaderboard_point : 0);

                    $certificate_record = new CertificateRecord();
                    $certificate_record->certificate_id = $this->generateUniqueCode();
                    $certificate_record->student_id = Auth::user()->id;
                    $certificate_record->course_id = $course_id;
                    $certificate_record->created_by = Auth::user()->id;
                    if (isModuleActive('Org')) {
                        if ($course->required_type == 1) {
                            $enrolls = $course->enrolls->where('user_id', Auth::id());
                            if (isset($enrolls[0])) {
                                $plan_id = $enrolls[0]->org_subscription_plan_id;
                                $checkout = OrgSubscriptionCheckout::where('plan_id', $plan_id)->where('user_id', \auth()->id())->latest()->first();
                                $certificate_record->start_date = $checkout->start_date;
                                $certificate_record->end_date = $checkout->end_date;
                            }

                        } else {
                            $certificate_record->start_date = $course->created_at;
                            $certificate_record->end_date = '';
                        }
                        addOrgRecentActivity(\auth()->id(), $course->id, 'Complete');
                    }

                    $certificate_record->save();
                }

                if (isModuleActive('Org')) {
                    if (isModuleActive('CertificatePro') && Settings('use_certificate_template') == 'pro') {
                        request()->certificate_id = $certificate_record->certificate_id;
                        request()->course = $course;
                        request()->user = Auth::user();
                        $downloadFile = new CertificateController();
                        $certificate = $downloadFile->makeCertificate($certificate->id, request())['image'] ?? '';

                        if ($certificate){
                            $certificate->toJpeg()->save('public/certificate/' . $certificate_record->id . '.jpg');
                        }


                    } else {
                        request()->certificate_id = $certificate_record->certificate_id;
                        request()->course = $course;
                        request()->user = Auth::user();
                        $downloadFile = new CertificateController();
                        $certificate = $downloadFile->makeCertificate($certificate->id, request())['image'] ?? '';
if ($certificate){
    $certificate->toJpeg()->save('public/certificate/' . $certificate_record->id . '.jpg');
}

                    }


                }
                return $certificate_record;
            } else {
                return null;
            }

        } catch (Exception $e) {
            return null;
        }
    }

    public function lessonCompleteAjax(Request $request)
    {
        try {
            $newLessonComplete = false;

            if (empty($request->user_id)) {
                $user = Auth::user();
            } else {
                $user = User::find($request->user_id);
            }

            $enrolled = CourseEnrolled::where('course_id', (int)$request->course_id)->where('user_id', (int)$user->id)->first();

            $lesson = LessonComplete::query()
                ->where('course_id', (int)$request->course_id)
                ->where('lesson_id', (int)$request->lesson_id)
                ->where('user_id', (int)$user->id)
                ->first();
            if (!$lesson) {
                $check = Lesson::find((int)$request->lesson_id);
                if ($check) {
                    checkGamification('each_unit_complete', '');
                }

                $lesson = new LessonComplete();
                $newLessonComplete = true;

            }
            $lesson->user_id = $user->id;
            $lesson->course_id = (int)$request->course_id;
            $lesson->lesson_id = (int)$request->lesson_id;
            $lesson->chapter_id = 0;
            $lesson->enroll_id = (int)@$enrolled->id;
            $lesson->status = 1;
            $lesson->save();

            $course = Course::withCount('lessons')->find((int)$request->course_id);
            if ($course) {
                $completeLessons = LessonComplete::where('user_id', (int)$user->id)->where('course_id', (int)$course->id)->where('status', 1)->count();
                $totalLessons = $course->lessons;

                if ($completeLessons != 0) {
                    $percentage = ceil($completeLessons / count($totalLessons) * 100);
                } else {
                    $percentage = 0;
                }
                if ($percentage > 100) {
                    $percentage = 100;
                }

                if ($percentage >= 100 && $newLessonComplete) {

                    if ($newLessonComplete) {
                        checkGamification('each_course_complete', 'learning', null, isModuleActive('Org') ? $course->org_leaderboard_point : 0);
                        orgLeaderboardPointCheck('Course', $course->org_leaderboard_point, $course->id);
                    }
                    if (isModuleActive('SkillAndPathway')) {
                        if ($enrolled->pathway_id != null) {
                            StudentSkillController::studentCreateSkill(2, $course->id, $user, $enrolled);
                        } else {
                            StudentSkillController::studentCreateSkill(1, $course->id, $user, $enrolled);
                        }
                    }


                    $this->getCertificateRecord($course->id);
                    earnCourseBadge($course->id, auth()->id(), $course->has_badge);


                    $this->sendNotification('Complete_Course', $user, [
                        'time' => Carbon::now()->format('d-M-Y, g:i A'),
                        'course' => $course->getTranslation('title', $user->language_code ?? config('app.fallback_locale')),

                    ], [
                        'actionText' => trans('common.View'),
                        'actionUrl' => courseDetailsUrl(@$course->id, @$course->type, @$course->slug),
                    ]);
                }
            }

            return true;


        } catch (Exception $e) {
            return false;
        }

    }

    public function subscriptionCourses()
    {
        if (!Auth::check()) {
            return redirect('login');
        }
        if (isModuleActive('Subscription')) {
            if (!isSubscribe()) {
                Toastr::error(trans('frontend.You must subscribe first'), trans('common.Failed'));
                return redirect()->back();
            }
        }
        try {

            return view(theme('pages.subscription-courses'));

        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function orgSubscriptionCourses(Request $request)
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        try {
            $sliders = Slider::where('status', 1)->get();
            return view(theme('pages.org-subscription-courses'), compact('request', 'sliders'));

        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function orgSubscriptionPlanList($planId, Request $request)
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        try {
            return view(theme('pages.org-subscription-plan-list'), compact('request', 'planId'));

        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function subscription(Request $request)
    {

        if (isModuleActive('Subscription')) {

            return view(theme('pages.subscription'));

        } else {
            Toastr::error(trans('frontend.Module not active'), trans('common.Failed'));
            return redirect()->back();
        }
    }

    public function subscriptionCourseList(Request $request, $plan_id)
    {
        try {
            if (isModuleActive('Subscription')) {
                return view(theme('pages.subscription_course_list'), compact('plan_id'));
            } else {
                Toastr::error(trans('frontend.Module not active'), trans('common.Failed'));
                return redirect()->back();
            }
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function subscriptionCheckout(Request $request)
    {


        if (empty($request->plan)) {
            $s_plan = '';
        } else {
            $s_plan = $request->plan;
        }

        if (empty($request->price)) {
            $price = '';
        } else {
            $price = $request->price;
        }
        if (currentTheme() != 'tvt') {
            if (!empty($s_plan) && !empty($price)) {
                if (Auth::check()) {
                    if (Auth::user()->role_id == 1) {
                        Toastr::error(trans('subscription.You are not allowed'), trans('common.Failed'));
                        return \redirect()->route('courseSubscription');
                    }

                    $subscription = new CourseSubscriptionController();
                    $addCart = $subscription->addToCart(Auth::id(), $s_plan);
                    if (!$addCart) {
                        Toastr::error(trans('frontend.Invalid Request'), trans('common.Failed'));
                        return \redirect()->route('courseSubscription');
                    }

                } else {
                    Toastr::error(trans('frontend.You must login'), trans('common.Failed'));
                    return \redirect()->route('login');
                }
            } else {
                Toastr::error(trans('frontend.Invalid Request'), trans('common.Failed'));
                return \redirect()->route('login');
            }
        }


        return view(theme('pages.subscriptionCheckout'), compact('request', 's_plan', 'price'));

    }
/*
    public function addToCart($id, $qty = null)
    {
        try {
            $course = Course::find($id);
            $is_store = false;

            if (!$course) {
                Toastr::error(trans('frontend.Item not found'), trans('common.Failed'));
                return redirect()->back();
            }
            if ($course->discount_price > 0) {
                $price = $course->discount_price;
            } else {
                $price = $course->price;
            }
             if (hasCouponApply($course->id)){
                $price =getCouponPrice($course->id);
            }
                if (isModuleActive('Org')) {
                $type = $course->required_type;
                if ($type == 1) {
                    Toastr::error(trans('org.Unable to add cart'), trans('common.Failed'));
                    return redirect()->back();
                }
            }
            if ($course->type == 3 && $course->class->capacity && $course->total_enrolled >= $course->class->capacity) {
                Toastr::error(trans('virtual-class.Enrollment limit for this course has been reached'), trans('common.Failed'));
                return redirect()->back();
            }


            if (isModuleActive('Store') && $course->type == 5) {
                $is_store = true;
            }

            if (Auth::check() && (Auth::user()->role_id != 1)) {
                $user = Auth::user();

                $exist = Cart::where('user_id', $user->id)->where('course_id', $id)->first();
                $oldCart = Cart::where('user_id', $user->id)->when(isModuleActive('Appointment'), function ($query) {
                    $query->whereNotNull('course_id');
                })->first();


                if (isset($exist)) {
                    Toastr::error(trans('frontend.Item already added in your cart'), trans('common.Failed'));

                    return redirect()->back();
                } elseif (Auth::check() && ($user->role_id == 1)) {
                    Toastr::error(trans('frontend.You logged in as admin so can not add cart'), trans('common.Failed'));
                    return redirect()->back();
                } else {
                    if (isModuleActive('EarlyBird')) {
                        $early_bird_price = verifyEarlybirdOffer($course, auth()->user()->id);
                    }

                    if (isset($oldCart)) {


                        $cart = new Cart();
                        $cart->user_id = $user->id;
                        $cart->instructor_id = $course->user_id;
                        $cart->course_id = $id;
                        $cart->tracking = $oldCart->tracking;
                        if ($course->discount_price != null) {
                            $cart->price = $course->discount_price;
                        } else {
                            $cart->price = $course->price;
                        }


                        if (isModuleActive('EarlyBird')) {
                            $cart->price = $early_bird_price['price'];
                            $cart->is_earlybird_offer = 1;
                            $cart->price_plan_id = $early_bird_price['price_plan_id'];
                        }

                        if (isModuleActive('Store') && $is_store) {
                            $cart->qty = $qty;
                            $cart->is_store = $is_store;

                            $sku = ProductSku::find(\request()->sku_id);
                            $cart->price = $sku->price ?? 0;


                            $cart->attributes_values = \request('attribute_values');
                            $cart->product_sku_id = \request('sku_id');
                            $attributes_values = ProductAttributeValue::whereIn('id', explode(',', \request('attribute_values')))->pluck('value')->toArray();
                            $cart->product_sku_label = implode(' - ', $attributes_values);
                        }


                        if (isModuleActive('UpcomingCourse') && $course->is_upcoming_course && $course->is_allow_prebooking) {
                            $pre_booking = UpcomingCourseBooking::where('course_id', $course->id)->where('user_id', $user->id)->first();

                            if ($pre_booking) {
                                $pre_booking_amount = UpcomingCourseBookingPayment::where('booking_id', $pre_booking->id)->sum('amount');
                                $cart->pre_booking_amount = $pre_booking_amount;

                            }

                        }
                        if (isModuleActive('UserGroup') && $user->userGroup && $user->userGroup->group->status && $user->userGroup->group->discount) {
                            $cart->group_discount = number_format(($cart->price * $user->userGroup->group->discount) / 100, 2);
                        }

                        if (hasCouponApply($course->id)) {
                            $cart->price = getCouponPrice($course->id);
                        }
                        $cart->save();

                    } else {


                        $cart = new Cart();
                        $cart->user_id = $user->id;
                        $cart->instructor_id = $course->user_id;
                        $cart->course_id = $id;
                        $cart->tracking = getTrx();


                        if ($course->discount_price != null) {
                            $cart->price = $course->discount_price;
                        } else {
                            $cart->price = $course->price;
                        }


                        if (isModuleActive('EarlyBird')) {
                            $cart->price = $early_bird_price['price'];
                            $cart->is_earlybird_offer = 1;
                            $cart->price_plan_id = $early_bird_price['price_plan_id'];
                        }

                        if (isModuleActive('Store') && $is_store) {
                            $cart->qty = $qty;
                            $cart->is_store = $is_store;

                            $sku = ProductSku::find(\request()->sku_id);
                            $cart->price = $sku->price ?? 0;


                            $cart->attributes_values = \request('attribute_values');
                            $cart->product_sku_id = \request('sku_id');
                            $attributes_values = ProductAttributeValue::whereIn('id', explode(',', \request('attribute_values')))->pluck('value')->toArray();
                            $cart->product_sku_label = implode(' - ', $attributes_values);
                        }


                        if (isModuleActive('UpcomingCourse') && $course->is_upcoming_course && $course->is_allow_prebooking) {
                            $pre_booking = UpcomingCourseBooking::where('course_id', $course->id)->where('user_id', $user->id)->first();

                            if ($pre_booking) {
                                $pre_booking_amount = UpcomingCourseBookingPayment::where('booking_id', $pre_booking->id)->sum('amount');
                                $cart->pre_booking_amount = $pre_booking_amount;

                            }

                        }

                        if (isModuleActive('UserGroup') && $user->userGroup && $user->userGroup->group->status && $user->userGroup->group->discount) {
                            $cart->group_discount = number_format(($cart->price * $user->userGroup->group->discount) / 100, 2);
                        }
                         if (hasCouponApply($course->id)) {
                            $cart->price = getCouponPrice($course->id);
                        }
                        $cart->save();
                     }
                    if ($cart->price == 0) {
                        $paymentController = new PaymentController();
                        if ($cart->course->type == 5) {
                            $paymentController->directProductEnroll($cart, $cart->tracking);
                        } else {
                            $paymentController->directEnroll($cart->course_id, $cart->tracking);
                        }

                    }


                    $this->postEvent([
                        'name' => 'add_to_cart',
                        'params' => [
                            "items" => [
                                [
                                    "item_id" => $cart->course_id,
                                    "item_name" => $cart->course?->title,
                                    "price" => $cart->price
                                ]
                            ],
                        ],
                    ]);

                    Toastr::success(trans('frontend.Item Added to your cart'), trans('common.Success'));
                    return redirect()->back();
                }

            } //If user not logged in then cart added into session

            else {


                if (isModuleActive('Store') && $is_store) {
                    $sku = ProductSku::find(\request()->sku_id);
                    $price = $sku->price ?? 0;
                    $attributes_values = \request('attribute_values');
                    $product_sku_id = \request('sku_id');

                    $attributes_values_array = ProductAttributeValue::whereIn('id', explode(',', \request('attribute_values')))->pluck('value')->toArray();
                    $product_sku_label = implode(' - ', $attributes_values_array);
                } else {
                    $attributes_values = '';
                    $product_sku_id = '';
                    $product_sku_label = '';
                }
                $cart = session()->get('cart');
                if (!$cart) {
                    $cart = [
                        $id => [
                            "id" => $course->id,
                            "course_id" => $course->id,
                            "instructor_id" => $course->user_id,
                            "instructor_name" => $course->user->name,
                            "title" => $course->title,
                            "image" => $course->image,
                            "slug" => $course->slug,
                            "type" => $course->type,
                            "price" => $price,
                            "qty" => $qty,
                            "is_store" => $is_store,
                            "attributes_values" => $attributes_values,
                            "product_sku_id" => $product_sku_id,
                            "product_sku_label" => $product_sku_label,
                        ]
                    ];
                    session()->put('cart', $cart);
                    Toastr::success(trans('frontend.Item Added to your cart'), trans('common.Success'));
                    return redirect()->back();
                } elseif (isset($cart[$id])) {
                    Toastr::error(trans('frontend.Item already added in your cart'), trans('common.Failed'));
                    return redirect()->back();
                } else {

                    $cart[$id] = [

                        "id" => $course->id,
                        "course_id" => $course->id,
                        "instructor_id" => $course->user_id,
                        "instructor_name" => $course->user->name,
                        "title" => $course->title,
                        "image" => $course->image,
                        "slug" => $course->slug,
                        "type" => $course->type,
                        "price" => $price,
                        "qty" => $qty,
                        "is_store" => $is_store,
                        "attributes_values" => $attributes_values,
                        "product_sku_id" => $product_sku_id,
                        "product_sku_label" => $product_sku_label,
                    ];

                    session()->put('cart', $cart);


                    $this->postEvent([
                        'name' => 'add_to_cart',
                        'params' => [
                            "items" => [
                                [
                                    "item_id" => $course->id,
                                    "item_name" => $course->title,
                                    "price" => $price
                                ]
                            ],
                        ],
                    ]);

                    Toastr::success(trans('frontend.Item Added to your cart'), trans('common.Success'));
                    return redirect()->back();

                }


            }
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }*/

    public function emptyCart()
    {
        if (Auth::check()) {
             Cart::where('user_id',Auth::id())->delete();
        } else {
                session()->put('cart');
        }


        Toastr::success(trans('frontend.All items removed from your cart'), trans('common.Success'));
        return redirect()->back();

    }

    public function continueCourse($slug)
    {
        try {
            $lesson_id = null;
            if (!Auth::check()) {
                Toastr::error(trans('frontend.You must login for continue'), trans('common.Failed'));
                return redirect()->route('courseDetailsView', $slug);
            }
            $user = Auth::user();
            $course = Course::where('slug', $slug)->first();
            if (!$course) {
                Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
                return redirect()->route('courseDetailsView', $slug);
            }
            $isEnrolled = $course->isLoginUserEnrolled;
            $enrollForCpd = false;
            $enrollForClass = false;
            if (isModuleActive('CPD')) {
                $enrollForCpd = $course->hasEnrollForCPd ? true : false;
            }
            if (isModuleActive('MyClass')) {
                $studentClassRepository = App::make(AddStudentToClassRepositoryInterface::class);
                $enrollForClass = $studentClassRepository->hasEnrollCourse($course->id, auth()->user()->id);
            }

            if (isModuleActive('Membership')) {
                $membershipRepo = new MembershipController();
                $enrollForMembership = $membershipRepo->hasEnrolled($course->id, auth()->id());
            } else {
                $enrollForMembership = false;
            }


            if ($isEnrolled || $enrollForCpd || $enrollForClass || $enrollForMembership) {

                $lesson = LessonComplete::where('course_id', $course->id)->where('user_id', $user->id)->has('lesson')->orderBy('updated_at', 'desc')->first();
                if (empty($lesson)) {
                    $chapter = Chapter::where('course_id', $course->id)->whereHas('lessons')->orderBy('position', 'asc')->first();
                    if (empty($chapter)) {
                        Toastr::error(trans('frontend.No lesson found'), trans('common.Failed'));
                        return redirect()->route('courseDetailsView', $slug);
                    }
                    $lesson = Lesson::where('course_id', $course->id)->where('chapter_id', $chapter->id)->orderBy('position', 'asc')->first();
                    if (!empty($lesson)) {
                        $lesson_id = $lesson->id;
                    }
                } else {
                    $next_lesson = null;
                    $chapters = Chapter::select('id')->where('course_id', $course->id)->whereHas('lessons')->orderBy('position', 'asc')->get();
                    $all_lessons = Lesson::select('id')->where('course_id', $course->id)->orderBy('position', 'asc')->get();

                    $lesson_ids=[];
                    foreach ($chapters as $c) {
                        foreach ($all_lessons as $item) {
                            if ($c->id == $item->chapter_id) {
                                $lesson_ids[] = $item->id;

                            }
                        }
                    }

                    foreach ($lesson_ids as $id) {
                        if (in_array($lesson->lesson_id, $id)) {
                            $position = array_search($lesson->lesson_id, $id);
                            $position = $position + 1;
                            if (isset($lessons[$position])) {
                                $next_lesson = $lessons[$position];
                            }
                        }
                    }
                    $lesson_id = !empty($next_lesson) ? $next_lesson : $lesson->lesson_id;
                }

                if (!empty($lesson_id)) {

                    return \redirect()->to(url('fullscreen-view/' . $course->id . '/' . $lesson_id));
                } else {
                    Toastr::error(trans('frontend.There is no lesson for this course'), trans('common.Failed'));
                    return redirect()->route('courseDetailsView', $slug);
                }


            } else {
                Toastr::error(trans('frontend.You are not enrolled for this course'), trans('common.Failed'));
                return redirect()->route('courseDetailsView', $slug);
            }

        } catch (Exception $e) {

            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function vimeoPlayer($video_id)
    {
        return view('vimeo_player', compact('video_id'));
    }


    public function scormPlayer($lesson_id, $user_id = null)
    {
        $lesson = Lesson::with('course')->find($lesson_id);
        $course = $lesson->course;
        $with = [];
        if (isModuleActive('Org')) {
            $with[] = 'branch';
        }
        $user = User::with($with)->find($user_id);
        return view('scorm_player', compact('lesson', 'course', 'user'));
    }

    public function offline()
    {
        return 'offline';
    }


    public function test()
    {
        return 'okk';
    }

    public function calendarView()
    {
        try {
            $query = Calendar::with('course', 'event', 'course.user', 'course.user.role')
                ->whereNull('event_id')
                ->orWhereHas('event', function ($q) {
                    if (Auth::check()) {
                        $role_name = Auth::user()->role->name;
                    } else {
                        $role_name = 'All';
                    }
                    if (Auth::check() && Auth::user()->role_id != 1) {
                        $isAdmin = false;
                    } else {
                        $isAdmin = true;
                    }
                    if (!$isAdmin) {
                        $q->where('for_whom', $role_name);
                        $q->orWhere('for_whom', 'All');
                    }

                });

            $calendars = $query->get();


            return view(theme('pages.calendarView'), compact('calendars'));
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function documentPlayer($lesson_id)
    {
        $lesson = Lesson::with('course')->find($lesson_id);
        return view('document_player', compact('lesson'));
    }

    public function onlyAppMode()
    {
        $row = FrontPage::where('slug', 'app-mode')->first();
        $details = dynamicContentAppend($row->details);
        return view('aorapagebuilder::pages.show', compact('row', 'details'));
    }

    public function readSomePartOfBooks($id)
    {
        $course = Course::findOrFail($id);
        return view(theme('pages.downloadSampleFiles'), compact('course'));
    }

    public function classRecords($slug)
    {
        try {

            $course = Course::where('slug', $slug)->where('type', 3)->where('status', 1)->first();
            if (!$course) {
                Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
                return redirect()->route('classDetails', $slug);
            }
            $isEnrolled = $course->isLoginUserEnrolled;

            if ($isEnrolled || Auth::user()->role_id == 1) {
                $classRecord = ClassRecord::where('class_id', $course->class->id)->first();
                if (empty($classRecord)) {
                    Toastr::error(trans('frontend.No Record found'), trans('common.Failed'));
                    return redirect()->route('classDetails', $slug);
                }
                return \redirect()->to('class-record/' . $classRecord->class_id . '/' . $classRecord->id);

            } else {
                Toastr::error(trans('frontend.You are not enrolled for this class'), trans('common.Failed'));
                return redirect()->route('classDetails', $slug);
            }

        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function classRecord($class_id, $record_id)

    {
        $class = VirtualClass::with('course')->findOrFail($class_id);
        $course = $class->course;


        $enrolled = CourseEnrolled::where('user_id', Auth::id())->where('course_id', $course->id)->where('status', 1)->first();

        if ($enrolled || Auth::user()->role_id == 1) {
            $records = ClassRecord::where('class_id', $class_id)
                ->get();
            $currentRecord = $records->where('id', $record_id)->first();

            if (!$currentRecord) {
                abort(404);
            }

            if ($class->record_validity > 0 && $currentRecord->created_at->diffInDays(Carbon::now()) > $class->record_validity) {
                Toastr::error(trans('frontend.Your access validity is expired'), trans('common.Failed'));
                return redirect()->route('classDetails', $course->slug);
            }


            $meetings = [];
            if ($class->host == "Zoom") {
                $meetings = $class->zoomMeetings;
            } elseif ($class->host == "BBB") {
                $meetings = $class->bbbMeetings;
            } elseif ($class->host == "Jitsi") {
                $meetings = $class->jitsiMeetings;
            } elseif ($class->host == "Custom") {
                $meetings = $class->customMeetings;
            } elseif ($class->host == "InAppLiveClass") {
                $meetings = $class->inAppMeetings;
            } elseif ($class->host == "GoogleMeet") {
                $meetings = $class->googleMeetMeetings;
            }
            return view(theme('pages.classRecord'), compact('records', 'currentRecord', 'class', 'course', 'meetings'));

        } else {
            Toastr::error(trans('frontend.You are not enrolled for this class'), trans('common.Failed'));
            return redirect()->route('classDetails', $course->slug);
        }


    }
}
