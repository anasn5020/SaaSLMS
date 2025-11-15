<?php

namespace App\View\Components;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Modules\CourseSetting\Entities\Category;
use Modules\CourseSetting\Entities\CourseEnrolled;
use Modules\CPD\Repositories\Interfaces\CpdRepositoryInterface;

class MyCoursesPageSection extends Component
{
    public $request;
    private $cpdRepository;

    public function __construct(
        $request
    )
    {
        $this->request = $request;
    }


    public function render()
    {
        if (routeIs('myClasses')) {
            $type = 3;
        } elseif (routeIs('myQuizzes')) {
            $type = 2;
        } elseif (routeIs('myCourses')) {
            $type = 1;
        } else {
            $type = 4;
        }

        $with = ['course', 'course.activeReviews', 'course.courseLevel', 'course.BookmarkUsers', 'course.user', 'course.reviews', 'course.enrollUsers'];

        if ($type == 1) {
            $with[] = 'course.completeLessons';
            $with[] = 'course.lessons';
        } elseif ($type == 2) {
            $with[] = 'course.quiz';
            $with[] = 'course.quiz.assign';
        } elseif ($type == 3) {
            $with[] = 'course.class';
            $with[] = 'course.class.zoomMeetings';
            if (isModuleActive('BBB')) {
                $with[] = 'course.class.bbbMeetings';
            }
            if (isModuleActive('Jisti')) {
                $with[] = 'course.class.jitsiMeetings';
            }
        }
        $per_page = 16;
        // Initialize variables
        $category_id = $this->request->category ?? '';
        $search = $this->request->search ?? '';

// Build the base query
        $query = CourseEnrolled::where('user_id', Auth::user()->id)
            ->whereHas('course', function ($query) use ($type, $category_id, $search) {
                $query->where('type', '=', $type)
                    ->where('status', '=', 1);

                // Apply category filter if provided
                if ($category_id) {
                    $query->where(function ($query) use ($category_id) {
                        $query->where('category_id', $category_id);
                        $query->orWhere('subcategory_id', $category_id);
                        $query->orWhereHas('quiz', function ($query) use ($category_id) {
                            $query->where('category_id', $category_id);
                            $query->orWhere('sub_category_id', $category_id);
                        });
                        $query->orWhereHas('virtualClass', function ($query) use ($category_id) {
                            $query->where('category_id', $category_id);
                            $query->orWhere('sub_category_id', $category_id);
                        });
                    });
                 }

                // Apply search filter if provided
                if ($search) {
                    $query->whereLike('title', $search);
                }
            })
            ->with($with)
            ->latest();

// Paginate the final query result
        $courses = $query->paginate($per_page);


        $categories = Category::where('status', 1)->with('activeSubcategories')->orderBy('position_order', 'asc')->get();
        $data = [];

        if (Settings('frontend_active_theme') == 'wetech') {

        }

        if (isModuleActive('CPD')) {
            $interface = App::make(CpdRepositoryInterface::class);
            $data['cpds'] = $interface->studentCpd(auth()->user()->id);
        }
        return view(theme('components.my-courses-page-section'), $data, compact('category_id', 'search', 'courses', 'categories'));
    }
}
