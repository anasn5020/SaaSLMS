<?php

namespace App\View\Components;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\CourseEnrolled;
use Modules\CourseSetting\Entities\CourseLevel;
use Modules\Forum\Entities\Forum;
use Modules\Payment\Entities\Cart;
use Modules\StudentSetting\Entities\BookmarkCourse;

class ProductDeatilsPageSection extends Component
{
    public $request, $course, $isEnrolled;

    public function __construct($request, $course, $isEnrolled)
    {
        $this->request = $request;
        $this->course = $course;
        $this->isEnrolled = $isEnrolled;
    }


    public function render()
    {


        $related = Course::where('category_id', $this->course->category_id)->with('activeReviews', 'enrollUsers', 'cartUsers', 'lessons')
            ->where('id', '!=', $this->course->id)->with('lessons')->take(2)->get();


        $userRating = userRating($this->course->user_id);
        $course_exercises = DB::table('course_exercises')
            ->select('file', 'fileName', 'lock', 'status')
            ->where('course_id', $this->course->id)
            ->where('status', 1)
            ->get();
        $course_reviews = DB::table('course_reveiws')->select('user_id')
            ->where('status',1)->where('course_id', $this->course->id)->get();
        $course_enrolls = DB::table('course_enrolleds')->select('user_id')->where('course_id', $this->course->id)->get();


        $bookmarked = BookmarkCourse::where('user_id', Auth::id())->where('course_id', $this->course->id)->count();
        if ($bookmarked == 0) {
            $isBookmarked = false;
        } else {
            $isBookmarked = true;

        }
        $is_cart = 0;
        if (Auth::check()) {
            $reviewPermission = CourseEnrolled::where('user_id', Auth::user()->id)->where('course_id', $this->course->id)->where('status', 1)->count();
            $cart = Cart::where('user_id', Auth::id())->where('course_id', $this->course->id)->first();
            if ($cart) {
                $is_cart = 1;
            }
        } else {
            $reviewPermission = 0;
            $sessonCartList = session()->get('cart');
            if (!empty($sessonCartList)) {
                foreach ($sessonCartList as $item) {
                    if ($item['course_id'] == $this->course->id) {
                        $is_cart = 1;
                    }
                }
            }
        }


        if ($this->course->price == 0) {
            $isFree = true;
        } else {
            $isFree = false;
        }


        $reviewer_user_ids = [];
        foreach ($course_reviews as $key => $review) {
            $reviewer_user_ids[] = $review->user_id;
        }

        $course_enrolled_std = [];
        foreach ($course_enrolls as $key => $enroll) {
            $course_enrolled_std[] = $enroll->user_id;
        }


        $today = Carbon::now()->toDateString();
        $showDrip = Settings('show_drip') ?? 0;
        $all = $this->course->lessons;
        $lessons = [];
        if ($this->course->drip == 1) {
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
                                $enrolled = DB::table('course_enrolleds')->where('user_id', Auth::user()->id)->where('course_id', $this->course->id)->where('status', 1)->first();
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
        $levels = CourseLevel::select('id', 'title')->where('status', 1)->get();

        $data = [];
        if (isModuleActive("Forum")) {
            $query = Forum::where('forums.topic_type', 1)
                ->where('forums.course_id', $this->course->id)
                ->where('forums.parent_id', 0)
                ->where(function ($q) {
                    $q->whereHas('course', function ($q2) {
                        $q2->where('status', 1);
                    });
                })
                ->whereNull('forums.deleted_at')
                ->with('course', 'course.category', 'course.user')
                ->withCount('threads', 'views', 'replies', 'likes')
                ->orderBy('pin', 'desc');

            $data['topics'] = $query->paginate(10);

        }
        return view(theme('components.product-details-page-section'), $data, compact('is_cart', 'levels', 'related', 'userRating', 'lessons', 'total', 'isFree', 'isBookmarked', 'course_exercises', 'reviewer_user_ids', 'course_enrolled_std', 'reviewPermission'));
    }
}
