<?php

namespace Modules\SystemSetting\Entities;

use App\Traits\Tenantable;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Inventory\Entities\ShowRoom;
use Modules\Inventory\Entities\WareHouse;
use Modules\Payroll\Entities\Payroll;
use Modules\Setup\Entities\Department;
use Modules\Setup\Entities\IntroPrefix;

class Staff extends Model
{
    use Tenantable;

    use SoftDeletes;
    protected $table = 'staffs';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(\Modules\SystemSetting\Entities\Department::class)->withDefault();
    }

    public function payrolls(){
        return $this->hasMany(\Modules\HumanResource\Entities\Payroll::class, 'staff_id', 'id');
    }
}
