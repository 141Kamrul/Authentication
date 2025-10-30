<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        
        Gate::define('edit-job', function ($user, $job) {
            
            return $job->employer->user->is($user);
        });

        Gate::define('update-job', function ($user, $job) {
            return $job->employer->user->is($user);
        });

        Gate::define('delete-job', function ($user, $job) {
            return $job->employer->user->is($user);
        });

        
        Gate::define('view-job', function ($user, $job) {
            return $job->employer->user->is($user);
        });

        
        Gate::define('is-employer', function ($user) {
            return $user->employer !== null;
        });

        Gate::define('create-job', function ($user) {
            return $user->employer !== null;
        });
    }
}
