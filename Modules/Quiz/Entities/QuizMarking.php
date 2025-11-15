<?php

namespace Modules\Quiz\Entities;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;

class QuizMarking extends Model
{
    use Tenantable;
    protected $fillable = [];
}
