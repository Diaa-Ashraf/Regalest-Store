<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} - {{ __('Register') }}</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Cairo:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: {{ app()->getLocale() == 'ar' ? "'Cairo', sans-serif" : "'Inter', sans-serif" }};
            min-height: 100vh;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }

        .bg-shapes {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }

        .shape {
            position: absolute;
            background: linear-gradient(135deg, rgba(0, 212, 170, 0.1), rgba(0, 188, 212, 0.1));
            border-radius: 50%;
        }

        .shape:nth-child(1) {
            width: 500px;
            height: 500px;
            top: -150px;
            left: -100px;
            animation: morph 15s infinite alternate;
        }

        .shape:nth-child(2) {
            width: 350px;
            height: 350px;
            bottom: -80px;
            right: -80px;
            animation: morph 12s infinite alternate-reverse;
        }

        @keyframes morph {
            0% { border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%; transform: rotate(0deg); }
            50% { border-radius: 30% 60% 70% 40% / 50% 60% 30% 60%; }
            100% { border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%; transform: rotate(360deg); }
        }

        .register-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 480px;
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 28px;
            padding: 44px 40px;
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.4);
            animation: fadeScale 0.7s ease-out;
        }

        @keyframes fadeScale {
            from { opacity: 0; transform: scale(0.95) translateY(20px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }

        .logo-section {
            text-align: center;
            margin-bottom: 32px;
        }

        .logo-icon {
            width: 68px;
            height: 68px;
            background: linear-gradient(135deg, #00d4aa 0%, #00bcd4 100%);
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 18px;
            box-shadow: 0 12px 35px -8px rgba(0, 212, 170, 0.4);
        }

        .logo-icon svg { width: 38px; height: 38px; fill: #ffffff; }

        .logo-section h1 { color: #ffffff; font-size: 1.625rem; font-weight: 700; margin-bottom: 6px; }
        .logo-section p { color: rgba(255, 255, 255, 0.55); font-size: 0.9rem; }

        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; color: rgba(255, 255, 255, 0.85); font-weight: 500; margin-bottom: 8px; font-size: 0.875rem; }

        .input-wrapper { position: relative; }

        .input-wrapper .icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            fill: rgba(255, 255, 255, 0.35);
            transition: fill 0.3s ease;
            pointer-events: none;
        }

        html[dir="rtl"] .input-wrapper .icon { left: auto; right: 14px; }

        .form-control {
            width: 100%;
            padding: 14px 14px 14px 46px;
            background: rgba(255, 255, 255, 0.06);
            border: 2px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            font-size: 0.9375rem;
            color: #ffffff;
            transition: all 0.3s ease;
        }

        html[dir="rtl"] .form-control { padding: 14px 46px 14px 14px; }
        .form-control::placeholder { color: rgba(255, 255, 255, 0.35); }

        .form-control:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.1);
            border-color: #00d4aa;
            box-shadow: 0 0 0 4px rgba(0, 212, 170, 0.15);
        }

        .form-control.is-invalid { border-color: #f87171; }
        .invalid-feedback { color: #fca5a5; font-size: 0.8rem; margin-top: 6px; display: block; }

        .password-toggle {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
        }

        html[dir="rtl"] .password-toggle { right: auto; left: 14px; }

        .password-toggle svg {
            width: 18px;
            height: 18px;
            fill: rgba(255, 255, 255, 0.35);
            transition: fill 0.3s ease;
        }

        .password-toggle:hover svg { fill: #00d4aa; }

        .terms-check {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 24px;
        }

        .terms-check input { width: 18px; height: 18px; accent-color: #00d4aa; cursor: pointer; margin-top: 2px; }
        .terms-check label { color: rgba(255, 255, 255, 0.65); font-size: 0.875rem; cursor: pointer; line-height: 1.5; }
        .terms-check a { color: #00d4aa; text-decoration: none; }

        .btn-register {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #00d4aa 0%, #00bcd4 100%);
            border: none;
            border-radius: 12px;
            color: #1a1a2e;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-register:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px -8px rgba(0, 212, 170, 0.45);
        }

        .btn-register svg { width: 20px; height: 20px; fill: currentColor; }

        .divider {
            display: flex;
            align-items: center;
            margin: 24px 0;
        }

        .divider::before, .divider::after { content: ''; flex: 1; height: 1px; background: rgba(255, 255, 255, 0.1); }
        .divider span { padding: 0 14px; color: rgba(255, 255, 255, 0.45); font-size: 0.85rem; }

        .login-link { text-align: center; color: rgba(255, 255, 255, 0.65); font-size: 0.9rem; }
        .login-link a { color: #00d4aa; text-decoration: none; font-weight: 600; }

        .back-home { text-align: center; margin-top: 20px; }
        .back-home a {
            color: rgba(255, 255, 255, 0.45);
            font-size: 0.85rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: color 0.3s ease;
        }
        .back-home a:hover { color: #ffffff; }
        .back-home svg { width: 14px; height: 14px; fill: currentColor; }

        .alert {
            padding: 12px 14px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 0.85rem;
            background: rgba(248, 113, 113, 0.12);
            border: 1px solid rgba(248, 113, 113, 0.25);
            color: #fca5a5;
        }

        .alert ul { margin: 0; padding-left: 18px; }

        @media (max-width: 480px) {
            .register-container { padding: 32px 24px; }
            .logo-icon { width: 56px; height: 56px; }
            .logo-section h1 { font-size: 1.375rem; }
        }
    </style>
</head>
<body>
    <div class="bg-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <div class="register-container">
        <div class="logo-section">
            <div class="logo-icon">
                <svg viewBox="0 0 24 24">
                    <path d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V7H4v3H1v2h3v3h2v-3h3v-2H6zm9 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                </svg>
            </div>
            <h1>{{ __('Create Account') }}</h1>
            <p>{{ __('Join us and start shopping') }}</p>
        </div>

        @if ($errors->any())
            <div class="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label for="name">{{ __('Full Name') }}</label>
                <div class="input-wrapper">
                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}" placeholder="{{ __('Enter your full name') }}" required autofocus>
                    <svg class="icon" viewBox="0 0 16 16">
                        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4z"/>
                    </svg>
                </div>
            </div>

            <div class="form-group">
                <label for="email">{{ __('Email Address') }}</label>
                <div class="input-wrapper">
                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}" placeholder="{{ __('Enter your email') }}" required>
                    <svg class="icon" viewBox="0 0 16 16">
                        <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Z"/>
                    </svg>
                </div>
            </div>

            <div class="form-group">
                <label for="password">{{ __('Password') }}</label>
                <div class="input-wrapper">
                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror"
                           placeholder="{{ __('Create password') }}" required>
                    <svg class="icon" viewBox="0 0 16 16">
                        <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                    </svg>
                    <button type="button" class="password-toggle" onclick="togglePassword('password')">
                        <svg id="eye-password" viewBox="0 0 16 16">
                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                <div class="input-wrapper">
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"
                           placeholder="{{ __('Confirm password') }}" required>
                    <svg class="icon" viewBox="0 0 16 16">
                        <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                    </svg>
                    <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                        <svg id="eye-password_confirmation" viewBox="0 0 16 16">
                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="terms-check">
                <input type="checkbox" id="terms" name="terms" required>
                <label for="terms">
                    {{ __('I agree to the') }} 
                    <a href="#">{{ __('Terms of Service') }}</a> 
                    {{ __('and') }} 
                    <a href="#">{{ __('Privacy Policy') }}</a>
                </label>
            </div>

            <button type="submit" class="btn-register">
                <svg viewBox="0 0 16 16">
                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4z"/>
                </svg>
                {{ __('Create Account') }}
            </button>
        </form>

        <div class="divider"><span>{{ __('or') }}</span></div>

        <div class="login-link">
            {{ __('Already have an account?') }}
            <a href="{{ route('login') }}">{{ __('Sign In') }}</a>
        </div>

        <div class="back-home">
            <a href="{{ url('/') }}">
                <svg viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                </svg>
                {{ __('Back to Store') }}
            </a>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const input = document.getElementById(fieldId);
            const icon = document.getElementById('eye-' + fieldId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = '<path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l.708.709z"/><path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829l.822.822zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829z"/><path d="M3.35 5.47c-.18.16-.353.322-.518.487A13.134 13.134 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12-.708.708z"/>';
            } else {
                input.type = 'password';
                icon.innerHTML = '<path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/><path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>';
            }
        }
    </script>
</body>
</html>