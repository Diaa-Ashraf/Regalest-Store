<?php

namespace App\Observers;

use App\Models\Banner;
use Illuminate\Support\Facades\Cache;

class BannerObserver
{
    public function saved(Banner $banner): void
    {
        $this->clearBannerCaches();
    }

    public function deleted(Banner $banner): void
    {
        $this->clearBannerCaches();
    }

    protected function clearBannerCaches(): void
    {
        Cache::forget('homepage_banners');
    }
}
