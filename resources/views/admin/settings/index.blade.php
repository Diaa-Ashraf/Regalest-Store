@extends('layouts.admin')

@section('title', __('إعدادات المتجر العامة'))

@section('content')
<div class="max-w-6xl mx-auto space-y-6" x-data="{ activeTab: 'general' }">
    
    <!-- Header -->
    <div class="bg-white border border-[#EADBCC] rounded-2xl p-6 sm:p-8 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="text-xs font-bold text-[#C5A059] uppercase tracking-wider">⚙️ Global Configurations</span>
            </div>
            <h1 class="font-cinzel text-2xl sm:text-3xl font-bold text-[#18181B]">
                {{ __('إعدادات المتجر وهوية الموقع') }}
            </h1>
            <p class="text-xs sm:text-sm text-[#71717A] mt-1">
                {{ __('تخصيص أسماء وروابط المتجر، العملات وسعر الصرف، نصوص الفوتر، وسائل التواصل، وبيانات الاتصال.') }}
            </p>
        </div>

        <a href="{{ route('site.home') }}" target="_blank" class="px-4 py-2.5 rounded-xl border border-[#EADBCC] bg-[#F8F6F2] hover:bg-[#EADBCC] text-[#18181B] text-xs font-bold transition-all flex items-center gap-2 shadow-sm shrink-0">
            <span>👁️</span>
            <span>{{ __('معاينة المتجر المباشر') }}</span>
        </a>
    </div>

    @if (session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-bold flex items-center gap-2">
            <span>✓</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-medium">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Container -->
    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Tabs Navigation -->
        <div class="flex items-center gap-2 border-b border-[#EADBCC] overflow-x-auto pb-px">
            <button type="button" 
                    @click="activeTab = 'general'"
                    :class="activeTab === 'general' ? 'border-[#C5A059] text-[#18181B] font-bold bg-white' : 'border-transparent text-gray-500 hover:text-[#18181B]'"
                    class="px-5 py-3 text-xs border-b-2 rounded-t-xl transition-all flex items-center gap-2 shrink-0">
                <span>🏢</span>
                <span>{{ __('عام والتسعير والعملات') }}</span>
            </button>
            <button type="button" 
                    @click="activeTab = 'footer'"
                    :class="activeTab === 'footer' ? 'border-[#C5A059] text-[#18181B] font-bold bg-white' : 'border-transparent text-gray-500 hover:text-[#18181B]'"
                    class="px-5 py-3 text-xs border-b-2 rounded-t-xl transition-all flex items-center gap-2 shrink-0">
                <span>📜</span>
                <span>{{ __('نصوص الفوتر والخدمات') }}</span>
            </button>
            <button type="button" 
                    @click="activeTab = 'contact'"
                    :class="activeTab === 'contact' ? 'border-[#C5A059] text-[#18181B] font-bold bg-white' : 'border-transparent text-gray-500 hover:text-[#18181B]'"
                    class="px-5 py-3 text-xs border-b-2 rounded-t-xl transition-all flex items-center gap-2 shrink-0">
                <span>💬</span>
                <span>{{ __('التواصل وواتساب') }}</span>
            </button>
            <button type="button" 
                    @click="activeTab = 'social'"
                    :class="activeTab === 'social' ? 'border-[#C5A059] text-[#18181B] font-bold bg-white' : 'border-transparent text-gray-500 hover:text-[#18181B]'"
                    class="px-5 py-3 text-xs border-b-2 rounded-t-xl transition-all flex items-center gap-2 shrink-0">
                <span>🌐</span>
                <span>{{ __('شبكات التواصل') }}</span>
            </button>
            <button type="button" 
                    @click="activeTab = 'features'"
                    :class="activeTab === 'features' ? 'border-[#C5A059] text-[#18181B] font-bold bg-white' : 'border-transparent text-gray-500 hover:text-[#18181B]'"
                    class="px-5 py-3 text-xs border-b-2 rounded-t-xl transition-all flex items-center gap-2 shrink-0">
                <span>🔒</span>
                <span>{{ __('الميزات و Google OAuth') }}</span>
            </button>
        </div>

        <!-- Tab 1: General & Currency -->
        <div x-show="activeTab === 'general'" class="bg-white border border-[#EADBCC] rounded-2xl p-6 sm:p-8 shadow-sm space-y-6">
            <h2 class="text-base font-bold text-[#18181B] pb-3 border-b border-[#EADBCC] flex items-center gap-2">
                <span>🏢</span>
                <span>{{ __('بيانات المتجر والعملة وسعر الصرف') }}</span>
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2">{{ __('اسم المتجر (Site Name)') }} <span class="text-rose-500">*</span></label>
                    <input type="text" name="settings[site_name]" value="{{ $settings['site_name'] ?? 'Regalest Store' }}" required
                           class="w-full px-4 py-2.5 text-xs rounded-xl bg-[#F8F6F2] border border-[#EADBCC] text-[#18181B] focus:outline-none focus:ring-2 focus:ring-[#C5A059] focus:bg-white">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2">{{ __('العملة الافتراضية للتسعير') }}</label>
                    <select name="settings[default_currency]" class="w-full px-4 py-2.5 text-xs rounded-xl bg-[#F8F6F2] border border-[#EADBCC] text-[#18181B] focus:outline-none focus:ring-2 focus:ring-[#C5A059] focus:bg-white">
                        <option value="USD" selected>دولار أمريكي (USD $)</option>
                    </select>
                </div>

                {{-- Site Main Logo --}}
                <div class="bg-[#FAF8F5] border border-[#EADBCC] p-4 rounded-2xl space-y-3">
                    <div class="flex items-center justify-between">
                        <label class="block text-xs font-bold text-gray-800">
                            👑 {{ __('شعار المتجر الرئيسي (Logo)') }}
                        </label>
                        <span class="text-[10px] text-gray-400">يظهر في الهيدر والفوتر</span>
                    </div>
                    <input type="file" name="site_logo" accept="image/*"
                           class="w-full px-3 py-2 text-xs rounded-xl bg-white border border-[#EADBCC] text-[#18181B] focus:outline-none file:me-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#18181B] file:text-white cursor-pointer">
                    
                    @php
                        $currentLogo = get_site_logo();
                    @endphp
                    @if($currentLogo)
                        <div class="p-3 rounded-xl bg-[#18181B] border border-gray-700 flex items-center justify-between gap-4">
                            <span class="text-[10px] text-[#C5A059] font-bold">المعاينة الحالية للشعار:</span>
                            <img src="{{ $currentLogo }}" alt="Site Logo" class="h-9 max-w-[140px] object-contain">
                        </div>
                    @else
                        <span class="text-[10px] text-gray-400 block italic">لم يتم رفع شعار مخصص (يتم استخدام النص الملكي كشعار افتراضي)</span>
                    @endif
                </div>

                {{-- Site Favicon (Browser Tab Icon) --}}
                <div class="bg-[#FAF8F5] border border-[#EADBCC] p-4 rounded-2xl space-y-3">
                    <div class="flex items-center justify-between">
                        <label class="block text-xs font-bold text-gray-800">
                            📑 {{ __('أيقونة التاب في المتصفح (Favicon)') }}
                        </label>
                        <span class="text-[10px] text-gray-400">تظهر بجانب اسم الصفحة بالمتصفح</span>
                    </div>
                    <input type="file" name="site_favicon" accept="image/x-icon,image/png,image/svg+xml,image/jpeg,image/webp"
                           class="w-full px-3 py-2 text-xs rounded-xl bg-white border border-[#EADBCC] text-[#18181B] focus:outline-none file:me-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#18181B] file:text-white cursor-pointer">
                    
                    @php
                        $currentFavicon = get_site_favicon();
                    @endphp
                    @if($currentFavicon)
                        <div class="p-3 rounded-xl bg-white border border-[#EADBCC] flex items-center justify-between gap-4">
                            <div class="flex items-center gap-2">
                                <img src="{{ $currentFavicon }}" alt="Favicon" class="w-7 h-7 object-contain rounded-md border p-0.5">
                                <span class="text-[11px] font-medium text-gray-700">أيقونة التاب الحالية</span>
                            </div>
                            <span class="text-[10px] text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200 font-bold">مفعلة ✓</span>
                        </div>
                    @else
                        <span class="text-[10px] text-gray-400 block italic">لم يتم رفع أيقونة تاب (Favicon)</span>
                    @endif
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2">{{ __('سعر الصرف اليومي (USD → SYP)') }} <span class="text-rose-500">*</span></label>
                    <input type="number" step="1" name="settings[exchange_rate]" value="{{ $settings['exchange_rate'] ?? 15000 }}" required
                           class="w-full px-4 py-2.5 text-xs rounded-xl bg-[#F8F6F2] border border-[#EADBCC] text-[#18181B] focus:outline-none focus:ring-2 focus:ring-[#C5A059] focus:bg-white font-mono">
                    <span class="text-[11px] text-[#C5A059] mt-1 block font-medium">سعر صرف 1 دولار بالليرة السورية لكافة حسابات المتجر</span>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2">{{ __('نسبة الضريبة المضافة (%)') }}</label>
                    <input type="number" step="0.1" name="settings[tax_rate]" value="{{ $settings['tax_rate'] ?? 0 }}"
                           class="w-full px-4 py-2.5 text-xs rounded-xl bg-[#F8F6F2] border border-[#EADBCC] text-[#18181B] focus:outline-none focus:ring-2 focus:ring-[#C5A059] focus:bg-white font-mono">
                </div>
            </div>
        </div>

        <!-- Tab 2: Footer & Content Customization -->
        <div x-show="activeTab === 'footer'" style="display: none;" class="bg-white border border-[#EADBCC] rounded-2xl p-6 sm:p-8 shadow-sm space-y-6">
            <h2 class="text-base font-bold text-[#18181B] pb-3 border-b border-[#EADBCC] flex items-center gap-2">
                <span>📜</span>
                <span>{{ __('تخصيص نصوص الفوتر ورسائل المتجر') }}</span>
            </h2>

            <div class="space-y-5">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2">{{ __('الشعار الفرعي (Slogan / Subtitle)') }}</label>
                    <input type="text" name="settings[site_slogan]" value="{{ $settings['site_slogan'] ?? 'Haute Horlogerie • المتجر الفاخر للهدايا والمقتنيات' }}"
                           class="w-full px-4 py-2.5 text-xs rounded-xl bg-[#F8F6F2] border border-[#EADBCC] text-[#18181B] focus:outline-none focus:ring-2 focus:ring-[#C5A059] focus:bg-white">
                    <span class="text-[11px] text-gray-400 mt-1 block">يظهر تحت اسم المتجر في الفوتر ورأس الصفحة</span>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2">{{ __('نبذة المتجر في الفوتر (About text)') }}</label>
                    <textarea name="settings[footer_about]" rows="3"
                              class="w-full px-4 py-2.5 text-xs rounded-xl bg-[#F8F6F2] border border-[#EADBCC] text-[#18181B] focus:outline-none focus:ring-2 focus:ring-[#C5A059] focus:bg-white leading-relaxed">{{ $settings['footer_about'] ?? 'وجهتك الأولى لاقتناء أرقى الهدايا، الإكسسوارات، والقطع الفنية الكلاسيكية المصممة بأعلى معايير الحرفية مع شحن موثوق.' }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2">{{ __('مواعيد وساعات خدمة العملاء') }}</label>
                        <input type="text" name="settings[working_hours]" value="{{ $settings['working_hours'] ?? 'يومياً 10:00 ص - 11:00 م' }}"
                               class="w-full px-4 py-2.5 text-xs rounded-xl bg-[#F8F6F2] border border-[#EADBCC] text-[#18181B] focus:outline-none focus:ring-2 focus:ring-[#C5A059] focus:bg-white">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2">{{ __('نص طرق الدفع والتوصيل بالفوتر') }}</label>
                        <input type="text" name="settings[payment_methods_text]" value="{{ $settings['payment_methods_text'] ?? 'دفع عند الاستلام نقداً في كافة المحافظات أو تحويل فوري عبر سيريتل كاش وبيمو بنك.' }}"
                               class="w-full px-4 py-2.5 text-xs rounded-xl bg-[#F8F6F2] border border-[#EADBCC] text-[#18181B] focus:outline-none focus:ring-2 focus:ring-[#C5A059] focus:bg-white">
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab 3: Contact & WhatsApp -->
        <div x-show="activeTab === 'contact'" style="display: none;" class="bg-white border border-[#EADBCC] rounded-2xl p-6 sm:p-8 shadow-sm space-y-6">
            <h2 class="text-base font-bold text-[#18181B] pb-3 border-b border-[#EADBCC] flex items-center gap-2">
                <span>💬</span>
                <span>{{ __('بيانات التواصل واستقبال طلبات واتساب') }}</span>
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2">{{ __('رقم الواتساب الرسمي للطلبات (WhatsApp Number)') }} <span class="text-rose-500">*</span></label>
                    <input type="text" name="settings[whatsapp_number]" value="{{ $settings['whatsapp_number'] ?? '+963999999999' }}" required
                           class="w-full px-4 py-2.5 text-xs rounded-xl bg-[#F8F6F2] border border-[#EADBCC] text-[#18181B] focus:outline-none focus:ring-2 focus:ring-[#C5A059] focus:bg-white font-mono">
                    <span class="text-[11px] text-gray-400 mt-1 block">يشمل رمز الدولة بدون فواصل مثل: 963987654321+</span>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2">{{ __('رقم الهاتف المباشر') }}</label>
                    <input type="text" name="settings[phone]" value="{{ $settings['phone'] ?? '' }}"
                           class="w-full px-4 py-2.5 text-xs rounded-xl bg-[#F8F6F2] border border-[#EADBCC] text-[#18181B] focus:outline-none focus:ring-2 focus:ring-[#C5A059] focus:bg-white font-mono">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2">{{ __('البريد الإلكتروني للدعم') }}</label>
                    <input type="email" name="settings[email]" value="{{ $settings['email'] ?? 'info@regalest.com' }}"
                           class="w-full px-4 py-2.5 text-xs rounded-xl bg-[#F8F6F2] border border-[#EADBCC] text-[#18181B] focus:outline-none focus:ring-2 focus:ring-[#C5A059] focus:bg-white">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2">{{ __('العنوان أو صالة العرض (Store Address)') }}</label>
                    <input type="text" name="settings[store_address]" value="{{ $settings['store_address'] ?? 'دمشق، سوريا • شحن لكافة المحافظات' }}"
                           class="w-full px-4 py-2.5 text-xs rounded-xl bg-[#F8F6F2] border border-[#EADBCC] text-[#18181B] focus:outline-none focus:ring-2 focus:ring-[#C5A059] focus:bg-white">
                </div>
            </div>
        </div>

        <!-- Tab 4: Social Media -->
        <div x-show="activeTab === 'social'" style="display: none;" class="bg-white border border-[#EADBCC] rounded-2xl p-6 sm:p-8 shadow-sm space-y-6">
            <h2 class="text-base font-bold text-[#18181B] pb-3 border-b border-[#EADBCC] flex items-center gap-2">
                <span>🌐</span>
                <span>{{ __('روابط حسابات التواصل الاجتماعي') }}</span>
            </h2>

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2">{{ __('رابط صفحة فيسبوك (Facebook URL)') }}</label>
                    <input type="url" name="settings[facebook_link]" value="{{ $settings['facebook_link'] ?? '' }}" placeholder="https://facebook.com/..."
                           class="w-full px-4 py-2.5 text-xs rounded-xl bg-[#F8F6F2] border border-[#EADBCC] text-[#18181B] focus:outline-none focus:ring-2 focus:ring-[#C5A059] focus:bg-white">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2">{{ __('رابط حساب انستغرام (Instagram URL)') }}</label>
                    <input type="url" name="settings[instagram_link]" value="{{ $settings['instagram_link'] ?? '' }}" placeholder="https://instagram.com/..."
                           class="w-full px-4 py-2.5 text-xs rounded-xl bg-[#F8F6F2] border border-[#EADBCC] text-[#18181B] focus:outline-none focus:ring-2 focus:ring-[#C5A059] focus:bg-white">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2">{{ __('رابط منصة X (تويتر)') }}</label>
                    <input type="url" name="settings[twitter_link]" value="{{ $settings['twitter_link'] ?? '' }}" placeholder="https://x.com/..."
                           class="w-full px-4 py-2.5 text-xs rounded-xl bg-[#F8F6F2] border border-[#EADBCC] text-[#18181B] focus:outline-none focus:ring-2 focus:ring-[#C5A059] focus:bg-white">
                </div>
            </div>
        </div>

        <!-- Tab 5: Feature Flags -->
        <div x-show="activeTab === 'features'" style="display: none;" class="bg-white border border-[#EADBCC] rounded-2xl p-6 sm:p-8 shadow-sm space-y-6">
            <h2 class="text-base font-bold text-[#18181B] pb-3 border-b border-[#EADBCC] flex items-center gap-2">
                <span>🔒</span>
                <span>{{ __('ميزات وبوابات تسجيل الدخول والخدمات') }}</span>
            </h2>

            <div class="space-y-4">
                <div class="p-4 rounded-2xl bg-[#F8F6F2] border border-[#EADBCC] flex items-start gap-4">
                    <input type="checkbox" name="settings[google_oauth_enabled]" value="1" id="googleOauthSwitch" 
                           {{ !empty($settings['google_oauth_enabled']) ? 'checked' : '' }}
                           class="mt-1 w-5 h-5 rounded text-[#C5A059] focus:ring-[#C5A059] border-gray-300">
                    <div>
                        <label for="googleOauthSwitch" class="block text-xs font-bold text-[#18181B] cursor-pointer">
                            {{ __('تفعيل تسجيل الدخول السريع عبر Google OAuth') }}
                        </label>
                        <p class="text-[11px] text-gray-500 mt-1 leading-relaxed">
                            {{ __('يمكن إيقاف هذا الخيار بسهولة في حال وجود قيود على خدمات جوجل، وسيتم إخفاء زر جوجل تلقائياً من صفحات الدخول والتسجيل.') }}
                        </p>
                    </div>
                </div>

                <div class="p-4 rounded-2xl bg-[#F8F6F2] border border-[#EADBCC] flex items-start gap-4">
                    <input type="checkbox" name="settings[wishlist_enabled]" value="1" id="wishlistSwitch" 
                           {{ !empty($settings['wishlist_enabled']) ? 'checked' : '' }}
                           class="mt-1 w-5 h-5 rounded text-[#C5A059] focus:ring-[#C5A059] border-gray-300">
                    <div>
                        <label for="wishlistSwitch" class="block text-xs font-bold text-[#18181B] cursor-pointer">
                            {{ __('تفعيل قائمة الرغبات والمفضلة (Wishlist)') }}
                        </label>
                        <p class="text-[11px] text-gray-500 mt-1">
                            {{ __('إظهار زر حفظ المنتجات في المفضلة للعملاء.') }}
                        </p>
                    </div>
                </div>

                <div class="p-4 rounded-2xl bg-[#F8F6F2] border border-[#EADBCC] flex items-start gap-4">
                    <input type="checkbox" name="settings[reviews_enabled]" value="1" id="reviewsSwitch" 
                           {{ !empty($settings['reviews_enabled']) ? 'checked' : '' }}
                           class="mt-1 w-5 h-5 rounded text-[#C5A059] focus:ring-[#C5A059] border-gray-300">
                    <div>
                        <label for="reviewsSwitch" class="block text-xs font-bold text-[#18181B] cursor-pointer">
                            {{ __('تفعيل مراجعات وتقييمات المنتجات') }}
                        </label>
                        <p class="text-[11px] text-gray-500 mt-1">
                            {{ __('السماح للعملاء بإضافة تقييماتهم على المنتجات.') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-end gap-3 pt-4">
            <button type="submit" 
                    class="px-8 py-3.5 rounded-xl bg-[#18181B] hover:bg-[#C5A059] text-white text-xs font-bold transition-all shadow-md hover:shadow-lg active:scale-95 flex items-center gap-2">
                <span>💾</span>
                <span>{{ __('حفظ وتطبيق كافة التعديلات') }}</span>
            </button>
        </div>
    </form>
</div>
@endsection
