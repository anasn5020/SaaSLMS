<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Modules\CourseSetting\Entities\Course;

class EdumeFrontendThemeController extends Controller
{
    public function getCourseByCategory($category_id)
    {

        $query = Course::where('status', 1)
            ->with('courseLevel', 'user', 'reviews', 'lessons', 'BookmarkUsers', 'cartUsers', 'enrollUsers')
            ->where('type', 1);

        if ($category_id != 0) {
            $query->where('category_id', $category_id)->orWhere('subcategory_id', $category_id);
        }
        $courses = $query->latest()->limit(10)->get();
        $result = '  <div class="lms_course_grid">';
        $i = 0;
        foreach ($courses as $key => $course) {
            if ($i > 2) {
                $hover = 'right';
            } else {
                $hover = 'left';
            }
            $i++;
            if ($i == 5) {
                $i = 0;
            }
            $result .= view(theme('components.single-course-with-out-column'), compact('course', 'hover'));
        }

        $result .= '  </div > ';

        return $result;
    }
}
