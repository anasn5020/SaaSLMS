<?php

namespace App\Http\Controllers\Api\V2\Course;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\QuizRepositoryInterface;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class QuizController extends Controller
{
    private $quizRepository;
    public function __construct(QuizRepositoryInterface $quizRepository)
    {
        $this->quizRepository = $quizRepository;
    }
    public function storeCourseQuiz(Request $request): object
    {
        $rules = [
            'chapter_id' => 'required',
        ];
        if ($request->type == 'long_form') {
            $rules = [
                'title.*' => 'required',
                'category_id' => 'required',
                'min_percentange' => 'required',
                'instruction.*' => 'required'
            ];
            $request->merge([
                'category' => $request->category_id,
                'percentage' => $request->min_percentange,
                'chapterId' => $request->chapter_id,
            ]);
        } else {
            $rules = [
                'quiz_id' => 'required',
            ];
            $request->merge([
                'quiz' => $request->quiz_id,
            ]);
        }
        $request->merge([
            'chapterId' => $request->chapter_id,
            'lock' => $request->privacy,
        ]);
        $request->validate($rules, validationMessage($rules));
        $this->quizRepository->storeCourseQuiz($request);
        return response()->json([
            'success'   => true,
            'message'   => trans('api.Quiz created successfully')
        ]);
    }

    public function quizDetail(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => $this->quizRepository->quizDetail($request),
            'message' => trans('api.Getting quiz details successfully'),
        ]);
    }

    public function courseQuizUpdate(Request $request)
    {
        $rules = [
            'quiz_id' => 'required|exists:online_quizzes,id',
            'title' => 'required',
            'category_id' => 'required',
            'percentage' => 'required',
            'instruction' => 'required'
        ];
        $request->validate($rules, validationMessage($rules));

        $this->quizRepository->courseQuizUpdate($request);

        return response()->json([
            'success' => true,
            'message' => trans('api.Quiz updated successfully'),
        ]);
    }

    public function storeQuestion(Request $request): object
    {
        $rules = [
            'quiz_id'                   => 'nullable|exists:online_quizzes,id',
            'group_id'                  => "required|exists:question_groups,id",
            'question'                  => "required|string",
            'question_type'             => "required|in:M,S,L,X",
            'mark'                      => "required|numeric",
            "question_level_id"         => "nullable|exists:question_levels,id",
            "pre_condition_question"    => "nullable|in:0,1",
            'number_of_option'          => "nullable|required_if:question_type,M|numeric",
            'number_of_qus'             => "nullable|required_if:question_type,X|numeric",
            'number_of_ans'             => "nullable|required_if:question_type,X|numeric",
            "shuffle_answer"            => "nullable|required_if:question_type,M|in:0,1",
        ];
        $request->validate($rules, validationMessage($rules));

        $request->merge([
            "quize_id"      => $request->quiz_id,
            'group'         => $request->group_id,
            'level'         => $request->question_level_id,
            'pre_condition' => $request->pre_condition_question,
            'marks'         => $request->mark,
            'shuffle'       => $request->shuffle_answer,
        ]);

        $this->quizRepository->storeQuestion($request);

        return response()->json([
            'success'   => true,
            'message'   => trans('api.Question added successfully')
        ]);
    }

    public function groupList(Request $request): object
    {
        return response()->json([
            'success'   => true,
            'data'      => $this->quizRepository->groupList($request),
            'message'   => trans('api.Get question group list successfully'),
        ]);
    }

    public function questionLevels(Request $request): object
    {
        return response()->json([
            'success'   => true,
            'data'      => $this->quizRepository->questionLevels($request),
            'message'   => trans('api.Get quiz level list successfully')
        ]);
    }

    public function questionTypes(): object
    {
        return $this->quizRepository->questionTypes();
    }

    public function deleteLesson(Request $request): object
    {
        $rules = [
            'course_id'     => ['required', Rule::exists('lessons', 'course_id')->where('is_quiz', 1)->where('chapter_id', $request->chapter_id)->where('id', $request->content_id)],
            'chapter_id'    => ['required', Rule::exists('lessons', 'chapter_id')->where('is_quiz', 1)->where('course_id', $request->course_id)->where('id', $request->content_id)],
            'content_id'     => ['required', Rule::exists('lessons', 'id')->where('is_quiz', 1)->where('course_id', $request->course_id)->where('chapter_id', $request->chapter_id)],
        ];
        $request->validate($rules, validationMessage($rules));

        $this->quizRepository->deleteLesson($request);

        return response()->json([
            'success'   => true,
            'message'   => trans('api.Quiz deleted successfully'),
        ]);
    }
    public function questionList(Request $request): object
    {
        $rules = [
            'course_id' => ['required', Rule::exists('lessons', 'course_id')->where('chapter_id', $request->chapter_id)->where('is_quiz', 1)->where('quiz_id', $request->quiz_id)],
            'chapter_id' => ['required', Rule::exists('lessons', 'chapter_id')->where('course_id', $request->course_id)->where('is_quiz', 1)->where('quiz_id', $request->quiz_id)],
            'quiz_id' => ['required', Rule::exists('lessons', 'quiz_id')->where('course_id', $request->course_id)->where('chapter_id', $request->chapter_id)->where('is_quiz', 1)],
        ];
        $request->validate($rules, validationMessage($rules));

        return response()->json([
            'success'   => true,
            'data'      => $this->quizRepository->questionList($request),
            'message'   => trans('api.Quiz question list'),
        ]);
    }
    public function questionDetail(Request $request): object
    {
        $rules = [
            'course_id' => 'required|exists:courses,id',
            'chapter_id' => 'required|exists:chapters,id',
            'quiz_id' => 'required|exists:online_quizzes,id',
            'question_id' => ['required', Rule::exists('online_exam_question_assigns', 'question_bank_id')->where('online_exam_id', $request->quiz_id)],
        ];
        $request->validate($rules, validationMessage($rules));

        return response()->json([
            'success'   => true,
            'data'      => $this->quizRepository->questionDetail($request),
            'message'   => trans('api.Quiz question detail'),
        ]);
    }
    public function updateQuestion(Request $request): object
    {
        $rules = [
            'course_id'     => 'required|exists:courses,id',
            'chapter_id'    => 'required|exists:chapters,id',
            'quiz_id'       => 'required|exists:online_quizzes,id',
            'question_id'   => ['required', Rule::exists('online_exam_question_assigns', 'question_bank_id')->where('online_exam_id', $request->quiz_id)],

            'group'         => "nullable",
            'question'      => "required",
            'question_type' => "required",
            'marks'         => "required",
        ];
        if ($request->question_type == "M") {
            $rules['number_of_option'] = "required";
        } elseif ($request->question_type == "S") {
            $rules['number_of_option'] = "nullable";
        } elseif ($request->question_type == "X") {
            $rules['number_of_qus'] = "required";
            $rules['number_of_ans'] = "required";
        }
        $request->validate($rules, validationMessage($rules));

        return response()->json([
            'success'   => true,
            'data'      => $this->quizRepository->updateQuestion($request),
            'message'   => trans('api.Question updated successfully'),
        ]);
    }
    public function storeQuestionGroup(Request $request): object
    {
        if (demoCheck()) {
            return response()->json([
                'message' => trans('api.For the demo version, you cannot change this')
            ],403);
        }
        if (isModuleActive('AdvanceQuiz')) {
            $rules = [
                'title' => ['required', Rule::unique('question_groups', 'title')->when(isModuleActive('LmsSaas'), function ($q) {
                    return $q->where('lms_id', app('institute')->id);
                })],
                'code' => 'required|unique:question_groups,code',
                'parent_id' => 'nullable'
            ];
            $request->merge([
                'parent' => $request->parent_id
            ]);
        } else {
            $rules = [
                'title' => 'required',
            ];
        }
        $request->validate($rules, validationMessage($rules));

        $this->quizRepository->storeQuestionGroup($request);

        return response()->json([
            'success' => true,
            'message' => trans('api.Question group added successfully'),
        ]);
    }
    public function updateQuestionGroup(Request $request): object
    {
        if (demoCheck()) {
            return response()->json([
                'message' => trans('api.For the demo version, you cannot change this')
            ],403);
        }
        $rules = [
            'title' => ['required'],
            'group_id' => 'nullable|exists:question_groups,id',
        ];
        $request->validate($rules, validationMessage($rules));
        $request->merge([
            'id' => $request->group_id,
            'parent' => $request->parent_id
        ]);

        $this->quizRepository->updateQuestionGroup($request);

        return response()->json([
            'success' => true,
            'message' => trans('api.Question group updated successfully'),
        ]);
    }
    public function orderQuestionGroup(Request $request): object
    {
        $data = $this->quizRepository->orderQuestionGroup($request);
        if ($data) {
            $response = [
                'success' => true,
                'message' => trans('api.Question group order changed successfully'),
            ];
        } else {
            $response = [
                'success' => false,
                'message' => trans('api.You cannot change this'),
            ];
            $status = Response::HTTP_UNPROCESSABLE_ENTITY;
        }
        return response()->json($response, $status ?? 200);
    }
    public function destroyQuestionGroup(Request $request): object
    {
        if (demoCheck()) {
            return response()->json([
                'message' => trans('api.For the demo version, you cannot change this')
            ],403);
        }

        $rules = [
            'group_id' => 'required|exists:question_groups,id'
        ];
        $request->validate($rules, validationMessage($rules));

        $this->quizRepository->destroyQuestionGroup($request);

        return response()->json([
            'success' => true,
            'message' => trans('api.Question group deleted successfully'),
        ]);
    }
    public function storeQuestionLevel(Request $request): object
    {
        if (demoCheck()) {
            return response()->json([
                'message' => trans('api.For the demo version, you cannot change this')
            ],403);
        }

        $rules = [
            'title.*' => 'required|max:255',
        ];
        $request->validate($rules, validationMessage($rules));

        $store = $this->quizRepository->storeQuestionLevel($request);

        if ($store) {
            $response = [
                'success' => true,
                'message' => trans('api.Quiz level added successfully'),
            ];
        } else {
            $response = [
                'success' => false,
                'message' => trans('api.You cannot change this'),
            ];
            $status = 422;
        }

        return response()->json($response, $status ?? 200);
    }
    public function updateQuestionLevel(Request $request): object
    {
        if (demoCheck()) {
            return response()->json([
                'message' => trans('api.For the demo version, you cannot change this')
            ],403);
        }

        $rules = [
            'level_id' => 'required|exists:question_levels,id',
            'title.*' => 'required|max:255',
        ];
        $request->validate($rules, validationMessage($rules));

        $update = $this->quizRepository->updateQuestionLevel($request);

        if ($update) {
            $response = [
                'success' => true,
                'message' => trans('api.Quiz level updated successfully'),
            ];
        } else {
            $response = [
                'success' => false,
                'message' => trans('api.You cannot change this'),
            ];
            $status = 422;
        }

        return response()->json($response, $status ?? 200);
    }
    public function updateQuestionLevelStatus(Request $request): object
    {
        if (demoCheck()) {
            return response()->json([
                'message' => trans('api.For the demo version, you cannot change this')
            ],403);
        }

        $rules = [
            'level_id' => 'required|exists:question_levels,id',
            'status' => 'nullable|boolean',
        ];
        $request->validate($rules, validationMessage($rules));

        $update = $this->quizRepository->updateQuestionLevelStatus($request);

        if ($update) {
            $response = [
                'success' => true,
                'message' => trans('api.Quiz level status changed successfully'),
            ];
        } else {
            $response = [
                'success' => false,
                'message' => trans('api.You cannot change this'),
            ];
            $status = 422;
        }

        return response()->json($response, $status ?? 200);
    }
    public function deleteQuestionLevel(Request $request): object
    {
        if (demoCheck()) {
            return response()->json([
                'message' => trans('api.For the demo version, you cannot change this')
            ],403);
        }

        $rules = [
            'level_id' => 'required|exists:question_levels,id'
        ];
        $request->validate($rules, validationMessage($rules));

        $delete = $this->quizRepository->deleteQuestionLevel($request);

        if($delete){
            $response = [
                'success' => true,
                'message' => trans('api.Quiz level deleted successfully'),
            ];
        } else {
            $response = [
                'success' => false,
                'message' => trans('api.You cannot change this'),
            ];
            $status = 422;
        }

        return response()->json($response, $status ?? 200);
    }

    public function updateQuizQuestion(Request $request)
    {
        if (demoCheck()) {
            return response()->json([
                'message' => trans('api.For the demo version, you cannot change this')
            ],403);
        }

        $rules = [
            'group_id' => "required",
            'question' => "required",
            'question_type' => "required",
            'mark' => "required",
            'question_id' => "required|exists:question_banks,id",
        ];
        if ($request->question_type == "M") {
            $rules['number_of_option'] = "required";
        } elseif ($request->question_type == "S") {
            $rules['number_of_option'] = "nullable";
        } elseif ($request->question_type == "X") {
            $rules['number_of_qus'] = "required";
            $rules['number_of_ans'] = "required";
        }
        $request->validate($rules, validationMessage($rules));

        $request->merge([
            "quize_id"      => $request->quiz_id,
            'group'         => $request->group_id,
            'level'         => $request->question_level_id,
            'pre_condition' => $request->pre_condition_question,
            'marks'         => $request->mark,
            'shuffle'       => $request->shuffle_answer,
        ]);

        $this->quizRepository->updateQuizQuestion($request);

        return response()->json([
            'success' => true,
            'message' => trans('api.Question updated successfully'),
        ]);
    }
}
