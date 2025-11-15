<?php

namespace App\View\Components;

use Illuminate\View\Component;

class QuizDetailsQuestionList extends Component
{
    public $quiz;
    public function __construct($quiz)
    {
        $this->quiz= $quiz;
    }

    public function render()
    {
        return view(theme('components.quiz-details-question-list'));
    }
}
