<?php

namespace App\Repositories\Eloquents;

use App\User;
use Carbon\Carbon;
use App\TopicReport;
use Modules\Setting\Entities\Badge;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\CourseEnrolled;
use App\Http\Resources\api\v2\User\UserDetailsResource;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use App\Http\Resources\api\v2\Student\StudentListResource;
use App\Http\Resources\api\v2\Badge\ActiveBadgeListResource;

class AdminRepository implements AdminRepositoryInterface
{
    public function studentList(object $request): object
    {
        $students = User::query();
        if (isModuleActive('LmsSaas')) {
            $students->where('lms_id', app('institute')->id)
                ->whereHas('role', function ($role) {
                    $role->where('id', 3);
                })
                ->when($request->search, function ($query) use ($request) {
                    $query->where('name', 'like', "%$request->search%")
                        ->orWhere('email', 'like', "%$request->search%")
                        ->orWhere('phone', 'like', "%$request->search%");
                });
        } else {
            $students->where('lms_id', 1)
                ->whereHas('role', function ($role) {
                    $role->where('id', 3);
                })
                ->when($request->search, function ($query) use ($request) {
                    $query->where('name', 'like', "%$request->search%")
                        ->orWhere('email', 'like', "%$request->search%")
                        ->orWhere('phone', 'like', "%$request->search%");
                });
        }
        if (isModuleActive('UserType')) {
            $students->whereHas('userRoles', function ($q) {
                $q->where('role_id', 3);
            })
                ->when($request->search, function ($query) use ($request) {
                    $query->where('name', 'like', "%$request->search%")
                        ->orWhere('email', 'like', "%$request->search%")
                        ->orWhere('phone', 'like', "%$request->search%");
                });
        } else {
            $students->whereHas('role', function ($role) {
                $role->where('id', 3);
            })
                ->when($request->search, function ($query) use ($request) {
                    $query->where('name', 'like', "%$request->search%")
                        ->orWhere('email', 'like', "%$request->search%")
                        ->orWhere('phone', 'like', "%$request->search%");
                });
        }
        return StudentListResource::collection($students->paginate($request->per_page ?? 15));
    }

    public function changeStudentStatus(object $request): bool
    {
        $student = User::whereHas('role', function ($role) {
            $role->where('id', 3);
        })->where('is_active', 1)->find($request->student_id);
        $student->update([
            'status' => (bool)$request->status
        ]);
        return true;
    }

    public function studentDetail(object $request): object
    {
        $student = User::whereHas('role', function ($role) {
            $role->where('id', 3);
        })
            ->with('userInfo')
            ->where('is_active', 1)->find($request->student_id);
        return new UserDetailsResource($student);
    }

    public function dashboard(): array
    {
        $user = auth()->user();
        if ($user->role_id == 2) {
            $allCourseEnrolled = CourseEnrolled::with('user', 'course')
                ->whereHas('course', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })->get();

            $allCourses = Course::where('user_id', $user->id)->get();

            $thisMonthEnroll = CourseEnrolled::whereYear('created_at', Carbon::now()->year)
                ->whereMonth('created_at', Carbon::now()->format('m'))
                ->whereHas('course', function ($query) use ($user) {
                    $query->where('user_id', '=', $user->id);
                })->sum('purchase_price');


            $today = CourseEnrolled::whereDate('created_at', Carbon::today())
                ->whereHas('course', function ($query) use ($user) {
                    $query->where('user_id', '=', $user->id);
                })->sum('purchase_price');


            $rev = $allCourseEnrolled->sum('reveune');
        } else {
            $query = CourseEnrolled::query();
            if (isModuleActive('Organization') && auth()->user()->isOrganization()) {
                $query->whereHas('course.user', function ($q) {
                    $q->where('organization_id', auth()->id());
                    $q->orWhere('id', auth()->id());
                });
            }
            $allCourseEnrolled = $query->get();
            $query2 = Course::query();
            if (isModuleActive('Organization') && auth()->user()->isOrganization()) {
                $query2->whereHas('user', function ($q) {
                    $q->where('organization_id', auth()->id());
                    $q->orWhere('id', auth()->id());
                });
            }
            $allCourses = $query2->get();

            $query3 = CourseEnrolled::whereYear('created_at', Carbon::now()->year)
                ->whereMonth('created_at', Carbon::now()->format('m'));

            if (isModuleActive('Organization') && auth()->user()->isOrganization()) {
                $query3->whereHas('course.user', function ($q) {
                    $q->where('organization_id', auth()->id());
                    $q->orWhere('id', auth()->id());
                });
            }

            $thisMonthEnroll = $query3->sum('purchase_price');

            $query4 = CourseEnrolled::whereDate('created_at', Carbon::today());
            if (isModuleActive('Organization') && auth()->user()->isOrganization()) {
                $query4->whereHas('course.user', function ($q) {
                    $q->where('organization_id', auth()->id());
                    $q->orWhere('id', auth()->id());
                });
            }
            $today = $query4->sum('purchase_price');

            $rev = (isModuleActive('Organization') && auth()->user()->isOrganization()) ? $allCourseEnrolled->sum('reveune') : $allCourseEnrolled->sum('purchase_price') - $allCourseEnrolled->sum('reveune');
        }

        $courses = Course::with('user', 'enrolls');

        if (isModuleActive('Organization') && auth()->user()->isOrganization()) {
            $courses->whereHas('user', function ($q) {
                $q->where('organization_id', auth()->id());
                $q->orWhere('id', auth()->id());
            });
        }
        $course = $courses->get();

        $data['academic_status'] = [
            'course'    => empty($course->where('type', 1)->where('status', 1)),
            'quize'     => empty($course->where('type', 2)->where('status', 1)),
            'class'     => empty($course->where('type', 3)->where('status', 1)),
        ];

        $data['info'] = [
            'course'                => (int)$allCourses->count(),
            'enrolled'              => (int)$allCourseEnrolled->count(),
            'enrolled_today'       => (float)$today,
            'enrolled_amount'       => (float)$allCourseEnrolled->sum('purchase_price'),
            'this_month_enrolled'   => (float)$thisMonthEnroll,
            'revenue'               => (float)$rev,
        ];

        $data['overview_topics'] = [
            'active_topics'     => (int)$course->where('status', 1)->count(),
            'pending_topics'    => (int)$course->where('status', 0)->count(),
            'courses'           => (int)$course->where('type', 1)->count(),
            'quizes'            => (int)$course->where('type', 2)->count(),
            'classes'           => (int)$course->where('type', 3)->count(),
            'others'            => (int)TopicReport::count(),
        ];

        $data['upcoming_badges'] = ActiveBadgeListResource::collection(Badge::where('status', 1)->get());

        return $data;
    }
}
