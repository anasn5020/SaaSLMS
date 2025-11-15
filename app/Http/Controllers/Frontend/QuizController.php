<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Traits\GoogleAnalytics4;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\CourseComment;
use Modules\CourseSetting\Entities\CourseEnrolled;
use Modules\FrontendManage\Entities\FrontPage;
use Modules\Membership\Http\Controllers\MembershipController;
use Modules\Quiz\Entities\MatchingTypeQuestionAssign;
use Modules\Quiz\Entities\OnlineExamQuestionAssign;
use Modules\Quiz\Entities\OnlineQuiz;
use Modules\Quiz\Entities\QuestionBankMuOption;
use Modules\Quiz\Entities\QuizMarking;
use Modules\Quiz\Entities\QuizTest;
use Modules\Quiz\Entities\QuizTestDetails;
use Modules\Quiz\Entities\QuizTestDetailsAnswer;
use Throwable;
use function redirect;

class QuizController extends Controller
{
    use GoogleAnalytics4;

    public function __construct()
    {
        $this->middleware(['maintenanceMode', 'onlyAppMode']);
    }

    public function quizzes(Request $request)
    {
        try {
            if (hasDynamicPage()) {
                $row = FrontPage::where('slug', '/quizzes')->first();
                $details = dynamicContentAppend($row->details);
                return view('aorapagebuilder::pages.show', compact('row', 'details'));
            } else {
                return view(theme('pages.quizzes'), compact('request'));
            }

        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function quizDetails($slug, Request $request)
    {


        try {

            $select_field = [
                'courses.id',
                'courses.type',
                'courses.slug',
                'courses.image',
                'courses.trailer_link',
                'courses.thumbnail',
                'courses.title',
                'courses.level',
                'courses.host',
                'courses.host',
                'courses.status',
                'courses.about',
                'courses.quiz_id',
                'courses.reveiw',
                'courses.duration',
                'courses.type',
                'courses.total_enrolled',
                'courses.special_commission',
                'courses.duration',
                'courses.slug',
                'courses.user_id',
                'courses.price',
                'courses.discount_price',
                'courses.total_rating',
                'courses.about',
                'courses.requirements',
                'courses.outcomes',
                'courses.price_text',
                'users.name as userName'

            ];
            if (isModuleActive('UpcomingCourse')) {
                $select_field[] = 'courses.is_upcoming_course';
                $select_field[] = 'courses.publish_date';
                $select_field[] = 'courses.publish_status';
                $select_field[] = 'courses.is_allow_prebooking';
                $select_field[] = 'courses.booking_amount';
            }
            if (isModuleActive('WaitList')) {
                $select_field[] = 'courses.waiting_list_status';
            }


            $course = Course::select(
                $select_field
            )->leftJoin('users', 'courses.user_id', 'users.id')
                ->where('courses.slug', $slug)->first();

            if (!$course) {
                Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
                return redirect()->back();
            }

            $this->postEvent([
                'name' => 'view_item',
                'params' => [
                    "items" => [
                        [
                            "item_id" => $course->id,
                            "item_name" => $course->title,
                            'type' => 'quiz',
                            "price" => !empty($course->discount_price) ? $course->discount_price : $course->price,
                        ]
                    ],
                ],
            ]);
            if (isModuleActive('OrgSubscription') && Auth::check()) {
                if (!orgSubscriptionCourseValidity($course->id)) {
                    Toastr::warning(trans('org-subscription.Your Subscription Expire'));
                    return back();
                }
                if (!orgSubscriptionCourseSequence($course->id)) {
                    Toastr::warning(trans('org.subscription.You Can Not Continue This . Pls Complete Previous Course'));
                    return back();
                }
            }

            if (!isViewable($course)) {
                Toastr::error(trans('common.Access Denied'), trans('common.Failed'));
                return redirect()->to(route('quizzes'));
            }

            if (empty($course->quiz->id)) {
                Toastr::error(trans('quiz.No Quiz Assign'), trans('common.Failed'));
                return redirect()->back();
            }
            if (Auth::check()) {
                $isEnrolled = $course->isLoginUserEnrolled;
            } else {
                $isEnrolled = false;
            }
            if (isModuleActive('Membership')) {
                $membershipRepo = new MembershipController() ;
                $enrollForMembership = $membershipRepo->hasEnrolled($course->id, auth()->id());
                if($enrollForMembership){
                    $isEnrolled = true;
                }
            }

            if ($isEnrolled) {
                $enroll = CourseEnrolled::where('user_id', Auth::id())->where('course_id', $course->id)->first();
                if ($enroll) {
                    if ($enroll->subscription == 1) {
                        if (isModuleActive('Subscription')) {
                            if (!isSubscribe()) {
                                Toastr::error(trans('quiz.Subscription has expired, Please Subscribe again'), trans('common.Failed'));
                                return redirect()->route('courseSubscription');
                            }
                        }
                    }
                }
            }
            $data = '';
            $reviews = DB::table('course_reveiws')
                ->select(
                    'course_reveiws.id',
                    'course_reveiws.star',
                    'course_reveiws.comment',
                    'course_reveiws.instructor_id',
                    'course_reveiws.created_at',
                    'users.id as userId',
                    'users.name as userName',
                )
                ->join('users', 'users.id', '=', 'course_reveiws.user_id')
                ->where('course_reveiws.status',1)
                ->where('course_reveiws.course_id', $course->id)->get();

            if ($request->ajax()) {
                if ($request->type == "review") {
                    foreach ($reviews as $review) {
                        $data .= view(theme('partials._single_review'), ['review' => $review, 'isEnrolled' => $isEnrolled, 'course' => $course])->render();
                    }
                    if (count($reviews) == 0) {
                        $data .= '';
                    }
                    return $data;
                }
            }
            $comments = CourseComment::where('course_id', $course->id)->with('replies', 'replies.user', 'user')
                ->where('status', 1)
                ->get();

            if ($request->ajax()) {
                if ($request->type == "comment") {
                    foreach ($comments as $comment) {
                        $data .= view(theme('partials._single_comment'), ['comment' => $comment, 'isEnrolled' => $isEnrolled, 'course' => $course])->render();
                    }
                    return $data;
                }

            }
            $course->view = $course->view + 1;
            $course->save();
            return view(theme('pages.quizDetails'), compact('course', 'request', 'isEnrolled'));

        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function quizStart($id, $quiz_id, $slug)
    {
        if (isModuleActive('OrgSubscription') && Auth::check()) {
            if (!orgSubscriptionCourseValidity($id)) {
                Toastr::warning(trans('org-subscription.Your Subscription Expire'));
                return redirect()->back();
            }
        }
        if (isModuleActive('OrgSubscription') && Auth::check()) {
            if (!orgSubscriptionCourseSequence($id)) {
                Toastr::warning(trans('org-subscription.You Can Not Continue This . Pls Complete Previous Course'));
                return redirect()->back();
            }
        }
        if (isModuleActive('Subscription')) {
            if (!isSubscriptionExpire()) {
                Toastr::error(trans('quiz.Your subscription validity expired'), trans('quiz.Access Denied'));
                return redirect()->back();
            }
        }
        try {
            $course = Course::with('quiz')->where('courses.id', $id)->first();


            $isEnrolled=Auth::check() && $course->isLoginUserEnrolled;
            if (Auth::check() && isModuleActive('Membership')) {
                $membershipRepo = new MembershipController() ;
                $enrollForMembership = $membershipRepo->hasEnrolled($course->id, auth()->id());
                if($enrollForMembership){
                    $isEnrolled = true;
                }
            }

            if ($isEnrolled) {
                if (isModuleActive('AdvanceQuiz')) {
                    $quiz = $course->quiz;

                    $givenQuiz = QuizTest::where('user_id', Auth::id())->where('course_id', $course->id)->where('quiz_id', $quiz->id)->count();

                    $totalAllow = $quiz->multiple_attend_count;
                    if ($quiz->multiple_attend == 1 && $quiz->multiple_attend_count != 0 && $givenQuiz >= $totalAllow) {
                        Toastr::error(trans('quiz.You have reach the maximum quiz attempt') . ' ' . $quiz->multiple_attend_count . ' ' . trans('quiz.time(s) set by teacher. Please contact your teacher to support'), trans('common.Failed'));
                        return redirect()->back();
                    }
                }

                $enroll = CourseEnrolled::where('course_id', $course->id)->where('user_id', Auth::id())->first();

                if (!empty($enroll->shift)) {
                    if ($quiz->random_question == 1) {
                        $quiz->assignRand = [];
                    } else {
                        $quiz->assign = [];
                    }
                    $shift = $course->shifts->where('shift', $enroll->shift)->first();
                    if ($shift) {
                        $now = Carbon::now();
                        $start_time = Carbon::createFromFormat(getActivePhpDateFormat() . ' ' . 'g:i A', $shift->start_date . ' ' . $shift->start_time);
                        $end_time = Carbon::createFromFormat(getActivePhpDateFormat() . ' ' . 'g:i A', $shift->end_date . ' ' . $shift->end_time);
                        if (!$now->between($start_time, $end_time)) {
                            Toastr::error(trans('common.Access Denied') . '! ' . trans('quiz.Check shift time'), trans('common.Failed'));
                            return redirect()->back();
                        }

                    }

                }

                return view(theme('pages.quizStart'), compact('course', 'quiz_id'));
            } else {
                Toastr::error(trans('quiz.Access Denied'), trans('common.Failed'));
                return redirect()->back();
            }


        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function quizSubmit(Request $request)
    {

        $quiz_test = QuizTest::with('quiz', 'details')->findOrFail((int)$request->quiz_test_id);
        $quiz = OnlineQuiz::findOrFail((int)$quiz_test->quiz_id);
        try {
            $userId = Auth::id() ?? 0;

            if (!isModuleActive('AdvanceQuiz')) {
                if ($quiz) {
                    $givenQuiz = QuizTest::where('user_id', Auth::id())->where('quiz_id', $quiz_test->quiz_id)->count();
                    if ($quiz->multiple_attend == 0 && $givenQuiz > 1) {
                        Toastr::error(trans('quiz.You have reach the maximum quiz attempt') . trans('quiz.time(s) set by teacher. Please contact your teacher to support'), trans('common.Failed'));
                        return redirect()->back();
                    }
                }
            }

            if (!$quiz_test) {
                $quiz_test = new QuizTest();
            }

            if ($quiz_test->quiz_id) {
                $marking = QuizMarking::where('quiz_id', $quiz_test->quiz_id)->where('quiz_test_id', $quiz_test->id)->where('student_id', $userId)->first();
            } else {
                $marking = null;
            }

            if ($marking) {
                $quiz_marking = $marking;
            } else {
                $quiz_marking = new QuizMarking();
            }

            $quiz_marking->quiz_id = $quiz_test->quiz_id;
            $quiz_marking->quiz_test_id = $quiz_test->id;
            $quiz_marking->student_id = $userId;
            $score = 0;
            if (in_array('L', $request->type) || in_array('S', $request->type)) {
                $quiz_marking->marking_status = 0;
                $quiz_test->publish = 0;
            } else {
                $totalCorrect = 0;

                if ($quiz_test->details) {
                    foreach ($quiz_test->details as $test) {
                        $score += $test->mark ?? 1;
                    }
                }
                $quiz_marking->marked_by = 0;
                $quiz_marking->marking_status = 1;
                $quiz_marking->marks = $score;
                $quiz_test->publish = 1;
            }
            $quiz_marking->save();
            $quiz_test->focus_lost = (int)$request->focus_lost;
            if (isModuleActive('AdvanceQuiz')) {
                $quiz_test->state = 2;
            }
            $quiz_test->save();

            $quiz = OnlineQuiz::find((int)$quiz_test->quiz_id);

            if ($quiz_test->publish == 1 && (int)getPercentage($score, $quiz->totalMarks()) >= 90) {
                $course = $quiz_test->course;
                checkGamification('each_perfectionism', 'perfectionism', null, isModuleActive('Org') ? $course->org_leaderboard_point : 0);

                earnCourseBadge($course->id, auth()->id(), $course->has_badge);

            }
            try {
                $websiteController = new WebsiteController();
                $websiteController->getCertificateRecord($quiz_test->course_id);

            } catch (Throwable $th) {
            }


            Toastr::success(trans('quiz.Successfully submitted'), trans('common.Success'));
            if ($request->from == "course") {
                checkGamification('each_test_complete', 'NaN');
                $previousUrl = app('url')->previous();
                return redirect()->to($previousUrl . '?' . http_build_query(['quiz_result_id' => $quiz_test->id]));

            } else {
                $course = $quiz_test->course;
                checkGamification('each_test_complete', 'test', null, isModuleActive('Org') ? $course->org_leaderboard_point : 0);

                orgLeaderboardPointCheck($course->advance_test > 0 ? 'Test' : 'Quiz', $course->org_leaderboard_point, $quiz_test->course_id);

                return redirect()->route('getQuizResult', $quiz_test->id);

            }

        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function quizResult($id)
    {
        try {

            $user = Auth::user();

            $quiz = QuizTest::with('quiz')->findOrFail($id);
            if ($quiz->user_id == $user->id) {
                $course = Course::findOrFail($quiz->course_id);
                return view(theme('pages.quizResult'), compact('quiz', 'user', 'course'));
            } else {
                Toastr::error(trans('quiz.Access Denied'), trans('common.Failed'));
                return redirect()->back();
            }

        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function quizResultPreview($id)
    {
        $quizTest = QuizTest::findOrFail($id);
        try {
            $user = Auth::user();


            if (Auth::check() && $quizTest->user_id == $user->id) {
                $course = Course::with('quiz')
                    ->where('courses.id', $quizTest->course_id)->first();
                return view(theme('pages.quizResultPreview'), compact('user', 'quizTest', 'course'));

            } else {
                Toastr::error(trans('quiz.Access Denied'), trans('common.Failed'));
                return redirect()->back();
            }

        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function quizTestStart(Request $request)
    {
        $userId = Auth::id();
        $courseId = $request->get('courseId');
        $quizId = $request->get('quizId');
        $quizType = $request->get('quizType');

        $quiz = OnlineQuiz::findOrFail($quizId);

        if ($quiz->multiple_attend != 1) {
            if (isModuleActive('AdvanceQuiz')) {
                if ($quiz->multiple_attend == 0) {
                    $totalAllow = 1;
                } else {
                    $totalAllow = $quiz->multiple_attend_count;
                }
            } else {
                $totalAllow = 1;
            }
            $alreadyAttend = QuizTest::where('user_id', $userId)->where('course_id', $courseId)->where('quiz_id', $quizId)->count();

            if (!isModuleActive('Org') && $alreadyAttend >= $totalAllow) {
                abort(403);
            }
        }

        try {

            $quiz = QuizTest::find((int)$request->quiz_test_id);
            if (!$quiz) {
                $quiz = new QuizTest();
                $quiz->start_at = now();
                $quiz->end_at = null;
                $quiz->duration = 0.00;
            } else {
                if (isModuleActive('Org')) {
                    $quiz->continue_do_test = 0;
                }
            }
            $quiz->user_id = $userId;
            $quiz->course_id = $courseId;
            $quiz->quiz_id = $quizId;
            $quiz->quiz_type = $quizType;

            $quiz->save();

            $return['result'] = true;
            $return['data'] = $quiz;

        } catch (Exception $e) {
            $return['result'] = true;
            $return['data'] = null;
        }

        return $return;
    }

    public function singleQuizSubmit(Request $request)
    {
         $quiz_test = QuizTest::with('quiz', 'details')->find((int)$request->quiz_test_id);
        if (empty($quiz_test)) {
            if ($request->ajax()){
                return response(trans('quiz.Action Not Allowed'), 403);
            }else{
                abort(403);
            }
        }
        try {
            $answer = $request->ans;
            $userId = Auth::id();
            $type = $request->get('type');
            $assign_id = (int)$request->get('assign_id');
            $quiz_test_id = (int)$request->get('quiz_test_id');
            $assign = OnlineExamQuestionAssign::with('questionBank')->find($assign_id);
            $qus = $assign->question_bank_id;
            $quizTest = QuizTest::find($quiz_test_id);


            $start_at = Carbon::parse($quizTest->start_at);
            $end_at = Carbon::now();
            if ($quizTest->focus_lost < $request->focus_lost) {
                $quizTest->focus_lost = (int)$request->focus_lost;
            }
            $quizTest->end_at = $end_at;
            $quizTest->duration = number_format(abs(strtotime($start_at) - strtotime($end_at)) / 60, 2) ?? 0.00;

            if (isModuleActive('AdvanceQuiz')) {
                $quizTest->state = 1;
            }
            $quizTest->save();

            if (empty($answer)) {
                return false;
            }
            $check_details = QuizTestDetails::where('quiz_test_id', $quiz_test_id)->where('qus_id', $qus)->first();
            if ($check_details) {
                $quizDetails = $check_details;
            } else {
                $quizDetails = new QuizTestDetails();
                $quizDetails->quiz_test_id = $quiz_test_id;
                $quizDetails->qus_id = $qus;
                $quizDetails->status = 0;
                $quizDetails->mark = $assign->questionBank->marks;
                $quizDetails->save();
            }

            if ($type == "M" || $type == "C") {

                $alreadyAns = QuizTestDetailsAnswer::where('quiz_test_details_id', $quizDetails->id)->get();
                $totalCorrectAns = QuestionBankMuOption::where('status', 1)->where('question_bank_id', $assign->question_bank_id)->count();

                foreach ($alreadyAns as $already) {
                    $already->delete();
                }
                $wrong = 0;
                $userCorrectAns = 0;
                if (!empty($answer)) {
                    foreach ($answer as $ans) {
                        $setAns = new QuizTestDetailsAnswer();
                        $option = QuestionBankMuOption::with('question')->find($ans);
                        if ($option) {
                            $setAns->quiz_test_details_id = $quizDetails->id;
                            $setAns->ans_id = (int)$ans;
                            $setAns->status = $option->status;
                            $setAns->save();

                            if ($setAns->status == 0) {
                                $wrong++;
                            } elseif ($setAns->status == 1) {
                                $userCorrectAns++;
                            }
                        }
                    }
                    if ($wrong == 0) {
                        if ($userCorrectAns == $totalCorrectAns) {
                            $quizDetails->status = 1;
                        } else {
                            $quizDetails->status = 0;
                        }
                    } else {
                        $quizDetails->status = 0;
                    }
                    $quizDetails->save();
                }

            } elseif ($type == "O") {
                $alreadyAns = QuizTestDetailsAnswer::where('quiz_test_details_id', $quizDetails->id)->get();
                $totalCorrectAns = QuestionBankMuOption::where('status', 1)->where('question_bank_id', $assign->question_bank_id)->count();

                foreach ($alreadyAns as $already) {
                    $already->delete();
                }
                $wrong = 0;
                $userCorrectAns = 0;
                    foreach ($answer as $key=>$ans) {
                        $setAns = new QuizTestDetailsAnswer();
                        $option = QuestionBankMuOption::with('question')->find($ans);
                        if ($option) {
                            $setAns->quiz_test_details_id = $quizDetails->id;
                            $setAns->ans_id = (int)$ans;
                            $setAns->status = $option->position ==$key ? 1 : 0;
                            $setAns->save();

                            if ($setAns->status == 0) {
                                $wrong++;
                            } elseif ($setAns->status == 1) {
                                $userCorrectAns++;
                            }
                        }
                    }
                    if ($wrong == 0) {
                        if ($userCorrectAns == $totalCorrectAns) {
                            $quizDetails->status = 1;
                        } else {
                            $quizDetails->status = 0;
                        }
                    } else {
                        $quizDetails->status = 0;
                    }
                    $quizDetails->save();


            }elseif ($type == "P") {


                $alreadyAns = QuizTestDetailsAnswer::where('quiz_test_details_id', $quizDetails->id)->get();

                foreach ($alreadyAns as $already) {
                    $already->delete();
                }

                $given_answers_data = (array)json_decode($request->ans);
                $matching_type_question_assigns =MatchingTypeQuestionAssign::select('option_id','question_id','answer_id')->where('question_id', $assign->question_bank_id)->get()->toArray();





                $totalPuzzleCorrectAns =0;
                $totalPuzzleAns=count($matching_type_question_assigns);
                foreach ($matching_type_question_assigns as $question) {
                    $option_id = $question['option_id'];
                    $answer_id = $question['answer_id'];

                    $setAns = new QuizTestDetailsAnswer();
                    $setAns->quiz_test_details_id = $quizDetails->id;
                    $setAns->ans_id = (int)$answer_id;


                     if (isset($given_answers_data[$option_id]) && in_array($answer_id, $given_answers_data[$option_id])) {
                         $totalPuzzleCorrectAns++;
                         $setAns->status =1;
                     }else{
                         $setAns->status =0;
                     }
                    $setAns->save();

                }



                if ($totalPuzzleCorrectAns == $totalPuzzleAns) {
                    $quizDetails->status = 1;
                } else {
                    $quizDetails->status = 0;
                }
                $quizDetails->save();


            } else {

                $quizDetails->quiz_test_id = $quiz_test_id;
                $quizDetails->qus_id = (int)$qus;
                $quizDetails->answer = $answer;
                $quizDetails->status = 0;
                $quizDetails->mark = 0;

                if ($type == 'X') {
                    $connections = explode(',', $assign->questionBank->connection);
                    $answers = explode(',', $answer);
                    $diff = array_diff(array_filter($connections), array_filter($answers));
                    if (count($diff) == 0) {
                        $quizDetails->status = 1;
                        $quizDetails->mark = $assign->questionBank->marks;
                    }
                }

                $quizDetails->save();
            }

            if (isModuleActive('AdvanceQuiz')) {
                if ($quizDetails->question->pre_condition == 1 && $quizDetails->status == 0) {
                    $quizTest->flag = 1;
                    $quizTest->save();
                }
            }

            return $quizDetails->status;

        } catch (Exception $e) {
            return false;
        }
    }


    public function quizResultPreviewApi($quiz_id)
    {
        $quizTest = QuizTest::with('quiz', 'quiz.assign', 'quiz.assign.questionBank', 'quiz.assign.questionBank.questionMuInSerial')->findOrFail($quiz_id);

        $questions = [];

        foreach ($quizTest->quiz->assign as $key => $assign) {

            $test = QuizTestDetails::where('quiz_test_id', $quizTest->id)->where('qus_id', $assign->questionBank->id)->first();
            $questions[$key]['isSubmit'] = false;
            $questions[$key]['isWrong'] = false;
            $questions[$key]['id'] = $assign->questionBank->id;

            if ($assign->questionBank->type == "M") {
                foreach (@$assign->questionBank->questionMuInSerial as $key2 => $option) {
                    $questions[$key]['option'][$key2]['id'] = $option->id;
                    $questions[$key]['option'][$key2]['title'] = $option->title;
                    $questions[$key]['option'][$key2]['right'] = $option->status == 1 ? true : false;
                    $questions[$key]['option'][$key2]['wrong'] = false;


                    if ($test) {
                        $questions[$key]['isSubmit'] = true;
                        $wrong = $test->answers->where('ans_id', $option->id)->where('status', 0)->count();
                        if ($test->status == 0 && $wrong != 0) {
                            $questions[$key]['option'][$key2]['wrong'] = $test->status == 0 ? true : false;
                            $questions[$key]['isWrong'] = true;
                        }
                    }
                }

            }


        }
        return $questions;
    }

    public function quizHistory($id)
    {
        try {

            $user = Auth::user();
            $quiz = QuizTest::with('quiz')->findOrFail($id);
            $preResult = [];
            if (Auth::check()) {
                $user = Auth::user();
                $all = QuizTest::with('details')->where('course_id', $quiz->id)->where('user_id', $user->id)->get();

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

            $course = Course::findOrFail($quiz->id);

            return view(theme('pages.quizHistory'), compact('quiz', 'user', 'course', 'preResult'));


        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

}
