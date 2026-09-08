<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductObserver
{
    public function saved(Product $product): void
    {
        $this->clearProductCaches();
    }

    public function deleted(Product $product): void
    {
        $this->clearProductCaches();
    }

    protected function clearProductCaches(): void
    {
        Cache::forget('homepage_featured_products_ar_8');
        Cache::forget('homepage_featured_products_en_8');
        Cache::forget('homepage_latest_products_ar_12');
        Cache::forget('homepage_latest_products_en_12');
    }
}
