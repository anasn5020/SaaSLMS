<?php

namespace App\Models;

use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

use Modules\LmsSaas\Entities\SaasCheckout;
use Modules\LmsSaas\Entities\SaasInstitutePlanManagement;

use Modules\LmsSaasMD\Entities\SaasCheckout as MDSaasCheckout;
use Modules\LmsSaasMD\Entities\SaasInstitutePlanManagement as MDSaasInstitutePlanManagement;
use Modules\Setting\Model\GeneralSetting;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LmsInstitute extends Model
{
    use SoftDeletes;

    protected $connection;

    protected $dates = ['deleted_at'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        if (isModuleActive('LmsSaasMD') && SaasDomain() != "main") {
            $this->setConnection('mysql_md');
        } else {
            $this->setConnection(config('database.default'));
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function settings()
    {
        $settings = DB::table('general_settings')->where('lms_id', $this->id)->pluck('value', 'key');
        $settings['country_name'] = DB::table('countries')->where('id', $settings['country_id'] ?? 0)->first()->name ?? '';
        return $settings;
    }

    public function plan_management()
    {
        if (isModuleActive('LmsSaasMD')) {
            return $this->belongsTo(MDSaasInstitutePlanManagement::class, 'id', 'lms_id')->withDefault();

        } else {
            return $this->belongsTo(SaasInstitutePlanManagement::class, 'id', 'lms_id')->withDefault();
        }
    }

    public function saas_checkout()
    {
        if (isModuleActive('LmsSaasMD')) {
            return $this->hasMany(MDSaasCheckout::class, 'lms_id')->orderBy('id', 'desc');

        } else {
            return $this->hasMany(SaasCheckout::class, 'lms_id')->orderBy('id', 'desc');
        }
    }
}
