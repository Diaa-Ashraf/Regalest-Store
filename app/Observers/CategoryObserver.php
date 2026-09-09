<?php

namespace App\Observers;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class CategoryObserver
{
    public function saved(Category $category): void
    {
        $this->clearCategoryCaches();
    }

    public function deleted(Category $category): void
    {
        $this->clearCategoryCaches();
    }

    protected function clearCategoryCaches(): void
    {
        $locales = ['ar', 'en'];
        foreach ($locales as $locale) {
            Cache::forget('site_nav_categories_' . $locale);
            Cache::forget('site_homepage_categories_' . $locale);
            Cache::forget('site_all_categories_' . $locale);
        }
    }
}
