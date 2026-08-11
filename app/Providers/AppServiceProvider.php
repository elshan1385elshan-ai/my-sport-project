<?php

namespace App\Providers;

use App\Models\AppSetting;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        View::composer('*', function ($view) {
            $appSettings = AppSetting::allSettings();
            $appSettings['copyright_display'] = AppSetting::copyrightText($appSettings);

            $view->with('appSettings', $appSettings);
        });

        View::composer(['layouts.partials.nav', 'layouts.partials.footer'], function ($view) {
            $view->with('navCategories', Cache::remember('nav_categories', 3600, function () {
                return Category::whereNull('parent_id')->with('children')->select(['id', 'name'])->get();
            }));
        });
    }
}
