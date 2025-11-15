<?php

namespace Modules\Quiz\Http\Controllers;

use App\Exports\OnlineQuizReport;
use App\Http\Controllers\Controller;
use App\Traits\SendNotification;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Modules\AdvanceQuiz\Http\Controllers\AdvanceOnlineQuizController;
use Modules\CourseSetting\Entities\Category;
use Modules\CourseSetting\Entities\Chapter;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\Lesson;
use Modules\CourseSetting\Http\Controllers\CourseSettingController;
use Modules\Org\Entities\OrgBranch;
use Modules\Org\Entities\OrgPosition;
use Modules\Quiz\Entities\OnlineExamQuestionAssign;
use Modules\Quiz\Entities\OnlineQuiz;
use Modules\Quiz\Entities\QuestionBank;
use Modules\Quiz\Entities\QuestionGroup;
use Modules\Quiz\Entities\QuizeSetup;
use Modules\Quiz\Entities\QuizMarking;
use Modules\Quiz\Entities\QuizTest;
use Modules\Quiz\Entities\QuizTestDetails;
use Modules\Quiz\Entities\StudentTakeOnlineQuiz;
use Yajra\DataTables\Facades\DataTables;

class OnlineQuizController extends Controller
{
    use SendNotification;

    public function index()
    {

        try {
            if (isModuleActive('AdvanceQuiz')) {
                $advanceOnlineQuizController = new AdvanceOnlineQuizController();
                return $advanceOnlineQuizController->index();
            } else {
                $user = Auth::user();
                $query = OnlineQuiz::query();
                if ($user->role_id == 2) {
                    $quiz_ids = [];
                    if (isModuleActive('OrgInstructorPolicy')) {
                        $ids = $user->policy->course_assigns->pluck('course_id')->toArray();
                        $course_quiz_ids = Course::select('quiz_id')->whereNotNull('quiz_id')->whereIn('id', $ids)->get()->pluck('quiz_id')->toArray();
                        $lesson_quiz_ids = Lesson::select('quiz_id')->whereNotNull('quiz_id')->whereIn('id', $ids)->get()->pluck('quiz_id')->toArray();
                        $quiz_ids = array_merge($course_quiz_ids, $lesson_quiz_ids);

                    }
                    $query->where('created_by', $user->id)->orWhereIn('id', $quiz_ids);
                } else {
                    if (isModuleActive('Organization') && Auth::user()->isOrganization()) {
                        $query->whereHas('user', function ($q) {
                            $q->where('organization_id', Auth::id());
                            $q->orWhere('created_by', Auth::id());
                        });
                    }
                }
                $online_exams = $query->with('subCategory', 'category', 'assign')->withCount('assign')->latest()->get();
                $categories = Category::where('status', 1)->orderBy('position_order', 'asc')->get();
                $groups = QuestionGroup::select('title', 'id')->where('active_status', 1)->latest()->pluck('title', 'id');
                $groups_query = QuestionGroup::where('active_status', 1);
                if (isModuleActive('Organization') && $user->isOrganization()) {
                    $groups_query->whereHas('user', function ($q) {
                        $q->where('organization_id', Auth::id());
                        $q->orWhere('id', Auth::id());
                    });
                }
                $groups = $groups_query->latest()->select('title', 'id')->latest()->pluck('title', 'id');
                $present_date_time = date("Y-m-d H:i:s");
                $present_time = date("H:i:s");
                $quiz_setup = QuizeSetup::getData();
                return view('quiz::online_quiz', compact('quiz_setup', 'online_exams', 'categories', 'present_date_time', 'present_time', 'groups'));
            }


        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());

        }
    }

    public function query()
    {
         $query = QuizTest::with(['course', 'quiz', 'user']);

        if (\request('student_status')) {
            $query->whereHas('user', function ($q) {
                return $q->where('status', \request('student_status')==1?1:0);
            });
        }

        if (\request('category')) {
            $category = Category::find(request('category'));
            if ($category) {

                $ids = $category->getAllChildIds($category, [$category->id]);

                $query->whereHas('quiz', function ($q) use ($ids) {
                    $q->whereIn('category_id', $ids);
                    $q->orWhereIn('sub_category_id', $ids);
                });

            }
        }
        if (\request('type')) {
            $query->where('quiz_type', \request('type'));
        }

        if (isModuleActive('Org')) {
            if (\request('required_type')) {
                $query->whereHas('course', function ($q) {
                    return $q->where('required_type', \request('required_type'));
                });
            }
            if (\request('mode_of_delivery')) {
                $query->whereHas('course', function ($q) {
                    return $q->where('mode_of_delivery', \request('mode_of_delivery'));
                });
            }
            if (\request('org_branch')) {
                $query->whereHas('user', function ($q) {
                    return $q->where('org_chart_code', \request('org_branch'));
                });
            }
            if (\request('job_position')) {
                $query->whereHas('user', function ($q) {

                    return $q->where('org_position_code', \request('job_position'));
                });
            }

            if (isModuleActive('OrgInstructorPolicy')) {
                $user = Auth::user();
                if ($user->role_id != 1) {

                    $course_ids = $user->policy->course_assigns->pluck('course_id')->toArray();
                    $query->whereIn('course_id', $course_ids);
                }
            }
        }
        if (isModuleActive('Organization') && Auth::user()->isOrganization()) {
            $query->whereHas('course.user', function ($q) {
                $q->where('organization_id', Auth::id());
                $q->orWhere('id', Auth::id());
            });
        }


        return $query;
    }

    public function CourseQuizStore(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }

        $user = Auth::user();
        $isType2 = $request->type == 2;
        $code = auth()->user()->language_code;


        // Define validation rules
        $rules = $isType2 ? [
            'title.' . $code => 'required|max:255',
            'instruction.' . $code => 'required',
            'category' => 'required',
            'percentage' => 'required',
        ] : [
            'quiz' => 'required',
            'chapterId' => 'required',
        ];
         // Validate request
        $this->validate($request, $rules, validationMessage($rules));

        try {
            // Start transaction for type 2 operations
            if ($isType2) {
                DB::beginTransaction();
            }

            // Fetch course and chapter based on user role
            $course = $this->getCourseByRole($request->course_id, $user->role_id);
            $chapter = Chapter::find($request->chapterId);

            if ($course && $chapter) {
                $lesson = $this->createOrUpdateLesson($request, $isType2);

                // If type is 2, save the quiz details
                if ($isType2) {
                    $online_exam = $this->createOrUpdateOnlineQuiz($request);
                    $lesson->quiz_id = $online_exam->id;
                    $lesson->save();
                    DB::commit();
                }

                $quiz = OnlineQuiz::find($isType2 ? $online_exam->id : $request->quiz);
                $this->sendCourseQuizNotifications($course, $chapter, $quiz);
                (new CourseSettingController())->updateTotalCountForCourse($course);

                Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                return redirect()->back();
            } else {
                Toastr::error(trans('frontend.Invalid Access'), trans('common.Failed'));
            }

        } catch (Exception $e) {
            if ($isType2) {
                DB::rollBack();
            }
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
        }

        return redirect()->back();
    }

    /**
     * Get course based on user role.
     */
    private function getCourseByRole($course_id, $role_id)
    {
        return $role_id == 2
            ? Course::where('id', $course_id)->where('user_id', Auth::id())->first()
            : Course::where('id', $course_id)->first();
    }

    /**
     * Create or update lesson.
     */
    private function createOrUpdateLesson(Request $request, $isType2)
    {
        $lesson = new Lesson();
        $lesson->course_id = $request->course_id;
        $lesson->chapter_id = $request->chapterId;
        $lesson->is_quiz = $request->is_quiz;
        $lesson->is_lock = (int)$request->lock;
        if (!$isType2) {
            $lesson->quiz_id = $request->quiz;
        }
        $lesson->save();
        return $lesson;
    }

    /**
     * Create or update online quiz.
     */
    private function createOrUpdateOnlineQuiz(Request $request)
    {
        $online_exam = new OnlineQuiz();

        foreach ($request->title as $key => $title) {
            $online_exam->setTranslation('title', $key, $title);
        }
        foreach ($request->instruction as $key => $instruction) {
            $online_exam->setTranslation('instruction', $key, $instruction);
        }

        $online_exam->category_id = (int)$request->category;
        $online_exam->sub_category_id = (int)$request->sub_category ?? null;
        $online_exam->course_id = (int)$request->course_id;
        $online_exam->percentage = $request->percentage;
        $online_exam->status = 1;
        $online_exam->created_by = Auth::id();

        $setup = QuizeSetup::getData();
        $online_exam->random_question = $setup->random_question == 1 ? 1 : 0;
        $online_exam->question_time_type = $setup->set_per_question_time == 1 ? 0 : 1;
        $online_exam->question_time = $setup->set_per_question_time == 1 ? $setup->time_per_question : $setup->time_total_question;
        $online_exam->question_review = $setup->question_review == 1 ? 1 : 0;
        $online_exam->show_result_each_submit = $setup->show_result_each_submit == 1 ? 1 : 0;
        $online_exam->multiple_attend = $setup->multiple_attend == 1 ? 1 : 0;
        $online_exam->show_ans_with_explanation = $setup->show_ans_with_explanation == 1 ? 1 : 0;

        $online_exam->save();
        return $online_exam;
    }

    /**
     * Send notifications for course quiz.
     */
    private function sendCourseQuizNotifications($course, $chapter, $quiz)
    {
        $notificationData = [
            'time' => Carbon::now()->format('d-M-Y, g:i A'),
            'course' => $course->title,
            'chapter' => $chapter->name,
            'quiz' => $quiz->title,
        ];

        if (!empty($course->enrollUsers)) {
            foreach ($course->enrollUsers as $user) {
                $this->sendNotification('Course_Quiz_Added', $user, $notificationData, [
                    'actionText' => trans('common.View'),
                    'actionUrl' => courseDetailsUrl($course->id, $course->type, $course->slug),
                ]);
            }
        }

        $this->sendNotification('Course_Quiz_Added', $course->user, $notificationData, [
            'actionText' => trans('common.View'),
            'actionUrl' => courseDetailsUrl($course->id, $course->type, $course->slug),
        ]);
    }

    public function CourseQuizUpdate(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        $rules = [
            'title' => 'required',
            'category' => 'required',
            'percentage' => 'required',
            'instruction' => 'required'
        ];
        $this->validate($request, $rules, validationMessage($rules));

         try {
            $sub = $request->sub_category;
            if (empty($sub)) {
                $sub = null;
            }
            $online_exam = OnlineQuiz::find($request->quiz_id);
            foreach ((array)$request->title as $key => $title) {
                $online_exam->setTranslation('title', $key, $title);
            }
            foreach ((array)$request->instruction as $key => $instruction) {
                $online_exam->setTranslation('instruction', $key, $instruction);
            }
            $online_exam->category_id = (int)$request->category;
            $online_exam->sub_category_id = (int)$sub;
            $online_exam->percentage = (int)$request->percentage;

            $online_exam->status = 0;
            $online_exam->created_by = Auth::user()->id;
            $result = $online_exam->save();
            if ($request->lesson_id) {
                $lesson = Lesson::find($request->lesson_id);
                if ($lesson) {
                    $lesson->is_lock = (int)$request->lock;
                    $lesson->save();
                }
            }


            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->route('courseDetails', $request->course_id);
        } catch (Exception $e) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }


    }

    public function store(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }


        $code = auth()->user()->language_code;


        $rules = [
            'title.' . $code => 'required|max:255',
            'instruction.' . $code => 'required',
            'category' => 'required',
            'percentage' => 'required',
        ];
        $this->validate($request, $rules, validationMessage($rules));


        try {
            DB::beginTransaction();
            $sub = $request->sub_category;
            if (empty($sub)) {
                $sub = null;
            }
            $group = $request->group_id;
            if (empty($group)) {
                $group = null;
            }
            $online_exam = new OnlineQuiz();
            foreach ($request->title as $key => $title) {
                $online_exam->setTranslation('title', $key, $title);
            }
            foreach ($request->instruction as $key => $instruction) {
                $online_exam->setTranslation('instruction', $key, $instruction);
            }
            $online_exam->group_id = $group;
            $online_exam->category_id = (int)$request->category;
            $online_exam->sub_category_id = (int)$sub;
            $online_exam->course_id = $request->course;
            $online_exam->percentage = $request->percentage;
            $online_exam->status = 1;
            $online_exam->created_by = Auth::user()->id;
            $online_exam->default_setting = (int)$request->change_default_settings;


            if ($request->change_default_settings == 0) {
                $setup = QuizeSetup::getData();
                $online_exam->random_question = (int)$setup->random_question == 1 ? 1 : 0;
                $online_exam->question_time_type = (int)$setup->set_per_question_time == 1 ? 0 : 1;
                $online_exam->question_time = (int)$setup->set_per_question_time == 1 ? $setup->time_per_question : $setup->time_total_question;
                $online_exam->question_review = (int)$setup->question_review == 1 ? 1 : 0;
                $online_exam->show_result_each_submit = (int)$setup->show_result_each_submit == 1 ? 1 : 0;
                $online_exam->multiple_attend = (int)$setup->multiple_attend == 1 ? 1 : 0;
                $online_exam->show_ans_with_explanation = (int)$setup->show_ans_with_explanation == 1 ? 1 : 0;
                $online_exam->losing_focus_acceptance_number = (int)$setup->losing_focus_acceptance_number ?? 0;
                $online_exam->show_correct_ans_in_ans_sheet = (int)$setup->show_correct_ans_in_ans_sheet ?? 0;
                $online_exam->show_only_wrong_ans_in_ans_sheet = (int)$setup->show_only_wrong_ans_in_ans_sheet ?? 0;
                $online_exam->show_total_correct_answer = (int)$setup->show_total_correct_answer ?? 0;
                $online_exam->losing_type = $setup->losing_type;

                if ($setup->show_ans_sheet != 1) {
                    $show_ans_sheet = 0;
                } else {
                    $show_ans_sheet = $setup->show_ans_sheet;
                }
                $online_exam->show_ans_sheet = $show_ans_sheet;

                if ($setup->show_score_result != 1) {
                    $show_score_result = 0;
                } else {
                    $show_score_result = $setup->show_score_result;
                }
                $online_exam->show_score_result = $show_score_result;
            } else {
                $online_exam->random_question = (int)$request->random_question == 1 ? 1 : 0;
                $online_exam->question_time_type = (int)$request->type == 1 ? 1 : 0;
                $online_exam->question_time = (int)$request->question_time;
                $online_exam->question_review = (int)$request->question_review == 1 ? 1 : 0;
                $online_exam->show_result_each_submit = (int)$request->show_result_each_submit == 1 ? 1 : 0;
                $online_exam->multiple_attend = (int)$request->multiple_attend == 1 ? 1 : 0;
                $online_exam->show_ans_with_explanation = (int)$request->show_ans_with_explanation == 1 ? 1 : 0;
                if ($request->losing_focus_acceptance_number_check != 1) {
                    $losing_focus_acceptance_number = 0;
                } else {
                    $losing_focus_acceptance_number = $request->losing_focus_acceptance_number;
                }
                $online_exam->losing_focus_acceptance_number = $losing_focus_acceptance_number;
                $online_exam->losing_type = $request->losing_type ?? 1;


                $online_exam->show_ans_sheet = (int)$request->get('show_ans_sheet', 0);
                $online_exam->show_score_result = (int)$request->get('show_score_result', 0);
                $online_exam->show_correct_ans_in_ans_sheet = $request->get('show_correct_ans_in_ans_sheet', 0);
                $online_exam->show_only_wrong_ans_in_ans_sheet = (int)$request->get('show_only_wrong_ans_in_ans_sheet', 0);
                $online_exam->show_total_correct_answer = (int)$request->get('show_total_correct_answer', 0);

            }

            $result = $online_exam->save();

            if ($request->set_random_question == 1) {
                $total = $request->total_random_question;

                $query = QuestionBank::query();
                if (Auth::user()->role_id == 2) {
                    $query->where('user_id', Auth::user()->id);
                }
//                if (!empty($request->category)) {
//                    $query->where('category_id', $request->category);
//
//                }
//                if (!empty($sub)) {
//                    $query->where('sub_category_id', $sub);
//                }

                if (!empty($group)) {
                    $query->where('q_group_id', $group);
                }
                $questions = $query->inRandomOrder()->limit($total)->get();

                foreach ($questions as $question) {
                    $assign = new OnlineExamQuestionAssign();
                    $assign->online_exam_id = $online_exam->id;
                    $assign->question_bank_id = $question->id;
                    $assign->save();

                }

            }


            if ($result) {

                DB::commit();
                Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                return redirect()->back();
            } else {
                Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
                return redirect()->back();
            }
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function edit($id)
    {
        try {
            if (isModuleActive('AdvanceQuiz')) {
                $advanceOnlineQuizController = new AdvanceOnlineQuizController();
                return $advanceOnlineQuizController->edit($id);
            } else {
                $user = Auth::user();
                $query = OnlineQuiz::query();
                if ($user->role_id == 2) {
                    $quiz_ids = [];
                    if (isModuleActive('OrgInstructorPolicy')) {
                        $ids = $user->policy->course_assigns->pluck('course_id')->toArray();
                        $course_quiz_ids = Course::select('quiz_id')->whereNotNull('quiz_id')->whereIn('id', $ids)->get()->pluck('quiz_id')->toArray();
                        $lesson_quiz_ids = Lesson::select('quiz_id')->whereNotNull('quiz_id')->whereIn('id', $ids)->get()->pluck('quiz_id')->toArray();
                        $quiz_ids = array_merge($course_quiz_ids, $lesson_quiz_ids);

                    }
                    $query->where('created_by', $user->id)->orWhereIn('id', $quiz_ids);
                } else {
                    if (isModuleActive('Organization') && Auth::user()->isOrganization()) {
                        $query->whereHas('user', function ($q) {
                            $q->where('organization_id', Auth::id());
                            $q->orWhere('created_by', Auth::id());
                        });
                    }
                }
                $online_exams = $query->with('subCategory', 'category', 'assign')->withCount('assign')->latest()->get();

                $categories = Category::where('status', 1)->orderBy('position_order', 'asc')->get();
                $online_exam = OnlineQuiz::find($id);
                $groups_query = QuestionGroup::where('active_status', 1);
                if (isModuleActive('Organization') && $user->isOrganization()) {
                    $groups_query->whereHas('user', function ($q) {
                        $q->where('organization_id', Auth::id());
                        $q->orWhere('id', Auth::id());
                    });
                }
                $groups = $groups_query->latest()->select('title', 'id')->latest()->pluck('title', 'id');


                $present_date_time = date("Y-m-d H:i:s");
                $present_time = date("H:i:s");
                $quiz_setup = QuizeSetup::getData();
                return view('quiz::online_quiz', compact('groups', 'quiz_setup', 'online_exams', 'categories', 'online_exam', 'present_date_time', 'present_time'));
            }
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function update(Request $request, $id)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        $code = auth()->user()->language_code;

        $rules = [
            'title.' . $code => 'required|max:255',
            'instruction.' . $code => 'required',
            'category' => 'required',
            'percentage' => 'required',
        ];

        $this->validate($request, $rules, validationMessage($rules));

        DB::beginTransaction();
        try {

            $sub = $request->sub_category;
            if (empty($sub)) {
                $sub = null;
            }
            $group = $request->group_id;
            if (empty($group)) {
                $group = null;
            }
            $online_exam = OnlineQuiz::find($id);
            foreach ($request->title as $key => $title) {
                $online_exam->setTranslation('title', $key, $title);
            }
            foreach ($request->instruction as $key => $instruction) {
                $online_exam->setTranslation('instruction', $key, $instruction);
            }
            $online_exam->category_id = (int)$request->category;
            $online_exam->sub_category_id = (int)$sub;
            $online_exam->group_id = $group;
            $online_exam->course_id = $request->course;
            $online_exam->percentage = $request->percentage;
            $online_exam->default_setting = (int)$request->change_default_settings;

            if ($request->change_default_settings == 0) {
                $setup = QuizeSetup::getData();
                $online_exam->random_question = $setup->random_question == 1 ? 1 : 0;
                $online_exam->question_time_type = $setup->set_per_question_time == 1 ? 0 : 1;
                $online_exam->question_time = $setup->set_per_question_time == 1 ? $setup->time_per_question : $setup->time_total_question;
                $online_exam->question_review = $setup->question_review == 1 ? 1 : 0;
                $online_exam->show_result_each_submit = $setup->show_result_each_submit == 1 ? 1 : 0;
                $online_exam->multiple_attend = $setup->multiple_attend == 1 ? 1 : 0;
                $online_exam->show_ans_with_explanation = $setup->show_ans_with_explanation == 1 ? 1 : 0;
                $online_exam->losing_focus_acceptance_number = $setup->losing_focus_acceptance_number ?? 0;
                $online_exam->show_correct_ans_in_ans_sheet = $setup->show_correct_ans_in_ans_sheet ?? 0;
                $online_exam->show_only_wrong_ans_in_ans_sheet = $setup->show_only_wrong_ans_in_ans_sheet ?? 0;
                $online_exam->show_total_correct_answer = $setup->show_total_correct_answer ?? 0;

                $online_exam->losing_type = $setup->losing_type;

                if ($setup->show_ans_sheet != 1) {
                    $show_ans_sheet = 0;
                } else {
                    $show_ans_sheet = $setup->show_ans_sheet;
                }
                $online_exam->show_ans_sheet = $show_ans_sheet;

                if ($setup->show_score_result != 1) {
                    $show_score_result = 0;
                } else {
                    $show_score_result = $setup->show_score_result;
                }
                $online_exam->show_score_result = $show_score_result;
            } else {
                $online_exam->random_question = $request->random_question == 1 ? 1 : 0;
                $online_exam->question_time_type = $request->type == 1 ? 1 : 0;
                $online_exam->question_time = $request->question_time;
                $online_exam->question_review = $request->question_review == 1 ? 1 : 0;
                $online_exam->show_result_each_submit = $request->show_result_each_submit == 1 ? 1 : 0;
                $online_exam->multiple_attend = $request->multiple_attend == 1 ? 1 : 0;
                $online_exam->show_ans_with_explanation = $request->show_ans_with_explanation == 1 ? 1 : 0;
                if ($request->losing_focus_acceptance_number_check != 1) {
                    $losing_focus_acceptance_number = 0;
                } else {
                    $losing_focus_acceptance_number = $request->losing_focus_acceptance_number;
                }
                $online_exam->losing_focus_acceptance_number = $losing_focus_acceptance_number;
                $online_exam->losing_type = $request->losing_type ?? 1;

                if ($request->show_ans_sheet != 1) {
                    $show_ans_sheet = 0;
                } else {
                    $show_ans_sheet = $request->show_ans_sheet;
                }
                $online_exam->show_ans_sheet = $show_ans_sheet;

                if ($request->show_score_result != 1) {
                    $show_score_result = 0;
                } else {
                    $show_score_result = $request->show_score_result;
                }
                $online_exam->show_score_result = $show_score_result;

                $online_exam->show_correct_ans_in_ans_sheet = $request->get('show_correct_ans_in_ans_sheet', 0);
                $online_exam->show_only_wrong_ans_in_ans_sheet = $request->get('show_only_wrong_ans_in_ans_sheet', 0);
                $online_exam->show_total_correct_answer = $request->get('show_total_correct_answer', 0);

            }


            $result = $online_exam->save();
            if ($result) {

                DB::commit();
                Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            } else {
                Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            }
            return redirect()->route('online-quiz');
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function manageOnlineExamQuestion($id, Request $request)
    {
        $online_exam = OnlineQuiz::find($id);
        if (!$online_exam){
            abort(404);
        }
        try {
            $user = Auth::user();

            $assign_ids = [];
            if (isModuleActive('AdvanceQuiz')) {
                $assign_ids = $online_exam->group_assigns->pluck('group_id')->toArray();
            }

            $online_exam->total_marks = $online_exam->totalMarks() ?? 0;
            $online_exam->total_questions = $online_exam->totalQuestions() ?? 0;


            if (!empty($online_exam->group_id)) {
                $request->merge([
                    'group' => $online_exam->group_id
                ]);
            }
            $query = QuestionBank::query();

            if ($user->role_id == 2) {
                $query->where('user_id', $user->id);
            }
            $searchGroup = $request->get('group');

            if (!empty($request->get('group'))) {
                $query->where('q_group_id', $request->get('group'));
            }

            if (isModuleActive('AdvanceQuiz')) {
                $query->whereIn('q_group_id', $assign_ids);
            }
            $question_banks = $query->with('questionGroup', 'questionMu')->get();

            $query2 = QuestionGroup::where('active_status', 1);
            if ($user->role_id == 2) {
                $query2->where('user_id', $user->id);
            }
            if (isModuleActive('AdvanceQuiz')) {
                $query2->whereIn('id', $assign_ids);
            }

            $groups = $query2->latest()->get();

            $assigned_questions = OnlineExamQuestionAssign::with('questionBank')->where('online_exam_id', $id)->get();
            $already_assigned = [];
            foreach ($assigned_questions as $assigned_question) {
                $already_assigned[] = $assigned_question->question_bank_id;
            }

            return view('quiz::manage_quiz', compact('searchGroup', 'groups', 'online_exam', 'question_banks', 'already_assigned'));
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function onlineExamPublish($id)
    {
        try {
            $publish = OnlineQuiz::find($id);
            $publish->status = 1;
            $publish->save();
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function quizSetup()
    {
        $quiz_setup = QuizeSetup::getData();
        return view('quiz::quiz_setup', compact('quiz_setup'));
    }

    public function SaveQuizSetup(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        try {
            if ($request->set_per_question_time == 1) {
                if (empty($request->set_time_per_question)) {
                    Toastr::error(trans('frontend.Per question time required'), trans('common.Failed'));
                    return redirect()->back();
                }
            } else {
                if (empty($request->set_time_total_question)) {
                    Toastr::error(trans('frontend.Total questions time required'), trans('common.Failed'));
                    return redirect()->back();
                }
            }

            $setup = QuizeSetup::firstOrCreate(['id' => 1]);
            $setup->random_question = $request->random_question;
            $setup->set_per_question_time = $request->set_per_question_time;
            $setup->multiple_attend = $request->multiple_attend ?? 0;
            $setup->show_ans_with_explanation = $request->show_ans_with_explanation ?? 0;
            if ($request->set_per_question_time == 1) {
                $setup->time_per_question = $request->set_time_per_question;
                $setup->time_total_question = null;
            } else {
                $setup->time_per_question = null;
                $setup->time_total_question = $request->set_time_total_question;
            }
            $setup->question_review = $request->question_review;
            if ($request->question_review == 1) {
                $setup->show_result_each_submit = null;
            } else {
                $setup->show_result_each_submit = $request->show_result_each_submit;
            }

            $setup->losing_type = $request->losing_type ?? 1;


            if ($request->show_ans_sheet != 1) {
                $show_ans_sheet = 0;
            } else {
                $show_ans_sheet = $request->show_ans_sheet;
            }
            $setup->show_ans_sheet = $show_ans_sheet;


            if ($request->show_score_result != 1) {
                $show_score_result = 0;
            } else {
                $show_score_result = $request->show_score_result;
            }
            $setup->show_score_result = $show_score_result;

            if ($request->losing_focus_acceptance_number_check != 1) {
                $losing_focus_acceptance_number = 0;
            } else {
                $losing_focus_acceptance_number = $request->losing_focus_acceptance_number;
            }

            $setup->losing_focus_acceptance_number = $losing_focus_acceptance_number;
            $setup->show_total_correct_answer = (int)$request->get('show_total_correct_answer', 0);
            $setup->show_correct_ans_in_ans_sheet = (int)$request->get('show_correct_ans_in_ans_sheet', 0);
            $setup->show_only_wrong_ans_in_ans_sheet = (int)$request->get('show_only_wrong_ans_in_ans_sheet', 0);
            if (isModuleActive('AdvanceQuiz')) {
                $setup->difficulty_level_status = (int)$request->get('difficulty_level_status', 0);
                $setup->auto_generate_quiz_code_status = (int)$request->get('auto_generate_quiz_code_status', 0);
                $setup->auto_generate_quiz_offline_testing_status = (int)$request->get('auto_generate_quiz_offline_testing_status', 0);
                $setup->advance_test_mode_status = (int)$request->get('advance_test_mode_status', 0);
            }

            $setup->save();
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }


    }

    public function onlineExamMarksRegister($id)
    {
        try {
            $online_exam_question = OnlineQuiz::find($id);
            $students = User::where('role_id', 3)->get();
            $present_students = [];
            foreach ($students as $student) {
                $take_exam = StudentTakeOnlineQuiz::where('student_id', $student->id)->where('online_exam_id', $online_exam_question->id)->first();
                if ($take_exam != "") {
                    $present_students[] = $student->id;
                }
            }

            return view('quiz::online_exam_marks_register', compact('online_exam_question', 'students', 'present_students'));
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function onlineExamQuestionAssign(Request $request)
    {
        try {
            OnlineExamQuestionAssign::where('online_exam_id', $request->online_exam_id)->delete();
            if (isset($request->questions)) {
                foreach ($request->questions as $question) {
                    $assign = new OnlineExamQuestionAssign();
                    $assign->online_exam_id = $request->online_exam_id;
                    $assign->question_bank_id = $question;
                    $assign->save();
                }
                Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                return redirect()->back();
            }
            Toastr::error(trans('frontend.No question is assigned'), trans('frontend.Failed'));
            return redirect()->back();
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function delete(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }


        $check = QuizTest::where('quiz_id', $request->id)->count();
        if ($check != 0) {
            Toastr::error(trans('quiz.You cannot delete this quiz because it has been taken by users'), trans('common.Failed'));
            return redirect()->back();
        }

        try {

            $delete_query = OnlineQuiz::destroy($request->id);

            if ($delete_query) {
                Lesson::where('quiz_id', $request->id)->delete();
                OnlineExamQuestionAssign::where('online_exam_id')->delete();
                Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                return redirect()->route('online-quiz');
            } else {
                Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
                return redirect()->route('online-quiz');

            }
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function onlineExamQuestionAssignByAjax(Request $request)
    {
        try {

            $online_exam = OnlineQuiz::findOrFail($request->online_exam_id);

            if (saasPlanCheck('quiz', $online_exam->totalQuestions())) {
                return response()->json([
                    'success' => 'You have no permission to add more quiz',
                    'totalQus' => $online_exam->total_marks,
                    'totalMarks' => $online_exam->total_questions,
                ], 200);
            }
            OnlineExamQuestionAssign::where('online_exam_id', $request->online_exam_id)->delete();

            if (isset($request->questions)) {
                foreach ($request->questions as $question) {
                    $assign = new OnlineExamQuestionAssign();
                    $assign->online_exam_id = $request->online_exam_id;
                    $assign->question_bank_id = $question;
                    $assign->save();
                }

                $totalMarks = $online_exam->total_marks = $online_exam->totalMarks() ?? 0;
                $totalQus = $online_exam->total_questions = $online_exam->totalQuestions() ?? 0;
                $online_exam->save();
                return response()->json([
                    'success' => 'Operation successful',
                    'totalQus' => $totalQus,
                    'totalMarks' => $totalMarks,
                ], 200);
            }

            return response()->json([
                'success' => 'Operation successful',
                'totalQus' => 0,
                'totalMarks' => 0,
            ], 200);

        } catch (Exception $e) {
            return response()->json(['error' => 'Something Went Wrong'], 500);
        }
    }

    public function viewOnlineQuestionModal($id)
    {

        try {
            $question_bank = QuestionBank::find($id);
            return view('quiz::online_eaxm_question_view_modal', compact('question_bank'));
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function quizResult(Request $request)
    {

        try {

            $categories = Category::where('status', 1)->with('childs')->orderBy('position_order', 'asc')->get();

            if ($request->category) {
                $category_search = $request->category;
            } else {
                $category_search = '';

            }

            if ($request->sub_category) {
                $subcategory_search = $request->sub_category;
            } else {
                $subcategory_search = '';
            }

            if ($request->course) {
                $course_search = $request->course;
            } else {
                $course_search = '';
            }

            $data = [];
            if (isModuleActive('Org')) {
                $data['positions'] = OrgPosition::orderBy('order', 'asc')->get();
                $data['branches'] = OrgBranch::where('parent_id', 0)->orderBy('order', 'asc')->get();
            }
            return view('quiz::online_exam_report', $data, compact('course_search', 'subcategory_search', 'category_search', 'categories',));
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());

        }
    }

    public function quizMarkingStore(Request $request)
    {

        try {
            $test = QuizTest::where('id', $request->quizTestId)->with('details', 'user')->first();

            if ($test->publish == 1) {
                Toastr::error(trans('quiz.Marks Already Given'), trans('common.Failed'));
                return redirect()->back();
            }
            DB::beginTransaction();

            foreach ($request->question as $key => $question) {
                if ($request->mark[$question] > $request->question_marks[$question]) {
                    Toastr::error(trans('frontend.Given Marks Should not greater than question marks'), trans('common.Failed'));
                    return redirect()->back();
                } else {
                    $quizDetails = QuizTestDetails::where('quiz_test_id', $test->id)->where('qus_id', $question)->first();
                    if (!empty($quizDetails) && $request->mark[$question] > 0) {
                        $quizDetails->status = 1;
                    }
                    if (!empty($quizDetails) && $request->question_type[$question] != 'M') {
                        $quizDetails->mark = $request->mark[$question];
                        $quizDetails->save();
                    }

                }

            }
            $question_given_marks = QuizTestDetails::where('quiz_test_id', $test->id)->sum('mark');
            $quiz_marking = QuizMarking::where('quiz_test_id', $test->id)->where('student_id', $test->user_id)->where('quiz_id', $test->quiz_id)->first();
            if ($quiz_marking) {
                $quiz_marking->marked_by = Auth::user()->id ?? 1;
                $quiz_marking->marking_status = 1;
                $quiz_marking->marks = $question_given_marks;
                $quiz_marking->save();
            }


            $quiz = OnlineQuiz::find($test->quiz_id);
            $totalScore = totalQuizMarks($quiz->id);


            $result['passMark'] = $quiz->percentage ?? 0;
            $result['mark'] = $question_given_marks > 0 ? number_format($question_given_marks / $totalScore * 100, 1) : 0;
            $result['status'] = $result['mark'] >= $result['passMark'] ? "Passed" : "Failed";
            $result['text_color'] = $result['mark'] >= $result['passMark'] ? "success_text" : "error_text";
            $test->pass = $result['mark'] >= $result['passMark'] ? 1 : 0;
            $test->publish = 1;
            $test->save();
            DB::commit();

            $this->sendNotification('QUIZ_RESULT_TEMPLATE', $test->user, [
                'quiz' => $quiz->title,
                'mark' => $question_given_marks,
                'total' => $totalScore,
                'status' => $test->pass == 1 ? 'Passed' : 'Failed',
            ]);


            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect('quiz/quiz-enrolled-student/' . $test->quiz_id);
        } catch (Exception $e) {
            DB::rollback();
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function enrolledStudent($id, Request $request)
    {
        try {
            $quiz_type = '';
            if ($request->type) {
                $type = $request->type;
                if ($type == "Course") {
                    $quiz_type = 1;
                } elseif ($type == "Quiz") {
                    $quiz_type = 2;

                }

            } else {
                $type = '';
            }

            $quiz = OnlineQuiz::find($id);
            if (empty($quiz_type)) {
                $quizTests = QuizTest::where('quiz_id', $quiz->id)->with('details', 'quiz', 'user', 'course')->get();
            } else {
                $quizTests = QuizTest::where('quiz_id', $quiz->id)->where('quiz_type', $quiz_type)->with('details', 'quiz', 'user', 'course')->get();
            }
            $student_details = [];
            if (isModuleActive('OrgInstructorPolicy')) {
                $user = Auth::user();
                if ($user->role_id != 1) {
                    $ids = $user->policy->course_assigns->pluck('course_id')->toArray();
                    $quizTests = $quizTests->whereIn('course_id', $ids);
                }
            }

            foreach ($quizTests as $key => $test) {
                if (isModuleActive('Org')) {
                    if ($test->course->advance_test == 1) {
                        continue;
                    }
                    $student_details[$key]['branch_name'] = $test->user->branch->group;
                }
                $student_details[$key]['id'] = $test->user->id;
                $student_details[$key]['role_id'] = $test->user->role_id;
                $student_details[$key]['date'] = showDate($test->start_at);
                $student_details[$key]['name'] = $test->user->name;

                $student_details[$key]['quiz_id'] = $id;
                $student_details[$key]['course_id'] = $test->course_id;
                $student_details[$key]['status'] = $test->publish;
                $student_details[$key]['pass'] = $test->pass;
                $student_details[$key]['duration'] = $test->duration;
                $student_details[$key]['test_id'] = $test->id;
                $student_details[$key]['quizDetails'] = $test->details;
                $student_details[$key]['focus_lost'] = $test->focus_lost;

            }
            return view('quiz::online_exam_enrolled', compact('type', 'quiz', 'student_details'));
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }

    }

    public function markingScript($quiz_test_id)
    {
        try {
            $quizTest = QuizTest::where('id', $quiz_test_id)->with('details', 'user')->first();
            $data = [];

            $user = $quizTest->user->id;

            $questions = [];

            if (Auth::check() && $quizTest->user_id == $user) {

                $quizSetup = QuizeSetup::getData();

                $course = Course::with('quiz')
                    ->where('courses.id', $quizTest->course_id)->first();

                $quiz = OnlineQuiz::with('assign', 'assign.questionBank', 'assign.questionBank.questionMu')->findOrFail($quizTest->quiz_id);

                foreach (@$quiz->assign as $key => $assign) {

                    $questions[$key]['qus_id'] = $assign->questionBank->id;
                    $questions[$key]['qus'] = $assign->questionBank->question;
                    $questions[$key]['type'] = $assign->questionBank->type;
                    $questions[$key]['image'] = $assign->questionBank->image;
                    $questions[$key]['question_marks'] = $assign->questionBank->marks;
                    $questions[$key]['qusBank'] = $assign->questionBank;
                    $test_answer = QuizTestDetails::where('quiz_test_id', $quizTest->id)->where('qus_id', $assign->questionBank->id)->first();
                    if ($test_answer) {
                        $test_ans_mark = $test_answer->mark;
                        $test_ans_answer = $test_answer->answer;
                    } else {
                        $test_ans_mark = 0;
                        $test_ans_answer = '';
                    }

                    $questions[$key]['mark'] = $test_ans_mark;
                    if ($assign->questionBank->type != 'M' && $assign->questionBank->type != 'X') {
                        $questions[$key]['answer'] = $test_ans_answer;
                    } else {
                        foreach (@$assign->questionBank->questionMuInSerial as $key2 => $option) {
                            $questions[$key]['option'][$key2]['title'] = $option->title;
                            $questions[$key]['option'][$key2]['right'] = $option->status == 1;

                        }

                        $test = QuizTestDetails::where('quiz_test_id', $quizTest->id)->where('qus_id', $assign->questionBank->id)->first();
                        if ($test) {
                            $questions[$key]['isSubmit'] = true;
                            if ($test->status == 0) {
                                $questions[$key]['option'][$key2]['wrong'] = $test->status == 0 ? true : false;
                                $questions[$key]['isWrong'] = true;
                            }
                        }
                    }
                }
                return view('quiz::online_exam_marking', compact('questions', 'quizSetup', 'course', 'data', 'quizTest'));

            } else {
                Toastr::error(trans('frontend.Permission Denied'), trans('common.Failed'));
                return redirect()->route('online-quiz');
            }
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }

    }

    public function getTotalQuizNumbers(Request $request)
    {
        if (Auth::check()) {
            $query = QuestionBank::query();
            if (Auth::user()->role_id == 2) {
                $query->where('user_id', Auth::user()->id);
            }
//            if (!empty($request->category_id)) {
//                $query->where('category_id', $request->category_id);
//
//            }
//            if (!empty($request->subcategory_id)) {
//                $query->where('sub_category_id', $request->subcategory_id);
//            }
            if (!empty($request->group_id)) {
                $query->where('q_group_id', $request->group_id);
            }
            return $query->count();
        } else {
            return 0;
        }
    }

    public function quizResultData()
    {
        $query = $this->query();
        return Datatables::of($query)
            ->addIndexColumn()
            ->editColumn('user.name', function ($query) {
                return $query->user->name;
            })
            ->addColumn('employee_id', function ($query) {
                return $query->user->employee_id;
            })
            ->addColumn('org_chart_code', function ($query) {
                return $query->user->org_chart_code;
            })
            ->addColumn('org_position_code', function ($query) {
                return $query->user->org_position_code;
            })
            ->editColumn('course.title', function ($query) {
                return $query->course->title;
            })
            ->editColumn('quiz.title', function ($query) {
                return $query->quiz->title;
            })
            ->editColumn('quiz.percentage', function ($query) {
                return $query->quiz->percentage . '%';
            })
            ->editColumn('start_at', function ($query) {
                return showDate($query->start_at) . ' ' . Carbon::parse($query->start_at)->format('h:i A');
            })
            ->editColumn('end_at', function ($query) {
                return showDate($query->end_at) . ' ' . Carbon::parse($query->end_at)->format('h:i A');
            })
            ->addColumn('marks', function ($query) {
                $totalCorrect = $query->details->where('status', 1)->sum('mark');
                $totalMark = $query->quiz->totalMarks();

                return $totalCorrect . '/' . $totalMark;
            })->editColumn('duration', function ($query) {
                if ($query->duration == 0) {
                    return 0;
                } else {
                    return $query->duration;
                }
            })->addColumn('status', function ($query) {
                if ($query->pass == 1) {
                    return trans('common.Pass');
                } else {
                    return trans('common.Fail');
                }
            })
            ->addColumn('result', function ($query) {
                $totalCorrect = $query->details->where('status', 1)->sum('mark');
                $totalMark = $query->quiz->totalMarks();

                if ($totalCorrect == 0 || $totalMark == 0) {
                    $result = 0;
                } else {
                    $result = number_format(($totalCorrect / $totalMark) * 100, 1);
                }
                return $result . '%';
            })
            ->make(true);
    }

    public function quizResultExport()
    {
        return Excel::download(new OnlineQuizReport(), 'quiz-report.xlsx');
    }

    public function quizReTest($id)
    {
        $test = QuizTest::find($id);
        if ($test) {
            $details = $test->details;
            foreach ($details as $item) {
                $ans = $item->answers;
                foreach ($ans as $a) {
                    $a->delete();
                }
                $item->delete();
            }
            $test->delete();
        }
        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->route('online-quiz');
    }
}
