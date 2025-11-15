<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\View\Components\MyOrgSubscriptionPlanSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\CourseEnrolled;
use Modules\Org\Entities\OrgBranch;
use Modules\Org\Entities\OrgLeaderboardUser;
use Modules\Org\Entities\OrgLeaderboardUserPoint;
use Modules\OrgSubscription\Entities\OrgCourseSubscription;
use Modules\AdvanceQuiz\Entities\OnlineQuizTestShift;

class WeTechFrontendThemeController extends Controller
{
    public function route($route_name, Request $request)
    {
        try {

            if ($route_name == 'quizList') {
                if ($request->type == 'online') {
                    $mode_of_delivery = 1;
                } elseif ($request->type == 'offline') {
                    $mode_of_delivery = 3;
                } else {
                    $mode_of_delivery = '';
                }
                if ($request->type == 'quiz') {
                    $type2 = $request->type;
                } else {
                    $type2 = 0;
                }
                $type = $request->type;
                $status = $request->status;
                $order = $request->order;
                $search = $request->search;
                $with = [];
//                $with = ['course', 'course.activeReviews', 'course.courseLevel', 'course.BookmarkUsers', 'course.user', 'course.reviews', 'course.enrollUsers'];
//                $with[] = 'course.quiz';
//                $with[] = 'course.quiz.assign';
                $query = CourseEnrolled::where('user_id', Auth::id())
                    ->where(function ($q) {
                        $q->where('org_subscription_plan_id', '=', 0);
                        $q->orWhereHas('orgSubscriptionPlan', function ($q) {
                            $q->where('status', 1);
                        });
                    })
                    ->whereHas('course', function ($query) use ($type, $search) {
                        if (!empty($search)) {
                            $query->where('title', 'LIKE', "%{$search}%");
                        }
                        $query->where('type', '=', 2);
                        $query->where('status', 1);
                        $query->whereHas('quiz', function ($query) {
                            $query->where(function ($q) {
                                if (!empty(request('category'))) {
                                    $q->where('category_id', \request('category'));
                                    $q->orWhere('sub_category_id', \request('category'));
                                }
                            });
                        });

                    });
                if (!empty($mode_of_delivery)) {
                    $query->whereHas('course', function ($query) use ($mode_of_delivery) {
                        $query->where('mode_of_delivery', '=', $mode_of_delivery);
                    });
                }
                if ($request->limit == 1) {
                    $limit = true;
                } else {
                    $limit = false;
                }

                if ($order == 'title') {
                    $query->orderBy(
                        Course::select('title')
                            ->whereColumn('course_id', 'courses.id')
                            ->orderBy('title')
                            ->limit(1)
                    );
                } elseif ($order == 'start_date') {
                    $query->orderBy(
                        OrgCourseSubscription::select('join_date')
                            ->whereColumn('org_subscription_plan_id', 'org_course_subscriptions.id')
                            ->orderBy('join_date')
                            ->limit(1)
                    );
                } elseif ($order == 'end_date') {
                    $query->orderBy('subscription_validity_time');
                    $query->orderBy(
                        OnlineQuizTestShift::select('end_date')
                            ->whereColumn('course_id', 'online_quiz_test_shifts.test_id')
                            ->orderByRaw("DATE_FORMAT('d-m-Y',end_date)")
                            ->limit(1)
                    );

                }
                $query->with($with);
                $courses = $query->get();

                return view(theme('partials._quiz_list'), compact('courses', 'type', 'status', 'limit', 'type2', 'search'));
            } elseif ($route_name == 'courseList') {
                if ($request->type == 'online') {
                    $mode_of_delivery = 1;
                } elseif ($request->type == 'offline') {
                    $mode_of_delivery = 3;
                } else {
                    $mode_of_delivery = '';
                }
                $type = $request->type;
                $status = $request->status;
                $search = $request->search;
                $order = $request->order;
                $request_form = $request->request_form;
                $with = [];
//                $with = ['course', 'course.activeReviews', 'course.courseLevel', 'course.BookmarkUsers', 'course.user', 'course.reviews', 'course.enrollUsers'];
//                $with[] = 'course.quiz';
//                $with[] = 'course.quiz.assign';
//                $with[] = 'course.orgSubscriptionCourseList';
                $query = CourseEnrolled::where('user_id', Auth::user()->id)
                    ->where(function ($q) {
                        $q->where('org_subscription_plan_id', '=', 0);
                        $q->orWhereHas('orgSubscriptionPlan', function ($q) {
                            $q->where('status', 1);
                        });
                    })
                    ->whereHas('course', function ($query) use ($type) {
                        if (\request()->type == 'class') {
                            $course_type = [3];
                        } elseif (\request()->type == 'online' || \request()->type == 'offline') {
                            $course_type = [1];
                        } else {
                            $course_type = [1, 3];
                        }
                        $query->whereIn('type', $course_type);
                        $query->where('status', 1);

                        $query->where(function ($q) {
                            if (!empty(request('category'))) {
                                $q->where('category_id', \request('category'));
                                $q->orWhere('subcategory_id', \request('category'));
                            }
                        });
                    });
                if (!empty($mode_of_delivery)) {
                    $query->whereHas('course', function ($query) use ($mode_of_delivery) {
                        $query->where('mode_of_delivery', '=', $mode_of_delivery);
                    });
                }
                if (!empty($search)) {
                    $query->whereHas('course', function ($query) use ($search) {
                        $query->where('title', 'LIKE', "%{$search}%");

                    });
                }
                if ($request->limit == 1) {
                    $limit = true;
                } else {
                    $limit = false;
                }
                if ($order == 'title') {
                    $query->orderBy(
                        Course::select('title')
                            ->whereColumn('course_id', 'courses.id')
                            ->orderBy('title')
                            ->limit(1)
                    );
                } elseif ($order == 'start_date') {
                    $query->orderBy(
                        OrgCourseSubscription::select('join_date')
                            ->whereColumn('org_subscription_plan_id', 'org_course_subscriptions.id')
                            ->orderBy('join_date')
                            ->limit(1)
                    );
                } elseif ($order == 'end_date') {
                    $query->orderBy(
                        OrgCourseSubscription::select('end_date')
                            ->whereColumn('org_subscription_plan_id', 'org_course_subscriptions.id')
                            ->orderBy('end_date')
                            ->limit(1)
                    );
                }

                $query->with($with);
                $courses = $query->get();
                return view(theme('partials._course_list'), compact('courses', 'type', 'status', 'limit', 'search', 'request_form'));
            } elseif ($route_name == 'orgSubPlanSection') {
                $MyOrgSubscriptionPlanSection = new MyOrgSubscriptionPlanSection($request);
                return $MyOrgSubscriptionPlanSection->render();

            } elseif ($route_name == 'learningScheduleList') {
                $month = $request->month;
                $year = $request->year;

                $open_started = CourseEnrolled::whereYear('created_at', '=', $year)
                    ->whereMonth('created_at', '=', $month)
                    ->with('course')
                    ->whereHas('course', function ($q) {
                        $q->where('required_type', 0);

                    })
                    ->where('user_id', \auth()->id())
                    ->get();

                $close_started = CourseEnrolled::with('orgSubscriptionPlan', 'course')
                    ->whereHas('course', function ($q) {
                        $q->where('required_type', 1);

                    })
                    ->whereHas('orgSubscriptionPlan', function ($q) use ($month, $year) {
                        $q->whereHas('checkouts', function ($q2) use ($month, $year) {
                            $q2->whereMonth('start_date', '=', $month);
                            $q2->whereYear('start_date', '=', $year);
                            $q2->where('user_id', '=', \auth()->id());
                        });

                    })
                    ->where('user_id', \auth()->id())
                    ->get();

                $ended = CourseEnrolled::whereYear('subscription_validity_date', '=', $year)
                    ->whereMonth('subscription_validity_date', '=', $month)
                    ->with('orgSubscriptionPlan', 'course')
                    ->where('user_id', \auth()->id())
                    ->get();

                return view(theme('partials._schedule_list'), compact('month', 'year', 'open_started', 'close_started', 'ended'));
            } elseif ($route_name == 'branch_list_checkbox') {
                $status = $request->boolean('status');
                $branches = OrgBranch::withCount('childs')->where('parent_id', $request->id)->orderBy('order', 'asc')->get();
                return view('org::branch.ajax_tree_branch_list', compact('branches', 'status'));

            } elseif ($route_name == 'leaderboardList') {
                $userLeaderBoard = OrgLeaderboardUser::find($request->id);
                $items = OrgLeaderboardUserPoint::where('leaderboard_user_id', $request->id)
                    ->where('leaderboard_id', $userLeaderBoard->leaderboard_id)
                    ->where('user_id', $request->user_id)
                    ->where('point', '!=', 0)
                    ->get();
                return view(theme('partials._student_points'), compact('items', 'userLeaderBoard'));
            } else {
                return '';
            }
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }
}
