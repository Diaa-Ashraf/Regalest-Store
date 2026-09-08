@extends('layouts.admin')

@section('title', __('لوحة الإدارة الملكية'))

@section('content')
<div class="space-y-8">
    
    <!-- Welcome Header & Top Actions -->
    <div class="bg-white border border-[#EADBCC] rounded-2xl p-6 sm:p-8 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="text-xs font-bold text-[#C5A059] uppercase tracking-wider">👑 Regalest Dashboard</span>
            </div>
            <h1 class="font-cinzel text-2xl sm:text-3xl font-bold text-[#18181B]">
                {{ __('لوحة الإدارة الفاخرة') }}
            </h1>
            <p class="text-xs sm:text-sm text-[#71717A] mt-1">
                {{ __('نظرة عامة على المبيعات، تحويلات واتساب، ومؤشرات الأداء الرئيسية للمتجر.') }}
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.orders.index') }}" 
               class="px-4 py-2.5 rounded-xl border border-[#EADBCC] bg-[#F8F6F2] hover:bg-[#EADBCC] text-[#18181B] text-xs font-bold transition-all flex items-center gap-2 shadow-sm">
                <span>📦</span>
                <span>{{ __('عرض الطلبات') }}</span>
                <span class="px-2 py-0.5 rounded-full bg-[#C5A059]/20 text-[#C5A059] text-[11px]">
                    {{ data_get($metrics, 'pending_orders', 1) }} {{ __('قيد الانتظار') }}
                </span>
            </a>
            <a href="{{ route('admin.products.create') }}" 
               class="px-4 py-2.5 rounded-xl bg-[#18181B] hover:bg-[#C5A059] text-white text-xs font-bold shadow-sm transition-all flex items-center gap-1.5">
                <span>+</span>
                <span>{{ __('إضافة منتج جديد') }}</span>
            </a>
        </div>
    </div>

    <!-- 4 Main Metric Cards (Warm Luxury - No Pitch Black) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        
        <!-- Total Orders Card -->
        <div class="bg-white border border-[#EADBCC] rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold text-[#71717A]">{{ __('إجمالي الطلبات') }}</span>
                <div class="w-10 h-10 rounded-xl bg-[#F8F6F2] border border-[#EADBCC] text-lg flex items-center justify-center">
                    📦
                </div>
            </div>
            <div class="text-3xl font-bold text-[#18181B] mb-2 font-cinzel">
                {{ data_get($metrics, 'total_orders', data_get($metrics, 'orders_count', 1)) }}
            </div>
            <div class="text-xs text-[#71717A] flex items-center gap-1.5">
                <span>{{ __('طلبات اليوم:') }}</span>
                <span class="font-bold text-[#18181B]">{{ data_get($metrics, 'today_orders', 0) }}</span>
            </div>
        </div>

        <!-- Total Revenue Card -->
        <div class="bg-white border border-[#EADBCC] rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold text-[#71717A]">{{ __('إجمالي المبيعات') }}</span>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-200 text-lg flex items-center justify-center">
                    💵
                </div>
            </div>
            <div class="text-2xl font-bold text-[#18181B] mb-2 font-cinzel">
                ${{ number_format(data_get($metrics, 'total_revenue', data_get($metrics, 'total_sales', 648846)), 2) }}
            </div>
            <div class="text-[11px] text-[#71717A]">
                {{ __('بالليرة:') }} {{ number_format(data_get($metrics, 'revenue_syp', (data_get($metrics, 'total_revenue', 648846) * 15000)), 0) }} {{ __('ل.س') }}
            </div>
        </div>

        <!-- WhatsApp Clicks Card -->
        <div class="bg-white border border-[#EADBCC] rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold text-[#71717A]">{{ __('نقرات واتساب للشراء') }}</span>
                <div class="w-10 h-10 rounded-xl bg-[#10B981]/10 border border-[#10B981]/20 text-[#10B981] text-lg flex items-center justify-center">
                    💬
                </div>
            </div>
            <div class="text-3xl font-bold text-[#18181B] mb-2 font-cinzel">
                {{ data_get($metrics, 'whatsapp_clicks', data_get($metrics, 'whatsapp_total', 0)) }}
            </div>
            <div class="text-xs text-[#10B981] font-semibold flex items-center gap-1">
                <span>{{ __('اليوم:') }}</span>
                <span>{{ data_get($metrics, 'today_whatsapp_clicks', 0) }} {{ __('نقرة') }}</span>
            </div>
        </div>

        <!-- Abandoned Carts Card -->
        <div class="bg-white border border-[#EADBCC] rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold text-[#71717A]">{{ __('سلات تسوق متروكة') }}</span>
                <div class="w-10 h-10 rounded-xl bg-red-50 border border-red-200 text-red-600 text-lg flex items-center justify-center">
                    🛒
                </div>
            </div>
            <div class="text-3xl font-bold text-[#18181B] mb-2 font-cinzel">
                {{ data_get($metrics, 'abandoned_carts_count', 0) }}
            </div>
            <div class="text-xs text-[#71717A] flex items-center justify-between">
                <span>{{ __('القيمة:') }} ${{ number_format(data_get($metrics, 'abandoned_carts_value', 0), 2) }}</span>
                <a href="{{ route('admin.abandoned-carts.index') }}" class="text-[#C5A059] font-bold hover:underline text-[11px]">
                    {{ __('متابعة ←') }}
                </a>
            </div>
        </div>

    </div>

    <!-- Main Content: Top Products Table & Management Links -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
        
        <!-- Top Selling Watches Table (Takes 2 Columns) -->
        <div class="lg:col-span-2 bg-white border border-[#EADBCC] rounded-2xl shadow-sm overflow-hidden">
            <div class="p-6 border-b border-[#EADBCC] flex items-center justify-between">
                <div>
                    <h2 class="font-bold text-base text-[#18181B] flex items-center gap-2">
                        <span>🏆</span>
                        <span>{{ __('الساعات والمنتجات الأكثر طلباً') }}</span>
                    </h2>
                    <p class="text-xs text-[#71717A] mt-0.5">{{ __('قائمة المنتجات الأكثر مبيعاً وتحقيقاً للإيرادات') }}</p>
                </div>
                <a href="{{ route('admin.products.index') }}" class="text-xs font-bold text-[#C5A059] hover:underline">
                    {{ __('عرض الكل ←') }}
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-start text-xs">
                    <thead class="bg-[#F8F6F2] text-[#71717A] uppercase text-[11px] border-b border-[#EADBCC]">
                        <tr>
                            <th class="py-3.5 px-6 text-start font-semibold">{{ __('المنتج') }}</th>
                            <th class="py-3.5 px-6 text-start font-semibold">{{ __('القطع المباعة') }}</th>
                            <th class="py-3.5 px-6 text-start font-semibold">{{ __('إجمالي الإيراد') }}</th>
                            <th class="py-3.5 px-6 text-end font-semibold">{{ __('إجراء') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#EADBCC]">
                        @forelse($topProducts ?? [] as $product)
                            <tr class="hover:bg-[#F8F6F2]/50 transition-colors">
                                <td class="py-4 px-6 flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-[#F8F6F2] border border-[#EADBCC] p-1 flex-shrink-0 flex items-center justify-center">
                                        <img src="{{ asset(data_get($product, 'image', 'assets/site/img/watch-placeholder.png')) }}" 
                                             alt="{{ data_get($product, 'name', '') }}" 
                                             class="w-full h-full object-contain">
                                    </div>
                                    <span class="font-bold text-[#18181B] truncate max-w-xs block">
                                        {{ data_get($product, 'name', 'ساعة فاخرة') }}
                                    </span>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-[#C5A059]/10 text-[#C5A059] border border-[#C5A059]/20">
                                        {{ data_get($product, 'total_sold', data_get($product, 'sold_count', 2)) }} {{ __('قطعة') }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 font-bold text-[#18181B] font-cinzel">
                                    ${{ number_format(data_get($product, 'total_revenue', data_get($product, 'price', 648846)), 2) }}
                                </td>
                                <td class="py-4 px-6 text-end">
                                    <a href="{{ route('admin.products.edit', data_get($product, 'id', 1)) }}" 
                                       class="inline-block px-3 py-1.5 text-xs font-semibold rounded-lg border border-[#EADBCC] hover:bg-[#F8F6F2] text-[#18181B] transition-colors">
                                        {{ __('تعديل') }}
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-[#71717A]">{{ __('لا توجد إحصائيات مبيعات متوفرة حالياً.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Quick Actions Sidebar (Takes 1 Column) -->
        <div class="bg-white border border-[#EADBCC] rounded-2xl p-6 shadow-sm space-y-4">
            <h3 class="font-bold text-sm text-[#18181B] flex items-center gap-2 pb-3 border-b border-[#EADBCC]">
                <span>⚡</span>
                <span>{{ __('روابط سريعة للإدارة') }}</span>
            </h3>

            <div class="space-y-3">
                <a href="{{ route('admin.bundles.create') }}" 
                   class="flex items-center justify-between p-3.5 rounded-xl bg-[#F8F6F2] hover:bg-[#EADBCC]/50 border border-[#EADBCC] text-xs font-semibold text-[#18181B] transition-all group">
                    <div>
                        <div class="flex items-center gap-2 mb-0.5">
                            <span>🎁</span>
                            <span class="font-bold">{{ __('إنشاء عرض مجمع (Bundle)') }}</span>
                        </div>
                        <span class="text-[11px] text-[#71717A] block ps-6">{{ __('ادمج ساعتين أو أكثر بسعر مخفض') }}</span>
                    </div>
                    <span class="text-[#C5A059] group-hover:translate-x-1 rtl:group-hover:-translate-x-1 transition-transform">←</span>
                </a>

                <a href="{{ route('admin.settings.index') }}" 
                   class="flex items-center justify-between p-3.5 rounded-xl bg-[#F8F6F2] hover:bg-[#EADBCC]/50 border border-[#EADBCC] text-xs font-semibold text-[#18181B] transition-all group">
                    <div>
                        <div class="flex items-center gap-2 mb-0.5">
                            <span>⚙️</span>
                            <span class="font-bold">{{ __('تعديل سعر الصرف والعملات') }}</span>
                        </div>
                        <span class="text-[11px] text-[#71717A] block ps-6">{{ __('الحالي: $1 = 15,000 ل.س') }}</span>
                    </div>
                    <span class="text-[#C5A059] group-hover:translate-x-1 rtl:group-hover:-translate-x-1 transition-transform">←</span>
                </a>

                <a href="{{ route('admin.abandoned-carts.index') }}" 
                   class="flex items-center justify-between p-3.5 rounded-xl bg-[#F8F6F2] hover:bg-[#EADBCC]/50 border border-[#EADBCC] text-xs font-semibold text-[#18181B] transition-all group">
                    <div>
                        <div class="flex items-center gap-2 mb-0.5">
                            <span>🛒</span>
                            <span class="font-bold">{{ __('متابعة السلات المتروكة') }}</span>
                        </div>
                        <span class="text-[11px] text-[#71717A] block ps-6">{{ __('تواصل مع الزبائن عبر واتساب مباشرة') }}</span>
                    </div>
                    <span class="text-[#C5A059] group-hover:translate-x-1 rtl:group-hover:-translate-x-1 transition-transform">←</span>
                </a>

                <a href="{{ route('admin.analytics.index') }}" 
                   class="flex items-center justify-between p-3.5 rounded-xl bg-[#F8F6F2] hover:bg-[#EADBCC]/50 border border-[#EADBCC] text-xs font-semibold text-[#18181B] transition-all group">
                    <div>
                        <div class="flex items-center gap-2 mb-0.5">
                            <span>📊</span>
                            <span class="font-bold">{{ __('تقارير نقرات واتساب التفصيلية') }}</span>
                        </div>
                        <span class="text-[11px] text-[#71717A] block ps-6">{{ __('تحليل مصادر الزوار واهتماماتهم') }}</span>
                    </div>
                    <span class="text-[#C5A059] group-hover:translate-x-1 rtl:group-hover:-translate-x-1 transition-transform">←</span>
                </a>
            </div>
        </div>

    </div>

</div>
@endsection