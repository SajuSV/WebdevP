<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Makes the $site variable available in the main layouts
        // (navbar, footer and page titles need it on every page).
        View::composer(['layouts.*', 'auth.*', 'pages.*', 'admin.*'], function ($view) {
            // once() = run the database query only one time per page
            $view->with('site', once(fn () => SiteSetting::current()));
        });
    }
}
