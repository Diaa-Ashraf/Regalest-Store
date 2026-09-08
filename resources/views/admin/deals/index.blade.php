@extends('layouts.admin')

@section('title', __('التخفيضات والعروض الخاصة'))

@section('content')
<div class="space-y-6">
    
    <!-- Top Header -->
    <div class="bg-white border border-[#EADBCC] rounded-2xl p-6 sm:p-8 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="text-xs font-bold text-[#C5A059] uppercase tracking-wider">🏷️ Flash Deals & Discounts</span>
            </div>
            <h1 class="font-cinzel text-2xl sm:text-3xl font-bold text-[#18181B]">
                {{ __('التخفيضات والعروض الخاصة') }}
            </h1>
            <p class="text-xs sm:text-sm text-[#71717A] mt-1">
                {{ __('إدارة العروض اليومية، وتحديد أسعار التخفيضات وشارات الخصم المباشر.') }}
            </p>
        </div>

        <a href="{{ route('deals.create') }}" class="px-5 py-3 rounded-xl bg-[#18181B] hover:bg-[#C5A059] text-white text-xs font-bold shadow-sm transition-all flex items-center gap-2 shrink-0">
            <span>+</span>
            <span>{{ __('إضافة عرض خاص') }}</span>
        </a>
    </div>

    <!-- Deals Table -->
    <div class="bg-white border border-[#EADBCC] rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-start text-xs">
                <thead class="bg-[#F8F6F2] text-[#71717A] uppercase text-[11px] border-b border-[#EADBCC]">
                    <tr>
                        <th class="py-3.5 px-6 text-start font-semibold" style="width: 80px;">#</th>
                        <th class="py-3.5 px-4 text-start font-semibold">{{ __('المنتج') }}</th>
                        <th class="py-3.5 px-4 text-start font-semibold">{{ __('السعر الأصلي') }}</th>
                        <th class="py-3.5 px-4 text-start font-semibold">{{ __('سعر العرض') }}</th>
                        <th class="py-3.5 px-4 text-start font-semibold">{{ __('الخصم') }}</th>
                        <th class="py-3.5 px-4 text-start font-semibold">{{ __('الشارة') }}</th>
                        <th class="py-3.5 px-4 text-start font-semibold">{{ __('الحالة') }}</th>
                        <th class="py-3.5 px-6 text-end font-semibold">{{ __('إجراءات') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#EADBCC]">
                    @forelse($deals as $deal)
                        <tr class="hover:bg-[#F8F6F2]/50 transition-colors">
                            <td class="py-4 px-6 font-bold text-[#71717A]">
                                {{ $loop->iteration }}
                            </td>
                            <td class="py-4 px-4 flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl bg-[#F8F6F2] border border-[#EADBCC] p-1 flex-shrink-0 flex items-center justify-center overflow-hidden">
                                    <img src="{{ $deal->product?->image_url ?? asset('assets/site/img/product/product-1.jpg') }}" 
                                         alt="{{ $deal->product?->name }}" 
                                         class="w-full h-full object-cover rounded-lg">
                                </div>
                                <span class="font-bold text-[#18181B] text-xs block">{{ $deal->product?->name ?? 'N/A' }}</span>
                            </td>
                            <td class="py-4 px-4 text-[#71717A] line-through font-cinzel">
                                {{ $deal->formatted_original_price }}
                            </td>
                            <td class="py-4 px-4 font-bold text-rose-600 font-cinzel text-xs">
                                {{ $deal->formatted_deal_price }}
                            </td>
                            <td class="py-4 px-4">
                                <span class="px-2.5 py-0.5 rounded-full bg-rose-50 border border-rose-200 text-rose-600 text-[10px] font-bold">
                                    -{{ $deal->discount_percent }}%
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                <span class="px-2.5 py-1 rounded-lg bg-[#C5A059]/10 border border-[#C5A059]/20 text-[#C5A059] text-[10px] font-bold">
                                    {{ $deal->badge_text }}
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                @if($deal->is_valid)
                                    <span class="px-2.5 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 text-[11px] font-bold">
                                        {{ __('نشط') }}
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full bg-gray-50 border border-gray-200 text-gray-500 text-[11px] font-bold">
                                        {{ __('منتهي') }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-end">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('deals.edit', $deal->id) }}" class="px-3 py-1.5 rounded-lg border border-[#EADBCC] bg-[#F8F6F2] hover:bg-[#EADBCC] text-[#18181B] font-semibold text-xs transition-colors">
                                        {{ __('تعديل') }}
                                    </a>
                                    <form action="{{ route('deals.destroy', $deal->id) }}" method="POST" data-confirm-message="{{ __('هل أنت متأكد من رغبتك في حذف هذا العرض الترويجي؟') }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 rounded-lg border border-rose-200 bg-rose-50 hover:bg-rose-100 text-rose-600 font-semibold text-xs transition-colors">
                                            {{ __('حذف') }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-[#71717A]">
                                {{ __('لا توجد عروض خاصة مسجلة حالياً.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
