<?php

namespace Modules\Quiz\Entities;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;
use Modules\Setting\Entities\UsedMedia;


class QuestionBankMuOption extends Model
{

    use Tenantable;

    protected $fillable = [];

    public function question()
    {
        return $this->belongsTo(QuestionBank::class, 'question_bank_id')->withDefault();
    }
    public function image_media()
    {
        return $this->morphOne(UsedMedia::class, 'usable')->where('used_for', 'image');
    }

}
