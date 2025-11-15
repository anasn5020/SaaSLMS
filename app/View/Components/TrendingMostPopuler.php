<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Modules\CourseSetting\Entities\Course;

class TrendingMostPopuler extends Component
{
    private $title, $subtitle;

    public function __construct($title, $subtitle)
    {
        $this->title = $title;
        $this->subtitle = $subtitle;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $title = $this->title;
        $subtitle = $this->subtitle;

        $with = ['user', 'category', 'subCategory', 'enrolls', 'comments', 'reviews', 'lessons', 'activeReviews', 'enrollUsers', 'cartUsers', 'courseLevel', 'BookmarkUsers'];
        $query = Course::where('scope', 1);

        if (routeIs('courses')) {
            $query->where('type', 1);
        } elseif (routeIs('quizzes')) {
            $with[] = 'quiz.assign';

            $query->where('type', 2);
        } elseif (routeIs('classes')) {
            $with[] = 'class.zoomMeetings';
            if (isModuleActive('BBB')) {
                $with[] = 'class.bbbMeetings';
            }
            if (isModuleActive('Jisti')) {
                $with[] = 'class.jitsiMeetings';
            }
            $query->where('type', 3);
        }
        $query->with($with);
        $query->where('status', 1);

        $populers = $query->orderBy('total_enrolled', 'desc')->take(4)->get();
        $trands = $query->orderBy('view', 'desc')->take(4)->get();
        $latest = $query->orderBy('created_at', 'desc')->take(4)->get();
        return view(theme('components.trending-most-populer'), compact('title', 'subtitle', 'populers', 'trands', 'latest'));
    }
}
