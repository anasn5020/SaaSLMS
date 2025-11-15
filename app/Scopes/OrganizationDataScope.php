<?php

namespace App\Scopes;


use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;


class OrganizationDataScope implements Scope
{

    public function apply(Builder $builder, Model $model)
    {
        if (isModuleActive('Organization') && Auth::check() && Auth::user()->isOrganization()) {
            $builder->where('organization_id', Auth::id());
        }

    }
}
