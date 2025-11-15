<?php

namespace App\View\Components;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Modules\Quiz\Entities\OnlineQuiz;
use Modules\Quiz\Entities\QuizeSetup;
use Modules\Quiz\Entities\QuizTest;

class QuizStartPageSection extends Component
{
    public $course, $quiz_id;

    public function __construct($course, $quizId)
    {
        $this->course = $course;
        $this->quiz_id = $quizId;
    }


    public function render()
    {
        $quiz = OnlineQuiz::where('id', $this->quiz_id)->with('assign', 'assign.questionBank', 'assign.questionBank.questionMu')->first();
        $quizSetup = QuizeSetup::getData();

        $alreadyJoin = 0;
        $givenQuiz = QuizTest::where('user_id', Auth::id())->where('course_id', $this->course->id)->where('quiz_id', $this->course->quiz->id)->count();
        if ($givenQuiz != 0) {
            $alreadyJoin = 1;
        }
        $last_given_quiz = null;
        if (isModuleActive('AdvanceQuiz')) {
            $last_given_quiz = QuizTest::where('user_id', Auth::id())->where('course_id', $this->course->id)->where('quiz_id', $quiz->id)->with('details')->latest()->first();

            if ($last_given_quiz && $last_given_quiz->state != 2 && $last_given_quiz->continue_do_test == 1) {
                $alreadyJoin = 0;
                $reminder_time = $last_given_quiz->extra_time;

                if (!empty($this->course->duration)) {
                    $timer = $this->course->duration;
                } else {
                    if (!empty($quiz->question_time_type == 1)) {
                        $timer = $quiz->question_time;
                    } else {
                        $timer = $quiz->question_time * count($quiz->assign);
                    }
                }
                $start_time = Carbon::parse($last_given_quiz->start_at);
                $end_time = Carbon::parse($last_given_quiz->start_at)->addSeconds($last_given_quiz->duration * 60);
                $last_time = $end_time->diffInSeconds($start_time);

                $timer = (($timer + $reminder_time) * 60) - $last_time;
                $quiz->remine_time = Carbon::parse($timer)->format('i:s');
                $quiz->last_given_quiz = $last_given_quiz;

            }

        }


        return view(theme('components.quiz-start-page-section'), compact('alreadyJoin', 'quiz', 'quizSetup', 'last_given_quiz'));
    }
}
