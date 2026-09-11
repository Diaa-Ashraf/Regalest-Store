<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'لوحة الإدارة') | {{ settings('site_name', 'Regalest Store') }}</title>

    @php
        $siteFavicon = get_site_favicon();
    @endphp
    @if($siteFavicon)
        <!-- Browser Tab Icon (Favicon) -->
        <link rel="icon" href="{{ $siteFavicon }}">
        <link rel="shortcut icon" href="{{ $siteFavicon }}">
        <link rel="apple-touch-icon" href="{{ $siteFavicon }}">
    @else
        <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>👑</text></svg>">
    @endif

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Readex+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind & App Assets via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] {
            display: none !important;
        }
        body {
            font-family: 'Readex Pro', 'Plus Jakarta Sans', sans-serif;
        }
        /* Custom Clean Scrollbar for Sidebar */
        .admin-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .admin-scrollbar::-webkit-scrollbar-thumb {
            background: #EADBCC;
            border-radius: 4px;
        }
    </style>

    @stack('styles')
</head>
<body class="bg-[#F8F6F2] text-[#18181B] antialiased overflow-hidden"
      x-data="{
          sidebarCollapsed: localStorage.getItem('regalest_admin_sidebar_collapsed') === 'true',
          mobileSidebarOpen: false,
          toggleSidebar() {
              this.sidebarCollapsed = !this.sidebarCollapsed;
              localStorage.setItem('regalest_admin_sidebar_collapsed', this.sidebarCollapsed);
          }
      }">

    <!-- Mobile Sidebar Backdrop Overlay -->
    <div x-show="mobileSidebarOpen" 
         x-cloak
         @click="mobileSidebarOpen = false"
         x-transition:enter="transition-opacity ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-40 bg-black/60 backdrop-blur-xs lg:hidden"></div>

    <!-- Master Layout Wrapper -->
    <div class="flex h-screen w-screen overflow-hidden">
        
        <!-- 1. Collapsible & Responsive Sidebar -->
        <aside :class="{
                   'w-72': !sidebarCollapsed,
                   'w-20': sidebarCollapsed,
                   'translate-x-0': mobileSidebarOpen,
                   'max-lg:rtl:translate-x-full max-lg:ltr:-translate-x-full': !mobileSidebarOpen
               }"
               class="fixed lg:static inset-y-0 start-0 flex-shrink-0 bg-white border-e border-[#EADBCC] flex flex-col h-full z-50 lg:z-30 shadow-sm transition-all duration-300 ease-in-out">
            
            <!-- Brand & Sidebar Toggle -->
            <div class="h-20 flex items-center justify-between px-4 sm:px-6 border-b border-[#EADBCC]">
                @php
                    $adminLogo = get_site_logo();
                @endphp
                <div class="flex items-center gap-3 overflow-hidden">
                    @if($adminLogo)
                        <div class="w-10 h-10 rounded-xl bg-[#18181B] p-1 flex items-center justify-center shadow-sm shrink-0 overflow-hidden border border-[#EADBCC]">
                            <img src="{{ $adminLogo }}" alt="Logo" class="w-full h-full object-contain">
                        </div>
                    @else
                        <div class="w-10 h-10 rounded-xl bg-[#18181B] text-[#C5A059] flex items-center justify-center text-xl font-bold shadow-sm shrink-0">
                            👑
                        </div>
                    @endif
                    <div x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms class="min-w-0">
                        <h1 class="font-bold text-sm text-[#18181B] leading-tight truncate">
                            {{ settings('site_name', 'Regalest Store') }}
                        </h1>
                        <span class="text-[11px] text-[#71717A] block truncate">{{ __('لوحة الإدارة الملكية') }}</span>
                    </div>
                </div>

                <!-- Desktop Collapse Button inside Sidebar Header -->
                <button type="button" 
                        @click="toggleSidebar()" 
                        class="hidden lg:flex w-8 h-8 rounded-lg bg-[#F8F6F2] hover:bg-[#EADBCC] text-[#71717A] hover:text-[#18181B] items-center justify-center transition-colors shrink-0"
                        :title="sidebarCollapsed ? '{{ __('توسيع القائمة') }}' : '{{ __('تصغير القائمة') }}'">
                    <svg class="w-4 h-4 transition-transform duration-300 rtl:rotate-180" 
                         :class="{ 'rotate-180 rtl:rotate-0': sidebarCollapsed }" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>

                <!-- Mobile Close Button -->
                <button type="button" 
                        @click="mobileSidebarOpen = false" 
                        class="flex lg:hidden w-8 h-8 rounded-lg bg-gray-100 text-[#71717A] items-center justify-center">
                    ✕
                </button>
            </div>

            <!-- Sidebar Navigation Menu -->
            <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1.5 admin-scrollbar">
                
                {{-- Dashboard --}}
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-[#C5A059] text-white shadow-sm' : 'text-[#52525B] hover:bg-[#F8F6F2] hover:text-[#18181B]' }}"
                   :class="sidebarCollapsed ? 'justify-center px-2' : ''"
                   title="{{ __('الرئيسية والإحصائيات') }}">
                    <span class="text-lg shrink-0">📊</span>
                    <span x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms class="truncate">{{ __('الرئيسية والإحصائيات') }}</span>
                </a>

                {{-- Products & Stock --}}
                <a href="{{ route('admin.products.index') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('admin.products.*') ? 'bg-[#C5A059] text-white shadow-sm' : 'text-[#52525B] hover:bg-[#F8F6F2] hover:text-[#18181B]' }}"
                   :class="sidebarCollapsed ? 'justify-center px-2' : ''"
                   title="{{ __('المنتجات والمخزون') }}">
                    <span class="text-lg shrink-0">⌚</span>
                    <span x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms class="truncate">{{ __('المنتجات والمخزون') }}</span>
                </a>

                {{-- Categories --}}
                <a href="{{ route('admin.categories.index') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('admin.categories.*') ? 'bg-[#C5A059] text-white shadow-sm' : 'text-[#52525B] hover:bg-[#F8F6F2] hover:text-[#18181B]' }}"
                   :class="sidebarCollapsed ? 'justify-center px-2' : ''"
                   title="{{ __('التصنيفات والأقسام') }}">
                    <span class="text-lg shrink-0">📁</span>
                    <span x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms class="truncate">{{ __('التصنيفات والأقسام') }}</span>
                </a>

                {{-- Bundles --}}
                <a href="{{ route('admin.bundles.index') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('admin.bundles.*') ? 'bg-[#C5A059] text-white shadow-sm' : 'text-[#52525B] hover:bg-[#F8F6F2] hover:text-[#18181B]' }}"
                   :class="sidebarCollapsed ? 'justify-center px-2' : ''"
                   title="{{ __('العروض المجمعة (Bundles)') }}">
                    <span class="text-lg shrink-0">🎁</span>
                    <span x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms class="truncate">{{ __('العروض المجمعة (Bundles)') }}</span>
                </a>

                {{-- Deals --}}
                <a href="{{ route('admin.deals.index') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('admin.deals.*') ? 'bg-[#C5A059] text-white shadow-sm' : 'text-[#52525B] hover:bg-[#F8F6F2] hover:text-[#18181B]' }}"
                   :class="sidebarCollapsed ? 'justify-center px-2' : ''"
                   title="{{ __('التخفيضات الخاصة') }}">
                    <span class="text-lg shrink-0">🏷️</span>
                    <span x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms class="truncate">{{ __('التخفيضات الخاصة') }}</span>
                </a>

                {{-- Orders --}}
                <a href="{{ route('admin.orders.index') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('admin.orders.*') ? 'bg-[#C5A059] text-white shadow-sm' : 'text-[#52525B] hover:bg-[#F8F6F2] hover:text-[#18181B]' }}"
                   :class="sidebarCollapsed ? 'justify-center px-2' : ''"
                   title="{{ __('إدارة الطلبات') }}">
                    <span class="text-lg shrink-0">📦</span>
                    <span x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms class="truncate">{{ __('إدارة الطلبات') }}</span>
                </a>

                {{-- Abandoned Carts --}}
                <a href="{{ route('admin.abandoned-carts.index') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('admin.abandoned-carts.*') ? 'bg-[#C5A059] text-white shadow-sm' : 'text-[#52525B] hover:bg-[#F8F6F2] hover:text-[#18181B]' }}"
                   :class="sidebarCollapsed ? 'justify-center px-2' : ''"
                   title="{{ __('السلات المتروكة') }}">
                    <span class="text-lg shrink-0">🛒</span>
                    <span x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms class="truncate">{{ __('السلات المتروكة') }}</span>
                </a>

                {{-- Analytics --}}
                <a href="{{ route('admin.analytics.index') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('admin.analytics.*') ? 'bg-[#C5A059] text-white shadow-sm' : 'text-[#52525B] hover:bg-[#F8F6F2] hover:text-[#18181B]' }}"
                   :class="sidebarCollapsed ? 'justify-center px-2' : ''"
                   title="{{ __('تحليلات واتساب') }}">
                    <span class="text-lg shrink-0">💬</span>
                    <span x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms class="truncate">{{ __('تحليلات واتساب') }}</span>
                </a>

                {{-- Reports --}}
                <a href="{{ route('admin.reports.index') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('admin.reports.*') ? 'bg-[#C5A059] text-white shadow-sm' : 'text-[#52525B] hover:bg-[#F8F6F2] hover:text-[#18181B]' }}"
                   :class="sidebarCollapsed ? 'justify-center px-2' : ''"
                   title="{{ __('التقارير الشاملة') }}">
                    <span class="text-lg shrink-0">📊</span>
                    <span x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms class="truncate">{{ __('التقارير الشاملة') }}</span>
                </a>

                {{-- Banners --}}
                <a href="{{ route('admin.banners.index') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('admin.banners.*') ? 'bg-[#C5A059] text-white shadow-sm' : 'text-[#52525B] hover:bg-[#F8F6F2] hover:text-[#18181B]' }}"
                   :class="sidebarCollapsed ? 'justify-center px-2' : ''"
                   title="{{ __('البانرات والإعلانات') }}">
                    <span class="text-lg shrink-0">🖼️</span>
                    <span x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms class="truncate">{{ __('البانرات والإعلانات') }}</span>
                </a>

                <div class="border-t border-[#EADBCC] my-2"></div>

                {{-- Users --}}
                <a href="{{ route('admin.users.index') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('admin.users.*') ? 'bg-[#C5A059] text-white shadow-sm' : 'text-[#52525B] hover:bg-[#F8F6F2] hover:text-[#18181B]' }}"
                   :class="sidebarCollapsed ? 'justify-center px-2' : ''"
                   title="{{ __('المستخدمين والأدوار') }}">
                    <span class="text-lg shrink-0">👥</span>
                    <span x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms class="truncate">{{ __('المستخدمين والأدوار') }}</span>
                </a>

                {{-- Settings --}}
                <a href="{{ route('admin.settings.index') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('admin.settings.*') ? 'bg-[#C5A059] text-white shadow-sm' : 'text-[#52525B] hover:bg-[#F8F6F2] hover:text-[#18181B]' }}"
                   :class="sidebarCollapsed ? 'justify-center px-2' : ''"
                   title="{{ __('إعدادات المتجر') }}">
                    <span class="text-lg shrink-0">⚙️</span>
                    <span x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms class="truncate">{{ __('إعدادات المتجر') }}</span>
                </a>

                {{-- Live Store Preview --}}
                <div class="pt-2">
                    <a href="{{ route('site.home') }}" 
                       target="_blank" 
                       class="flex items-center gap-2 w-full py-2.5 px-3 rounded-xl bg-[#F8F6F2] hover:bg-[#EADBCC] text-[#18181B] text-xs font-bold border border-[#EADBCC] transition-all"
                       :class="sidebarCollapsed ? 'justify-center px-2' : 'justify-center'"
                       title="{{ __('معاينة المتجر') }}">
                        <span class="text-base shrink-0">👁️</span>
                        <span x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms class="truncate">{{ __('معاينة المتجر') }}</span>
                    </a>
                </div>

            </nav>

            <!-- Bottom Profile / Logout -->
            <div class="p-3 sm:p-4 border-t border-[#EADBCC] bg-[#F8F6F2]/60">
                <div class="flex items-center gap-3" :class="sidebarCollapsed ? 'justify-center' : ''">
                    <div class="w-8 h-8 rounded-full bg-[#18181B] text-[#C5A059] flex items-center justify-center font-bold text-xs shrink-0">
                        {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                    </div>
                    <div x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms class="min-w-0 flex-1">
                        <p class="text-xs font-bold text-[#18181B] truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
                        <span class="text-[10px] text-[#C5A059] block truncate">{{ __('المدير العام') }}</span>
                    </div>
                    <form x-show="!sidebarCollapsed" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-red-500 hover:text-red-700 p-1 cursor-pointer" title="{{ __('تسجيل الخروج') }}">
                            🚪
                        </button>
                    </form>
                </div>
            </div>

        </aside>

        <!-- 2. Main Content Viewport -->
        <div class="flex-1 flex flex-col min-w-0 h-full overflow-y-auto">
            
            <!-- Sticky Top Header -->
            <header class="h-20 px-4 sm:px-8 bg-white/95 backdrop-blur-md border-b border-[#EADBCC] flex items-center justify-between sticky top-0 z-20 shrink-0">
                
                <!-- Left: Sidebar Toggle Button (Desktop Collapse + Mobile Open) & Search -->
                <div class="flex items-center gap-3 sm:gap-4 flex-1 max-w-xl">
                    
                    <!-- Toggle Sidebar Button (For Desktop & Mobile) -->
                    <button type="button" 
                            @click="if (window.innerWidth >= 1024) { toggleSidebar(); } else { mobileSidebarOpen = !mobileSidebarOpen; }"
                            class="w-10 h-10 rounded-xl border border-[#EADBCC] bg-[#F8F6F2] hover:bg-[#EADBCC] text-[#18181B] flex items-center justify-center transition-all shadow-xs shrink-0 cursor-pointer"
                            title="{{ __('تبديل إظهار / إخفاء القائمة الجانبية') }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>

                    <!-- Search Input -->
                    <div class="relative w-full max-w-md hidden sm:block">
                        <input type="text" 
                               placeholder="{{ __('ابحث عن منتجات، طلبات، عملاء...') }}" 
                               class="w-full ps-10 pe-4 py-2.5 text-xs bg-[#F8F6F2] border border-[#EADBCC] rounded-xl text-[#18181B] placeholder-[#71717A] focus:outline-none focus:border-[#C5A059] focus:bg-white transition-all">
                        <span class="absolute inset-y-0 start-0 flex items-center ps-3 text-[#71717A] pointer-events-none">🔍</span>
                    </div>
                </div>

                <!-- Right: Language & Profile Controls -->
                <div class="flex items-center gap-3">
                    
                    {{-- Quick Store Link --}}
                    <a href="{{ route('site.home') }}" target="_blank" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-[#F8F6F2] hover:bg-[#EADBCC] border border-[#EADBCC] text-xs font-semibold text-[#18181B] transition-colors">
                        <span>🛍️</span>
                        <span>{{ __('زيارة المتجر') }}</span>
                    </a>

                    {{-- Language Switcher --}}
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" type="button" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl border border-[#EADBCC] bg-[#F8F6F2] text-xs font-semibold text-[#18181B] cursor-pointer">
                            <span>🌐 {{ app()->getLocale() === 'ar' ? 'العربية' : 'English' }}</span>
                        </button>
                        <div x-show="open" @click.outside="open = false" class="absolute end-0 mt-1 w-32 rounded-xl bg-white border border-[#EADBCC] shadow-xl py-1 z-50" style="display: none;">
                            <a href="{{ route('change.language', 'ar') }}" class="block px-4 py-2 text-xs text-[#18181B] hover:bg-[#F8F6F2]">العربية</a>
                            <a href="{{ route('change.language', 'en') }}" class="block px-4 py-2 text-xs text-[#18181B] hover:bg-[#F8F6F2]">English</a>
                        </div>
                    </div>
                </div>

            </header>

            <!-- Page Body -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                @yield('content')
            </main>

        </div>

    </div>

    {{-- =========================================================================
         LUXURY DELETE CONFIRMATION MODAL (No native browser alerts)
         ========================================================================= --}}
    <div id="deleteModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-[#18181B]/60 backdrop-blur-sm opacity-0 pointer-events-none transition-all duration-200">
        <div class="relative w-full max-w-md bg-white border border-[#EADBCC] rounded-2xl shadow-2xl p-6 sm:p-7 text-center transform scale-95 transition-all duration-200" id="deleteModalCard">
            {{-- Icon Badge --}}
            <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-600 flex items-center justify-center text-3xl shadow-xs">
                ⚠️
            </div>

            <h3 class="text-xl font-bold text-[#18181B] mb-2" id="deleteModalTitle">
                {{ __('تأكيد عملية الحذف') }}
            </h3>
            <p class="text-xs sm:text-sm text-[#71717A] mb-6 leading-relaxed" id="deleteModalMessage">
                {{ __('هل أنت متأكد من رغبتك في حذف هذا العنصر؟ لن يمكنك التراجع عن هذه العملية لاحقاً.') }}
            </p>

            <div class="flex items-center justify-center gap-3">
                <button type="button" onclick="closeDeleteModal()" class="px-5 py-2.5 rounded-xl border border-[#EADBCC] bg-[#F8F6F2] hover:bg-[#EDE8DC] text-[#18181B] text-xs sm:text-sm font-semibold transition-colors flex-1 cursor-pointer">
                    {{ __('إلغاء') }}
                </button>
                <button type="button" id="deleteModalConfirmBtn" class="px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs sm:text-sm font-semibold shadow-sm transition-all flex-1 cursor-pointer">
                    {{ __('نعم، احذف') }}
                </button>
            </div>
        </div>
    </div>

    {{-- =========================================================================
         LUXURY TOASTER NOTIFICATIONS CONTAINER
         ========================================================================= --}}
    <div id="toastContainer" class="fixed top-6 end-6 z-50 flex flex-col gap-3 max-w-sm w-full pointer-events-none">
        {{-- Flash session toasts rendered from backend --}}
        @if (session('success'))
            <div class="toast-item pointer-events-auto flex items-start gap-3 p-4 rounded-2xl bg-white border border-emerald-200 shadow-xl transition-all transform translate-y-0 opacity-100">
                <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg shrink-0 border border-emerald-200">
                    ✓
                </div>
                <div class="flex-1 min-w-0 pt-0.5">
                    <h5 class="text-xs font-bold text-[#18181B]">{{ __('تم بنجاح') }}</h5>
                    <p class="text-xs text-[#71717A] mt-0.5 leading-relaxed">{{ session('success') }}</p>
                </div>
                <button type="button" onclick="this.closest('.toast-item').remove()" class="text-[#A1A1AA] hover:text-[#18181B] text-xs p-1">✕</button>
            </div>
        @endif

        @if (session('error'))
            <div class="toast-item pointer-events-auto flex items-start gap-3 p-4 rounded-2xl bg-white border border-rose-200 shadow-xl transition-all transform translate-y-0 opacity-100">
                <div class="w-9 h-9 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-lg shrink-0 border border-rose-200">
                    ✕
                </div>
                <div class="flex-1 min-w-0 pt-0.5">
                    <h5 class="text-xs font-bold text-rose-700">{{ __('تنبيه خطأ') }}</h5>
                    <p class="text-xs text-[#71717A] mt-0.5 leading-relaxed">{{ session('error') }}</p>
                </div>
                <button type="button" onclick="this.closest('.toast-item').remove()" class="text-[#A1A1AA] hover:text-[#18181B] text-xs p-1">✕</button>
            </div>
        @endif

        @if (session('info'))
            <div class="toast-item pointer-events-auto flex items-start gap-3 p-4 rounded-2xl bg-white border border-[#EADBCC] shadow-xl transition-all transform translate-y-0 opacity-100">
                <div class="w-9 h-9 rounded-xl bg-[#F8F6F2] text-[#C5A059] flex items-center justify-center text-lg shrink-0 border border-[#EADBCC]">
                    ℹ
                </div>
                <div class="flex-1 min-w-0 pt-0.5">
                    <h5 class="text-xs font-bold text-[#18181B]">{{ __('إشعار') }}</h5>
                    <p class="text-xs text-[#71717A] mt-0.5 leading-relaxed">{{ session('info') }}</p>
                </div>
                <button type="button" onclick="this.closest('.toast-item').remove()" class="text-[#A1A1AA] hover:text-[#18181B] text-xs p-1">✕</button>
            </div>
        @endif
    </div>

    {{-- System Core Modal & Toast Script --}}
    <script>
        let pendingFormToSubmit = null;

        // Custom Show Toast Function (Callable from anywhere: showToast('تم الحفظ', 'success'))
        function showToast(message, type = 'success') {
            const container = document.getElementById('toastContainer');
            if (!container) return;

            const toast = document.createElement('div');
            toast.className = `toast-item pointer-events-auto flex items-start gap-3 p-4 rounded-2xl bg-white border shadow-xl transition-all duration-300 transform translate-y-2 opacity-0 ${
                type === 'success' ? 'border-emerald-200' : (type === 'error' ? 'border-rose-200' : 'border-[#EADBCC]')
            }`;

            const icon = type === 'success' ? '✓' : (type === 'error' ? '✕' : 'ℹ');
            const iconBg = type === 'success' ? 'bg-emerald-50 text-emerald-600 border-emerald-200' : (type === 'error' ? 'bg-rose-50 text-rose-600 border-rose-200' : 'bg-[#F8F6F2] text-[#C5A059] border-[#EADBCC]');
            const title = type === 'success' ? '{{ __("تم بنجاح") }}' : (type === 'error' ? '{{ __("خطأ") }}' : '{{ __("إشعار") }}');

            toast.innerHTML = `
                <div class="w-9 h-9 rounded-xl ${iconBg} flex items-center justify-center text-lg shrink-0 border">
                    ${icon}
                </div>
                <div class="flex-1 min-w-0 pt-0.5">
                    <h5 class="text-xs font-bold text-[#18181B]">${title}</h5>
                    <p class="text-xs text-[#71717A] mt-0.5 leading-relaxed">${message}</p>
                </div>
                <button type="button" onclick="this.closest('.toast-item').remove()" class="text-[#A1A1AA] hover:text-[#18181B] text-xs p-1">✕</button>
            `;

            container.appendChild(toast);

            // Animate in
            requestAnimationFrame(() => {
                toast.classList.remove('translate-y-2', 'opacity-0');
                toast.classList.add('translate-y-0', 'opacity-100');
            });

            // Auto dismiss after 4 seconds
            setTimeout(() => {
                toast.classList.add('opacity-0', '-translate-y-2');
                setTimeout(() => toast.remove(), 300);
            }, 4000);
        }

        // Auto dismiss existing session toasts
        document.addEventListener('DOMContentLoaded', () => {
            const existingToasts = document.querySelectorAll('.toast-item');
            existingToasts.forEach((toast) => {
                setTimeout(() => {
                    toast.classList.add('opacity-0', '-translate-y-2');
                    setTimeout(() => toast.remove(), 300);
                }, 4500);
            });
        });

        // Luxury Delete Modal Handlers
        function openDeleteModal(form, message = null) {
            pendingFormToSubmit = form;
            const modal = document.getElementById('deleteModal');
            const modalMsg = document.getElementById('deleteModalMessage');
            const card = document.getElementById('deleteModalCard');

            if (message && modalMsg) {
                modalMsg.innerText = message;
            } else if (modalMsg) {
                modalMsg.innerText = '{{ __("هل أنت متأكد من رغبتك في حذف هذا العنصر؟ لن يمكنك التراجع عن هذه العملية لاحقاً.") }}';
            }

            modal.classList.remove('opacity-0', 'pointer-events-none');
            modal.classList.add('opacity-100', 'pointer-events-auto');
            card.classList.remove('scale-95');
            card.classList.add('scale-100');
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            const card = document.getElementById('deleteModalCard');
            modal.classList.remove('opacity-100', 'pointer-events-auto');
            modal.classList.add('opacity-0', 'pointer-events-none');
            card.classList.remove('scale-100');
            card.classList.add('scale-95');
            pendingFormToSubmit = null;
        }

        document.getElementById('deleteModalConfirmBtn')?.addEventListener('click', () => {
            if (pendingFormToSubmit) {
                pendingFormToSubmit.dataset.confirmed = "true";
                pendingFormToSubmit.submit();
            }
            closeDeleteModal();
        });

        // Intercept all forms with DELETE method or [data-confirm] to use Luxury Modal instead of window.confirm
        document.addEventListener('submit', function(e) {
            const form = e.target;
            const isDelete = form.querySelector('input[name="_method"][value="DELETE"]') || form.hasAttribute('data-confirm');
            
            // If already confirmed by modal or is not delete/confirm form, let it pass
            if (!isDelete || form.dataset.confirmed === "true") {
                return;
            }

            e.preventDefault();
            e.stopPropagation();

            // Extract custom message if present
            const customMessage = form.getAttribute('data-confirm-message') || null;
            openDeleteModal(form, customMessage);
        }, true);
    </script>

    @stack('scripts')
</body>
</html>