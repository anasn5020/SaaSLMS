<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Traits\GoogleAnalytics4;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\CourseComment;
use Modules\CourseSetting\Entities\CourseEnrolled;
use Modules\FrontendManage\Entities\FrontPage;

class CourseController extends Controller
{
    use GoogleAnalytics4;

    public function __construct()
    {
        $this->middleware(['maintenanceMode', 'onlyAppMode']);
    }


    public function courses(Request $request)
    {
        try {
            if (hasDynamicPage()) {
                $row = FrontPage::where('slug', '/courses')->first();
                $details = dynamicContentAppend($row->details);
                return view('aorapagebuilder::pages.show', compact('row', 'details'));
            } else {
                return view(theme('pages.courses'), compact('request'));
            }
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function freeCourses(Request $request)
    {
        try {

            if (hasDynamicPage()) {
                $row = FrontPage::where('slug', 'free-course')->first();
                $details = dynamicContentAppend($row->details);
                return view('aorapagebuilder::pages.show', compact('row', 'details'));
            } else {
                return view(theme('pages.free_courses'), compact('request'));
            }


        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function courseDetails($slug, Request $request)
    {

        try {
            $is_cart = 0;
            $course = Course::with('enrollUsers', 'user', 'user.courses', 'user.courses.enrollUsers', 'user.courses.lessons', 'chapters.lessons', 'enrolls', 'lessons', 'reviews', 'chapters', 'activeReviews')
                ->where('slug', $slug)->first();

            if (!$course) {
                Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
                return redirect()->back();
            }


            $this->postEvent([
                'name' => 'view_item',
                'params' => [
                    "items" => [
                        [
                            "item_id" => $course->id,
                            "item_name" => $course->title,
                            'type' => 'course',
                            "price" => !empty($course->discount_price) ? $course->discount_price : $course->price,
                        ]
                    ],
                ],
            ]);

            if (!isViewable($course)) {
                Toastr::error(trans('common.Access Denied'), trans('common.Failed'));
                return redirect()->to(route('courses'));
            }
            if (Auth::check()) {
                $isEnrolled = $course->isLoginUserEnrolled;
            } else {
                $isEnrolled = false;
            }

            if ($isEnrolled) {
                $enroll = CourseEnrolled::where('user_id', Auth::id())->where('course_id', $course->id)->first();
                if ($enroll) {
                    if ($enroll->subscription == 1) {
                        if (isModuleActive('Subscription')) {
                            if (!isSubscribe()) {
                                Toastr::error(trans('frontend.Subscription has expired, Please Subscribe again'), trans('common.Failed'));

                                 return redirect()->route('courseSubscription');
                            }
                        }
                    }
                }
            }

            $data = '';
            if ($request->ajax()) {
                if ($request->type == "comment") {
                    $comments = CourseComment::where('course_id', $course->id)->withCount('replies')
                        ->where('status', 1)
                        ->orderByDesc("replies_count")
                        ->orderBy('id', 'DESC')->with('replies', 'replies.user', 'user')->get();
                    foreach ($comments as $comment) {
                        $data .= view(theme('partials._single_comment'), ['comment' => $comment, 'isEnrolled' => $isEnrolled, 'course' => $course])->render();
                    }
                    return $data;
                }

            }


            if ($request->ajax()) {
                if ($request->type == "review") {
                    $reviews = DB::table('course_reveiws')
                        ->select(
                            'course_reveiws.id',
                            'course_reveiws.star',
                            'course_reveiws.comment',
                            'course_reveiws.instructor_id',
                            'course_reveiws.created_at',
                            'users.id as userId',
                            'users.name as userName',
                        )
                        ->join('users', 'users.id', '=', 'course_reveiws.user_id')
                        ->where('course_reveiws.status',1)
                        ->where('course_reveiws.course_id', $course->id)->get();
                    foreach ($reviews as $review) {
                        $data .= view(theme('partials._single_review'), ['review' => $review, 'isEnrolled' => $isEnrolled, 'course' => $course])->render();
                    }
                    if (count($reviews) == 0) {
                        $data .= '';
                    }
                    return $data;
                }
            }


            $course->view = $course->view + 1;
            $course->save();

            if ($course->host == "VdoCipher") {
                $websiteController = new WebsiteController();
                $otp = $websiteController->getOTPForVdoCipher($course->trailer_link);
                $course->otp = $otp['otp'];
                $course->playbackInfo = $otp['playbackInfo'];
            }
            if ($course->type == 1) {
                return view(theme('pages.courseDetails'), compact('request', 'course', 'isEnrolled'));
            } elseif ($course->type == 2 || $course->type == 3) {
                return \redirect()->to(courseDetailsUrl($course->id, $course->type, $course->slug));
            }


        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function offer(Request $request)
    {
        try {
            return view(theme('pages.offer'), compact('request'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }
}
