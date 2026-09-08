<?php

use App\Services\SettingsService;

if (!function_exists('settings')) {
    /**
     * Global settings helper
     */
    function settings(?string $key = null, mixed $default = null): mixed
    {
        $service = app(SettingsService::class);

        if (is_null($key)) {
            return $service;
        }

        return $service->get($key, $default);
    }
}

if (!function_exists('get_site_logo')) {
    /**
     * Get site logo URL with fallback
     */
    function get_site_logo(): ?string
    {
        $logo = settings('site_logo');
        if ($logo && \Illuminate\Support\Facades\Storage::disk('public')->exists($logo)) {
            return \Illuminate\Support\Facades\Storage::url($logo);
        }
        if ($logo && file_exists(public_path($logo))) {
            return asset($logo);
        }
        return null;
    }
}

if (!function_exists('get_site_favicon')) {
    /**
     * Get browser tab favicon URL with fallback
     */
    function get_site_favicon(): ?string
    {
        $favicon = settings('site_favicon');
        if ($favicon && \Illuminate\Support\Facades\Storage::disk('public')->exists($favicon)) {
            return \Illuminate\Support\Facades\Storage::url($favicon);
        }
        if ($favicon && file_exists(public_path($favicon))) {
            return asset($favicon);
        }
        // Fallback to logo if favicon is not set
        return get_site_logo();
    }
}
