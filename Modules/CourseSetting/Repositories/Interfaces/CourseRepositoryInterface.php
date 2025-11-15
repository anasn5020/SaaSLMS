<?php

namespace Modules\CourseSetting\Repositories\Interfaces;

use App\Repositories\Interfaces\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface CourseRepositoryInterface extends EloquentRepositoryInterface
{

    public function allActiveCourseInArray($key = 'id', $value = 'name'): array;
}
