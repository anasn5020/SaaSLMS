<?php

namespace App\Http\Controllers\Api\V2\Course;

use App\Traits\BunnySettings;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\LessonRepositoryInterface;

class LessonController extends Controller
{
    use BunnySettings;
    private $lessonRepository;

    public function __construct(LessonRepositoryInterface $lessonRepository)
    {
        $this->lessonRepository = $lessonRepository;
    }

    public function addLesson(Request $request): object
    {
        $rules = $this->rules($request);
        $request->validate($rules, validationMessage($rules));

        $store = $this->lessonRepository->addLesson($request);

        return response()->json([
            'success'   => true,
            'message'   => trans('api.Lesson created successfully'),
        ]);
    }

    public function lessons(Request $request): object
    {
        $rules = [
            'course_id'     => 'required|exists:lessons,course_id',
            'chapter_id'    => 'nullable|exists:lessons,chapter_id',
            'quiz_id'       => 'nullable|exists:lessons,quiz_id'
        ];
        $request->validate($rules, validationMessage($rules));

        return response()->json([
            'success'   => true,
            'data'      => $this->lessonRepository->lessons($request),
            'message'   => trans('api.Operation successful'),
        ]);
    }

    public function lessonDetail(Request $request): object
    {
        $rules = [
            'course_id' => ['required', Rule::exists('lessons', 'course_id')->where('chapter_id', $request->chapter_id)->where('id', $request->lesson_id)->where('is_quiz', 0)->where('is_assignment', 0)],
            'chapter_id' => ['required', Rule::exists('lessons', 'chapter_id')->where('course_id', $request->course_id)->where('id', $request->lesson_id)->where('is_quiz', 0)->where('is_assignment', 0)],
            'lesson_id' => ['required', Rule::exists('lessons', 'id')->where('course_id', $request->course_id)->where('chapter_id', $request->chapter_id)->where('is_quiz', 0)->where('is_assignment', 0)],
        ];
        $request->validate($rules, validationMessage($rules));

        return response()->json([
            'success'   => true,
            'data'      => $this->lessonRepository->lessonDetail($request),
            'message'   => trans('api.Get lesson details successfully'),
        ]);
    }

    public function hosts(): object
    {
        return response()->json([
            'success' => true,
            'data' => $this->lessonRepository->hosts(),
            'message' => trans('api.Operation successful')
        ]);
    }

    public function privacies(): object
    {
        return $this->lessonRepository->privacies();
    }

    public function updateLesson(Request $request): object
    {
        $rules = $this->rules($request);
        $request->validate($rules, validationMessage($rules));

        $this->lessonRepository->updateLesson($request);

        return response()->json([
            'success'   => true,
            'message'   => trans('api.Lesson updated successfully'),
        ]);
    }

    public function deleteLesson(Request $request): object
    {
        $rules = [
            'course_id'     => 'required|integer|exists:lessons,course_id',
            'chapter_id'    => 'required|integer|exists:lessons,chapter_id',
            'lesson_id'     => 'required|integer|exists:lessons,id',
        ];
        $request->validate($rules, validationMessage($rules));

        $this->lessonRepository->deleteLesson($request);

        return response()->json([
            'success'   => true,
            'message'   => trans('api.Lesson deleted successfully'),
        ]);
    }

    public function vimeoVideos(Request $request): object
    {
        return response()->json([
            'success' => true,
            'data' => $this->lessonRepository->vimeoVideos($request),
            'message' => trans('api.Getting vimeo list successfully')
        ]);
    }

    public function getAllVdocipherData(Request $request): object
    {
        return response()->json([
            'success' => true,
            'data' => $this->lessonRepository->getAllVdocipherData($request),
            'message' => trans('api.Getting VDOCipher list successfully')
        ]);
    }

    public function getBunnyVideos(Request $request): object
    {
        return response()->json([
            'success' => true,
            'data' => $this->lessonRepository->getBunnyVideos($request),
            'message' => trans('api.Getting Bunny storage video list successfully')
        ]);
    }

    private function rules($request)
    {
        $rules = [];
        if ($request->input_type == 1) {
            $rules['chapter_name'] = 'required';
        } else if ($request->input_type == 2) {
            $rules['quiz'] = 'required';
            $rules['chapterId'] = 'required';
        } else {
            $rules['name'] = 'required';
            $rules['chapter_id'] = 'required';
            $rules['course_id'] = 'required';

            /* if (isModuleActive('Org') && $request->fileType != 2) {
                $rules['file_type'] = 'required';
                $rules['file_path'] = 'required';
            } else {
            } */

            if ($request->get('host') == "Vimeo") {
                $rules['vimeo'] = 'required';
            } elseif ($request->get('host') == "VdoCipher") {
                $rules['vdocipher'] = 'required';
            } elseif ($request->get('host') == "BunnyStorage") {
                $rules['bunny'] = 'required';
            } elseif ($request->get('host') == "Iframe") {
                $rules['iframe_url'] = 'required';
            } elseif ($request->get('host') == "Youtube" || $request->get('host') == "URL") {
                $rules['video_url'] = 'required';
            } elseif ($request->get('host') == "ImagePreview") {
            } elseif ($request->get('host') == "Storage") {
                $rules['video'] = 'required';
            } else {
                $rules['file'] = 'required';
            }
        }
        return $rules;
    }
}
