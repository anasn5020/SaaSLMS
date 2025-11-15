<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Modules\Certificate\Entities\Certificate;
use Modules\Quiz\Entities\OnlineQuiz;
use Modules\Quiz\Entities\QuizeSetup;
use Modules\Quiz\Entities\QuizTest;

class QuizResultPageSection extends Component
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
        foreach ($all as $key => $i) {


            $date = showDate($i->created_at);
            $totalQus = totalQuizQus($i->quiz_id);
            $totalAns = count($quiz->details);
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

            if ($quiz->id == $i->id) {
                $result['start_at'] = $i->start_at;
                $result['end_at'] = $i->end_at;
                $result['duration'] = $i->duration;
                $result['totalQus'] = $totalQus;
                $result['totalAns'] = $totalAns;
                $result['totalCorrect'] = $totalCorrect;
                $result['totalWrong'] = $totalAns - $totalCorrect;
                $result['score'] = $score;
                $result['totalScore'] = $totalScore;
                $result['passMark'] = $onlineQuiz->percentage ?? 0;
                $result['mark'] = $score > 0 ? round($score / $totalScore * 100, 2) : 0;;

                if (isModuleActive('AdvanceQuiz')) {
                    $isPass = ($result['mark'] >= $result['passMark']) && ($i->flag != 1);
                } else {
                    $isPass = $result['mark'] >= $result['passMark'];
                }
                $result['pass'] = $isPass ? 1 : 0;
                $result['status'] = $isPass ? trans('quiz.Passed') : trans('quiz.Failed');
                $result['text_color'] = $isPass ? "success_text" : "error_text";
                $i->pass = $isPass ? 1 : 0;

                $i->save();
            } else {
                $preResult[$key]['quiz_test_id'] = $i->id;
                $preResult[$key]['totalQus'] = $totalQus;
                $preResult[$key]['date'] = $date;
                $preResult[$key]['totalAns'] = $totalAns;
                $preResult[$key]['totalCorrect'] = $totalCorrect;
                $preResult[$key]['totalWrong'] = $totalAns - $totalCorrect;
                $preResult[$key]['score'] = $score;
                $preResult[$key]['totalScore'] = $totalScore;
                $preResult[$key]['passMark'] = $onlineQuiz->percentage ?? 0;
                $preResult[$key]['mark'] = $score > 0 ? round($score / $totalScore * 100, 2) : 0;
                if (isModuleActive('AdvanceQuiz')) {
                    $isPass = ($preResult[$key]['mark'] >= $preResult[$key]['passMark']) && ($i->flag != 1);
                } else {
                    $isPass = $preResult[$key]['mark'] >= $preResult[$key]['passMark'];
                }
                $preResult[$key]['pass'] = $isPass ? 1 : 0;
                $preResult[$key]['status'] = $isPass ? trans('quiz.Passed') : trans('quiz.Failed');
                $preResult[$key]['text_color'] = $isPass ? "success_text" : "error_text";
//                $i->pass = $preResult[$key]['mark'] >= $isPass ? 1 : 0;
//                $i->save();
            }

        }

        $certificate = Certificate::where('for_quiz', 1)->first();
        return view(theme('components.quiz-result-page-section'), compact('onlineQuiz', 'certificate', 'quizSetup', 'result', 'preResult'));
    }
}
