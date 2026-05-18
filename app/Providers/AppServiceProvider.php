<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::define('view-dashboard', function (User $user) {
            return $user->hasRole('admin') || $user->hasRole('editor');
        });

        Gate::define('edit-post', function (User $user) {
            return $user->hasRole('admin') || $user->hasRole('editor');
        });

        Gate::define('delete-post', function (User $user) {
            return $user->hasRole('admin');
        });
    }
}
