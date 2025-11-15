<?php

namespace App\Repositories\Eloquents;

use App\Traits\SendNotification;
use Carbon\Carbon;
use App\Traits\UploadMedia;
use Illuminate\Support\Facades\File;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\Lesson;
use Modules\CourseSetting\Entities\Chapter;
use Modules\Assignment\Entities\InfixAssignment;
use Modules\Setting\Repositories\MediaManagerRepository;
use App\Http\Resources\api\v2\Chapter\AssignmentListResource;
use App\Repositories\Interfaces\AssignmentRepositoryInterface;
use Illuminate\Validation\Rule;

class AssignmentRepository implements AssignmentRepositoryInterface
{
    use UploadMedia, SendNotification;

    private $mediaManagerRepository;

    public function __construct(MediaManagerRepository $mediaManagerRepository)
    {
        $this->mediaManagerRepository = $mediaManagerRepository;
    }

    public function assignmentList(object $request): object
    {
        $assignments = Lesson::whereHas('assignmentInfo')
            ->where('is_assignment', 1)
            ->where('course_id', $request->course_id)
            ->where('chapter_id', $request->chapter_id)
            ->get();

        return AssignmentListResource::collection($assignments);
    }

    public function assignmentDetail(object $request): object
    {
        $assignments = Lesson::whereHas('assignmentInfo')
            ->where('is_assignment', 1)
            ->where('course_id', $request->course_id)
            ->where('chapter_id', $request->chapter_id)
            ->where('assignment_id', $request->assignment_id)
            ->first();

        return new AssignmentListResource($assignments);
    }

    public function assignmentUpdate(object $request): bool
    {
        $request->merge([
            'last_date_submission' => Carbon::createFromFormat('m-d-Y', $request->last_date_submission)->format('Y-m-d'),
        ]);
        $lesson = Lesson::where('course_id', $request->course_id)
            ->where('chapter_id', $request->chapter_id)
            ->where('is_assignment', 1)
            ->where('assignment_id', $request->assignment_id)
            ->first();

        $assignment = InfixAssignment::find($lesson->assignment_id);
        $assignment->title = $request->title;
        $assignment->course_id = $request->course_id;
        $assignment->marks = (int)$request->marks;
        $assignment->min_parcentage = (int)$request->min_parcentage;
        $assignment->description = $request->description;
        $assignment->last_date_submission = $request->last_date_submission;
        $assignment->attachment = null;
        $assignment->save();

        $this->removeLink($assignment->id, get_class($assignment));

        if ($request->attachment) {
            $image = $this->mediaManagerRepository->store($request->attachment);
            $assignment->attachment = $this->generateLink($image->id, $assignment->id, get_class($assignment), 'attachment');
            $assignment->save();
        }

        return true;
    }

    public function store(object $request): bool
    {
        $request->merge([
            'last_date_submission' => Carbon::createFromFormat('m-d-Y', $request->last_date_submission)->format('Y-m-d'),
        ]);

        $assignment = new InfixAssignment();
        $assignment->title = $request->title;
        $assignment->course_id = $request->course_id;
        $assignment->marks = (int)$request->marks;
        $assignment->min_parcentage = (int)$request->min_parcentage;
        $assignment->description = $request->description;
        $assignment->assignment_from = 2;
        $assignment->created_by = auth()->user()->id;
        $assignment->last_date_submission = $request->last_date_submission;
        $assignment->save();

        if ($request->attachment) {
            $image = $this->mediaManagerRepository->store($request->attachment);
            $assignment->attachment = $this->generateLink($image->id, $assignment->id, get_class($assignment), 'attachment');
            $assignment->save();
        }

        $course = Course::find($request->course_id);
        $chapter = Chapter::where('course_id', $course->id)->find($request->chapter_id);
        if (isset($course) && isset($chapter)) {
            $lesson = new Lesson();
            $lesson->course_id = (int)$request->course_id;
            $lesson->chapter_id = (int)$request->chapter_id;
            $lesson->assignment_id = (int)$assignment->id;
            $lesson->name = $assignment->title;
            $lesson->is_quiz = 0;
            $lesson->is_assignment = 1;
            $lesson->is_lock = (int)$request->is_lock;
            $lesson->save();

            if (isset($course->enrollUsers) && !empty($course->enrollUsers)) {
                foreach ($course->enrollUsers as $user) {


                    $this->sendNotification('Course_Assignment_Added', $user,[
                        'time' => Carbon::now()->format('d-M-Y, g:i A'),
                        'course' => $course->title,
                        'chapter' => $chapter->name,
                        'assignment' => $assignment->title,
                    ],[
                        trans('common.View'),
                        courseDetailsUrl(@$course->id, @$course->type, @$course->slug),
                    ]);

                }
            }
        }

        return true;
    }

    public function deleteChapterAssignment(object $request): bool
    {
        $lesson = Lesson::where('course_id', $request->course_id)
            ->where('chapter_id', $request->chapter_id)
            ->where('is_assignment', 1)
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

        return true;
    }
}
