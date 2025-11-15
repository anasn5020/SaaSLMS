<?php

namespace Modules\Quiz\Entities;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;

class QuizTestDetailsAnswer extends Model
{
    use Tenantable;
    protected $fillable = [];
}
