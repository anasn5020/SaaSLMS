<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Modules\CourseSetting\Entities\Category;
use Modules\UpcomingCourse\Entities\UpcomingCourseBooking;
use Modules\UpcomingCourse\Entities\UpcomingCourseFollower;

class MyUpcomingFollowingCoursesPageSection extends Component
{
    public $request, $page;

    public function __construct($request, $page)
    {
        $this->request = $request;
        $this->page = $page;
    }


    public function render()
    {
        $data['categories'] = Category::where('status', 1)->with('activeSubcategories')->orderBy('position_order', 'asc')->get();

        if ($this->page == 'following') {
            $courses = UpcomingCourseFollower::query()
                ->with(['course'])
                ->where('user_id', Auth::id());
            $data['search_text'] = trans('frontend.Search My Following Courses');
            $data['page_heading'] = trans('courses.My Following Courses');
        } else {
            $courses = UpcomingCourseBooking::query()
                ->with(['course'])
                ->where('user_id', Auth::id());
            $data['search_text'] = trans('frontend.Search My Booking Courses');
            $data['page_heading'] = trans('courses.My Booking Courses');


        }


        if ($this->request->category) {
            $category_id = $this->request->category;
            $courses->whereHas('course', function ($query) use ($category_id) {
                $query->where('category_id', $category_id);
            });

        } else {
            $category_id = '';
        }
        $data['category_id'] = $category_id;

        if ($this->request->search) {
            $search = $this->request->search;
            $courses->whereHas('course', function ($query) use ($search) {
                $query->where('title', 'LIKE', '%' . $search . '%');
            });
        } else {
            $search = '';
        }
        $data['search'] = $search;

        $data['courses'] = $courses->latest()->paginate(12);
        return view(theme('components.my-upcoming-following-courses-page-section'), $data);
    }

}
