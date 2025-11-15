<?php

namespace App\Http\Controllers\Api\V2\Assignment;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\AssignmentRepositoryInterface;

class AssignmentController extends Controller
{
    private $assignmentRepository;

    public function __construct(AssignmentRepositoryInterface $assignmentRepository)
    {
        $this->assignmentRepository = $assignmentRepository;
    }
    public function store(Request $request): object
    {
        if (isModuleActive('Assignment')) {
            $rules = [
                'title' => 'required|max:255',
                'marks' => 'required|min:0',
                'min_parcentage' => 'required|min:0',
                'description' => 'required',
            ];
            $request->validate($rules, validationMessage($rules));

            $this->assignmentRepository->store($request);

            return response()->json([
                'success'   => true,
                'message'   => trans('api.Assignment created successfully')
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => trans('api.It is a paid service')
            ], 401);
        }
    }

    public function assignmentList(Request $request): object
    {
        if (isModuleActive('Assignment')) {
            $rules = [
                'course_id' => 'required|exists:courses,id',
                'chapter_id' => 'required|exists:chapters,id',
            ];
            $request->validate($rules, validationMessage($rules));

            return response()->json([
                'success'   => true,
                'data'      => $this->assignmentRepository->assignmentList($request),
                'message'   => trans('api.Course assignment list'),
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => trans('api.It is a paid service')
            ], 401);
        }
    }
    public function assignmentDetail(Request $request): object
    {
        if (isModuleActive('Assignment')) {
            $rules = [
                'course_id' => 'required|exists:courses,id',
                'chapter_id' => 'required|exists:chapters,id',
                'assignment_id' => 'required|exists:infix_assignments,id',
            ];
            $request->validate($rules, validationMessage($rules));

            return response()->json([
                'success'   => true,
                'data'      => $this->assignmentRepository->assignmentDetail($request),
                'message'   => trans('api.Get assignment details successfully'),
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => trans('api.It is a paid service')
            ], 401);
        }
    }
    public function assignmentUpdate(Request $request): object
    {
        if (isModuleActive('Assignment')) {
            $rules = [
                'title' => 'required|max:255',
                'marks' => 'required|min:0',
                'min_parcentage' => 'required|min:0',
                'description' => 'required',
                'course_id' => [
                    'required',
                    Rule::exists('lessons', 'course_id')
                        ->where('is_assignment', 1)
                        ->where('chapter_id', $request->chapter_id)
                        ->where('assignment_id', $request->assignment_id)
                ],
                'chapter_id' => [
                    'required',
                    Rule::exists('lessons', 'chapter_id')
                        ->where('is_assignment', 1)
                        ->where('course_id', $request->course_id)
                        ->where('assignment_id', $request->assignment_id)
                ],
                'assignment_id' => [
                    'required',
                    Rule::exists('lessons', 'assignment_id')
                        ->where('is_assignment', 1)
                        ->where('course_id', $request->course_id)
                        ->where('chapter_id', $request->chapter_id)
                ],
            ];
            $request->validate($rules, validationMessage($rules));

            $this->assignmentRepository->assignmentUpdate($request);

            return response()->json([
                'success'   => true,
                'message'   => trans('api.Assignment updated successfully'),
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => trans('api.It is a paid service')
            ], 401);
        }
    }

    public function deleteChapterAssignment(Request $request): object
    {
        if (isModuleActive('Assignment')) {
            $rules = [
                'course_id' => [
                    'required',
                    Rule::exists('lessons', 'course_id')
                        ->where('is_assignment', 1)
                        ->where('chapter_id', $request->chapter_id)
                        ->where('id', $request->content_id)
                ],
                'chapter_id' => [
                    'required',
                    Rule::exists('lessons', 'chapter_id')
                        ->where('is_assignment', 1)
                        ->where('course_id', $request->course_id)
                        ->where('id', $request->content_id)
                ],
                'content_id' => [
                    'required',
                    Rule::exists('lessons', 'id')
                        ->where('is_assignment', 1)
                        ->where('course_id', $request->course_id)
                        ->where('chapter_id', $request->chapter_id)
                ],
            ];
            $request->validate($rules, validationMessage($rules));

            $this->assignmentRepository->deleteChapterAssignment($request);

            return response()->json([
                'success'   => true,
                'message'   => trans('api.Assignment deleted successfully'),
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => trans('api.It is a paid service')
            ], 401);
        }
    }
}
