<?php

namespace Modules\NotificationSetup\Entities;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;
use Modules\SystemSetting\Entities\EmailTemplate;

class RoleEmailTemplate extends Model
{
    use Tenantable;
    protected $guarded = [];

    public function template(){
          return $this->belongsTo(EmailTemplate::class, 'template_act','act')->withDefault();
    }
}
