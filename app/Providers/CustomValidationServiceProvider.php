<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class CustomValidationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Validator::extend('exists_in_columns', function ($attribute, $value, $parameters, $validator) {
            $table = array_shift($parameters);
            $columns = $parameters;

            foreach ($columns as $column) {
                if ($this->existsInColumn($table, $column, $value)) {
                    return true;
                }
            }

            return false;
        });
    }

    protected function existsInColumn($table, $column, $value)
    {
        return DB::table($table)
            ->where($column, $value)
            ->exists();
    }
}
