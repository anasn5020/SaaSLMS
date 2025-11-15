<?php

namespace Modules\FrontendManage\Entities;

use App\Traits\HasTranslations;
use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;

class HomePageFaq extends Model
{
    use Tenantable;
    use HasTranslations;

    public $translatable = ['question','answer'];
    protected $guarded = ['id'];
}
