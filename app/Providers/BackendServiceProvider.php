<?php

namespace App\Providers;

use App\Repositories\CommonRepository;
use App\Repositories\CommonRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class BackendServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(CommonRepositoryInterface::class, CommonRepository::class);
    }


    public function boot()
    {
        //
    }
}
