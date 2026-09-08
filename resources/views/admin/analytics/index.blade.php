@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-[#18181B] tracking-tight">💬 تحليلات واتساب | WhatsApp Analytics</h2>
            <p class="text-sm text-[#71717A] mt-0.5">تتبع شامل وفوري لنقرات الشراء وإتمام الطلب والاستفسار عن المنتجات عبر تطبيق واتساب.</p>
        </div>
    </div>

    {{-- 3 Summary Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div class="bg-white border border-[#EADBCC] rounded-2xl p-6 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-[#71717A] uppercase tracking-wider block">إجمالي نقرات واتساب</span>
                <h3 class="text-3xl font-black text-[#18181B] mt-1">{{ number_format($metrics['total_whatsapp_clicks'] ?? 0) }}</h3>
                <span class="inline-flex items-center gap-1.5 mt-2 text-xs font-medium text-emerald-700 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded-full">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    جميع التفاعلات المسجلة
                </span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-[#F8F6F2] border border-[#EADBCC] text-[#C5A059] flex items-center justify-center text-xl">
                💬
            </div>
        </div>

        <div class="bg-white border border-[#EADBCC] rounded-2xl p-6 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-[#71717A] uppercase tracking-wider block">إتمام الطلب (Checkout)</span>
                <h3 class="text-3xl font-black text-emerald-600 mt-1">{{ number_format($metrics['checkout_clicks'] ?? 0) }}</h3>
                <span class="inline-flex items-center gap-1.5 mt-2 text-xs font-medium text-[#71717A] bg-[#F8F6F2] border border-[#EADBCC] px-2 py-0.5 rounded-full">
                    زبائن بطلب معبأ للسلة
                </span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-600 flex items-center justify-center text-xl">
                🛒
            </div>
        </div>

        <div class="bg-white border border-[#EADBCC] rounded-2xl p-6 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-[#71717A] uppercase tracking-wider block">نقرات اليوم</span>
                <h3 class="text-3xl font-black text-[#C5A059] mt-1">{{ number_format($metrics['today_whatsapp_clicks'] ?? 0) }}</h3>
                <span class="inline-flex items-center gap-1.5 mt-2 text-xs font-medium text-amber-700 bg-amber-50 border border-amber-200 px-2 py-0.5 rounded-full">
                    نشاط الـ 24 ساعة الماضية
                </span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 border border-amber-200 text-amber-600 flex items-center justify-center text-xl">
                ⚡
            </div>
        </div>
    </div>

    {{-- Table of Recent Clicks --}}
    <div class="bg-white border border-[#EADBCC] rounded-2xl shadow-sm overflow-hidden">
        <div class="p-5 border-b border-[#EADBCC] flex items-center justify-between">
            <h3 class="font-bold text-[#18181B] text-base flex items-center gap-2">
                <span>📋</span>
                <span>سجل آخر نقرات واتساب المسجلة</span>
            </h3>
            <span class="text-xs text-[#71717A] font-medium">محدّث تلقائياً</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-right border-collapse">
                <thead>
                    <tr class="border-b border-[#EADBCC] bg-[#F8F6F2]/70 text-[#71717A] text-xs uppercase font-semibold">
                        <th class="py-3.5 px-5">النوع</th>
                        <th class="py-3.5 px-5">بيانات العميل والتواصل</th>
                        <th class="py-3.5 px-5">تفاصيل الطلب / المنتجات</th>
                        <th class="py-3.5 px-5">الإجمالي</th>
                        <th class="py-3.5 px-5">التاريخ والوقت</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#F0ECE1] text-sm text-[#18181B]">
                    @forelse($recentClicks as $click)
                        @php
                            $orderInfo = $click->order_data ?? [];
                            $customerName = $orderInfo['customer_name'] ?? $click->user?->name ?? 'زائر / عميل';
                            $customerPhone = $orderInfo['customer_phone'] ?? $click->user?->phone ?? null;
                            $customerAddress = $orderInfo['customer_address'] ?? null;
                            $orderNumber = $orderInfo['order_number'] ?? null;
                            $totalAmount = $orderInfo['total'] ?? null;
                        @endphp
                        <tr class="hover:bg-[#F8F6F2]/40 transition-colors">
                            <td class="py-4 px-5 align-top">
                                @if($click->click_type === 'checkout')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        🛒 إتمام طلب
                                    </span>
                                    @if($orderNumber)
                                        <span class="block text-[11px] font-mono text-gray-500 mt-1 font-bold">{{ $orderNumber }}</span>
                                    @endif
                                @elseif($click->click_type === 'product_inquiry')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-sky-50 text-sky-700 border border-sky-200">
                                        💎 استفسار منتج
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-[#F8F6F2] text-[#71717A] border border-[#EADBCC]">
                                        💬 تواصل عام
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-5 align-top">
                                <div class="font-bold text-[#18181B] flex items-center gap-1.5">
                                    <span>👤</span>
                                    <span>{{ $customerName }}</span>
                                </div>
                                @if($customerPhone)
                                    <div class="mt-1 flex items-center gap-2">
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $customerPhone) }}" target="_blank" class="inline-flex items-center gap-1 text-xs font-bold text-emerald-700 hover:underline font-mono">
                                            <span>📞</span>
                                            <span>{{ $customerPhone }}</span>
                                        </a>
                                    </div>
                                @endif
                                @if($customerAddress)
                                    <span class="text-[11px] text-[#71717A] block mt-1 line-clamp-2" title="{{ $customerAddress }}">
                                        📍 {{ $customerAddress }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-5 align-top text-xs">
                                @if(!empty($orderInfo['items']))
                                    <div class="space-y-1">
                                        @foreach($orderInfo['items'] as $it)
                                            <div class="flex items-center justify-between gap-2 text-[11px] bg-white border border-[#EADBCC]/60 px-2 py-1 rounded-lg">
                                                <span class="font-medium text-[#18181B] truncate max-w-[180px]">{{ $it['name'] }}</span>
                                                <span class="font-bold text-gray-500">×{{ $it['quantity'] }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @elseif(!empty($orderInfo['product_name']))
                                    <span class="font-bold text-[#18181B] block">{{ $orderInfo['product_name'] }}</span>
                                @else
                                    <span class="text-gray-400 text-xs">{{ $click->source_page ?? 'صفحة عامة' }}</span>
                                @endif
                            </td>
                            <td class="py-4 px-5 align-top font-bold text-sm text-[#C5A059] font-cinzel whitespace-nowrap">
                                @if(!empty($orderInfo['formatted_total']))
                                    {{ $orderInfo['formatted_total'] }}
                                @elseif(!is_null($totalAmount))
                                    ${{ number_format((float)$totalAmount, 2) }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="py-4 px-5 align-top text-[#71717A] text-xs whitespace-nowrap">
                                <span class="font-medium">{{ $click->created_at?->format('Y-m-d') }}</span>
                                <span class="block text-[10px] text-gray-400">{{ $click->created_at?->format('h:i A') }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-[#71717A]">
                                لا توجد نقرات مسجلة حتى الآن.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($recentClicks, 'hasPages') && $recentClicks->hasPages())
            <div class="p-4 border-t border-[#EADBCC] bg-[#F8F6F2]/30">
                {{ $recentClicks->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
