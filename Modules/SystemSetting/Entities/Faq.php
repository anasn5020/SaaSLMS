<?php

namespace Modules\SystemSetting\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


class Faq extends Model
{


    protected $fillable = [];

    protected $appends = ['addedFormat'];

    public function getaddedFormatAttribute()
    {
        return Carbon::parse($this->created_at)->isoformat('Do MMMM Y H:ss a');
    }

}
