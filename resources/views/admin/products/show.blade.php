@extends('layouts.admin')

@section('title', __('تفاصيل المنتج'))

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-[#18181B]">{{ $product->name }}</h2>
            <p class="text-sm text-[#71717A] mt-0.5">{{ __('التصنيف') }}: <span class="font-semibold text-[#18181B]">{{ $product->category?->name ?? __('غير مصنف') }}</span></p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.products.edit', $product->id) }}" class="px-4 py-2 rounded-xl bg-[#18181B] hover:bg-[#27272A] text-white text-sm font-semibold transition-colors">
                {{ __('تعديل المنتج') }}
            </a>
            <a href="{{ route('admin.products.index') }}" class="px-4 py-2 rounded-xl border border-[#EADBCC] bg-[#F8F6F2] hover:bg-[#EDE8DC] text-[#18181B] text-sm font-semibold transition-colors">
                {{ __('العودة للمنتجات') }}
            </a>
        </div>
    </div>

    <div class="bg-white border border-[#EADBCC] rounded-2xl p-6 sm:p-8 shadow-sm space-y-6">
        <div class="flex flex-col sm:flex-row gap-6 items-start">
            <div class="w-36 h-36 rounded-2xl bg-[#F8F6F2] border border-[#EADBCC] p-2 flex-shrink-0 flex items-center justify-center overflow-hidden">
                @if($product->image_url)
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover rounded-xl">
                @else
                    <span class="text-4xl">⌚</span>
                @endif
            </div>

            <div class="space-y-3 flex-1">
                <div class="flex items-center gap-3 flex-wrap">
                    <span class="text-2xl font-black text-[#C5A059] font-cinzel">{{ $product->formatted_price }}</span>
                    @if($product->has_discount)
                        <span class="text-sm text-[#71717A] line-through">${{ number_format($product->price, 2) }}</span>
                        <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-rose-50 text-rose-600 border border-rose-200">
                            -{{ $product->discount_percentage }}%
                        </span>
                    @endif
                    <span class="px-2.5 py-1 rounded-lg bg-[#F8F6F2] border border-[#EADBCC] text-xs font-semibold text-[#18181B]">
                        {{ __('المخزون') }}: {{ $product->available_stock }}
                    </span>
                    @if($product->featured)
                        <span class="px-2.5 py-1 rounded-lg bg-amber-50 border border-amber-200 text-xs font-bold text-amber-700">
                            ⭐ {{ __('مميز بالرئيسية') }}
                        </span>
                    @endif
                </div>

                <div class="pt-2">
                    <span class="text-xs font-semibold text-[#71717A] uppercase tracking-wider block mb-1">{{ __('الرابط الدائم (Slug)') }}</span>
                    <span class="text-xs font-mono bg-[#F8F6F2] px-2.5 py-1 rounded-lg border border-[#EADBCC]">{{ $product->slug }}</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-[#EADBCC]">
            <div class="p-4 rounded-xl bg-[#F8F6F2]/50 border border-[#EADBCC] space-y-2">
                <span class="text-xs font-bold text-[#C5A059] uppercase tracking-wider block">العربية</span>
                <h4 class="font-bold text-[#18181B] text-base">{{ $product->getTranslation('name', 'ar', false) ?? '-' }}</h4>
                <p class="text-xs text-[#71717A] leading-relaxed">{{ $product->getTranslation('description', 'ar', false) ?? '-' }}</p>
            </div>

            <div class="p-4 rounded-xl bg-[#F8F6F2]/50 border border-[#EADBCC] space-y-2">
                <span class="text-xs font-bold text-[#C5A059] uppercase tracking-wider block">English</span>
                <h4 class="font-bold text-[#18181B] text-base">{{ $product->getTranslation('name', 'en', false) ?? '-' }}</h4>
                <p class="text-xs text-[#71717A] leading-relaxed">{{ $product->getTranslation('description', 'en', false) ?? '-' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
