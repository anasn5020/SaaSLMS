<?php

namespace App\Http\Resources\api\v2\Course;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\CourseSetting\Entities\Lesson;

class CourseListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        switch ($this->type) {
            case 1:
                $type = 'course';
                break;

            case 2:
                $type = 'quiz';
                break;

            default:
                $type = 'course';
                break;
        }

        switch ($this->mode_of_delivery) {
            case 1:
                $deliveryMode = 'online';
                break;

            case 2:
                $deliveryMode = 'distance learning';
                break;

            case 3:
                $deliveryMode = 'face to face';
                break;

            default:
                $deliveryMode = 'online';
                break;
        }

        switch ($this->scope) {
            case 0:
                $scope = 'private';
                break;
            case 1:
                $scope = 'public';
                break;
            default:
                $scope = 'public';
                break;
        }

        $lessons = Lesson::where('course_id', $this->id)->count();

        $enrollUsers = $this->enrollUsers;

        $quizMark = null;
        if($this->type == 2 && isset($this->quiz)){
            $quizMark = (float)$this->quiz->total_marks;
        }

        return [
            'id'                => (int)$this->id,
            'course_type'       => (string)ucwords($type),
            $type . '_id'       => (int)$this->id,
            'title'             => (string)$this->title,
            'image'             => file_exists($this->image) ? (string)asset($this->image) : '',
            'thumbnail'         => file_exists($this->thumbnail) ? (string)asset($this->thumbnail) : '',
            'instructor'        => (string)trim($this->instructor->name),
            'delivery_mode'     => (string)ucwords($deliveryMode),
            'category'          => (string)trim($this->category->name),
            'price'             => (float)$this->price,
            'lesson'            => (int)$lessons,
            'enrolled_online'   => (int)($enrollUsers->where('teach_via', 1)->count()),
            'enrolled_offline'  => (int)($enrollUsers->where('teach_via', 2)->count()),
            'quiz'              => (string)trim($this->quiz->title),
            'view_scope'        => (string)ucwords($scope),
            'status'            => (bool)$this->status,
            'description'       => (string)$this->about,
            'duration'          => (string)$this->duration,
            'quiz_mark'          => $quizMark,
            'is_drip'          => (bool)$this->drip,
        ];
    }
}
