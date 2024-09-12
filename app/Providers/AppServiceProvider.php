<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Pagination\Paginator;

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
        Schema::defaultStringLength(191);
        app('view')->composer('layouts.admin.sidebar', function ($view) {
            $menuArr = [];
            if (Auth::check()) {
                $menuAll = getMenuItems();
                $menuArr = $menuAll;
            }
            $currentMenuRoute = getCurrentMenuRoute();
            $view->with(compact('menuArr','currentMenuRoute'));
        });
        Paginator::useBootstrap();

        if (config('app.env') === 'production' || config('app.env') === 'staging') {
            \URL::forceScheme('https');
            $this->app['request']->server->set('HTTPS', 'on');
        }
    }
}
