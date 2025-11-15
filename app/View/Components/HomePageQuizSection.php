<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Modules\CourseSetting\Entities\Course;

class HomePageQuizSection extends Component
{
    public $homeContent;

    public function __construct($homeContent)
    {
        $this->homeContent = $homeContent;
    }

    public function render()
    {
        $top_quizzes = Course::orderBy('total_enrolled', 'desc')->where('status', 1)->where('type', 2)->take(4)->with('quiz.assign', 'activeReviews', 'enrollUsers', 'cartUsers')->get();

        return view(theme('components.home-page-quiz-section'), compact('top_quizzes'));
    }
}
