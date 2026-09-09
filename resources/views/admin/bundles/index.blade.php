@extends('layouts.admin')

@section('title', __('العروض المجمعة'))

@section('content')
<div class="space-y-6">
    
    <!-- Top Header -->
    <div class="bg-white border border-[#EADBCC] rounded-2xl p-6 sm:p-8 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="text-xs font-bold text-[#C5A059] uppercase tracking-wider">🎁 Bundles & Multi-Deals</span>
            </div>
            <h1 class="font-cinzel text-2xl sm:text-3xl font-bold text-[#18181B]">
                {{ __('العروض المجمعة (Bundles)') }}
            </h1>
            <p class="text-xs sm:text-sm text-[#71717A] mt-1">
                {{ __('إتاحة شراء عدة قطع معاً بسعر مخفض خاص لزيادة متوسط قيمة الطلب.') }}
            </p>
        </div>

        <a href="{{ route('admin.bundles.create') }}" class="px-5 py-3 rounded-xl bg-[#18181B] hover:bg-[#C5A059] text-white text-xs font-bold shadow-sm transition-all flex items-center gap-2 shrink-0">
            <span>+</span>
            <span>{{ __('إنشاء عرض مجمع جديد') }}</span>
        </a>
    </div>

    <!-- Bundles Table -->
    <div class="bg-white border border-[#EADBCC] rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-start text-xs">
                <thead class="bg-[#F8F6F2] text-[#71717A] uppercase text-[11px] border-b border-[#EADBCC]">
                    <tr>
                        <th class="py-3.5 px-6 text-start font-semibold">{{ __('العرض') }}</th>
                        <th class="py-3.5 px-4 text-start font-semibold">{{ __('المنتجات المشمولة') }}</th>
                        <th class="py-3.5 px-4 text-start font-semibold">{{ __('السعر الأصلي') }}</th>
                        <th class="py-3.5 px-4 text-start font-semibold">{{ __('سعر العرض') }}</th>
                        <th class="py-3.5 px-4 text-start font-semibold">{{ __('نسبة التوفير') }}</th>
                        <th class="py-3.5 px-4 text-start font-semibold">{{ __('الحالة') }}</th>
                        <th class="py-3.5 px-6 text-end font-semibold">{{ __('إجراءات') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#EADBCC]">
                    @forelse($bundles as $bundle)
                        <tr class="hover:bg-[#F8F6F2]/50 transition-colors">
                            <td class="py-4 px-6 flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl bg-[#F8F6F2] border border-[#EADBCC] p-1 flex-shrink-0 flex items-center justify-center overflow-hidden">
                                    @if($bundle->image_url)
                                        <img src="{{ $bundle->image_url }}" alt="" class="w-full h-full object-cover rounded-lg">
                                    @else
                                        <span class="text-2xl">🎁</span>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <span class="font-bold text-[#18181B] text-xs block">{{ $bundle->name }}</span>
                                    <span class="text-[11px] text-[#71717A] block truncate max-w-xs">{{ Str::limit($bundle->description, 40) }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <span class="px-2.5 py-1 rounded-full bg-[#F8F6F2] border border-[#EADBCC] text-[11px] font-semibold text-[#18181B]">
                                    {{ $bundle->products_count ?? $bundle->products->count() }} {{ __('منتجات') }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-[#71717A] line-through font-cinzel">
                                {{ $bundle->formatted_original_total }}
                            </td>
                            <td class="py-4 px-4 font-bold text-[#18181B] font-cinzel text-xs">
                                {{ $bundle->formatted_bundle_price }}
                            </td>
                            <td class="py-4 px-4">
                                @if($bundle->discount_percent > 0)
                                    <span class="px-2.5 py-0.5 rounded-full bg-rose-50 border border-rose-200 text-rose-600 text-[10px] font-bold">
                                        {{ __('وفر') }} {{ $bundle->discount_percent }}%
                                    </span>
                                @else
                                    <span class="text-[#71717A]">-</span>
                                @endif
                            </td>
                            <td class="py-4 px-4">
                                @if(!$bundle->is_active)
                                    <span class="px-2.5 py-1 rounded-full bg-gray-100 border border-gray-200 text-gray-500 text-[11px] font-bold">
                                        {{ __('معطل') }}
                                    </span>
                                @elseif($bundle->starts_at && $bundle->starts_at->isFuture())
                                    <span class="px-2.5 py-1 rounded-full bg-amber-50 border border-amber-200 text-amber-700 text-[11px] font-bold" title="{{ __('يبدأ في: ') . $bundle->starts_at->format('Y-m-d H:i') }}">
                                        ⏳ {{ __('لم يبدأ بعد') }}
                                    </span>
                                @elseif($bundle->ends_at && $bundle->ends_at->isPast())
                                    <span class="px-2.5 py-1 rounded-full bg-rose-50 border border-rose-200 text-rose-600 text-[11px] font-bold" title="{{ __('انتهى في: ') . $bundle->ends_at->format('Y-m-d H:i') }}">
                                        {{ __('منتهي') }}
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 text-[11px] font-bold">
                                        ✓ {{ __('نشط') }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-end">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.bundles.edit', $bundle->id) }}" class="px-3 py-1.5 rounded-lg border border-[#EADBCC] bg-[#F8F6F2] hover:bg-[#EADBCC] text-[#18181B] font-semibold text-xs transition-colors">
                                        {{ __('تعديل') }}
                                    </a>
                                    <form action="{{ route('admin.bundles.destroy', $bundle->id) }}" method="POST" data-confirm-message="{{ __('هل أنت متأكد من رغبتك في حذف العرض المجمع: ') . $bundle->name . '؟' }}">
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
                            <td colspan="7" class="py-12 text-center text-[#71717A]">
                                {{ __('لا توجد عروض مجمعة مسجلة حالياً.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
