<?php

namespace Modules\CourseSetting\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\CourseSetting\Repositories\Eloquents\CourseRepository;
use Modules\CourseSetting\Repositories\Interfaces\CourseRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(CourseRepositoryInterface::class, CourseRepository::class);


    }

    public function boot()
    {
        //
    }
}
