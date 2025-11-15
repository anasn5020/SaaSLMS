<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Modules\Certificate\Entities\Certificate;
use Modules\Quiz\Entities\OnlineQuiz;
use Modules\Quiz\Entities\QuizeSetup;
use Modules\Quiz\Entities\QuizTest;

class QuizHistoryPageSection extends Component
{
    public $quiz, $user, $course;

    public function __construct($quiz, $user, $course)
    {
        $this->quiz = $quiz;
        $this->user = $user;
        $this->course = $course;
    }


    public function render()
    {
        $quiz = $this->quiz;
        $quizSetup = QuizeSetup::getData();
        $user = Auth::user();
        $all = QuizTest::with('details')->where('course_id', $this->course->id)->where('user_id', $user->id)->get();

        $result = [];
        $preResult = [];
        $onlineQuiz = OnlineQuiz::find($this->quiz->quiz_id);
        if (Auth::check()) {
            $user = Auth::user();
            $all = QuizTest::with('details')->where('course_id', $this->course->id)->where('user_id', $user->id)->get();

            foreach ($all as $key => $i) {
                $onlineQuiz = OnlineQuiz::find($i->quiz_id);
                $date = showDate($i->created_at);
                $totalQus = totalQuizQus($i->quiz_id);
                $totalAns = count($i->details);
                $totalCorrect = 0;
                $totalScore = totalQuizMarks($i->quiz_id);
                $score = 0;
                if ($totalAns != 0) {
                    foreach ($i->details as $test) {
                        if ($test->status == 1) {
                            $score += $test->mark ?? 1;
                            $totalCorrect++;
                        }

                    }
                }


                $preResult[$key]['quiz_test_id'] = $i->id;
                $preResult[$key]['totalQus'] = $totalQus;
                $preResult[$key]['date'] = $date;
                $preResult[$key]['totalAns'] = $totalAns;
                $preResult[$key]['totalCorrect'] = $totalCorrect;
                $preResult[$key]['totalWrong'] = $totalAns - $totalCorrect;
                $preResult[$key]['score'] = $score;
                $preResult[$key]['totalScore'] = $totalScore;
                $preResult[$key]['passMark'] = $onlineQuiz->percentage ?? 0;
                $preResult[$key]['mark'] = $score > 0 && $totalScore > 0 ? ($score / $totalScore * 100) : 0;
                $preResult[$key]['publish'] = $i->publish;
                $preResult[$key]['status'] = $preResult[$key]['mark'] >= $preResult[$key]['passMark'] ? "Passed" : "Failed";
                $preResult[$key]['text_color'] = $preResult[$key]['mark'] >= $preResult[$key]['passMark'] ? "success_text" : "error_text";
                $i->pass = $preResult[$key]['mark'] >= $preResult[$key]['passMark'] ? "1" : "0";
                $i->save();


            }
        }

        $certificate = Certificate::where('for_quiz', 1)->first();
        return view(theme('components.quiz-history-page-section'), compact('onlineQuiz', 'certificate', 'quizSetup', 'result', 'preResult'));
    }


}
