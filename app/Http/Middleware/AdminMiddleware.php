<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', __('يجب تسجيل الدخول أولاً للوصول للوحة التحكم.'));
        }

        $user = Auth::user();

        if (!$user->is_active) {
            Auth::logout();
            return redirect()->route('login')->with('error', __('تم تعطيل هذا الحساب. يرجى التواصل مع الإدارة.'));
        }

        if (!$user->hasAnyRole(['super_admin', 'admin'])) {
            return redirect()->route('site.home')->with('error', __('ليس لديك الصلاحية لدخول لوحة التحكم.'));
        }

        return $next($request);
    }
}
