<?php

namespace App\Repositories\Eloquents;

use App\Http\Resources\api\v2\Chapter\ChapterContentListResource;
use App\Http\Resources\api\v2\Chapter\ChapterListResource;
use App\LessonComplete;
use App\Repositories\Interfaces\ChapterRepositoryInterface;
use App\Traits\SendNotification;
use Carbon\Carbon;
use Modules\CourseSetting\Entities\Chapter;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\Lesson;
use Modules\CourseSetting\Http\Controllers\CourseSettingController;
use Modules\CourseSetting\Http\Controllers\LessonController;

class ChapterRepository implements ChapterRepositoryInterface
{
    use SendNotification;
    public function chapters(object $request): object
    {
        $chapters = Chapter::where('course_id', $request->course_id)->orderBy('position')->get();
        return ChapterListResource::collection($chapters);
    }
    public function update(object $request): bool
    {
        $userRole = in_array(auth()->user()->role_id, [1, 2]);

        if ($userRole) {
            switch (auth()->user()->role_id) {
                case 1:
                    $course = Course::find($request->course_id);
                    break;
                case 2:
                    $course = Course::where('user_id', auth()->id())->find($request->course_id);
                    break;

                default:
                    $course = Course::where('user_id', auth()->id())->find($request->course_id);
                    break;
            }

            if ($course) {
                Chapter::where('course_id', $course->id)
                    ->find($request->chapter_id)->update([
                        'name' => $request->chapter_name
                    ]);
            }
            (new CourseSettingController)->updateTotalCountForCourse($course);
            return true;
        } else {
            return false;
        }
    }

    private function updateTotalCountForCourse($course): void
    {
        $course->total_chapters = count($course->chapters);
        $course->total_lessons = count($course->lessons);
        $course->total_quiz_lessons = count($course->lessonQuizzes);
        $course->total_comments = count($course->comments);
        $course->total_reviews = count($course->reviews);
        $course->save();
    }

    public function create(object $request): bool
    {
        if (in_array(auth()->user()->role_id, [1, 2])) {
            $course = Course::when(auth()->user()->role_id == 2, function ($q) {
                $q->where('user_id', auth()->id());
            })->find($request->course_id);
        }

        if (!empty($course)) {
            $chapterNo = Chapter::where('course_id', $request->course_id)->count();

            $chapter = Chapter::create([
                'course_id'     => $course->id,
                'name'          => $request->chapter_name,
                'chapter_no'    => ++$chapterNo
            ]);

            if (!empty($course->enrollUsers)) {
                foreach ($course->enrollUsers as $user) {
                    $this->sendNotification('Course_Chapter_Added', $user,[
                        'time'      => Carbon::now()->format('d-M-Y, g:i A'),
                        'course'    => $course->title,
                        'chapter'   => $chapter->name
                    ],[
                        trans('common.View'), //actionText
                        courseDetailsUrl(@$course->id, @$course->type, @$course->slug), //actionUrl
                        'chapter',
                        $course->id
                    ]);
                }
            }

            $courseUser = $course->user;

            $this->sendNotification('Course_Chapter_Added',$courseUser,[
                'time'      => Carbon::now()->format('d-M-Y, g:i A'),
                'course'    => $course->title,
                'chapter'   => $chapter->name
            ],[
                trans('common.View'), //actionText
                courseDetailsUrl(@$course->id, @$course->type, @$course->slug), //actionUrl
                'chapter',
                $course->id
            ]);

            (new CourseSettingController())->updateTotalCountForCourse($course);
            return true;
        } else {
            return false;
        }
    }

    public function delete(object $request): bool
    {
        if (auth()->user()->role_id == 2) {
            $course = Course::where('user_id', auth()->user()->id)->find($request->course_id);
        } else {
            $course = Course::find($request->course_id);
        }

        if ($course) {
            $lessons = Lesson::where('chapter_id', $request->chapter_id)->where('course_id', $request->course_id)->get();

            foreach ($lessons as $lesson) {
                $completeLessons = LessonComplete::where('lesson_id', $lesson->id)->get();

                foreach ($completeLessons as $completeLesson) {
                    $completeLesson->delete();
                }

                $lessonController = new LessonController();
                $lessonController->lessonFileDelete($lesson);
                $lesson->delete();
            }

            $chapter = Chapter::find($request->chapter_id);
            $chapter->delete();

            $this->updateTotalCountForCourse($course);
            return true;
        } else {
            return false;
        }
    }

    public function contents(object $request): object
    {
        $contents = Lesson::where('course_id', $request->course_id)->where('chapter_id', $request->chapter_id)->orderBy('position')->get();
        return ChapterContentListResource::collection($contents);
    }

    public function rearrangeContents(object $request): bool
    {
        $contents = Lesson::where('course_id', $request->course_id)->where('chapter_id', $request->chapter_id)->get();
        if (!empty($request->content_id)) {
            foreach ($request->content_id as $key => $id) {
                $content = $contents->find($id);
                if ($content) {
                    $content->position = ++$key;
                    $content->save();
                }
            }
            return true;
        } else {
            return false;
        }
    }
}
