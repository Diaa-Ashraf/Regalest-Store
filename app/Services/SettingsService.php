<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Collection;

class SettingsService
{
    protected const CACHE_KEY = 'global_settings_all';
    protected const CACHE_TTL = 86400; // 24 hours

    /**
     * Get a setting by key with optional default
     */
    public function get(string $key, mixed $default = null): mixed
    {
        $settings = $this->all();

        if (isset($settings[$key])) {
            return $settings[$key];
        }

        return $default;
    }

    /**
     * Get all settings as key => formatted_value array (cached)
     */
    public function all(): array
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            return Setting::all()->mapWithKeys(function ($item) {
                return [$item->key => $item->formatted_value];
            })->toArray();
        });
    }

    /**
     * Get settings by group
     */
    public function getGroup(string $group): Collection
    {
        return Setting::where('group', $group)->get();
    }

    /**
     * Set/update a setting value
     */
    public function set(string $key, mixed $value, string $group = 'general', string $type = 'text'): Setting
    {
        $setting = Setting::updateOrCreate(
            ['key' => $key],
            [
                'value' => is_array($value) ? json_encode($value) : $value,
                'group' => $group,
                'type' => $type,
            ]
        );

        $this->clearCache();

        return $setting;
    }

    /**
     * Check if a feature flag is enabled
     */
    public function isFeatureEnabled(string $featureKey): bool
    {
        return (bool) $this->get($featureKey, false);
    }

    /**
     * Clear settings cache
     */
    public function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
