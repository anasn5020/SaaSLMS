<?php

namespace App\Repositories\Eloquents;

use App\Traits\SendNotification;
use Carbon\Carbon;
use App\Traits\ImageStore;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Modules\Quiz\Entities\OnlineQuiz;
use Modules\Quiz\Entities\QuizeSetup;
use Modules\Quiz\Entities\QuestionBank;
use Modules\Quiz\Entities\QuestionGroup;
use Modules\Quiz\Entities\QuestionLevel;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\Lesson;
use Modules\CourseSetting\Entities\Chapter;
use Modules\Quiz\Entities\QuestionBankMuOption;
use Modules\Assignment\Entities\InfixAssignment;
use Modules\Quiz\Entities\OnlineExamQuestionAssign;
use App\Http\Resources\api\v2\Quize\QuizListResource;
use App\Http\Resources\api\v2\Quize\QuestionsResource;
use App\Http\Resources\api\v2\Quize\QuizDetailResource;
use App\Repositories\Interfaces\QuizRepositoryInterface;
use App\Http\Resources\api\v2\Quize\QuestionListResource;
use Modules\AdvanceQuiz\Entities\MatchingTypeQuestionAssign;
use App\Http\Resources\api\v2\Quize\CourseQuizDetailResource;
use App\Http\Resources\api\v2\Quize\QuestionGroupListResource;
use App\Http\Resources\api\v2\Quize\QuestionLevelListResource;
use App\Http\Resources\api\v2\Quize\QuestionBankDetailResource;
use Throwable;

class QuizRepository implements QuizRepositoryInterface
{
    use ImageStore,SendNotification;

    public function storeCourseQuiz(object $request): bool
    {
        try {
            if ($request->type == 'long_form') {
                DB::transaction(function () use ($request) {
                    $sub = $request->sub_category;
                    if (empty($sub)) {
                        $sub = null;
                    }
                    $online_exam = new OnlineQuiz();

                    foreach ($request->title as $key => $title) {
                        $online_exam->setTranslation('title', $key, $title);
                    }
                    foreach ($request->instruction as $key => $instruction) {
                        $online_exam->setTranslation('instruction', $key, $instruction);
                    }

                    $online_exam->category_id = (int) $request->category;
                    $online_exam->sub_category_id = (int) $sub;
                    $online_exam->course_id = (int) $request->course_id;
                    $online_exam->percentage = $request->percentage;
                    $online_exam->gourp_id = $request->group_id;
                    $online_exam->status = 1;
                    $online_exam->created_by = auth()->id();

                    $setup = QuizeSetup::getData();
                    $online_exam->random_question = $setup->random_question == 1 ? 1 : 0;
                    $online_exam->question_time_type = $setup->set_per_question_time == 1 ? 0 : 1;
                    $online_exam->question_time = $setup->set_per_question_time == 1 ? $setup->time_per_question : $setup->time_total_question;
                    $online_exam->question_review = $setup->question_review == 1 ? 1 : 0;
                    $online_exam->show_result_each_submit = $setup->show_result_each_submit == 1 ? 1 : 0;
                    $online_exam->multiple_attend = $setup->multiple_attend == 1 ? 1 : 0;
                    $online_exam->show_ans_with_explanation = $setup->show_ans_with_explanation == 1 ? 1 : 0;

                    $online_exam->save();

                    $user = auth()->user();
                    if ($user->role_id == 2) {
                        $course = Course::where('id', $request->course_id)->where('user_id', auth()->id())->first();
                    } else {
                        $course = Course::where('id', $request->course_id)->first();
                    }
                    $chapter = Chapter::find($request->chapterId);
                    if (isset($course) && isset($chapter)) {
                        $lesson = new Lesson();
                        $lesson->course_id = $course->id;
                        $lesson->chapter_id = $chapter->id;
                        $lesson->quiz_id = $online_exam->id;
                        $lesson->is_quiz = (int) 1;
                        $lesson->is_lock = (int) $request->lock;
                        $lesson->save();

                        $quiz = OnlineQuiz::find($online_exam->id);
                        $codes = [
                            'time' => Carbon::now()->format('d-M-Y, g:i A'),
                            'course' => $course->title,
                            'chapter' => $chapter->name,
                            'quiz' => $quiz->title,
                        ];

                        $act = 'Course_Quiz_Added';
                        $this->quizStoreNotification($course, $act, $codes);
                    }
                });
            } else {
                $user = auth()->user();
                if ($user->role_id == 2) {
                    $course = Course::where('id', $request->course_id)->where('user_id', auth()->id())->first();
                } else {
                    $course = Course::where('id', $request->course_id)->first();
                }
                $chapter = Chapter::find($request->chapterId);

                if (isset($course) && isset($chapter)) {
                    $lesson = new Lesson();
                    $lesson->course_id = $request->course_id;
                    $lesson->chapter_id = $request->chapterId;
                    $lesson->quiz_id = $request->quiz;
                    $lesson->is_quiz = (int) 1;
                    $lesson->is_lock = (int) $request->lock;
                    $lesson->save();
                    $quiz = OnlineQuiz::find($request->quiz);

                    $act = 'Course_Quiz_Added';
                    $codes = [
                        'time' => Carbon::now()->format('d-M-Y, g:i A'),
                        'course' => $course->title,
                        'chapter' => $chapter->name,
                        'quiz' => $quiz->title,
                    ];
                    $this->quizStoreNotification($course, $act, $codes);
                }
            }
            return true;
        } catch (Throwable $th) {
            return false;
        }
    }

    private function quizStoreNotification($course, $act, $codes)
    {
        try {
            if (isset($course->enrollUsers) && !empty($course->enrollUsers)) {
                foreach ($course->enrollUsers as $user) {


                    $this->sendNotification($act,$user,$codes,[
                        trans('common.View'),
                        courseDetailsUrl(@$course->id, @$course->type, @$course->slug),
                    ]);
                }
            }
            $courseUser = $course->user;

            $this->sendNotification($act,$courseUser,$codes,[
                trans('common.View'),
                courseDetailsUrl(@$course->id, @$course->type, @$course->slug),
            ]);

        } catch (Throwable $th) {
            //throw $th;
        }
    }

    public function store(object $request): bool
    {
        $request->merge([
            'lock' => $request->privacy,
            'random_question' => $request->set_random_question,
            'losing_focus_acceptance_number_check' => $request->losing_focus_acceptance,
        ]);

        try {
            if ($request->form_type == 'long_form') {
                DB::transaction(function () use ($request) {
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
                    $online_exam->category_id = (int) $request->category;
                    $online_exam->sub_category_id = (int) $sub;
                    $online_exam->course_id = $request->course;
                    $online_exam->percentage = $request->percentage;
                    $online_exam->status = 1;
                    $online_exam->created_by = auth()->user()->id;
                    $online_exam->default_setting = (int) $request->change_default_settings;

                    if ($request->change_default_settings == 0) {
                        $setup = QuizeSetup::getData();
                        $online_exam->random_question = (int) $setup->random_question == 1 ? 1 : 0;
                        $online_exam->question_time_type = (int) $setup->set_per_question_time == 1 ? 0 : 1;
                        $online_exam->question_time = (int) $setup->set_per_question_time == 1 ? $setup->time_per_question : $setup->time_total_question;
                        $online_exam->question_review = (int) $setup->question_review == 1 ? 1 : 0;
                        $online_exam->show_result_each_submit = (int) $setup->show_result_each_submit == 1 ? 1 : 0;
                        $online_exam->multiple_attend = (int) $setup->multiple_attend == 1 ? 1 : 0;
                        $online_exam->show_ans_with_explanation = (int) $setup->show_ans_with_explanation == 1 ? 1 : 0;
                        $online_exam->losing_focus_acceptance_number = (int) $setup->losing_focus_acceptance_number ?? 0;
                        $online_exam->show_correct_ans_in_ans_sheet = (int) $setup->show_correct_ans_in_ans_sheet ?? 0;
                        $online_exam->show_only_wrong_ans_in_ans_sheet = (int) $setup->show_only_wrong_ans_in_ans_sheet ?? 0;
                        $online_exam->show_total_correct_answer = (int) $setup->show_total_correct_answer ?? 0;
                        $online_exam->losing_type = (int)$setup->losing_type;

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
                        $online_exam->random_question = (int) $request->random_question == 1 ? 1 : 0;
                        $online_exam->question_time_type = (int) $request->type == 1 ? 1 : 0;
                        $online_exam->question_time = (int) $request->question_time;
                        $online_exam->question_review = (int) $request->question_review == 1 ? 1 : 0;
                        $online_exam->show_result_each_submit = (int) $request->show_result_each_submit == 1 ? 1 : 0;
                        $online_exam->multiple_attend = (int) $request->multiple_attend == 1 ? 1 : 0;
                        $online_exam->show_ans_with_explanation = (int) $request->show_ans_with_explanation == 1 ? 1 : 0;
                        if ($request->losing_focus_acceptance_number_check != 1) {
                            $losing_focus_acceptance_number = 0;
                        } else {
                            $losing_focus_acceptance_number = $request->losing_focus_acceptance_number;
                        }
                        $online_exam->losing_focus_acceptance_number = $losing_focus_acceptance_number;
                        $online_exam->losing_type = $request->losing_type ?? 1;

                        $online_exam->show_ans_sheet = (int) $request->get('show_ans_sheet', 0);
                        $online_exam->show_score_result = (int) $request->get('show_score_result', 0);
                        $online_exam->show_correct_ans_in_ans_sheet = $request->get('show_correct_ans_in_ans_sheet', 0);
                        $online_exam->show_only_wrong_ans_in_ans_sheet = (int) $request->get('show_only_wrong_ans_in_ans_sheet', 0);
                        $online_exam->show_total_correct_answer = (int) $request->get('show_total_correct_answer', 0);
                    }

                    $online_exam->save();

                    if ($request->set_random_question == 1) {
                        $total = $request->total_random_question;

                        $query = QuestionBank::query();
                        if (auth()->user()->role_id == 2) {
                            $query->where('user_id', auth()->user()->id);
                        }

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
                    if ($request->from == 'course') {
                        $user = auth()->user();
                        if ($user->role_id == 2) {
                            $course = Course::where('id', $request->course_id)->where('user_id', auth()->id())->first();
                        } else {
                            $course = Course::where('id', $request->course_id)->first();
                        }
                        $chapter = Chapter::find($request->chapterId);
                        if (isset($course) && isset($chapter)) {
                            $lesson = new Lesson();
                            $lesson->course_id = $course->id;
                            $lesson->chapter_id = $chapter->id;
                            $lesson->quiz_id = $online_exam->id;
                            $lesson->is_quiz = (int) 1;
                            $lesson->is_lock = (int) $request->lock;
                            $lesson->save();

                            $quiz = OnlineQuiz::find($online_exam->id);
                            $codes = [
                                'time' => Carbon::now()->format('d-M-Y, g:i A'),
                                'course' => $course->title,
                                'chapter' => $chapter->name,
                                'quiz' => $quiz->title,
                            ];

                            $act = 'Course_Quiz_Added';
                            $this->quizStoreNotification($course, $act, $codes);
                        }
                    }
                });
            } else {
                $user = auth()->user();
                if ($user->role_id == 2) {
                    $course = Course::where('id', $request->course_id)->where('user_id', auth()->id())->first();
                } else {
                    $course = Course::where('id', $request->course_id)->first();
                }
                $chapter = Chapter::find($request->chapterId);

                if (isset($course) && isset($chapter)) {
                    $lesson = new Lesson();
                    $lesson->course_id = $request->course_id;
                    $lesson->chapter_id = $request->chapterId;
                    $lesson->quiz_id = $request->quiz;
                    $lesson->is_quiz = (int) 1;
                    $lesson->is_lock = (int) $request->lock;
                    $lesson->save();
                    $quiz = OnlineQuiz::find($request->quiz);

                    $act = 'Course_Quiz_Added';
                    $codes = [
                        'time' => Carbon::now()->format('d-M-Y, g:i A'),
                        'course' => $course->title,
                        'chapter' => $chapter->name,
                        'quiz' => $quiz->title,
                    ];
                    $this->quizStoreNotification($course, $act, $codes);
                }
            }
            return true;
        } catch (Throwable $th) {
            return false;
        }
    }

    public function quizDetail(object $request): object
    {
        if ($request->course_id) {
            $lesson = Lesson::where('course_id', $request->course_id)
                ->where('chapter_id', $request->chapter_id)
                ->where('is_quiz', 1)
                ->where('quiz_id', $request->quiz_id)
                ->first();

            return new CourseQuizDetailResource($lesson);
        } else {
            // $quiz = OnlineQuiz::find($request->quiz_id);
            return new QuizDetailResource(OnlineQuiz::find($request->quiz_id));
        }
    }
    public function courseQuizUpdate(object $request): bool
    {
        try {
            DB::transaction(function () use ($request) {
                $sub = $request->sub_category_id;
                if (empty($sub)) {
                    $sub = null;
                }
                $online_exam = OnlineQuiz::find($request->quiz_id);
                foreach ($request->title as $key => $title) {
                    $online_exam->setTranslation('title', $key, $title);
                }
                foreach ($request->instruction as $key => $instruction) {
                    $online_exam->setTranslation('instruction', $key, $instruction);
                }
                $online_exam->category_id = (int) $request->category_id;
                $online_exam->sub_category_id = (int) $sub;
                $online_exam->percentage = (int) $request->percentage;

                $online_exam->status = 0;
                $online_exam->created_by = auth()->user()->id;
                $online_exam->save();
                $course = $online_exam->course;
                if ($request->lock) {
                    $lesson = Lesson::whereNotNull('is_quiz')->where('quiz_id', $online_exam->id)->where('course_id', $course->id)->first();
                    if ($lesson) {
                        $lesson->is_lock = (int) $request->lock;
                        $lesson->save();
                    }
                }
            });
            return true;
        } catch (Throwable $th) {
            return false;
        }
    }
    public function storeQuestion(object $request): bool
    {
        $user = auth()->user();
        $online_question = new QuestionBank();
        $online_question->type = $request->question_type;
        $online_question->q_group_id = $request->group;
        $online_question->category_id = (int) $request->category;
        $online_question->sub_category_id = (int) $request->sub_category;
        $online_question->marks = (int) $request->marks;
        $online_question->question = $request->question;
        $online_question->user_id = (int) $user->id;
        $online_question->shuffle = $request->question_type == 'M' ? (int)$request->shuffle : 0;

        if (isModuleActive('AdvanceQuiz')) {
            $online_question->level = (int) $request->level;
            $online_question->pre_condition = (int)$request->pre_condition;
        }

        if ($request->file('image')) {
            $online_question->image = $this->saveImage($request->image);
        }
        $online_question->save();
        if ($request->question_type == 'M') {
            $online_question->explanation = $request->explanation;
            $online_question->number_of_option = $request->number_of_option;
            $online_question->save();
            $online_question->toArray();
            $i = 0;
            if (isset($request->option)) {
                foreach ($request->option as $option) {
                    $i++;
                    $option_check = 'option_check_' . $i;
                    $online_question_option = new QuestionBankMuOption();
                    $online_question_option->question_bank_id = $online_question->id;
                    $online_question_option->title = $option;
                    if (isset($request->$option_check)) {
                        $online_question_option->status = 1;
                    } else {
                        $online_question_option->status = 0;
                    }
                    $online_question_option->save();
                }
            }
            if ($request->quize_id) {
                $assign = new OnlineExamQuestionAssign();
                $assign->online_exam_id = $request->quize_id;
                $assign->question_bank_id = $online_question->id;
                $assign->save();
            }
        } elseif ($request->question_type == 'X') {


            $online_question->number_of_qus = $request->number_of_qus;
            $online_question->number_of_ans = $request->number_of_ans;
            $online_question->data = $request->data;
            $online_question->connection = $request->connection;
            $online_question->save();

            $qus = [];
            $ans = [];
            foreach ((array)$request->qus as $key => $option) {
                $online_question_option = new QuestionBankMuOption();
                $online_question_option->question_bank_id = $online_question->id;
                $online_question_option->title = $option;
                $online_question_option->status = 0;
                $online_question_option->type = 1;
                $online_question_option->option_index = $key;
                $online_question_option->save();
                $qus[] = $online_question_option->id;
            }

            foreach ((array)$request->ans as $key => $option) {
                $online_question_option = new QuestionBankMuOption();
                $online_question_option->question_bank_id = $online_question->id;
                $online_question_option->title = $option;
                $online_question_option->status = 0;
                $online_question_option->type = 0;
                $online_question_option->option_index = $key;
                $online_question_option->save();
                $ans[] = $online_question_option->id;
            }


            $connection = $request->connection;
            $connection = explode(',', $connection);
            foreach ($connection as $con) {
                $con = explode('|', $con);
                if (empty($con)) {
                    continue;
                }
                if (isset($con[0]) && isset($con[1])) {
                    $qusKey = explode('-', $con[0])[0];
                    $ansKey = explode('-', $con[1])[0];
                    MatchingTypeQuestionAssign::create([
                        'question_id' => $online_question->id,
                        'option_id' => $qus[$qusKey],
                        'answer_id' => $ans[$ansKey],
                    ]);
                }
            }
        }
        return true;
    }
    public function updateQuizQuestion(object $request): bool
    {
        $id = $request->question_id;
        $online_question = QuestionBank::find($id);
        $online_question->type = $request->question_type;
        $online_question->q_group_id = $request->group;
        $online_question->category_id = (int) $request->category;
        $online_question->sub_category_id = (int) $request->sub_category;
        $online_question->marks = (int) $request->marks;
        $online_question->shuffle = $request->question_type == 'M' ? (int)$request->shuffle : 0;
        $online_question->question = $request->question;
        if (isModuleActive('AdvanceQuiz')) {
            $online_question->level = (int) $request->level;
            $online_question->pre_condition = (int)$request->pre_condition;
        }

        if ($request->file('image')) {
            $online_question->image = $this->saveImage($request->image);
        }
        $online_question->save();

        if ($request->question_type == 'M') {
            $i = 0;
            if (isset($request->option)) {
                QuestionBankMuOption::where('question_bank_id', $online_question->id)->delete();
                foreach ($request->option as $option) {
                    $i++;
                    $option_check = 'option_check_' . $i;
                    $online_question_option = new QuestionBankMuOption();
                    $online_question_option->question_bank_id = (int) $online_question->id;
                    $online_question_option->title = $option;
                    if (isset($request->$option_check)) {
                        $online_question_option->status = 1;
                    } else {
                        $online_question_option->status = 0;
                    }
                    $online_question_option->save();
                }
            }
        } elseif ($request->question_type == 'X') {


            $online_question->number_of_qus = (int) $request->number_of_qus;
            $online_question->number_of_ans = (int) $request->number_of_ans;
            $online_question->data = $request->data;
            $online_question->connection = $request->connection;
            $online_question->save();
            QuestionBankMuOption::where('question_bank_id', $online_question->id)->delete();
            MatchingTypeQuestionAssign::where('question_id', $online_question->id)->delete();
            $qus = [];
            $ans = [];
            foreach ((array) $request->qus as $key => $option) {
                $online_question_option = new QuestionBankMuOption();
                $online_question_option->question_bank_id = $online_question->id;
                $online_question_option->title = $option;
                $online_question_option->status = 0;
                $online_question_option->type = 1;
                $online_question_option->save();
                $qus[] = $online_question_option->id;
            }

            foreach ((array) $request->ans as $key => $option) {
                $online_question_option = new QuestionBankMuOption();
                $online_question_option->question_bank_id = $online_question->id;
                $online_question_option->title = $option;
                $online_question_option->status = 0;
                $online_question_option->type = 0;
                $online_question_option->save();
                $ans[] = $online_question_option->id;
            }


            $connection = $request->connection;
            $connection = explode(',', $connection);
            foreach ($connection as $con) {
                $con = explode('|', $con);
                if (empty($con)) {
                    continue;
                }
                if (isset($con[0]) && isset($con[1])) {
                    $qusKey = explode('-', $con[0])[0];
                    $ansKey = explode('-', $con[1])[0];
                    MatchingTypeQuestionAssign::create([
                        'question_id' => $online_question->id,
                        'option_id' => (int) $qus[$qusKey],
                        'answer_id' => (int) $ans[$ansKey],
                    ]);
                }
            }
        }
        return true;
    }
    public function groupList(object $request): object
    {
        $groups = QuestionGroup::where('active_status', 1)
            ->when(isModuleActive('AdvanceQuiz'), function ($group) {
                $group->orderBy('order');
            })
            ->when($search = $request->search, function ($groups) use ($search) {
                $groups->whereLike('title', $search);
            })->paginate($request->per_page ?? 10);
        return QuestionGroupListResource::collection($groups);
    }
    public function questionLevels(object $request): object
    {
        $levels = QuestionLevel::when($search = $request->search, function ($levels) use ($search) {
            $levels->whereLike('title', $search);
        })->paginate($request->get('per_page', 10));

        return QuestionLevelListResource::collection($levels);
    }
    public function questionTypes(): object
    {
        $types = [
            'M' => 'Multiple Choice',
            'S' => 'Short Answer',
            'L' => 'Long Answer',
            'X' => 'Matching Type',
        ];
        $response = [
            'success' => true,
            'data' => $types,
            'message' => trans('api.Operation successful'),
        ];
        return response()->json($response);
    }
    public function deleteLesson(object $request): bool
    {
        $lesson = Lesson::where('course_id', $request->course_id)
            ->where('chapter_id', $request->chapter_id)
            ->where('is_quiz', 1)
            ->find($request->content_id);
        if (auth()->user()->role_id == 2) {
            $course = Course::where('user_id', auth()->id())->find($lesson->course_id);
        } else {
            $course = Course::find($lesson->course_id);
        }

        if ($course) {
            if ($lesson->is_assignment == 1) {
                $assignment = InfixAssignment::find($lesson->assignment_id);
                $assignment->delete();
            }
            $this->lessonFileDelete($lesson);

            if (isModuleActive('BunnyStorage')) {
                if ($lesson->bunnyLesson) {
                    $lesson->bunnyLesson->delete();
                }
            }
            $lesson->delete();
            return true;
        } else {
            return false;
        }
    }

    private function lessonFileDelete($lesson): bool
    {
        try {
            $host = $lesson->host;
            if ($host == "SCORM") {
                $index = $lesson->video_url;
                if (!empty($index)) {
                    $new_path = str_replace("/public/uploads/scorm/", "", $index);
                    $folder = explode('/', $new_path)[0] ?? '';
                    $delete_dir = public_path() . "/uploads/scorm/" . $folder;

                    if (File::isDirectory($delete_dir)) {
                        File::deleteDirectory($delete_dir);
                    }
                }
            } elseif (in_array($host, ['Self', 'Image', 'PDF', 'Word', 'Excel', 'PowerPoint', 'Text', 'Zip'])) {
                $file = File::exists($lesson->video_url);

                if ($file) {
                    File::delete($lesson->video_url);
                }
            }
        } catch (Exception $e) {
        }
        return true;
    }

    public function questionList(object $request): object
    {
        $quizId = Lesson::where('course_id', $request->course_id)
            ->where('chapter_id', $request->chapter_id)
            ->where('is_quiz', 1)
            ->where('quiz_id', $request->quiz_id)
            ->first()->quiz_id;

        $questionIds = OnlineExamQuestionAssign::where('online_exam_id', $quizId)->pluck('question_bank_id');

        return QuestionListResource::collection($questionIds);
    }

    public function questions(object $request): object
    {
        $user = auth()->user();
        if ($user->role_id == 2) {
            $queries = QuestionBank::latest()->select('question_banks.*')->where('question_banks.active_status', 1)->with('category', 'subCategory', 'questionGroup')->where('question_banks.user_id', $user->id);
        } else {
            $queries = QuestionBank::latest()->select('question_banks.*')->where('question_banks.active_status', 1)->with('category', 'subCategory', 'questionGroup');
        }
        $queries->withCount('quizAssign');

        if ($request->group) {
            if (isModuleActive('AdvanceQuiz')) {
                $group = QuestionGroup::find($request->group);
                $ids = $group->getAllChildIds($group, [$group->id]);
                $queries->whereIn('q_group_id', $ids);
            } else {
                $queries->where('q_group_id', $request->group);
            }
        }
        if (isModuleActive('Organization') && auth()->user()->isOrganization()) {
            $queries->whereHas('user', function ($q) {
                $q->where('organization_id', auth()->id());
                $q->orWhere('id', auth()->id());
            });
        }

        $questions = $queries->when($search = $request->search, function ($questions) use ($search) {
            $questions->whereLike('question', $search);
        })->paginate($request->per_page ?? 10);

        return QuestionsResource::collection($questions);
    }

    public function questionDetail(object $request): object
    {
        $quizId = Lesson::where('course_id', $request->course_id)
            ->where('chapter_id', $request->chapter_id)
            ->where('is_quiz', 1)
            ->where('quiz_id', $request->quiz_id)->first()->quiz_id;

        $questionId = OnlineExamQuestionAssign::where('online_exam_id', $quizId)->where('question_bank_id', $request->question_id)->first()->question_bank_id;

        return new QuestionListResource($questionId);
    }

    public function updateQuestion(object $request): array
    {
        $quizId = Lesson::where('course_id', $request->course_id)
            ->where('chapter_id', $request->chapter_id)
            ->where('is_quiz', 1)
            ->where('quiz_id', $request->quiz_id)->first()->quiz_id;

        $questionId = OnlineExamQuestionAssign::where('online_exam_id', $quizId)->where('question_bank_id', $request->question_id)->first()->question_bank_id;

        $online_question = QuestionBank::find($questionId);
        $online_question->type = $request->question_type;
        $online_question->q_group_id = $request->group;
        $online_question->category_id = (int) $request->category;
        $online_question->sub_category_id = (int) $request->sub_category;
        $online_question->marks = (int) $request->marks;
        $online_question->shuffle = (int) $request->question_type == 'M' ? $request->shuffle : 0;
        $online_question->question = $request->question;
        if (isModuleActive('AdvanceQuiz')) {
            $online_question->level = (int) $request->level;
            $online_question->pre_condition = (int) $request->get('pre_condition', 0);
        }
        if ($request->file('image')) {
            $online_question->image = $this->saveImage($request->image);
        }
        $online_question->save();

        if ($request->question_type == 'M') {
            $i = 0;
            if (isset($request->option)) {
                QuestionBankMuOption::where('question_bank_id', $online_question->id)->delete();
                foreach ($request->option as $option) {
                    $i++;
                    $option_check = 'option_check_' . $i;
                    $online_question_option = new QuestionBankMuOption();
                    $online_question_option->question_bank_id = (int) $online_question->id;
                    $online_question_option->title = $option;
                    if (isset($request->$option_check)) {
                        $online_question_option->status = 1;
                    } else {
                        $online_question_option->status = 0;
                    }
                    $online_question_option->save();
                }
            }
        } elseif ($request->question_type == 'X') {
            $online_question->number_of_qus = (int) $request->number_of_qus;
            $online_question->number_of_ans = (int) $request->number_of_ans;
            $online_question->data = $request->data;
            $online_question->connection = $request->connection;
            $online_question->save();
            QuestionBankMuOption::where('question_bank_id', $online_question->id)->delete();
            MatchingTypeQuestionAssign::where('question_id', $online_question->id)->delete();
            $qus = [];
            $ans = [];
            foreach ((array) $request->qus as $key => $option) {
                $online_question_option = new QuestionBankMuOption();
                $online_question_option->question_bank_id = $online_question->id;
                $online_question_option->title = $option;
                $online_question_option->status = 0;
                $online_question_option->type = 1;
                $online_question_option->save();
                $qus[] = $online_question_option->id;
            }

            foreach ((array) $request->ans as $key => $option) {
                $online_question_option = new QuestionBankMuOption();
                $online_question_option->question_bank_id = $online_question->id;
                $online_question_option->title = $option;
                $online_question_option->status = 0;
                $online_question_option->type = 0;
                $online_question_option->save();
                $ans[] = $online_question_option->id;
            }

            $connection = $request->connection;
            $connection = explode(',', $connection);
            foreach ($connection as $con) {
                $con = explode('|', $con);
                if (empty($con)) {
                    continue;
                }
                if (isset($con[0]) && isset($con[1])) {
                    $qusKey = explode('-', $con[0])[0];
                    $ansKey = explode('-', $con[1])[0];
                    $data = MatchingTypeQuestionAssign::create([
                        'question_id' => $online_question->id,
                        'option_id' => (int) $qus[$qusKey],
                        'answer_id' => (int) $ans[$ansKey],
                    ]);
                }
            }
        }
        return $data ?? [];
    }

    public function storeQuestionGroup(object $request): bool
    {
        if (isModuleActive('AdvanceQuiz')) {
            $group = new QuestionGroup();
            $parent = QuestionGroup::where('id', $request->parent)->first();
            $parent_id = 0;
            if ($parent && !empty($request->parent)) {
                $parent_id = $parent->id;
            }
            $group->title = $request->title;
            $group->code = $request->code;
            $group->parent_id = $parent_id;
            $group->level = (int)$parent_id ?? $parent->level + 1;
            $group->user_id = auth()->id();
            $ref = QuestionGroup::where('id', (int)$request->get('orderId', 0))->first();
            if ($ref) {
                if ($request->position == "after") {
                    $group->order = $ref->order;
                } elseif ($request->position == "before") {
                    $group->order = $ref->order - 1;
                }
            }
            return $group->save();
        } else {
            $group = new QuestionGroup();
            $group->title = $request->title;
            $group->user_id = auth()->id();
            $group->save();
            return true;
        }
    }

    public function updateQuestionGroup(object $request): bool
    {
        $group = QuestionGroup::find($request->id);
        if (isModuleActive('AdvanceQuiz')) {
            $parent = QuestionGroup::find($request->parent);
            $parent_id = 0;
            if ($parent && !empty($request->parent)) {
                $parent_id = $parent->id;
            }
            $group->title = $request->title;
            $group->code = $request->code;
            $group->parent_id = $parent_id;
            $group->level = (int)$parent_id ?? $parent->level + 1;
            $group->user_id = auth()->id();
            $ref = QuestionGroup::where('id', (int)$request->get('orderId', 0))->first();
            if ($ref) {
                if ($request->position == "after") {
                    $group->order = $ref->order;
                } elseif ($request->position == "before") {
                    $group->order = $ref->order - 1;
                }
            }
            return $group->save();
        } else {
            $group->title = $request->title;
            $group->save();
            return true;
        }
    }

    public function orderQuestionGroup(object $request): bool
    {
        if (isModuleActive('AdvanceQuiz') && count($request->group_ids) > 0) {
            $ids = $request->group_ids;
            foreach ($ids as $key => $id) {
                $lesson = QuestionGroup::find($id);
                if ($lesson) {
                    $lesson->order = $key + 1;
                    $lesson->save();
                }
            }
            return true;
        } else {
            return false;
        }
    }

    public function destroyQuestionGroup(object $request): bool
    {
        $id = $request->group_id;
        if (isModuleActive('AdvanceQuiz')) {
            $group = QuestionGroup::findOrFail($id);
            $childs = $group->getAllChildIds($group);
            $group->delete();
            foreach ($childs as $child) {
                $b = QuestionGroup::where('id', $child)->first();
                $b->delete();
            }
            return true;
        } else {
            $group = QuestionGroup::destroy($id);
            return true;
        }
    }

    public function storeQuestionLevel(object $request): bool
    {
        if (isModuleActive('AdvanceQuiz')) {
            $level = new QuestionLevel();
            $level->id = QuestionLevel::max('id') + 1;
            foreach ($request->title as $key => $title) {
                $level->setTranslation('title', $key, $title);
            }
            $level->save();
            return true;
        } else {
            return false;
        }
    }

    public function updateQuestionLevel(object $request): bool
    {
        if (isModuleActive('AdvanceQuiz')) {
            $id = $request->level_id;
            $edit = QuestionLevel::find($id);
            foreach ($request->title as $key => $title) {
                $edit->setTranslation('title', $key, $title);
            }
            $edit->save();

            return true;
        } else {
            return false;
        }
    }

    public function updateQuestionLevelStatus(object $request): bool
    {
        if (isModuleActive('AdvanceQuiz')) {
            QuestionLevel::find($request->level_id)->update([
                'status' => (bool) $request->status
            ]);
            return true;
        } else {
            return false;
        }
    }

    public function update(object $request): bool
    {
        $request->merge([
            'show_ans_with_explanation' => (int)$request->same_page_show_questions_and_explanation,
            'show_ans_sheet' => (int)$request->see_answer,
            'losing_focus_acceptance_number_check' => (int)$request->losing_focus_acceptance,
        ]);

        try {
            DB::transaction(function () use ($request) {
                $id = $request->quiz_id;
                $sub = $request->sub_category;
                if (empty($sub)) {
                    $sub = null;
                }
                $group = $request->group_id;
                if (empty($group)) {
                    $group = null;
                }
                $online_exam = OnlineQuiz::find($id);
                foreach ($request->get('title', []) as $key => $title) {
                    $online_exam->setTranslation('title', $key, $title);
                }
                foreach ($request->get('instruction', []) as $key => $instruction) {
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

                    $online_exam->show_correct_ans_in_ans_sheet = $request->get('show_correct_ans_in_answer_sheet', 0);
                    $online_exam->show_only_wrong_ans_in_ans_sheet = $request->get('show_only_wrong_ans_in_answer_sheet', 0)==1 ? 1 : 0;
                    $online_exam->show_total_correct_answer = $request->get('show_total_correct_answer', 0);
                }
                $online_exam->save();
            });
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function deleteQuestionLevel(object $request): bool|object
    {
        if (isModuleActive('AdvanceQuiz')) {
            $level = QuestionLevel::withCount('questions')->find($request->level_id);

            $hasQuestion = $level->questions_count;
            if ($hasQuestion > 0) {
                return response()->json([
                    'message' => trans('quiz.This level has been used in') . ' ' . $hasQuestion . ' ' . trans('quiz.questions') . ' ' . trans('quiz.and cannot be deleted')
                ]);
            } else {
                $level->delete();
                return true;
            }
        } else {
            return false;
        }
    }

    public function quizList(object $request): object
    {
        $quizes = OnlineQuiz::where('active_status', 1)
            ->when($search = $request->search, function ($quizes) use ($search) {
                $quizes->whereLike('title', $search);
            })->paginate($request->get('per_page', 10));

        return QuizListResource::collection($quizes);
    }

    public function updateQuizStatus(object $request): bool
    {
        OnlineQuiz::where('active_status', 1)
            ->find($request->quiz_id)
            ->update([
                'status' => (bool) $request->status
            ]);

        return true;
    }

    public function deleteQuiz(object $request): bool
    {
        $lessons = Lesson::where('quiz_id', $request->quiz_id)->get();
        foreach ($lessons as $lesson) {
            $lesson->delete();
        }
        $questions = OnlineExamQuestionAssign::where('online_exam_id', $request->quiz_id)->get();
        foreach ($questions as $question) {
            $question->delete();
        }
        OnlineQuiz::destroy($request->quiz_id);

        return true;
    }

    public function deleteQuestion(object $request): bool
    {
        $quizAssign = QuestionBank::find($request->question_id)->quizAssign;
        if ($quizAssign->count() < 1) {
            $id = $request->question_id;
            $online_question = QuestionBank::find($id);
            if ($online_question->type == "M") {
                QuestionBankMuOption::where('question_bank_id', $online_question->id)->delete();
            }
            $online_question->delete();
            return true;
        } else {
            return false;
        }
    }

    public function questionBankDetail(object $request): object
    {
        $id = $request->question_id;
        $bank = QuestionBank::find($id);
        return new QuestionBankDetailResource($bank);
    }
}
