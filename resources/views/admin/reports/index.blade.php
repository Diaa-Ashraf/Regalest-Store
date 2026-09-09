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
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Revenue & Orders Trend (Visual Responsive Timeline) --}}
        <div class="lg:col-span-2 bg-white border border-[#EADBCC] rounded-2xl p-5 sm:p-6 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-[#EADBCC] pb-3">
                <div class="flex items-center gap-2">
                    <span class="text-lg">📈</span>
                    <h3 class="font-bold text-[#18181B] text-base">{{ __('حركة المبيعات والطلبات اليومية') }}</h3>
                </div>
                <span class="text-xs font-semibold text-[#71717A] bg-[#F8F6F2] px-3 py-1 rounded-full border border-[#EADBCC]">
                    {{ count($reports['daily_trend']) }} {{ __('أيام نشطة') }}
                </span>
            </div>

            @if(!empty($reports['daily_trend']))
                <div class="overflow-x-auto no-scrollbar">
                    <div class="min-w-[500px] h-64 flex items-end gap-3 pt-6 pb-2 px-2">
                        @php
                            $maxDailyRevenue = max(array_map(fn($d) => (float)$d['daily_revenue'], $reports['daily_trend'])) ?: 1;
                        @endphp
                        @foreach($reports['daily_trend'] as $day)
                            @php
                                $heightPercent = max(10, min(100, round(((float)$day['daily_revenue'] / $maxDailyRevenue) * 100)));
                            @endphp
                            <div class="flex-1 flex flex-col items-center gap-1.5 group relative">
                                {{-- Tooltip --}}
                                <div class="absolute -top-12 opacity-0 group-hover:opacity-100 transition-opacity bg-[#18181B] text-white text-[10px] py-1 px-2 rounded-lg pointer-events-none whitespace-nowrap z-20 shadow-md">
                                    <div class="font-bold">${{ number_format($day['daily_revenue'], 2) }}</div>
                                    <div class="text-gray-300">{{ $day['orders_count'] }} {{ __('طلبات') }}</div>
                                </div>

                                {{-- Bar Container --}}
                                <div class="w-full bg-[#FAF8F5] rounded-xl flex items-end justify-center p-1 h-48 border border-[#EADBCC]/50">
                                    <div class="w-full bg-gradient-to-t from-[#C5A059] to-[#EADBCC] rounded-lg transition-all duration-500 group-hover:from-[#18181B] group-hover:to-[#C5A059]"
                                         style="height: {{ $heightPercent }}%;"></div>
                                </div>

                                {{-- Date Label --}}
                                <span class="text-[10px] font-bold text-[#71717A] truncate w-full text-center">
                                    {{ \Carbon\Carbon::parse($day['date'])->format('m/d') }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="py-16 text-center text-[#71717A] text-xs">
                    {{ __('لا توجد حركات مبيعات مسجلة في هذا النطاق الزمني المحدد.') }}
                </div>
            @endif
        </div>

        {{-- Order Status Breakdown & Funnel --}}
        <div class="bg-white border border-[#EADBCC] rounded-2xl p-5 sm:p-6 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between border-b border-[#EADBCC] pb-3 mb-4">
                    <h3 class="font-bold text-[#18181B] text-base flex items-center gap-2">
                        <span>📊</span>
                        <span>{{ __('حالات الطلبات') }}</span>
                    </h3>
                </div>

                <div class="space-y-3">
                    @php
                        $statuses = [
                            'pending' => ['label' => 'قيد الانتظار', 'color' => 'bg-amber-500', 'badge' => 'bg-amber-50 text-amber-700 border-amber-200'],
                            'confirmed' => ['label' => 'مؤكدة وجارية', 'color' => 'bg-sky-500', 'badge' => 'bg-sky-50 text-sky-700 border-sky-200'],
                            'delivered' => ['label' => 'تم التسليم بنجاح', 'color' => 'bg-emerald-500', 'badge' => 'bg-emerald-50 text-emerald-700 border-emerald-200'],
                            'cancelled' => ['label' => 'ملغاة', 'color' => 'bg-rose-500', 'badge' => 'bg-rose-50 text-rose-700 border-rose-200'],
                        ];
                    @endphp

                    @foreach($statuses as $stKey => $stMeta)
                        @php
                            $stData = $reports['orders_by_status'][$stKey] ?? null;
                            $count = $stData['count'] ?? 0;
                            $percent = $reports['total_orders'] > 0 ? round(($count / $reports['total_orders']) * 100) : 0;
                        @endphp
                        <div class="p-3 rounded-xl border border-gray-100 bg-[#FAF8F5]/60 space-y-2">
                            <div class="flex items-center justify-between text-xs font-bold">
                                <span class="flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full {{ $stMeta['color'] }}"></span>
                                    <span>{{ $stMeta['label'] }}</span>
                                </span>
                                <span class="font-mono text-sm text-[#18181B]">{{ $count }} ({{ $percent }}%)</span>
                            </div>
                            <div class="w-full bg-gray-200 h-1.5 rounded-full overflow-hidden">
                                <div class="{{ $stMeta['color'] }} h-full rounded-full transition-all duration-500" style="width: {{ $percent }}%;"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Abandoned Carts Mini Card --}}
            <div class="mt-5 p-4 rounded-xl bg-rose-50/70 border border-rose-200 text-xs">
                <div class="flex items-center justify-between font-bold text-rose-800 mb-1">
                    <span>🛒 {{ __('السلات المتروكة') }}</span>
                    <span>{{ $reports['abandoned']['total'] }} {{ __('سلة') }}</span>
                </div>
                <div class="flex items-center justify-between text-[11px] text-rose-600">
                    <span>{{ __('مستردة بنجاح:') }} <strong>{{ $reports['abandoned']['recovered'] }}</strong></span>
                    <span>{{ __('مبالغ معلقة:') }} <strong>${{ number_format($reports['abandoned']['unrecovered_amount'], 2) }}</strong></span>
                </div>
            </div>
        </div>

    </div>

    {{-- 4. Top Selling Products & Inventory Alerts Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        {{-- Top Selling Products --}}
        <div class="bg-white border border-[#EADBCC] rounded-2xl shadow-sm overflow-hidden">
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
@endsection
