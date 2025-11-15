<?php

namespace App\View\Components;

use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;
use Modules\BBB\Entities\BbbMeeting;
use Modules\Certificate\Entities\Certificate;
use Modules\CertificatePro\Entities\CertificateTemplate;
use Modules\CourseSetting\Entities\Category;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\CourseEnrolled;
use Modules\GoogleMeet\Entities\GoogleMeetMeeting;
use Modules\InAppLiveClass\Entities\InAppLiveClassMeeting;
use Modules\Jitsi\Entities\JitsiMeeting;
use Modules\Payment\Entities\Cart;
use Modules\StudentSetting\Entities\BookmarkCourse;
use Modules\VirtualClass\Entities\ClassComplete;
use Modules\VirtualClass\Entities\CustomMeeting;
use Modules\Zoom\Entities\ZoomMeeting;

class ClassDetailsPageSection extends Component
{
    public $course, $request;

    public function __construct($course, $request)
    {
        $this->course = $course;
        $this->request = $request;
    }


    public function render()
    {
        $course_reviews = DB::table('course_reveiws')->select('user_id')
            ->where('status',1)
            ->where('course_id', $this->course->id)->get();

        if (Auth::check()) {
            $isEnrolled = $this->course->isLoginUserEnrolled;
        } else {
            $isEnrolled = false;
        }


        $bookmarked = BookmarkCourse::where('user_id', Auth::id())->where('course_id', $this->course->id)->count();
        if ($bookmarked == 0) {
            $isBookmarked = false;
        } else {
            $isBookmarked = true;

        }


        if ($this->course->price == 0) {
            $isFree = true;
        } else {
            $isFree = false;
        }

        if ($isEnrolled) {
            $enroll = CourseEnrolled::where('user_id', Auth::id())->where('course_id', $this->course->id)->first();
            if ($enroll) {
                if ($enroll->subscription == 1) {
                    if (isModuleActive('Subscription')) {
                        if (!isSubscribe()) {
                            Toastr::error(trans('frontend.Subscription has expired, Please Subscribe again'), trans('common.Failed'));
                            return redirect()->route('courseSubscription')->send();
                        }
                    }
                }
            }
        }

        if (Auth::check() && $this->course->isLoginUserEnrolled) {


            if ($this->course->class->host == "Zoom") {
                $nextMeeting = ZoomMeeting::where('class_id', $this->course->class->id)->where('date_of_meeting', date('m/d/Y'))
                    ->orderBy('start_time', 'asc')
                    ->get();
                $this->course->nextMeeting = null;
                $hasClass = false;
                foreach ($nextMeeting as $next) {
                    if ($next->currentStatus == "closed") {
                        continue;
                    } else {
                        if (!$hasClass) {
                            $this->course->nextMeeting = $next;
                            $hasClass = true;
                        }
                    }
                }

            } elseif ($this->course->class->host == "BBB") {
                if (isModuleActive("BBB")) {

                    $nextMeeting = BbbMeeting::where('class_id', $this->course->class->id)->where('date', date('m/d/Y'))
                        ->orderBy('datetime', 'asc')->first();
                    $this->course->nextMeeting = $nextMeeting;

                } else {
                    Toastr::error(trans('frontend.Module is not activated'), trans('common.Failed'));
                }

            } elseif ($this->course->class->host == "Jitsi") {
                if (isModuleActive("Jitsi")) {

                    $nextMeeting = JitsiMeeting::where('class_id', $this->course->class->id)->where('date', date('m/d/Y'))->first();
                    if ($nextMeeting) {
                        $nextMeeting->isRunning = true;
                    }
                    $this->course->nextMeeting = $nextMeeting;

                } else {
                    Toastr::error(trans('frontend.Module is not activated'), trans('common.Failed'));
                }

            } elseif ($this->course->class->host == "Custom") {

                $nextMeeting = CustomMeeting::where('class_id', $this->course->class->id)->whereNotNull('link')->where('date', date('m/d/Y'))->first();
                if ($nextMeeting) {
                    $nextMeeting->isRunning = true;
                }
                $this->course->nextMeeting = $nextMeeting;

            } elseif ($this->course->class->host == "InAppLiveClass") {
                if (isModuleActive("InAppLiveClass")) {

                    $nextMeeting = InAppLiveClassMeeting::where('class_id', $this->course->class->id)->where('date', date('m/d/Y'))->first();
                    if ($nextMeeting) {
                        $nextMeeting->isRunning = true;
                    }
                    $this->course->nextMeeting = $nextMeeting;

                } else {
                    Toastr::error(trans('frontend.Module is not activated'), trans('common.Failed'));
                }

            } elseif ($this->course->class->host == "GoogleMeet") {
                if (isModuleActive("GoogleMeet")) {
                    $nextMeeting = GoogleMeetMeeting::where('class_id', $this->course->class->id)
                        ->where(DB::raw('DATE(start_date_time)'), date('Y-m-d'))
                        ->orderBy('start_date_time', 'asc')
                        ->get();
                    $this->course->nextMeeting = null;
                    $hasClass = false;
                    foreach ($nextMeeting as $next) {
                        if ($next->currentStatus == "closed") {
                            continue;
                        } else {
                            if (!$hasClass) {
                                $this->course->nextMeeting = $next;
                                $hasClass = true;
                            }
                        }
                    }

                } else {
                    Toastr::error(trans('frontend.Module is not activated'), trans('common.Failed'));
                }
            }


        }
        $reviewer_user_ids = [];
        foreach ($this->course->reviews as $key => $review) {
            $reviewer_user_ids[] = $review->user_id;
        }


        $course_enrolled_std = [];
        foreach ($this->course->enrolls as $key => $enroll) {
            $course_enrolled_std[] = $enroll['user_id'];
        }


        $related = Course::where('category_id', $this->course->category_id)->where('id', '!=', $this->course->id)->take(2)->get();

        $is_cart = 0;
        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->where('course_id', $this->course->id)->first();
            if ($cart) {
                $is_cart = 1;
            }
        } else {
            $sessonCartList = session()->get('cart');
            if (!empty($sessonCartList)) {
                foreach ($sessonCartList as $item) {
                    if ($item['course_id'] == $this->course->id) {
                        $is_cart = 1;
                    }
                }
            }
        }


        $class = $this->course->class;
        $last_time = Carbon::parse($class->end_date . ' ' . $class->time);
        $nowDate = Carbon::now();
        $isWaiting = $last_time->gt($nowDate);
        $certificateCanDownload = false;
        if (!$isWaiting) {
            if (Auth::check() && $isEnrolled) {
                $totalClass = $class->total_class;
                $completeClass = ClassComplete::where('course_id', $this->course->id)->where('class_id', $class->id)->count();
                if ($totalClass == $completeClass) {
                    if (isModuleActive('CertificatePro') && Settings('use_certificate_template') == 'pro') {
                        $hasCertificate = $this->course->pro_certificate_id;
                    } else {
                        $hasCertificate = $this->course->certificate_id;
                    }

                    if (!empty($hasCertificate)) {

                        if (isModuleActive('CertificatePro') && Settings('use_certificate_template') == 'pro') {
                            $certificate = CertificateTemplate::find($hasCertificate);
                        } else {
                            $certificate = Certificate::find($hasCertificate);
                        }
                        if ($certificate) {
                            $certificateCanDownload = true;
                        }

                    } else {


                        if (isModuleActive('CertificatePro') && Settings('use_certificate_template') == 'pro') {
                            $certificate = CertificateTemplate::where('default_for', 'l')->first();
                        } else {
                            $certificate = Certificate::where('for_class', 1)->first();
                        }

                        if ($certificate) {
                            $certificateCanDownload = true;
                        }
                    }
                }
            }
        }
        $userRating = userRating($this->course->user_id);
        $data = [];
        if (currentTheme() == 'teachery') {
            $data['categories'] = Category::where('status', 1)->take(12)->get();
        }

        $others = Course::with('activeReviews', 'enrollUsers', 'cartUsers', 'lessons','enrollUsers','lessons')
            ->whereHas('enrollUsers')
            ->whereNot('id', $this->course->id)
            ->take(6)
            ->get();

        return view(theme('components.class-details-page-section'), $data, compact('userRating', 'certificateCanDownload', 'isWaiting', 'is_cart', 'reviewer_user_ids', 'related', 'isFree', 'isBookmarked', 'isEnrolled','others'));
    }
}
