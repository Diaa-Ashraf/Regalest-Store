<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SocialAuthController extends Controller
{
    /**
     * Redirect to Google OAuth provider
     */
    public function redirectToGoogle(): RedirectResponse
    {
        if (!settings('google_oauth_enabled', false)) {
            return redirect()->route('login')->with('error', __('تسجيل الدخول بواسطة جوجل معطل حالياً من قبل الإدارة.'));
        }

        if (empty(config('services.google.client_id')) || empty(config('services.google.client_secret'))) {
            return redirect()->route('login')->with('error', __('لم يتم إعداد بيانات Google OAuth (Client ID & Secret) في ملف البيئة بعد.'));
        }

        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google OAuth callback
     */
    public function handleGoogleCallback(): RedirectResponse
    {
        if (!settings('google_oauth_enabled', false)) {
            return redirect()->route('login')->with('error', __('خدمة تسجيل الدخول بواسطة جوجل معطلة.'));
        }

        if (empty(config('services.google.client_id')) || empty(config('services.google.client_secret'))) {
            return redirect()->route('login')->with('error', __('لم يتم إعداد بيانات Google OAuth في ملف البيئة بعد.'));
        }

        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Throwable $e) {
            return redirect()->route('login')->with('error', __('فشل الاتصال بخدمات جوجل، يرجى المحاولة لاحقاً.'));
        }

        // Find or create user
        $user = User::where('google_id', $googleUser->getId())
            ->orWhere('email', $googleUser->getEmail())
            ->first();

        if ($user) {
            $user->update([
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
            ]);
        } else {
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'password' => Hash::make(Str::random(24)),
                'is_active' => true,
                'email_verified_at' => now(),
            ]);

            // Assign default customer role
            $user->assignRole('customer');
        }

        Auth::login($user, true);

        return redirect()->intended(route('site.home'))->with('success', __('تم تسجيل الدخول بنجاح! مرحباً بك في متجر Regalest.'));
    }
}
