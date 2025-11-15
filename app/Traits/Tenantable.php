<?php

namespace App\Traits;

use App\Scopes\LmsScope;
use App\Models\LmsInstitute;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

trait Tenantable
{

    protected static function bootTenantable()
    {

        static::addGlobalScope(new LmsScope);

        if (isset(Auth::user()->lms_id)) {
            static::creating(function ($model) {
                if (Schema::hasColumn($model->getTable(), 'lms_id')) {
                    $model->lms_id = (int)Auth::user()->lms_id;
                }
            });

        }
    }

    public function institute()
    {
        return $this->belongsTo(LmsInstitute::class, 'lms_id', 'id');
    }
}
