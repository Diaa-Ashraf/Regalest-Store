@extends('layouts.site')

@section('content')
@php
    $displayPrice = format_currency($product->final_price, 'USD');
    $isWishlisted = auth()->check() && auth()->user()->wishlistItems()->where('product_id', $product->id)->exists();
@endphp

<div class="bg-[#F8F9FA] text-[#18181B] min-h-[85vh] py-6 sm:py-10" 
     x-data="{
        quantity: 1,
        maxStock: {{ (int)($product->available_stock ?? 1) }},
        activeTab: 'details',
        isAdding: false,
        imgZoom: false,
        increment() {
            if (this.quantity < this.maxStock) {
                this.quantity++;
            }
        },
        decrement() {
            if (this.quantity > 1) {
                this.quantity--;
            }
        },
        addToCart() {
            if (this.isAdding || this.maxStock <= 0) return;
            this.isAdding = true;
            
            $.post('{{ route('AddToCart', $product->id) }}', {
                quantity: this.quantity
            }).done((res) => {
                if (res.success) {
                    toastr.success(res.message);
                    fetch('{{ route('cart.payload') }}')
                        .then(r => r.json())
                        .then(payload => {
                            window.dispatchEvent(new CustomEvent('cart-updated', { detail: payload }));
                            window.dispatchEvent(new CustomEvent('open-mini-cart'));
                        })
                        .catch(() => {});
                } else {
                    toastr.error(res.message);
                }
            }).fail((xhr) => {
                const msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : '{{ __('حدث خطأ أثناء إضافة المنتج.') }}';
                toastr.error(msg);
            }).always(() => {
                this.isAdding = false;
            });
        }
     }">
    
    <div class="w-full max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Breadcrumbs navigation bar --}}
        <nav class="flex items-center gap-2 text-xs text-[#71717A] mb-6 sm:mb-8 font-sans overflow-x-auto whitespace-nowrap pb-1">
            <a href="{{ route('site.home') }}" class="hover:text-[#C5A059] transition-colors">{{ __('الرئيسية') }}</a>
            <span class="text-gray-300">/</span>
            <a href="{{ route('product.shop') }}" class="hover:text-[#C5A059] transition-colors">{{ __('المتجر') }}</a>
            @if($product->category)
                <span class="text-gray-300">/</span>
                <a href="{{ route('category.product', $product->category->id) }}" class="hover:text-[#C5A059] transition-colors">{{ $product->category->name }}</a>
            @endif
            <span class="text-gray-300">/</span>
            <span class="text-[#18181B] font-semibold truncate max-w-[200px] sm:max-w-xs">{{ $product->name }}</span>
        </nav>

        {{-- Main Product Card Showcase --}}
        <div class="bg-white rounded-3xl border border-[#E5E7EB] shadow-xs overflow-hidden mb-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 p-6 sm:p-8 lg:p-12 items-start">
                
                {{-- Column 1: Image Showcase --}}
                <div class="lg:col-span-6 flex flex-col items-center">
                    <div class="relative w-full aspect-square max-w-[540px] bg-[#F8F9FA] rounded-2xl sm:rounded-3xl border border-[#E5E7EB] p-4 sm:p-8 flex items-center justify-center overflow-hidden group shadow-inner">
                        
                        {{-- Badges --}}
                        <div class="absolute top-4 start-4 z-10 flex flex-col gap-2 pointer-events-none">
                            @if($product->has_discount)
                                <span class="bg-rose-600 text-white font-bold text-xs sm:text-sm px-3 py-1 rounded-full shadow-md animate-pulse">
                                    -{{ $product->discount_percentage }}% {{ __('خصم') }}
                                </span>
                            @endif
                            @if($product->featured)
                                <span class="bg-[#C5A059] text-white font-extrabold text-xs sm:text-sm px-3 py-1 rounded-full shadow-md flex items-center gap-1">
                                    ★ {{ __('إصدار مميز') }}
                                </span>
                            @endif
                        </div>

                        {{-- Wishlist Floating Button --}}
                        @if(settings('wishlist_enabled', true))
                            <button type="button" 
                                    onclick="window.toggleWishlist(event, {{ $product->id }}, this);"
                                    class="btn-wishlist-toggle absolute top-4 end-4 z-10 w-11 h-11 rounded-full bg-white/95 border border-[#E5E7EB] hover:border-[#C5A059] {{ $isWishlisted ? 'text-rose-600' : 'text-gray-400' }} hover:text-rose-600 flex items-center justify-center transition-all duration-300 shadow-md backdrop-blur-sm hover:scale-110 active:scale-95 cursor-pointer" 
                                    data-id="{{ $product->id }}" 
                                    title="{{ $isWishlisted ? __('إزالة من المفضلة') : __('إضافة للمفضلة') }}">
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                </svg>
                            </button>
                        @endif

                        {{-- Product Main Image --}}
                        <img src="{{ $product->image_url ?? asset('assets/site/img/product/product-1.jpg') }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-full object-contain rounded-2xl transition-transform duration-500 ease-out group-hover:scale-105 select-none">
                    </div>

                    {{-- Quick Guarantee Badges under image --}}
                    <div class="grid grid-cols-3 gap-3 w-full max-w-[540px] mt-6">
                        <div class="bg-[#F8F9FA] border border-[#E5E7EB] rounded-2xl p-3 text-center flex flex-col items-center justify-center gap-1">
                            <span class="text-lg">🛡️</span>
                            <span class="text-[11px] font-bold text-[#18181B]">{{ __('ضمان أصالة 100%') }}</span>
                            <span class="text-[9px] text-[#71717A]">{{ __('جودة ملكية مضمونة') }}</span>
                        </div>
                        <div class="bg-[#F8F9FA] border border-[#E5E7EB] rounded-2xl p-3 text-center flex flex-col items-center justify-center gap-1">
                            <span class="text-lg">🚚</span>
                            <span class="text-[11px] font-bold text-[#18181B]">{{ __('شحن سريع ومؤمّن') }}</span>
                            <span class="text-[9px] text-[#71717A]">{{ __('لكافة المحافظات') }}</span>
                        </div>
                        <div class="bg-[#F8F9FA] border border-[#E5E7EB] rounded-2xl p-3 text-center flex flex-col items-center justify-center gap-1">
                            <span class="text-lg">💵</span>
                            <span class="text-[11px] font-bold text-[#18181B]">{{ __('الدفع عند الاستلام') }}</span>
                            <span class="text-[9px] text-[#71717A]">{{ __('معاينة قبل الدفع') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Column 2: Product Information & CTAs --}}
                <div class="lg:col-span-6 flex flex-col justify-between h-full space-y-6">
                    
                    <div>
                        {{-- Category Tag --}}
                        <div class="flex items-center gap-2 mb-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-[#C5A059]/10 text-[#C5A059] border border-[#C5A059]/20">
                                {{ $product->category?->name ?? __('مقتنيات فاخرة') }}
                            </span>
                            @if($product->available_stock > 0)
                                <span class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-600 bg-emerald-50 border border-emerald-200 px-2.5 py-0.5 rounded-full">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-ping"></span>
                                    {{ __('متوفر في المخزون الملكي') }} ({{ $product->available_stock }} {{ __('قطعة') }})
                                </span>
                            @else
                                <span class="inline-flex items-center text-xs font-semibold text-rose-600 bg-rose-50 border border-rose-200 px-2.5 py-0.5 rounded-full">
                                    ✕ {{ __('نفدت الكمية مؤقتاً') }}
                                </span>
                            @endif
                        </div>

                        {{-- Product Title --}}
                        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-[#18181B] leading-tight mb-4 tracking-tight">
                            {{ $product->name }}
                        </h1>

                        {{-- Price Section --}}
                        <div class="bg-[#F8F9FA] border border-[#E5E7EB] rounded-2xl p-4 sm:p-5 mb-6 flex items-center justify-between flex-wrap gap-4">
                            <div>
                                <span class="text-xs text-[#71717A] block mb-0.5">{{ __('السعر الحالي') }}</span>
                                <div class="flex items-baseline gap-3">
                                    <span class="text-2xl sm:text-3xl font-extrabold text-[#18181B] tabular-nums font-sans">
                                        {{ $displayPrice }}
                                    </span>
                                    @if($product->has_discount)
                                        <span class="text-sm sm:text-base text-gray-400 line-through tabular-nums font-sans">
                                            {{ format_currency($product->price, 'USD') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Description Snippet --}}
                        <div class="text-sm sm:text-base text-[#52525B] leading-relaxed mb-6">
                            {{ $product->description ?: __('ساعة يد أصلية فاخرة مصنوعة من أرقى المواد المقاومة للصدأ، تجمع بين الكلاسيكية الفاتنة والتقنيات العصرية الدقيقة. تأتي في علبة فاخرة ومناسبة كهدية راقية تليق بالمناسبات الخاصة.') }}
                        </div>

                        {{-- Key Luxury Specifications Grid --}}
                        <div class="grid grid-cols-2 sm:grid-cols-2 gap-3 mb-6">
                            <div class="bg-white border border-[#E5E7EB] rounded-xl p-3 flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-[#C5A059]/10 text-[#C5A059] flex items-center justify-center font-bold text-sm shrink-0">
                                    ⚙️
                                </div>
                                <div class="overflow-hidden">
                                    <span class="text-[10px] text-[#71717A] block">{{ __('نوع الحركة') }}</span>
                                    <span class="text-xs font-bold text-[#18181B] truncate block">{{ __('أوتوماتيك سويسري فاخر') }}</span>
                                </div>
                            </div>
                            <div class="bg-white border border-[#E5E7EB] rounded-xl p-3 flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-[#C5A059]/10 text-[#C5A059] flex items-center justify-center font-bold text-sm shrink-0">
                                    💎
                                </div>
                                <div class="overflow-hidden">
                                    <span class="text-[10px] text-[#71717A] block">{{ __('الزجاج والميناء') }}</span>
                                    <span class="text-xs font-bold text-[#18181B] truncate block">{{ __('ياقوت كريستال مضاد للخدش') }}</span>
                                </div>
                            </div>
                            <div class="bg-white border border-[#E5E7EB] rounded-xl p-3 flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-[#C5A059]/10 text-[#C5A059] flex items-center justify-center font-bold text-sm shrink-0">
                                    🌊
                                </div>
                                <div class="overflow-hidden">
                                    <span class="text-[10px] text-[#71717A] block">{{ __('مقاومة الماء') }}</span>
                                    <span class="text-xs font-bold text-[#18181B] truncate block">{{ __('50M / 5 ATM') }}</span>
                                </div>
                            </div>
                            <div class="bg-white border border-[#E5E7EB] rounded-xl p-3 flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-[#C5A059]/10 text-[#C5A059] flex items-center justify-center font-bold text-sm shrink-0">
                                    👑
                                </div>
                                <div class="overflow-hidden">
                                    <span class="text-[10px] text-[#71717A] block">{{ __('التغليف والإضافات') }}</span>
                                    <span class="text-xs font-bold text-[#18181B] truncate block">{{ __('صندوق ملكي فاخر مع كرت ضمان') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Actions Section: Quantity & Buttons --}}
                    <div class="space-y-4 pt-4 border-t border-[#E5E7EB]">
                        @if($product->available_stock > 0)
                            <div class="flex items-center gap-4">
                                <span class="text-xs font-bold text-[#18181B]">{{ __('الكمية:') }}</span>
                                
                                {{-- Quantity Selector --}}
                                <div class="flex items-center border border-[#E5E7EB] rounded-2xl bg-[#F8F9FA] p-1">
                                    <button type="button" 
                                            @click="decrement()"
                                            :disabled="quantity <= 1"
                                            class="w-8 h-8 rounded-xl bg-white border border-gray-200 text-gray-700 hover:border-[#C5A059] hover:text-[#C5A059] flex items-center justify-center font-bold transition-all disabled:opacity-40 disabled:cursor-not-allowed cursor-pointer">
                                        -
                                    </button>
                                    <span class="w-12 text-center font-bold text-sm text-[#18181B] tabular-nums" x-text="quantity"></span>
                                    <button type="button" 
                                            @click="increment()"
                                            :disabled="quantity >= maxStock"
                                            class="w-8 h-8 rounded-xl bg-white border border-gray-200 text-gray-700 hover:border-[#C5A059] hover:text-[#C5A059] flex items-center justify-center font-bold transition-all disabled:opacity-40 disabled:cursor-not-allowed cursor-pointer">
                                        +
                                    </button>
                                </div>

                                <span class="text-xs text-[#71717A]">
                                    {{ __('الحد الأقصى للطلب:') }} <span class="font-bold text-[#18181B]" x-text="maxStock"></span>
                                </span>
                            </div>

                            {{-- Dual Action Buttons: Add to Cart & Direct WhatsApp --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                {{-- Add To Cart Button --}}
                                <button type="button" 
                                        @click="addToCart()"
                                        :disabled="isAdding"
                                        class="w-full py-3.5 px-6 rounded-2xl bg-[#C5A059] hover:bg-[#18181B] text-white text-sm font-bold transition-all duration-300 shadow-md hover:shadow-lg active:scale-95 flex items-center justify-center gap-2 cursor-pointer group">
                                    <svg class="w-5 h-5 text-white group-hover:text-[#C5A059] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                    <span x-text="isAdding ? '{{ __('جاري الإضافة...') }}' : '{{ __('إضافة إلى السلة') }}'"></span>
                                </button>

                                {{-- Direct WhatsApp Inquiry & Order Button --}}
                                <a href="{{ $whatsappInquiryUrl }}" 
                                   target="_blank" 
                                   class="w-full py-3.5 px-6 rounded-2xl bg-[#25D366] hover:bg-[#1EBE5D] text-white text-sm font-bold transition-all duration-300 shadow-md hover:shadow-lg active:scale-95 flex items-center justify-center gap-2 cursor-pointer">
                                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                        <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.771-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.275.072.376-.044c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.099.824z"/>
                                    </svg>
                                    <span>{{ __('استفسار وشراء عبر واتساب') }}</span>
                                </a>
                            </div>
                        @else
                            {{-- Out of Stock & Notify via WhatsApp --}}
                            <div class="p-4 bg-rose-50 border border-rose-200 rounded-2xl text-center space-y-3">
                                <p class="text-rose-700 text-sm font-bold">
                                    {{ __('هذا المنتج غير متوفر حالياً في المخزون.') }}
                                </p>
                                <a href="{{ $whatsappInquiryUrl }}" 
                                   target="_blank" 
                                   class="inline-flex items-center justify-center gap-2 py-3 px-6 rounded-2xl bg-[#25D366] text-white text-xs font-bold hover:bg-[#1EBE5D] transition-all shadow-sm">
                                    <span>{{ __('طلب توفير خاص عبر واتساب') }}</span>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Related Products Section --}}
        @if($relatedProducts->count() > 0)
            <div class="mt-12 sm:mt-16">
                <div class="flex items-center justify-between mb-6 sm:mb-8">
                    <div>
                        <span class="text-xs font-bold text-[#C5A059] uppercase tracking-wider block mb-1">
                            {{ __('مقتنيات مقترحة') }}
                        </span>
                        <h2 class="text-xl sm:text-2xl font-extrabold text-[#18181B]">
                            {{ __('ساعات فاخرة قد تنال إعجابك') }} 👑
                        </h2>
                    </div>
                    <a href="{{ route('product.shop') }}" class="text-xs sm:text-sm font-bold text-[#18181B] hover:text-[#C5A059] transition-colors flex items-center gap-1">
                        <span>{{ __('عرض كافة الساعات') }}</span>
                        <span>←</span>
                    </a>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
                    @foreach($relatedProducts as $relProduct)
                        <x-product-card :product="$relProduct" />
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</div>
@endsection
