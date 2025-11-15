<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Modules\Quiz\Entities\MatchingTypeQuestionAssign;
use Modules\Quiz\Entities\OnlineQuiz;
use Modules\Quiz\Entities\QuizeSetup;
use Modules\Quiz\Entities\QuizTestDetails;
use Modules\Quiz\Entities\QuizTestDetailsAnswer;

class QuizResultPreviewPageSection extends Component
{
    public $quizTest, $user, $course;

    public function __construct($quizTest, $user, $course)
    {
        $this->quizTest = $quizTest;
        $this->user = $user;
        $this->course = $course;
    }


    public function render()
    {
        $quizSetup = QuizeSetup::getData();

        $quiz = OnlineQuiz::with('assign.questionBank', 'assign.questionBank.questionMu')->findOrFail($this->quizTest->quiz_id);
         $questions = [];
        $quiz->total_correct_ans = 0;
        foreach (@$quiz->assign as $key => $assign) {
            $questions[$key]['qusBank'] = $assign->questionBank;
            $questions[$key]['qus'] = $assign->questionBank->question;
            $questions[$key]['type'] = $assign->questionBank->type;

            $test = QuizTestDetails::where('quiz_test_id', $this->quizTest->id)->where('qus_id', $assign->questionBank->id)->first();
            $questions[$key]['isSubmit'] = false;
            $questions[$key]['isWrong'] = false;

            if ($assign->questionBank->type == "M" || $assign->questionBank->type == "O" ||  $assign->questionBank->type == "C") {
                foreach (@$assign->questionBank->questionMuInSerial as $key2 => $option) {
                    $questions[$key]['option'][$key2]['id'] = $option->id;
                    $questions[$key]['option'][$key2]['title'] = $option->title;
                    $questions[$key]['option'][$key2]['right'] = $option->status == 1;
                    if ($test) {
                        $questions[$key]['isSubmit'] = true;
                        $totalAns = $test->answers->where('ans_id', $option->id);
                        $wrong = $totalAns->where('status', 0)->count();
                        if ($test->status == 0 && $wrong != 0) {
                            $questions[$key]['option'][$key2]['wrong'] = $test->status == 0 ? true : false;
                        }
                        if ($totalAns->count() > 0) {
                            $questions[$key]['option'][$key2]['submit'] = true;
                        } else {
                            $questions[$key]['option'][$key2]['submit'] = false;
                        }
                    }
                }

                if ($test && $test->status == 1) {
                    $questions[$key]['isWrong'] = false;
                } else {
                    $questions[$key]['isWrong'] = true;
                }
            }elseif($assign->questionBank->type == "P"){


                $matchingTypeAssignments = MatchingTypeQuestionAssign::select('question_id','option_id','answer_id')->where('question_id', $assign->questionBank->id)->get();
                 $quizTestDetailsAns =QuizTestDetailsAnswer::where('quiz_test_details_id',$test?->id)->get();
                $puzzle_options = $assign->questionBank->questionSortingOptionsSerial;
                $puzzleQus = $puzzle_options->where('type',1);
                $puzzleAns = $puzzle_options->where('type',0);

                $questions[$key]['matching'] =$matchingTypeAssignments;
                foreach ($puzzleQus as $key2 => $option) {
                    $questions[$key]['option'][$key2]['id'] = $option->id;
                    $questions[$key]['option'][$key2]['title'] = $option->title;
                    $questions[$key]['option'][$key2]['testDetails'] = $test;

                }
                foreach ($puzzleAns as $key2 => $answer) {
                    $questions[$key]['answer'][$key2]['id'] = $answer->id;
                    $questions[$key]['answer'][$key2]['title'] = $answer->title;
                    $questions[$key]['answer'][$key2]['testDetails'] = $test;
                    $questions[$key]['answer'][$key2]['status'] = $quizTestDetailsAns->where('ans_id',$answer->id)->first()?->status;

                 }


                if ($test) {
                    $questions[$key]['isSubmit'] = true;
                }
                if ($test && $test->status == 1) {
                    $questions[$key]['isWrong'] = false;
                } else {
                    $questions[$key]['isWrong'] = true;
                }

//                $puzzle_options = $assign->questionBank->questionSortingOptionsSerial;
//                $puzzleQus = $puzzle_options->where('type',1);
//                $puzzleAns = $puzzle_options->where('type',0);
//
//
//                foreach (@$assign->questionBank->questionMuInSerial as $key2 => $option) {
//                    $questions[$key]['option'][$key2]['id'] = $option->id;
//                    $questions[$key]['option'][$key2]['title'] = $option->title;
//                    $questions[$key]['option'][$key2]['right'] = $option->status == 1;
//                    if ($test) {
//                        $questions[$key]['isSubmit'] = true;
//                        $totalAns = $test->answers->where('ans_id', $option->id);
//                        $wrong = $totalAns->where('status', 0)->count();
//                        if ($test->status == 0 && $wrong != 0) {
//                            $questions[$key]['option'][$key2]['wrong'] = $test->status == 0 ? true : false;
//                        }
//                        if ($totalAns->count() > 0) {
//                            $questions[$key]['option'][$key2]['submit'] = true;
//                        } else {
//                            $questions[$key]['option'][$key2]['submit'] = false;
//                        }
//                    }
//                }
//
//                if ($test) {
//                    $questions[$key]['isSubmit'] = true;
//                }
//                if ($test && $test->status == 1) {
//                    $questions[$key]['isWrong'] = false;
//                } else {
//                    $questions[$key]['isWrong'] = true;
//                }
            }else{

                if ($test) {
                    $questions[$key]['isSubmit'] = true;
                    if ($test->status == 0) {
                        $questions[$key]['isWrong'] = true;
                    }
                    $questions[$key]['answer'] = $test->answer;
                }
            }

            if (!$questions[$key]['isSubmit']) {
                $questions[$key]['isWrong'] = true;
            }
            if (!$questions[$key]['isWrong']) {
                $quiz->total_correct_ans++;
            }

        }
        return view(theme('components.quiz-result-preview-page-section'), compact('quiz', 'questions', 'quizSetup'));
    }
}
