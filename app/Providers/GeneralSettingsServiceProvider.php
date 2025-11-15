<?php

namespace App\Providers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class GeneralSettingsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {



        $this->app->singleton('ModuleList', function () {
            return Cache::rememberForever('ModuleList', function () {
               return DB::table('modules')->select('name', 'status', 'order', 'details')->get();
            });
        });



        $this->app->singleton('ModulePackageList', function () {
            return \Nwidart\Modules\Facades\Module::all();
        });

        $this->app->singleton('ModuleManagerList', function () {
            return Cache::rememberForever('ModuleManagerList', function () {
                return DB::table('infix_module_managers')
                    ->select('name', 'email', 'notes', 'version', 'update_url', 'purchase_code', 'installed_domain', 'activated_date', 'checksum')
                    ->get();
            });
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
       //
    }
}
