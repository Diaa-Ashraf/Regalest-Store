<!-- Grounded Luxury Footer (Obsidian & Satin Gold) -->
<footer class="bg-[#18181B] text-[#A1A1AA] border-t border-gray-800 pt-14 pb-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Main Footer Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 pb-10 border-b border-gray-800">
            
            <!-- Col 1: Brand Essence -->
            <div class="space-y-3">
                @php
                    $footerLogo = get_site_logo();
                @endphp
                <a href="{{ route('site.home') }}" class="flex items-center gap-2.5 group">
                    @if($footerLogo)
                        <img src="{{ $footerLogo }}" alt="{{ settings('site_name', 'Regalest Store') }}" class="h-9 max-w-[170px] object-contain">
                    @else
                        <span class="text-2xl">👑</span>
                        <div>
                            <h3 class="font-royal text-lg font-bold tracking-wider text-white group-hover:text-[#C5A059] transition-colors">
                                {{ settings('site_name', 'Regalest Store') }}
                            </h3>
                            <span class="text-[9px] tracking-[0.2em] text-[#C5A059] uppercase block font-medium">
                                {{ settings('site_slogan', __('Haute Horlogerie • المتجر الملكي')) }}
                            </span>
                        </div>
                    @endif
                </a>
                
                <p class="text-xs leading-relaxed text-gray-400">
                    {{ settings('footer_about', __('وجهتك الأولى لاقتناء أرقى ساعات اليد والمقتنيات الكلاسيكية المصممة بأعلى معايير الحرفية والدقة الملكية مع شحن مباشر.')) }}
                </p>

                <!-- Social Icons -->
                @php
                    $storePhone = preg_replace('/[^0-9]/', '', settings('whatsapp_number', '963999999999'));
                    $fbLink = settings('facebook_link', '');
                    $instaLink = settings('instagram_link', '');
                    $xLink = settings('twitter_link', '');
                @endphp
                <div class="flex items-center gap-2 pt-1">
                    <a href="https://wa.me/{{ $storePhone }}" target="_blank" class="w-8 h-8 rounded-full bg-white/10 border border-white/10 flex items-center justify-center text-[#25D366] hover:bg-[#25D366] hover:text-white transition-all shadow-xs" title="WhatsApp">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                    </a>
                    @if($fbLink)
                        <a href="{{ $fbLink }}" target="_blank" class="w-8 h-8 rounded-full bg-white/10 border border-white/10 flex items-center justify-center text-gray-300 hover:bg-[#C5A059] hover:text-white transition-all shadow-xs" title="Facebook">
                            <span class="text-xs font-bold">f</span>
                        </a>
                    @endif
                    @if($instaLink)
                        <a href="{{ $instaLink }}" target="_blank" class="w-8 h-8 rounded-full bg-white/10 border border-white/10 flex items-center justify-center text-gray-300 hover:bg-[#C5A059] hover:text-white transition-all shadow-xs" title="Instagram">
                            <span class="text-xs font-bold">📸</span>
                        </a>
                    @endif
                    @if($xLink)
                        <a href="{{ $xLink }}" target="_blank" class="w-8 h-8 rounded-full bg-white/10 border border-white/10 flex items-center justify-center text-gray-300 hover:bg-[#C5A059] hover:text-white transition-all shadow-xs" title="X">
                            <span class="text-xs font-bold">𝕏</span>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Col 2: Quick Links -->
            <div>
                <h4 class="text-xs font-bold text-white uppercase tracking-wider mb-4 flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#C5A059]"></span>
                    {{ __('استكشف المتجر') }}
                </h4>
                <ul class="space-y-2 text-xs">
                    <li><a href="{{ route('site.home') }}" class="hover:text-[#C5A059] transition-colors">{{ __('الرئيسية') }}</a></li>
                    <li><a href="{{ route('product.shop') }}" class="hover:text-[#C5A059] transition-colors">{{ __('كافة المنتجات والتشكيلات') }}</a></li>
                    <li><a href="{{ route('product.shop', ['bundles_only' => 1]) }}" class="hover:text-[#C5A059] transition-colors flex items-center justify-between"><span>{{ __('باقات موفّرة وعروض') }}</span> <span class="text-[9px] px-1.5 py-0.2 bg-[#C5A059]/20 text-[#C5A059] rounded">💎</span></a></li>
                    <li><a href="{{ route('product.shop', ['discount_only' => 1]) }}" class="hover:text-[#C5A059] transition-colors">{{ __('عروض وتخفيضات خاصة') }}</a></li>
                    <li><a href="{{ route('wishlist.index') }}" class="hover:text-[#C5A059] transition-colors">{{ __('قائمة المفضلة') }}</a></li>
                    <li><a href="{{ route('cart') }}" class="hover:text-[#C5A059] transition-colors">{{ __('سلة المشتريات') }}</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-[#C5A059] transition-colors">{{ __('خدمة العملاء والتواصل') }}</a></li>
                </ul>
            </div>

            <!-- Col 3: Contact & Syrian Delivery -->
            <div>
                <h4 class="text-xs font-bold text-white uppercase tracking-wider mb-4 flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#C5A059]"></span>
                    {{ __('خدمة العملاء والشحن') }}
                </h4>
                <ul class="space-y-2 text-xs text-gray-400">
                    <li class="flex items-center gap-2">
                        <span class="text-[#C5A059]">📍</span>
                        <span>{{ settings('store_address', 'دمشق، سوريا • شحن لكافة المحافظات') }}</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-[#C5A059]">💬</span>
                        <a href="https://wa.me/{{ $storePhone }}" dir="ltr" class="text-white hover:text-[#25D366] font-medium transition-colors">
                            {{ settings('whatsapp_number', '+963 999 999 999') }}
                        </a>
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-[#C5A059]">⏰</span>
                        <span>{{ settings('working_hours', __('خدمة العملاء: يومياً 10:00 ص - 11:00 م')) }}</span>
                    </li>
                </ul>
            </div>

            <!-- Col 4: Syrian Payment & Trust -->
            <div>
                <h4 class="text-xs font-bold text-white uppercase tracking-wider mb-4 flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#C5A059]"></span>
                    {{ __('طرق الدفع والتسليم') }}
                </h4>
                <p class="text-xs text-gray-400 leading-relaxed mb-3">
                    {{ settings('payment_methods_text', __('دفع عند الاستلام نقداً في كافة المحافظات أو تحويل فوري عبر سيريتل كاش وبيمو بنك.')) }}
                </p>
                <div class="flex flex-wrap gap-1.5">
                    <span class="px-2.5 py-1 rounded-lg bg-white/10 text-[10px] text-gray-300 font-medium">سيريتل كاش</span>
                    <span class="px-2.5 py-1 rounded-lg bg-white/10 text-[10px] text-gray-300 font-medium">بيمو بنك</span>
                    <span class="px-2.5 py-1 rounded-lg bg-white/10 text-[10px] text-gray-300 font-medium">دفع عند الاستلام</span>
                </div>
            </div>

        </div>

        <!-- Copyright -->
        <div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-gray-400">
            <p>
                © {{ date('Y') }} {{ settings('site_name', 'Regalest Store') }}. {{ __('جميع الحقوق محفوظة.') }}
            </p>
            <div class="text-[11px] text-[#C5A059]">
                👑 {{ settings('site_slogan', __('المتجر الفاخر للهدايا والمقتنيات')) }}
            </div>
        </div>

    </div>
</footer>