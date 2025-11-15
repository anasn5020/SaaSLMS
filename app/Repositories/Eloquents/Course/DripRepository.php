<?php

namespace App\Repositories\Eloquents\Course;

use App\Http\Resources\api\v2\Lesson\DripContentListResource;
use App\Repositories\Interfaces\Course\DripRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\Lesson;

class DripRepository implements DripRepositoryInterface
{
    /**
     * __construct
     *
     * @param  mixed $course
     * @param  mixed $lesson
     * @return void
     */
    public function __construct(private Course $course, private Lesson $lesson)
    {
        //
    }

    /**
     * index
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return object
     */
    public function index(object $request, ?int $id): object
    {
        $course = $this->course->where('type', 1)->where('drip', 1)->find($id);
        if (!$course) {
            throw ValidationException::withMessages(['course_id' => trans('validation.course_id.exists')]);
        }
        $dripContents = $course->lessons()->paginate($request->get('per_page', 10));
        return DripContentListResource::collection($dripContents);
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return bool
     */
    public function update(object $request, ?int $id): bool
    {
        $course = $this->course->where('type', 1)->where('drip', 1)->find($id);
        if (!$course) {
            throw ValidationException::withMessages(['course_id' => trans('validation.course_id.exists')]);
        }

        $lesson_id = $request->get('lesson_id');
        $lesson_date = $request->get('lesson_date');
        $lesson_day = $request->get('lesson_day');
        $drip_type = $request->get('drip_type');

        if (!empty($lesson_id) && is_array($lesson_id)) {
            foreach ($lesson_id as $key => $id) {
                $lesson = $course->lessons()->find($id);
                if ($lesson) {
                    $checkType = $drip_type[$key];
                    if ($checkType == 1) {
                        $lesson->unlock_days = null;
                        if (!empty($lesson_date[$key])) {
                            $lesson->unlock_date = Carbon::createFromFormat('m-d-Y',$lesson_date[$key])->format('Y-m-d');
                        } else {
                            $lesson->unlock_date = null;
                        }
                    } else {
                        $lesson->unlock_date = null;
                        if (!empty($lesson_day[$key])) {
                            $lesson->unlock_days = $lesson_day[$key];
                        } else {
                            $lesson->unlock_days = null;
                        }
                    }
                    $lesson->save();
                }
            }
        }
        return true;
    }
}
