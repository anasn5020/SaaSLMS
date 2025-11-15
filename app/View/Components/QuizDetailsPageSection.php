<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Modules\Certificate\Entities\Certificate;
use Modules\CertificatePro\Entities\CertificateTemplate;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\CourseLevel;
use Modules\Payment\Entities\Cart;
use Modules\Quiz\Entities\OnlineQuiz;
use Modules\Quiz\Entities\QuizeSetup;
use Modules\Quiz\Entities\QuizTest;
use Modules\StudentSetting\Entities\BookmarkCourse;

class QuizDetailsPageSection extends Component
{
    public $course, $request, $isEnrolled;

    public function __construct($course, $request, $isEnrolled)
    {
        $this->course = $course;
        $this->request = $request;
        $this->isEnrolled = $isEnrolled;
    }


    public function render()
    {

        if (isModuleActive('CertificatePro') && Settings('use_certificate_template') == 'pro') {
            $certificate = CertificateTemplate::where('default_for', 'q')->first();
        } else {
            $certificate = Certificate::where('for_quiz', 1)->first();
        }


        $bookmarked = BookmarkCourse::where('user_id', Auth::id())->where('course_id', $this->course->id)->count();
        if ($bookmarked == 0) {
            $isBookmarked = false;
        } else {
            $isBookmarked = true;

        }


        if ($this->course->price == 0) {
            $isFree = true;
        } else {
            $isFree = false;
        }
        $is_cart = 0;
        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->where('course_id', $this->course->id)->first();
            if ($cart) {
                $is_cart = 1;
            }
        } else {
            $sessonCartList = session()->get('cart');
            if (!empty($sessonCartList)) {
                foreach ($sessonCartList as $item) {
                    if ($item['course_id'] == $this->course->id) {
                        $is_cart = 1;
                    }
                }
            }
        }


        $reviewer_user_ids = [];
        foreach ($this->course->reviews as $key => $review) {
            $reviewer_user_ids[] = $review['user_id'];
        }

        $course_enrolled_std = [];
        foreach ($this->course->enrolls as $key => $enroll) {
            $course_enrolled_std[] = $enroll['user_id'];
        }
        $related = Course::where('category_id', $this->course->category_id)->where('id', '!=', $this->course->id)->with('lessons', 'enrollUsers', 'cartUsers',)->take(2)->get();


        $quizSetup = QuizeSetup::getData();
        $alreadyJoin = 0;
        $isPass = 0;

        $givenQuiz = QuizTest::where('user_id', Auth::id())->where('course_id', $this->course->id)->where('quiz_id', $this->course->quiz->id)->get();


        if (count($givenQuiz) != 0) {

            foreach ($givenQuiz as $q) {
                ++$alreadyJoin;
                if ($q->pass == 1) {
                    $isPass = 1;
                }
            }
        }

        $levels = CourseLevel::select('id', 'title')->where('status', 1)->get();


        $preResult = [];
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
                $preResult[$key]['mark'] = $score > 0 && $totalScore > 0 ? round($score / $totalScore * 100, 2) : 0;
                $preResult[$key]['publish'] = $i->publish;
                $preResult[$key]['status'] = $preResult[$key]['mark'] >= $preResult[$key]['passMark'] ? "Passed" : "Failed";
                $preResult[$key]['text_color'] = $preResult[$key]['mark'] >= $preResult[$key]['passMark'] ? "success_text" : "error_text";
                $i->pass = $preResult[$key]['mark'] >= $preResult[$key]['passMark'] ? "1" : "0";
                $i->save();


            }
        }


        return view(theme('components.quiz-details-page-section'), compact('preResult', 'isPass', 'levels', 'related', 'certificate', 'alreadyJoin', 'is_cart', 'isFree', 'isBookmarked', 'quizSetup', 'reviewer_user_ids'));
    }
}
