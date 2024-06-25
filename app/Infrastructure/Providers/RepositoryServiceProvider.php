<?php

namespace App\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\View;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Domain\Role\Infrastructure\RoleRepositoryInterface::class,
            \App\Domain\Role\Infrastructure\EloquentRoleRepository::class
        );

        $this->app->bind(
            \App\Domain\User\Infrastructure\UserRepositoryInterface::class,
            \App\Domain\User\Infrastructure\EloquentUserRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::unguard();
        Model::shouldBeStrict();

        View::addNamespace('admin', [
            app_path() . '/Infrastructure/Views',
        ]);

        view()->composer(['layouts.main'], function($view) {
            $view->with('user', Auth::user());
        });
    }
}
