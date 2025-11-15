<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Modules\CourseSetting\Entities\Course;

class HomePageLiveClassSection extends Component
{
    public $homeContent;

    public function __construct($homeContent)
    {
        $this->homeContent = $homeContent;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $with = ['activeReviews', 'enrollUsers', 'cartUsers', 'class', 'class.zoomMeetings', 'user', 'reviews','BookmarkUsers'];
        if (isModuleActive('BBB')) {
            $with[] = 'class.bbbMeetings';
        }
        if (isModuleActive('Jisti')) {
            $with[] = 'class.jitsiMeetings';
        }
        $top_live_classes = Course::orderBy('total_enrolled', 'desc')->where('status', 1)
            ->where('type', 3)->take(4)->with($with)
            ->get();
        return view(theme('components.home-page-live-class-section'), compact('top_live_classes'));
    }
}
