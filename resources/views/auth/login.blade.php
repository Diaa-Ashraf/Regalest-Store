<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ settings('site_name', 'Regalest Store') }} - {{ __('تسجيل الدخول') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alexandria:wght@300;400;500;600;700;800&family=Cinzel:wght@600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Alexandria', 'Plus Jakarta Sans', sans-serif; }
        
        .split-wrapper {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }
        
        .split-form-col {
            flex: 1 1 50%;
            width: 50%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background-color: #FFFFFF;
            padding: 40px 48px;
            min-height: 100vh;
        }

        .split-image-col {
            flex: 1 1 50%;
            width: 50%;
            position: relative;
            background-color: #18181B;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px;
            overflow: hidden;
            min-height: 100vh;
        }

        .split-image-bg {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.9;
            transition: transform 1.2s ease-out;
        }
        .split-image-col:hover .split-image-bg {
            transform: scale(1.04);
        }

        .split-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(24, 24, 27, 0.85) 0%, rgba(0, 0, 0, 0.4) 50%, rgba(0, 0, 0, 0.2) 100%);
        }

        @media (max-width: 1024px) {
            .split-wrapper {
                flex-direction: column;
            }
            .split-form-col {
                width: 100%;
                flex: 1 1 100%;
                padding: 32px 20px;
            }
            .split-image-col {
                display: none;
            }
        }
    </style>
</head>
<body class="bg-[#F8F9FA] text-[#18181B] antialiased">

    <div class="split-wrapper">
        
        {{-- Right / Form Side in RTL (Left in LTR) --}}
        <div class="split-form-col">
            
            {{-- Top Header --}}
            <div class="flex items-center justify-between mb-6">
                <a href="{{ route('site.home') }}" class="flex items-center gap-2 group">
                    <span class="text-2xl filter drop-shadow">🎁</span>
                    <span class="font-royal text-xl font-extrabold tracking-wider text-[#18181B] group-hover:text-[#C5A059] transition-colors">
                        {{ settings('site_name', 'REGALEST') }}
                    </span>
                </a>
                
                <a href="{{ route('site.home') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-gray-500 hover:text-[#C5A059] transition-colors">
                    <span>{{ __('العودة للرئيسية') }}</span>
                    <span class="rtl:rotate-180">&rarr;</span>
                </a>
            </div>

            {{-- Centered Form --}}
            <div class="max-w-md w-full mx-auto my-auto py-4">
                
                <div class="mb-7 text-start">
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-[#18181B] tracking-tight">
                        {{ __('مرحباً بعودتك') }} 👋
                    </h1>
                    <p class="text-xs sm:text-sm text-gray-500 mt-2 leading-relaxed">
                        {{ __('أدخل بياناتك لتسجيل الدخول ومتابعة طلباتك وسلتك بكل سهولة') }}
                    </p>
                </div>

                {{-- Status / Error Alerts --}}
                @if (session('status'))
                    <div class="p-3 mb-5 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-medium">
                        {{ session('status') }}
                    </div>
                @endif

                @if (session('success'))
                    <div class="p-3.5 mb-5 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-medium flex items-center gap-2">
                        <svg class="w-4 h-4 shrink-0 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="p-3.5 mb-5 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-medium flex items-center gap-2">
                        <svg class="w-4 h-4 shrink-0 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="p-3.5 mb-5 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-medium flex items-center gap-2">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-xs font-bold text-gray-700 mb-1.5">
                            {{ __('البريد الإلكتروني') }}
                        </label>
                        <div class="relative">
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autofocus 
                                   placeholder="name@example.com"
                                   class="w-full px-4 py-3 text-xs sm:text-sm rounded-2xl bg-[#F8F9FA] border border-gray-200 text-[#18181B] placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#C5A059] focus:bg-white transition-all">
                            <div class="absolute end-3.5 inset-y-0 flex items-center pointer-events-none text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                        </div>
                    </div>

                    {{-- Password --}}
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-xs font-bold text-gray-700">
                                {{ __('كلمة المرور') }}
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-[11px] font-semibold text-[#C5A059] hover:underline">
                                    {{ __('نسيت كلمة المرور؟') }}
                                </a>
                            @endif
                        </div>
                        <div class="relative">
                            <input type="password" 
                                   id="password" 
                                   name="password" 
                                   required 
                                   placeholder="••••••••"
                                   class="w-full px-4 py-3 text-xs sm:text-sm rounded-2xl bg-[#F8F9FA] border border-gray-200 text-[#18181B] placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#C5A059] focus:bg-white transition-all">
                            <button type="button" 
                                    onclick="togglePassword()" 
                                    class="absolute end-3.5 inset-y-0 flex items-center text-gray-400 hover:text-gray-600 transition-colors">
                                <svg id="eye-icon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Remember Me --}}
                    <div class="flex items-center justify-between py-1">
                        <label class="flex items-center gap-2 cursor-pointer select-none">
                            <input type="checkbox" 
                                   name="remember" 
                                   id="remember" 
                                   class="w-4 h-4 rounded text-[#C5A059] focus:ring-[#C5A059] border-gray-300">
                            <span class="text-xs text-gray-600 font-medium">{{ __('تذكر تسجيل دخولي') }}</span>
                        </label>
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit" 
                            class="w-full py-3.5 rounded-full bg-[#18181B] hover:bg-[#C5A059] text-white text-xs sm:text-sm font-bold transition-all duration-300 shadow-md hover:shadow-lg active:scale-98 flex items-center justify-center gap-2">
                        <span>{{ __('تسجيل الدخول') }}</span>
                        <span>&larr;</span>
                    </button>
                </form>

                {{-- Google OAuth --}}
                @if(settings('google_oauth_enabled', false))
                    <div class="relative my-6 text-center">
                        <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-gray-200"></div></div>
                        <span class="relative bg-white px-4 text-xs text-gray-400">{{ __('أو تسجيل الدخول السريع') }}</span>
                    </div>

                    <a href="{{ route('auth.google') }}" 
                       class="w-full py-3 rounded-full bg-white border border-gray-200 hover:border-gray-300 text-gray-700 text-xs font-bold transition-all flex items-center justify-center gap-2.5 shadow-xs hover:shadow-sm">
                        <svg class="w-4 h-4" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v4.51h6.6c-.29 1.52-1.14 2.82-2.4 3.68v3.05h3.88c2.27-2.09 3.665-5.17 3.665-9.17Z"/>
                            <path fill="#34A853" d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.88-3.05c-1.08.72-2.45 1.16-4.05 1.16-3.12 0-5.77-2.1-6.72-4.93H1.25v3.15C3.26 21.36 7.33 24 12 24Z"/>
                            <path fill="#FBBC05" d="M5.28 14.27c-.25-.72-.38-1.49-.38-2.27s.14-1.55.38-2.27V6.58H1.25C.45 8.18 0 9.99 0 12s.45 3.82 1.25 5.42l4.03-3.15Z"/>
                            <path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.33 0 3.26 2.64 1.25 6.58l4.03 3.15c.95-2.83 3.6-4.98 6.72-4.98Z"/>
                        </svg>
                        <span>{{ __('متابعة باستخدام Google') }}</span>
                    </a>
                @endif

                {{-- Register Link --}}
                <div class="mt-7 text-center text-xs text-gray-500">
                    <span>{{ __('ليس لديك حساب حتى الآن؟') }}</span>
                    <a href="{{ route('register') }}" class="font-bold text-[#C5A059] hover:underline ms-1">
                        {{ __('أنشئ حساباً جديداً') }}
                    </a>
                </div>
            </div>

            {{-- Bottom Footer --}}
            <div class="text-center text-[11px] text-gray-400 mt-4">
                &copy; {{ date('Y') }} {{ settings('site_name', 'Regalest Store') }}. {{ __('جميع الحقوق محفوظة.') }}
            </div>
        </div>

        {{-- Left / Image Showcase Side in RTL (Right in LTR) --}}
        <div class="split-image-col">
            <img src="{{ asset('assets/site/img/auth/luxury-showcase.jpg') }}" 
                 alt="Regalest Showcase" 
                 class="split-image-bg">
            
            <div class="split-overlay"></div>

            {{-- Editorial Glass Card --}}
            <div class="relative z-10 max-w-lg p-8 sm:p-10 rounded-3xl bg-black/40 backdrop-blur-md border border-white/20 text-white shadow-2xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#C5A059]/30 border border-[#C5A059]/50 text-[#C5A059] text-[11px] font-bold mb-4">
                    <span>✨</span>
                    <span>{{ __('مقتنيات وهدايا استثنائية') }}</span>
                </div>
                
                <h2 class="font-royal text-2xl sm:text-3xl font-extrabold leading-snug mb-3">
                    {{ __('عالم مفعم بالأناقة والقطع الفاخرة المصنوعة بعناية') }}
                </h2>
                
                <p class="text-xs sm:text-sm text-gray-200 leading-relaxed font-normal">
                    {{ __('انضم إلى مجتمع ريجاليست واستمتع بتجربة تسوق حصرية، عروض فورية، وخدمة إهداء مخصصة لكل مناسبة سعيدة.') }}
                </p>

                <div class="mt-6 pt-6 border-t border-white/20 flex items-center justify-between text-xs text-gray-200">
                    <div class="flex items-center gap-2">
                        <span class="text-emerald-400 font-bold">✓</span>
                        <span>{{ __('دفع آمن واستلام فوري') }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-emerald-400 font-bold">✓</span>
                        <span>{{ __('تغليف ملكي للهدايا') }}</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>
                `;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                `;
            }
        }
    </script>
</body>
</html>
