<?php

namespace Modules\NotificationSetup\Entities;

use App\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;

class UserNotificationSetup extends Model
{
    use Tenantable;
    protected $fillable = [];
}
