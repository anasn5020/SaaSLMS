<?php

namespace App\Http\Controllers\Api\V2\Quiz;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Modules\Quiz\Entities\QuizTest;
use App\Http\Controllers\Controller;
use Modules\Quiz\Entities\OnlineQuiz;
use Modules\Quiz\Entities\QuizeSetup;
use Modules\Quiz\Entities\QuestionBank;
use Modules\Quiz\Entities\QuestionGroup;
use Modules\Quiz\Entities\OnlineExamQuestionAssign;
use App\Repositories\Interfaces\QuizRepositoryInterface;

class QuizController extends Controller
{
    private $quizRepository;
    public function __construct(QuizRepositoryInterface $quizRepository)
    {
        $this->quizRepository = $quizRepository;
    }

    public function quizList(Request $request): object
    {
        return response()->json([
            'success' => true,
            'data' => $this->quizRepository->quizList($request),
            'message' => trans('api.Get question list successfully'),
        ]);
    }

    public function store(Request $request): object
    {
        if (demoCheck()) {
            return response()->json([
                'message' => trans('api.For the demo version, you cannot change this')
            ], 403);
        }

        $rules = [
            'form_type' => 'required|in:long_form,short_form',
            'from' => 'nullable|in:course',
            'course_id' => ['required_if:from,course', Rule::exists('chapters', 'course_id')->where('id', $request->chapter_id)],
            'chapter_id' => ['required_if:from,course', Rule::exists('chapters', 'id')->where('course_id', $request->course_id)],
            'title.*' => 'required_if:form_type,long_form|max:255',
            'category_id' => 'required_if:form_type,long_form',
            'min_percentange' => 'required_if:form_type,long_form',
            'instruction.*' => 'required_if:form_type,long_form',
            'quiz_id' => 'required_if:form_type,short_form',
        ];
        $request->validate($rules, validationMessage($rules));

        $request->merge([
            'chapterId' => $request->chapter_id,
            'category' => $request->category_id,
            'percentage' => $request->min_percentange,
            'quiz' => $request->quiz_id,
            'lock' => $request->privacy,
        ]);

        $store = $this->quizRepository->store($request);

        if ($store) {
            $response = [
                'success' => true,
                'message' => trans('api.Quiz created successfully')
            ];
        } else {
            $response = [
                'success' => false,
                'message' => trans('api.Quiz cannot crate')
            ];
            $status = 422;
        }
        return response()->json($response, $status ?? 200);
    }

    public function update(Request $request): object
    {
        if (demoCheck()) {
            return response()->json(['message' => trans('api.For the demo version, you cannot change this')],403);
        }

        $request->merge([
            'percentage' => $request->min_percentange,
            'course' => $request->course_id,
            'quiz' => $request->quiz_id,
            'lock' => $request->privacy,
            'category' => $request->category_id,
        ]);
        $rules = [
            'quiz_id' => 'required|exists:online_quizzes,id',
            'title.*' => 'required|max:255',
            'instruction.*' => 'required',
            'category' => 'required',
            'percentage' => 'required',
        ];
        $this->validate($request, $rules, validationMessage($rules));


        $update = $this->quizRepository->update($request);

        if ($update) {
            $response = [
                'success' => true,
                'message' => trans('api.Quiz updated successfully')
            ];
        } else {
            $response = [
                'success' => false,
                'message' => trans('api.Quiz cannot update')
            ];
            $status = 422;
        }
        return response()->json($response, $status ?? 200);
    }

    public function updateQuizStatus(Request $request): object
    {
        if (demoCheck()) {
            return response()->json([
                'message' => trans('api.For the demo version, you cannot change this')
            ],403);
        }

        $rules = [
            'quiz_id' => ['required', Rule::exists('online_quizzes', 'id')->where('active_status', 1)],
            'status' => 'nullable|boolean',
        ];
        $request->validate($rules, validationMessage($rules));

        $this->quizRepository->updateQuizStatus($request);

        return response()->json([
            'success' => true,
            'message' => trans('api.Quiz status changed successfully'),
        ]);
    }

    public function deleteQuiz(Request $request): object
    {
        if (demoCheck()) {
            return response()->json([
                'message' => trans('api.For the demo version, you cannot change this')
            ],403);
        }

        $rules = [
            'quiz_id' => ['required', Rule::exists('online_quizzes', 'id')->where('active_status', 1)],
        ];
        $request->validate($rules, validationMessage($rules));

        $check = QuizTest::where('quiz_id', $request->quiz_id)->count();
        if ($check > 0) {
            return response()->json([
                'message' => trans('quiz.You cannot delete this quiz because it has been taken by users')
            ]);
        }

        $this->quizRepository->deleteQuiz($request);

        return response()->json([
            'success' => true,
            'message' => trans('api.Quiz deleted successfully'),
        ]);
    }

    public function questions(Request $request): object
    {
        return response()->json([
            'success' => true,
            'data' => $this->quizRepository->questions($request),
            'message' => trans('api.Get question bank list successfully'),
        ]);
    }

    public function deleteQuestion(Request $request): object
    {
        if (demoCheck()) {
            return response()->json([
                'message' => trans('api.For the demo version, you cannot change this')
            ],403);
        }

        $rules = [
            'question_id' => 'required|exists:question_banks,id',
        ];
        $request->validate($rules, validationMessage($rules));

        $quizAssign = QuestionBank::find($request->question_id)->quizAssign;
        if ($quizAssign->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => trans('quiz.You cannot delete this question because it has been used in') . ' ' . $quizAssign->count() . ' ' . trans('quiz.quiz already'),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $delete = $this->quizRepository->deleteQuestion($request);

        if ($delete) {
            $response = [
                'success' => true,
                'message' => trans('api.Question deleted successfully'),
            ];
        }
        return response()->json($response);
    }

    public function questionBankDetail(Request $request): object
    {
        if (demoCheck()) {
            return response()->json([
                'message' => trans('api.For the demo version, you cannot change this')
            ], 403);
        }

        $rules = [
            'question_id' => 'required|exists:question_banks,id',
        ];
        $request->validate($rules, validationMessage($rules));

        return response()->json([
            'success' => true,
            'data' => $this->quizRepository->questionBankDetail($request),
            'message' => trans('api.Getting questions details successfully'),
        ]);
    }
}
