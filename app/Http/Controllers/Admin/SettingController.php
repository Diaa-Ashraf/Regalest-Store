<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SettingsService;
use App\Http\Requests\Admin\StoreSettingRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function __construct(
        protected SettingsService $settingsService
    ) {}

    public function index(): View
    {
        $settings = $this->settingsService->all();
        $groupedSettings = [
            'general' => $this->settingsService->getGroup('general'),
            'contact' => $this->settingsService->getGroup('contact'),
            'social' => $this->settingsService->getGroup('social'),
            'features' => $this->settingsService->getGroup('features'),
            'checkout' => $this->settingsService->getGroup('checkout'),
        ];

        return view('admin.settings.index', compact('settings', 'groupedSettings'));
    }

    public function update(StoreSettingRequest $request): RedirectResponse
    {
        $inputSettings = $request->validated()['settings'] ?? [];

        // Handle site logo upload
        if ($request->hasFile('site_logo')) {
            $logoPath = $request->file('site_logo')->store('settings', 'public');
            $this->settingsService->set('site_logo', $logoPath, 'general', 'image');
        }

        // Handle site favicon upload (browser tab icon)
        if ($request->hasFile('site_favicon')) {
            $faviconPath = $request->file('site_favicon')->store('settings', 'public');
            $this->settingsService->set('site_favicon', $faviconPath, 'general', 'image');
        }

        foreach ($inputSettings as $key => $value) {
            $this->settingsService->set($key, $value);
        }

        return redirect()->back()->with('success', __('تم حفظ وتحديث الإعدادات بنجاح.'));
    }
}
