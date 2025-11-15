<?php

namespace Modules\SystemSetting\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;


class EmailTemplate extends Model
{
    use HasTranslations;

    protected $guarded = ['id'];

    public $translatable = ['name', 'subj', 'email_body', 'browser_message', 'sms_message'];
}
