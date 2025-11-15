<?php

namespace Modules\Quiz\Entities;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;


class StudentTakeOnlineQuiz extends Model
{
    use Tenantable;

    protected $fillable = [];
}
