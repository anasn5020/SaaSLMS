<?php

namespace Modules\Quiz\Entities;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;


class OnlineExamQuestionAssign extends Model
{
    use Tenantable;

    protected $guarded = ['id'];

    public function questionBank()
    {
        return $this->belongsTo('Modules\Quiz\Entities\QuestionBank', 'question_bank_id', 'id')->withDefault();
    }
}
