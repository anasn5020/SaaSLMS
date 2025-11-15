<?php

namespace App\Repositories\Eloquents;

use Carbon\Carbon;
use App\Traits\UploadMedia;
use Illuminate\Http\Response;
use App\Traits\SendNotification;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\CourseExercise;
use Modules\Setting\Repositories\MediaManagerRepository;
use App\Repositories\Interfaces\CourseExerciseRepositoryInterface;
use Modules\CourseSetting\Http\Controllers\CourseSettingController;

class CourseExerciseRepository implements CourseExerciseRepositoryInterface
{
    use SendNotification, UploadMedia;
    private $mediaManagerRepository;
    public function __construct(MediaManagerRepository $mediaManagerRepository)
    {
        $this->mediaManagerRepository = $mediaManagerRepository;
    }
    public function store(object $request): bool|object
    {
        session()->flash('type', 'files');

        $course_file = new CourseExercise();
        $course_file->course_id = $request->id;
        $course_file->file = '';

        if (saasPlanCheck('upload_limit', $course_file->file)) {
            return response()->json(['message' => trans('api.You have reached upload limit')], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $course_file->lock = (int)$request->lock;
        $course_file->fileName = $request->fileName;
        $course_file->status = (int)$request->status;
        $course_file->save();

        if ($request->file) {
            $image = $this->mediaManagerRepository->store($request->file);
            $course_file->file = $this->generateLink($image->id, $course_file->id, get_class($course_file), 'image');
            $course_file->save();
        }

        $course = Course::find($request->id);
        if (isset($course->enrollUsers) && !empty($course->enrollUsers)) {
            foreach ($course->enrollUsers as $user) {
                $this->sendNotification('Course_ExerciseFile_Added', $user, [
                    'time' => Carbon::now()->format('d-M-Y ,g:i A'),
                    'course' => $course->title,
                    'filename' => $course_file->fileName,
                ]);
            }
        }
        $this->sendNotification('Course_ExerciseFile_Added', $course->user, [
            'time' => Carbon::now()->format('d-M-Y ,g:i A'),
            'course' => $course->title,
            'filename' => $course_file->fileName,
        ]);
        (new CourseSettingController())->updateTotalCountForCourse($course);

        return true;
    }
    public function update(object $request): bool|object
    {
        session()->flash('type', 'files');

        $course_file = CourseExercise::where('course_id', $request->course_id)->find($request->id);
        $this->removeLink($course_file->id, get_class($course_file));
        $course_file->file = null;
        $course_file->save();

        $filesize = 0;
        if ($request->file) {
            $image = $this->mediaManagerRepository->store($request->file);
            $course_file->file = $this->generateLink($image->id, $course_file->id, get_class($course_file), 'image');

            $filesize = file_exists(base_path($course_file->file)) ? filesize($course_file->file) ?? 0 : 0;
            // $filesize = round($filesize / 1024 / 1024, 1); //MB
            $filesize = round($filesize / 1024, 2); //KB
            if (saasPlanCheck('upload_limit', $filesize)) {
                return response()->json(['message' => trans('api.You have reached upload limit')], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            if (isModuleActive('LmsSaas')) {
                saasPlanManagement('upload_limit', 'create', $filesize);
                if ($course_file->old_file_size != null) {
                    saasPlanManagement('upload_limit', 'delete', $course_file->old_file_size);
                }
            }
        }

        $course_file->old_file_size = $filesize;
        $course_file->file_size = $filesize;

        $course_file->lock = (int)$request->lock;
        $course_file->fileName = $request->fileName;
        $course_file->status = (int)$request->status;
        $course_file->save();
        $course = Course::find($course_file->course_id);
        if ($course) {
            if (isset($course->enrollUsers) && !empty($course->enrollUsers)) {

                foreach ($course->enrollUsers as $user) {
                    $this->sendNotification('Course_ExerciseFile_Added', $user, [
                        'time' => Carbon::now()->format('d-M-Y ,g:i A'),
                        'course' => $course->title,
                        'filename' => $course_file->fileName,
                    ]);
                }
            }
        }
        (new CourseSettingController())->updateTotalCountForCourse($course);

        return true;
    }
    public function delete(object $request): object
    {
        session()->flash('type', 'files');
        $course_file = CourseExercise::where('course_id', $request->course_id)->find($request->file_id);
        if (file_exists($course_file->file)) {
            unlink($course_file->file);
        }
        $course_file->delete();

        $response = [
            'success' => true,
            'message' => trans('api.File deleted successfully'),
        ];

        return response()->json($response);
    }
}
