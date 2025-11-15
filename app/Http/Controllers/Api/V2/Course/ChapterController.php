<?php

namespace App\Http\Controllers\Api\V2\Course;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ChapterRepositoryInterface;
use Illuminate\Validation\Rule;

class ChapterController extends Controller
{
    protected $chapterRepository;

    public function __construct(ChapterRepositoryInterface $chapterRepository)
    {
        $this->chapterRepository = $chapterRepository;
    }
    public function chapters(Request $request): object
    {
        $rules = [
            'course_id' => ['required', Rule::exists('courses', 'id')
                ->when($user = auth()->user(), function ($course) use ($user) {
                    if ($user->role_id == 2) {
                        $course->where('user_id', $user->id);
                    } elseif ($user->role_id == 1) {
                        $course;
                    }
                })],
        ];
        $request->validate($rules, validationMessage($rules));

        $response = [
            'success'   => true,
            'data'      => $this->chapterRepository->chapters($request),
            'message'   => trans('api.Operation successful'),
        ];
        return response()->json($response);
    }

    public function update(Request $request): object
    {
        $rules = [
            'chapter_name'  => 'required|string',
            'course_id' => ['required', Rule::exists('courses', 'id')
                ->when($user = auth()->user(), function ($course) use ($user) {
                    if ($user->role_id == 2) {
                        $course->where('user_id', $user->id);
                    }
                })],
            'chapter_id' => ['required', Rule::exists('chapters', 'id')->where('course_id', $request->course_id)],
        ];
        $request->validate($rules, validationMessage($rules));

        $update = $this->chapterRepository->update($request);

        if ($update) {
            $response = [
                'success'   => true,
                'message'   => trans('api.Chapter name updated successfully'),
            ];
        } else {
            $response = [
                'success'   => false,
                'message'   => trans('api.Chapter cannot updated'),
            ];
            $stutas = 422;
        }

        return response()->json($response, $stutas ?? 200);
    }

    public function create(Request $request): object
    {
        $rules = [
            'chapter_name'  => 'required|string',
            'course_id' => ['required', Rule::exists('courses', 'id')
                ->when($user = auth()->user(), function ($course) use ($user) {
                    if ($user->role_id == 2) {
                        $course->where('user_id', $user->id);
                    } elseif ($user->role_id == 1) {
                        $course;
                    }
                })],
        ];
        $request->validate($rules, validationMessage($rules));

        $this->chapterRepository->create($request);

        return response()->json([
            'success'   => true,
            'message'   => trans('api.Chapter created successfully'),
        ]);
    }

    public function delete(Request $request): object
    {
        $rules = [
            'course_id' => ['required', Rule::exists('courses', 'id')
                ->when($user = auth()->user(), function ($course) use ($user) {
                    if ($user->role_id == 2) {
                        $course->where('user_id', $user->id);
                    } elseif ($user->role_id == 1) {
                        $course;
                    }
                })],
            'chapter_id' => ['required', Rule::exists('chapters', 'id')->where('course_id', $request->course_id)],
        ];
        $request->validate($rules, validationMessage($rules));

        $this->chapterRepository->delete($request);

        return response()->json([
            'success'   => true,
            'message'   => trans('api.Chapter deleted successfully')
        ]);
    }

    public function contents(Request $request): object
    {
        $rules = [
            'course_id' => 'required|exists:courses,id',
            'chapter_id' => ['required', Rule::exists('chapters', 'id')->where('course_id', $request->course_id)],
        ];
        $request->validate($rules, validationMessage($rules));

        return response()->json([
            'success'   => true,
            'data'      => $this->chapterRepository->contents($request),
            'message'   => trans('api.Get chapter contents successfully'),
        ]);
    }

    public function rearrangeContents(Request $request): object
    {
        $rules = [
            'course_id' => 'required|exists:courses,id',
            'chapter_id' => ['required', Rule::exists('chapters', 'id')->where('course_id', $request->course_id)],
            'content_id' => 'required|array',
        ];
        $request->validate($rules, validationMessage($rules));

        $this->chapterRepository->rearrangeContents($request);

        return response()->json([
            'success'   => true,
            'message'   => trans('api.Chapter content order changed successfully'),
        ]);
    }
}
