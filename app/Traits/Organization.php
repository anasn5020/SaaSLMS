<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;


trait Organization
{
    protected static function bootOrganization()
    {
        if (Auth::check() && Auth::user()->isOrganization()) {
            static::creating(function ($model) {
                if (Schema::hasColumn($model->getTable(), 'organization_id')) {
                    $model->organization_id = Auth::id();
                }
            });
        }
    }
}
