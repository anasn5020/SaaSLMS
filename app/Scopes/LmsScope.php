<?php

namespace App\Scopes;

use App\Models\LmsInstitute;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class LmsScope implements Scope
{
    public $tables = [
        'courses',
        'online_quizzes',
        'virtual_classes'
    ];

    public function apply(Builder $builder, Model $model)
    {
        if (!isModuleActive('LmsSaasMD') && !isModuleActive('LmsSaas')) {
            return;
        }
        $institute = 1;
        if (function_exists('SaasInstitute')) {
            try {
                $institute = SaasInstitute()->id ?? 1;
            } catch (\Exception $e) {

            }
        }

        if (isModuleActive('LmsSaas') && in_array($model->getTable(), $this->tables)) {
            if (config('app.short_url') == request()->getHost()) {
                $domain = null;
            } else {
                $domain = str_replace('.' . config('app.short_url'), '', request()->getHost());
            }

            if ($domain) {
                $checkInstitute = Cache::rememberForever('LmsInstitute' . $domain, function () use ($domain) {
                    return LmsInstitute::where('domain', $domain)->first();
                });;
                if ($checkInstitute) {
                    $institute = $checkInstitute->id;
                }
            }
        }
        $hasTable = Cache::rememberForever('hasTable' . $model->getTable(), function () use ($model) {
            return Schema::hasColumn($model->getTable(), 'lms_id');
        });
        if ($hasTable && !isModuleActive('LmsSaasMD')) {
            $builder->where($model->getTable() . '.lms_id', '=', $institute);
        }
    }
}
