<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(\App\Services\SettingsService::class, function () {
            return new \App\Services\SettingsService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \App\Models\Setting::observe(\App\Observers\SettingObserver::class);
        \App\Models\Product::observe(\App\Observers\ProductObserver::class);

        // Share global categories with site header and layouts
        view()->composer(['layouts.site-sections.header', 'layouts.site'], function ($view) {
            $siteNavCategories = \Illuminate\Support\Facades\Cache::remember('site_nav_categories_' . app()->getLocale(), 1800, function () {
                return \App\Models\Category::with(['translations'])
                    ->withCount('activeProducts')
                    ->get();
            });
            $view->with('siteNavCategories', $siteNavCategories);
        });
    }
}
