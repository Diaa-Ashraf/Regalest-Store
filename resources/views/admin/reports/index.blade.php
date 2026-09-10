@extends('layouts.admin')

@section('title', __('التقارير الشاملة ومؤشرات الأداء'))

@section('content')
<div class="space-y-6 sm:space-y-8">

    {{-- 1. Top Header Bar & Period Filter --}}
    <div class="bg-white border border-[#EADBCC] rounded-2xl p-5 sm:p-6 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="text-xs font-bold text-[#C5A059] uppercase tracking-wider">📊 Analytics & Performance Reports</span>
            </div>
            <h1 class="font-cinzel text-2xl sm:text-3xl font-bold text-[#18181B]">
                {{ __('التقارير الشاملة وتحليلات الأداء') }}
            </h1>
            <p class="text-xs sm:text-sm text-[#71717A] mt-1">
                {{ __('تقارير دقيقة ومحدثة حول المبيعات، إيرادات المتجر، تحويلات واتساب، وحركة المخزون.') }}
            </p>
        </div>

        {{-- Period Filters (Cached per day/period for high performance) --}}
        <div class="flex items-center gap-1.5 bg-[#F8F6F2] border border-[#EADBCC] p-1.5 rounded-2xl shrink-0 overflow-x-auto no-scrollbar">
            <a href="{{ route('admin.reports.index', ['period' => 'today']) }}" 
               class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all whitespace-nowrap {{ $period === 'today' ? 'bg-[#C5A059] text-white shadow-xs' : 'text-[#71717A] hover:text-[#18181B]' }}">
                {{ __('اليوم') }}
            </a>
            <a href="{{ route('admin.reports.index', ['period' => 'week']) }}" 
               class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all whitespace-nowrap {{ $period === 'week' ? 'bg-[#C5A059] text-white shadow-xs' : 'text-[#71717A] hover:text-[#18181B]' }}">
                {{ __('هذا الأسبوع') }}
            </a>
            <a href="{{ route('admin.reports.index', ['period' => 'month']) }}" 
               class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all whitespace-nowrap {{ $period === 'month' ? 'bg-[#C5A059] text-white shadow-xs' : 'text-[#71717A] hover:text-[#18181B]' }}">
                {{ __('هذا الشهر') }}
            </a>
            <a href="{{ route('admin.reports.index', ['period' => 'year']) }}" 
               class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all whitespace-nowrap {{ $period === 'year' ? 'bg-[#C5A059] text-white shadow-xs' : 'text-[#71717A] hover:text-[#18181B]' }}">
                {{ __('هذا العام') }}
            </a>
            <a href="{{ route('admin.reports.index', ['period' => 'all']) }}" 
               class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all whitespace-nowrap {{ $period === 'all' ? 'bg-[#C5A059] text-white shadow-xs' : 'text-[#71717A] hover:text-[#18181B]' }}">
                {{ __('الكل') }}
            </a>
        </div>
    </div>

    {{-- 2. Four Master KPI Metric Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
        
        <!-- Total Sales Revenue -->
        <div class="bg-white border border-[#EADBCC] rounded-2xl p-5 sm:p-6 shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-[#71717A]">{{ __('إجمالي المبيعات المحققة') }}</span>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-600 flex items-center justify-center text-lg">
                    💰
                </div>
            </div>
            <div>
                <div class="text-2xl sm:text-3xl font-black text-[#18181B] font-cinzel">
                    ${{ number_format($reports['total_sales'], 2) }}
                </div>
                <div class="mt-2 text-[11px] text-emerald-700 bg-emerald-50 border border-emerald-200 px-2.5 py-1 rounded-lg inline-flex items-center gap-1 font-bold">
                    <span>✓</span>
                    <span>{{ __('الطلبات المؤكدة وغير الملغاة') }}</span>
                </div>
            </div>
        </div>

        <!-- Total Orders & Fulfillment Rate -->
        <div class="bg-white border border-[#EADBCC] rounded-2xl p-5 sm:p-6 shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-[#71717A]">{{ __('عدد الطلبات المسجلة') }}</span>
                <div class="w-10 h-10 rounded-xl bg-[#F8F6F2] border border-[#EADBCC] text-[#C5A059] flex items-center justify-center text-lg">
                    📦
                </div>
            </div>
            <div>
                <div class="text-2xl sm:text-3xl font-black text-[#18181B] font-cinzel">
                    {{ number_format($reports['total_orders']) }}
                </div>
                <div class="mt-2 text-[11px] text-[#71717A] flex items-center justify-between font-medium">
                    <span>{{ __('المسلّمة:') }} <strong class="text-emerald-700">{{ $reports['delivered_orders'] }}</strong></span>
                    <span>{{ __('الملغاة:') }} <strong class="text-rose-700">{{ $reports['cancelled_orders'] }}</strong></span>
                </div>
            </div>
        </div>

        <!-- Average Order Value (AOV) -->
        <div class="bg-white border border-[#EADBCC] rounded-2xl p-5 sm:p-6 shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-[#71717A]">{{ __('متوسط قيمة الطلب (AOV)') }}</span>
                <div class="w-10 h-10 rounded-xl bg-amber-50 border border-amber-200 text-amber-600 flex items-center justify-center text-lg">
                    📈
                </div>
            </div>
            <div>
                <div class="text-2xl sm:text-3xl font-black text-[#C5A059] font-cinzel">
                    ${{ number_format($reports['avg_order_value'], 2) }}
                </div>
                <div class="mt-2 text-[11px] text-[#71717A] font-medium">
                    <span>{{ __('معدل الإنفاق لكل زبون في الفترة') }}</span>
                </div>
            </div>
        </div>

        <!-- WhatsApp Checkout Conversion -->
        <div class="bg-white border border-[#EADBCC] rounded-2xl p-5 sm:p-6 shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-[#71717A]">{{ __('معدل تحويل واتساب') }}</span>
                <div class="w-10 h-10 rounded-xl bg-[#25D366]/10 border border-[#25D366]/30 text-[#25D366] flex items-center justify-center text-lg">
                    💬
                </div>
            </div>
            <div>
                <div class="text-2xl sm:text-3xl font-black text-[#18181B] font-cinzel">
                    {{ $reports['whatsapp']['conversion_rate'] }}%
                </div>
                <div class="mt-2 text-[11px] text-[#71717A] flex items-center justify-between font-medium">
                    <span>{{ __('نقرات الإتمام:') }} <strong class="text-[#18181B]">{{ $reports['whatsapp']['checkout'] }}</strong></span>
                    <span>{{ __('استفسارات:') }} <strong class="text-[#18181B]">{{ $reports['whatsapp']['inquiry'] }}</strong></span>
                </div>
            </div>
        </div>

    </div>

    {{-- 3. Visual Charts & Sales Trend Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6" x-data="{ viewMode: 'chart' }">
        
        {{-- Revenue & Orders Trend (Interactive Chart + Detailed Table) --}}
        <div class="lg:col-span-2 bg-white border border-[#EADBCC] rounded-2xl p-5 sm:p-6 shadow-sm space-y-5 flex flex-col justify-between">
            <div>
                {{-- Chart Header with Switcher --}}
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-[#EADBCC] pb-4">
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-xl bg-[#F8F6F2] border border-[#EADBCC] text-[#C5A059] flex items-center justify-center text-base shrink-0">
                            📈
                        </div>
                        <div>
                            <h3 class="font-bold text-[#18181B] text-base leading-tight">{{ __('حركة المبيعات والطلبات اليومية') }}</h3>
                            <p class="text-[11px] text-[#71717A] mt-0.5">{{ __('متابعة نمو الإيرادات وحجم الطلبات على مدار الأيام') }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        {{-- Quick View Toggle --}}
                        <div class="flex items-center bg-[#F8F6F2] border border-[#EADBCC] p-1 rounded-xl text-xs font-semibold">
                            <button type="button" 
                                    @click="viewMode = 'chart'"
                                    :class="viewMode === 'chart' ? 'bg-[#C5A059] text-white shadow-xs' : 'text-[#71717A] hover:text-[#18181B]'"
                                    class="px-3 py-1 rounded-lg transition-all cursor-pointer">
                                📊 {{ __('رسم بياني') }}
                            </button>
                            <button type="button" 
                                    @click="viewMode = 'table'"
                                    :class="viewMode === 'table' ? 'bg-[#C5A059] text-white shadow-xs' : 'text-[#71717A] hover:text-[#18181B]'"
                                    class="px-3 py-1 rounded-lg transition-all cursor-pointer">
                                📋 {{ __('جدول تفصيلي') }}
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Trend Highlights summary strip --}}
                @php
                    $trendRevenueTotal = array_sum(array_column($reports['daily_trend'] ?? [], 'daily_revenue'));
                    $trendOrdersTotal = array_sum(array_column($reports['daily_trend'] ?? [], 'orders_count'));
                    $trendDaysCount = count($reports['daily_trend'] ?? []);
                    $activeDaysCount = count(array_filter($reports['daily_trend'] ?? [], fn($d) => ($d['daily_revenue'] > 0 || $d['orders_count'] > 0)));
                @endphp
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5 sm:gap-3 my-4">
                    <div class="p-2.5 sm:p-3 bg-[#FAF8F5] border border-[#EADBCC] rounded-xl flex items-center gap-3">
                        <span class="text-base sm:text-lg shrink-0">💵</span>
                        <div class="min-w-0">
                            <span class="text-[10px] sm:text-[11px] text-[#71717A] block truncate">{{ __('إجمالي إيراد الفترة:') }}</span>
                            <span class="text-xs sm:text-sm font-black text-[#18181B] font-cinzel truncate block">${{ number_format($trendRevenueTotal, 2) }}</span>
                        </div>
                    </div>
                    <div class="p-2.5 sm:p-3 bg-[#FAF8F5] border border-[#EADBCC] rounded-xl flex items-center gap-3">
                        <span class="text-base sm:text-lg shrink-0">📦</span>
                        <div class="min-w-0">
                            <span class="text-[10px] sm:text-[11px] text-[#71717A] block truncate">{{ __('إجمالي طلبات الفترة:') }}</span>
                            <span class="text-xs sm:text-sm font-black text-[#18181B] font-cinzel truncate block">{{ number_format($trendOrdersTotal) }} {{ __('طلب') }}</span>
                        </div>
                    </div>
                    <div class="col-span-2 sm:col-span-1 p-2.5 sm:p-3 bg-[#FAF8F5] border border-[#EADBCC] rounded-xl flex items-center gap-3">
                        <span class="text-base sm:text-lg shrink-0">📅</span>
                        <div class="min-w-0">
                            <span class="text-[10px] sm:text-[11px] text-[#71717A] block truncate">{{ __('الأيام ذات النشاط:') }}</span>
                            <span class="text-xs sm:text-sm font-bold text-[#C5A059] truncate block">{{ $activeDaysCount }} / {{ $trendDaysCount }} {{ __('يوم') }}</span>
                        </div>
                    </div>
                </div>

                {{-- View 1: Chart.js Area Chart --}}
                <div x-show="viewMode === 'chart'" class="relative w-full h-72 sm:h-80 pt-2">
                    <canvas id="salesTrendChart" class="w-full h-full"></canvas>
                </div>

                {{-- View 2: Detailed Day-by-Day Table --}}
                <div x-show="viewMode === 'table'" x-cloak style="display: none;" class="pt-2">
                    <div class="border border-[#EADBCC] rounded-xl overflow-hidden max-h-80 overflow-y-auto admin-scrollbar">
                        <table class="w-full text-right text-xs">
                            <thead class="bg-[#FAF8F5] text-[#71717A] border-b border-[#EADBCC] sticky top-0 z-10 font-bold">
                                <tr>
                                    <th class="p-3">{{ __('التاريخ') }}</th>
                                    <th class="p-3 text-center">{{ __('عدد الطلبات') }}</th>
                                    <th class="p-3 text-end">{{ __('الإيراد المحقق') }}</th>
                                    <th class="p-3 text-end">{{ __('متوسط الطلب') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse(array_reverse($reports['daily_trend']) as $row)
                                    @php
                                        $rowAvg = $row['orders_count'] > 0 ? ($row['daily_revenue'] / $row['orders_count']) : 0;
                                        $hasActivity = $row['orders_count'] > 0 || $row['daily_revenue'] > 0;
                                    @endphp
                                    <tr class="hover:bg-[#FAF8F5]/60 transition-colors {{ $hasActivity ? 'font-semibold' : 'text-gray-400' }}">
                                        <td class="p-3 flex items-center gap-2">
                                            <span class="w-2 h-2 rounded-full {{ $hasActivity ? 'bg-emerald-500' : 'bg-gray-300' }}"></span>
                                            <span>{{ \Carbon\Carbon::parse($row['date'])->translatedFormat('l, d M Y') }}</span>
                                        </td>
                                        <td class="p-3 text-center">
                                            @if($row['orders_count'] > 0)
                                                <span class="px-2.5 py-0.5 rounded-full bg-[#18181B] text-white text-[11px] font-bold">
                                                    {{ $row['orders_count'] }}
                                                </span>
                                            @else
                                                <span class="text-gray-300">-</span>
                                            @endif
                                        </td>
                                        <td class="p-3 text-end font-cinzel text-sm {{ $row['daily_revenue'] > 0 ? 'text-[#C5A059] font-bold' : 'text-gray-400' }}">
                                            ${{ number_format($row['daily_revenue'], 2) }}
                                        </td>
                                        <td class="p-3 text-end font-cinzel text-xs text-[#71717A]">
                                            ${{ number_format($rowAvg, 2) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="p-8 text-center text-[#71717A]">
                                            {{ __('لا توجد سجلات مبيعات في هذا النطاق.') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="pt-3 border-t border-[#EADBCC] flex items-center justify-between text-xs text-[#71717A]">
                <span class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span>{{ __('البيانات تستثني الطلبات الملغاة لضمان دقة الإيراد') }}</span>
                </span>
                <span class="font-bold text-[#18181B]">{{ $trendDaysCount }} {{ __('يوماً في النطاق') }}</span>
            </div>
        </div>

        {{-- Order Status Breakdown & Funnel --}}
        <div class="bg-white border border-[#EADBCC] rounded-2xl p-5 sm:p-6 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between border-b border-[#EADBCC] pb-3 mb-4">
                    <h3 class="font-bold text-[#18181B] text-base flex items-center gap-2">
                        <span>📊</span>
                        <span>{{ __('حالات الطلبات ونسب التنفيذ') }}</span>
                    </h3>
                </div>

                <div class="space-y-3">
                    @php
                        $statuses = [
                            'pending' => ['label' => 'قيد الانتظار', 'color' => 'bg-amber-500', 'textColor' => 'text-amber-700', 'badge' => 'bg-amber-50 text-amber-700 border-amber-200'],
                            'confirmed' => ['label' => 'مؤكدة وجارية', 'color' => 'bg-sky-500', 'textColor' => 'text-sky-700', 'badge' => 'bg-sky-50 text-sky-700 border-sky-200'],
                            'delivered' => ['label' => 'تم التسليم بنجاح', 'color' => 'bg-emerald-500', 'textColor' => 'text-emerald-700', 'badge' => 'bg-emerald-50 text-emerald-700 border-emerald-200'],
                            'cancelled' => ['label' => 'ملغاة', 'color' => 'bg-rose-500', 'textColor' => 'text-rose-700', 'badge' => 'bg-rose-50 text-rose-700 border-rose-200'],
                        ];
                    @endphp

                    @foreach($statuses as $stKey => $stMeta)
                        @php
                            $stData = $reports['orders_by_status'][$stKey] ?? null;
                            $count = $stData['count'] ?? 0;
                            $amount = (float)($stData['total_amount'] ?? 0.0);
                            $percent = $reports['total_orders'] > 0 ? round(($count / $reports['total_orders']) * 100) : 0;
                        @endphp
                        <div class="p-3 rounded-xl border border-[#EADBCC]/60 bg-[#FAF8F5]/60 hover:bg-[#FAF8F5] transition-colors space-y-2">
                            <div class="flex items-center justify-between text-xs font-bold">
                                <span class="flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full {{ $stMeta['color'] }}"></span>
                                    <span>{{ $stMeta['label'] }}</span>
                                </span>
                                <div class="flex items-center gap-2">
                                    <span class="font-cinzel text-xs text-[#71717A]">${{ number_format($amount, 2) }}</span>
                                    <span class="font-mono text-xs px-2 py-0.5 rounded-md bg-white border border-gray-200 text-[#18181B]">{{ $count }} ({{ $percent }}%)</span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-200/80 h-2 rounded-full overflow-hidden">
                                <div class="{{ $stMeta['color'] }} h-full rounded-full transition-all duration-700" style="width: {{ $percent }}%;"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Abandoned Carts Mini Card --}}
            <div class="mt-5 p-4 rounded-xl bg-rose-50/70 border border-rose-200 text-xs space-y-2">
                <div class="flex items-center justify-between font-bold text-rose-800">
                    <span class="flex items-center gap-1.5">
                        <span>🛒</span>
                        <span>{{ __('السلات المتروكة') }}</span>
                    </span>
                    <span class="px-2 py-0.5 rounded-full bg-rose-100 text-rose-800 text-[11px] font-bold">
                        {{ $reports['abandoned']['total'] }} {{ __('سلة') }}
                    </span>
                </div>
                <div class="flex items-center justify-between text-[11px] text-rose-700 font-medium pt-1 border-t border-rose-200/60">
                    <span>{{ __('مستردة بنجاح:') }} <strong class="text-emerald-700">{{ $reports['abandoned']['recovered'] }}</strong></span>
                    <span>{{ __('مبالغ معلقة:') }} <strong class="font-cinzel font-bold">${{ number_format($reports['abandoned']['unrecovered_amount'], 2) }}</strong></span>
                </div>
            </div>
        </div>

    </div>

    {{-- 4. Top Selling Products & Inventory Alerts Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        {{-- Top Selling Products --}}
        <div class="bg-white border border-[#EADBCC] rounded-2xl shadow-sm overflow-hidden flex flex-col justify-between">
            <div>
                <div class="p-4 sm:p-5 border-b border-[#EADBCC] flex items-center justify-between bg-[#FAF8F5]">
                    <h3 class="font-bold text-[#18181B] text-base flex items-center gap-2">
                        <span>👑</span>
                        <span>{{ __('المنتجات الأكثر مبيعاً وتحقيقاً للإيراد') }}</span>
                    </h3>
                    <a href="{{ route('admin.products.index') }}" class="text-xs text-[#C5A059] font-bold hover:underline">
                        {{ __('عرض المنتجات') }} &larr;
                    </a>
                </div>

                <div class="divide-y divide-gray-100">
                    @forelse($reports['top_products'] as $item)
                        <div class="p-3.5 sm:p-4 flex items-center justify-between gap-3 hover:bg-[#FAF8F5]/50 transition-colors">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-11 h-11 rounded-xl bg-[#F8F6F2] border border-[#EADBCC] p-1 shrink-0 overflow-hidden flex items-center justify-center">
                                    @if($item['image'])
                                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover rounded-lg">
                                    @else
                                        <span>💎</span>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <h4 class="font-bold text-xs sm:text-sm text-[#18181B] truncate">{{ $item['name'] }}</h4>
                                    <span class="text-[11px] text-[#71717A]">{{ __('الكمية المباعة:') }} <strong class="text-[#18181B]">{{ $item['total_sold'] }}</strong></span>
                                </div>
                            </div>

                            <div class="text-end shrink-0">
                                <span class="text-sm font-black text-[#C5A059] font-cinzel block leading-tight">
                                    ${{ number_format($item['total_revenue'], 2) }}
                                </span>
                                <span class="text-[10px] text-gray-400">{{ __('إجمالي المبيعات') }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-xs text-[#71717A]">
                            {{ __('لا توجد مبيعات منتجات مسجلة حتى الآن.') }}
                        </div>
                    @endforelse
                </div>
            </div>
            
            <div class="p-3.5 bg-[#FAF8F5] border-t border-[#EADBCC] text-end">
                <a href="{{ route('admin.products.index') }}" class="text-xs font-bold text-[#C5A059] hover:underline">
                    {{ __('إدارة المنتجات الكاملة') }} &rarr;
                </a>
            </div>
        </div>

        {{-- Inventory & Low Stock Alerts --}}
        <div class="bg-white border border-[#EADBCC] rounded-2xl shadow-sm overflow-hidden flex flex-col justify-between">
            <div>
                <div class="p-4 sm:p-5 border-b border-[#EADBCC] flex items-center justify-between bg-[#FAF8F5]">
                    <h3 class="font-bold text-[#18181B] text-base flex items-center gap-2">
                        <span>⚠️</span>
                        <span>{{ __('تنبيهات المخزون والكميات المنخفضة') }}</span>
                    </h3>
                    <span class="text-xs font-bold text-rose-700 bg-rose-50 border border-rose-200 px-2.5 py-0.5 rounded-full">
                        {{ $reports['stock_metrics']['out_of_stock'] }} {{ __('نفدت بالكامل') }}
                    </span>
                </div>

                <div class="divide-y divide-gray-100">
                    @forelse($reports['low_stock_products'] as $prod)
                        <div class="p-3.5 sm:p-4 flex items-center justify-between gap-3 hover:bg-[#FAF8F5]/50 transition-colors">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-11 h-11 rounded-xl bg-[#F8F6F2] border border-[#EADBCC] p-1 shrink-0 overflow-hidden flex items-center justify-center">
                                    @if($prod->image_url)
                                        <img src="{{ $prod->image_url }}" alt="{{ $prod->name }}" class="w-full h-full object-cover rounded-lg">
                                    @else
                                        <span>📦</span>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <h4 class="font-bold text-xs sm:text-sm text-[#18181B] truncate">{{ $prod->name }}</h4>
                                    <span class="text-[11px] text-[#71717A]">{{ __('السعر:') }} <strong>${{ number_format($prod->price, 2) }}</strong></span>
                                </div>
                            </div>

                            <div class="text-end shrink-0">
                                <span class="px-2.5 py-1 rounded-lg text-xs font-bold {{ $prod->available_stock <= 2 ? 'bg-rose-100 text-rose-700' : 'bg-amber-100 text-amber-700' }}">
                                    {{ $prod->available_stock }} {{ __('قطع متبقية') }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-xs text-[#71717A]">
                            {{ __('المخزون بحالة ممتازة ولا توجد منتجات منخفضة الكمية.') }}
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="p-4 bg-[#FAF8F5] border-t border-[#EADBCC] flex items-center justify-between text-xs text-[#71717A]">
                <span>{{ __('إجمالي المنتجات في المتجر:') }} <strong class="text-[#18181B]">{{ $reports['stock_metrics']['total_products'] }}</strong></span>
                <a href="{{ route('admin.products.index') }}" class="font-bold text-[#C5A059] hover:underline">
                    {{ __('إدارة المخزون') }} &rarr;
                </a>
            </div>
        </div>

    </div>

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const trendData = @json($reports['daily_trend'] ?? []);
        const labels = trendData.map(d => {
            const parts = d.date.split('-');
            return parts.length === 3 ? `${parts[1]}/${parts[2]}` : d.date;
        });
        const revenueData = trendData.map(d => parseFloat(d.daily_revenue || 0));
        const ordersData = trendData.map(d => parseInt(d.orders_count || 0));

        const ctx = document.getElementById('salesTrendChart');
        if (ctx) {
            const chartCtx = ctx.getContext('2d');
            
            // Create luxury gold gradient
            const goldGradient = chartCtx.createLinearGradient(0, 0, 0, 300);
            goldGradient.addColorStop(0, 'rgba(197, 160, 89, 0.45)');
            goldGradient.addColorStop(1, 'rgba(197, 160, 89, 0.02)');

            new Chart(chartCtx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: '{{ __("الإيراد اليومي ($)") }}',
                            data: revenueData,
                            borderColor: '#C5A059',
                            backgroundColor: goldGradient,
                            borderWidth: 2.5,
                            fill: true,
                            tension: 0.35,
                            pointBackgroundColor: '#18181B',
                            pointBorderColor: '#C5A059',
                            pointBorderWidth: 2,
                            pointRadius: 3.5,
                            pointHoverRadius: 6,
                            yAxisID: 'yRevenue',
                        },
                        {
                            label: '{{ __("عدد الطلبات") }}',
                            data: ordersData,
                            borderColor: '#18181B',
                            backgroundColor: 'transparent',
                            borderWidth: 1.8,
                            borderDash: [4, 4],
                            pointBackgroundColor: '#18181B',
                            pointRadius: 3,
                            tension: 0.3,
                            yAxisID: 'yOrders',
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                            align: 'end',
                            labels: {
                                boxWidth: 12,
                                boxHeight: 12,
                                font: {
                                    family: "'Readex Pro', sans-serif",
                                    size: 11,
                                    weight: 'bold'
                                },
                                color: '#18181B'
                            }
                        },
                        tooltip: {
                            rtl: true,
                            backgroundColor: '#18181B',
                            titleFont: { family: "'Readex Pro', sans-serif", size: 12, weight: 'bold' },
                            bodyFont: { family: "'Readex Pro', sans-serif", size: 11 },
                            padding: 10,
                            cornerRadius: 10,
                            callbacks: {
                                label: function(context) {
                                    if (context.datasetIndex === 0) {
                                        return ` الإيراد: $${context.parsed.y.toFixed(2)}`;
                                    }
                                    return ` الطلبات: ${context.parsed.y} طلب`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                font: { family: "'Plus Jakarta Sans', sans-serif", size: 10 },
                                color: '#71717A',
                                maxRotation: 0,
                                autoSkip: true,
                                maxTicksLimit: 12
                            }
                        },
                        yRevenue: {
                            type: 'linear',
                            position: 'right',
                            grid: {
                                color: 'rgba(234, 219, 204, 0.45)',
                                drawBorder: false
                            },
                            ticks: {
                                font: { family: "'Plus Jakarta Sans', sans-serif", size: 10 },
                                color: '#C5A059',
                                callback: function(value) {
                                    return '$' + value;
                                }
                            }
                        },
                        yOrders: {
                            type: 'linear',
                            position: 'left',
                            grid: {
                                display: false
                            },
                            ticks: {
                                stepSize: 1,
                                font: { family: "'Plus Jakarta Sans', sans-serif", size: 10 },
                                color: '#71717A',
                                callback: function(value) {
                                    return value + ' ط';
                                }
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endpush
@endsection
