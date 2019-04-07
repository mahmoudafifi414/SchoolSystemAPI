<?php

namespace App\Providers;

use App\BusinessLogic\LoaderEngine\Strategies\StudentStrategy;
use App\BusinessLogic\LoaderEngine\Strategies\SubjectStrategy;
use App\BusinessLogic\LoaderEngine\Strategies\TeacherStrategy;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Students', StudentStrategy::class);
        $this->app->bind('Teachers', TeacherStrategy::class);
        $this->app->bind('Subjects', SubjectStrategy::class);
    }
}
