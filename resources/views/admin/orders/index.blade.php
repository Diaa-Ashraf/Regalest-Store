@extends('layouts.admin')

@section('title', __('إدارة ومتابعة الطلبات'))

@section('content')
<div class="space-y-6">
    
    <!-- Top Header -->
    <div class="bg-white border border-[#EADBCC] rounded-2xl p-6 sm:p-8 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="text-xs font-bold text-[#C5A059] uppercase tracking-wider">📦 Orders Pipeline</span>
            </div>
            <h1 class="font-cinzel text-2xl sm:text-3xl font-bold text-[#18181B]">
                {{ __('إدارة ومتابعة الطلبات') }}
            </h1>
            <p class="text-xs sm:text-sm text-[#71717A] mt-1">
                {{ __('متابعة طلبات واتساب والدفع عند الاستلام وتحديث حالات التجهيز والشحن والتسليم.') }}
            </p>
        </div>
    </div>

    <!-- Filters Card -->
    <div class="bg-white border border-[#EADBCC] rounded-2xl p-4 sm:p-6 shadow-sm">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 items-center">
            <div class="lg:col-span-5">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('بحث برقم الطلب، اسم العميل أو الهاتف...') }}" 
                       class="w-full px-4 py-2 text-xs rounded-xl bg-[#F8F6F2] border border-[#EADBCC] text-[#18181B] placeholder-[#71717A] focus:outline-none focus:ring-2 focus:ring-[#C5A059] focus:bg-white">
            </div>

            <div class="lg:col-span-4">
                <select name="status" class="w-full px-3 py-2 text-xs rounded-xl bg-[#F8F6F2] border border-[#EADBCC] text-[#18181B] focus:outline-none focus:ring-2 focus:ring-[#C5A059] focus:bg-white">
                    <option value="">{{ __('-- تصفية حسب الحالة (الكل) --') }}</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>{{ __('قيد الانتظار (Pending)') }}</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>{{ __('تم التأكيد (Confirmed)') }}</option>
                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>{{ __('قيد التجهيز (Processing)') }}</option>
                    <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>{{ __('تم الشحن (Shipped)') }}</option>
                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>{{ __('تم التسليم بنجاح (Delivered)') }}</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>{{ __('ملغي (Cancelled)') }}</option>
                </select>
            </div>

            <div class="lg:col-span-3 flex gap-2">
                <button type="submit" class="w-full py-2 px-4 rounded-xl bg-[#18181B] hover:bg-[#C5A059] text-white text-xs font-bold transition-all shadow-sm">
                    {{ __('تطبيق الفلتر') }}
                </button>
                @if(request()->hasAny(['search', 'status']))
                    <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 rounded-xl bg-[#F8F6F2] border border-[#EADBCC] text-[#18181B] text-xs font-semibold hover:bg-[#EADBCC] transition-colors shrink-0">
                        {{ __('إلغاء') }}
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Orders Table -->
    <div class="bg-white border border-[#EADBCC] rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-start text-xs">
                <thead class="bg-[#F8F6F2] text-[#71717A] uppercase text-[11px] border-b border-[#EADBCC]">
                    <tr>
                        <th class="py-3.5 px-6 text-start font-semibold">{{ __('رقم الطلب') }}</th>
                        <th class="py-3.5 px-4 text-start font-semibold">{{ __('العميل والهاتف') }}</th>
                        <th class="py-3.5 px-4 text-start font-semibold">{{ __('المنتجات') }}</th>
                        <th class="py-3.5 px-4 text-start font-semibold">{{ __('المجموع') }}</th>
                        <th class="py-3.5 px-4 text-start font-semibold">{{ __('الحالة الحالية') }}</th>
                        <th class="py-3.5 px-4 text-start font-semibold">{{ __('تغيير الحالة') }}</th>
                        <th class="py-3.5 px-6 text-end font-semibold">{{ __('التاريخ') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#EADBCC]">
                    @forelse($orders as $order)
                        <tr class="hover:bg-[#F8F6F2]/50 transition-colors">
                            <td class="py-4 px-6 font-bold text-[#18181B] font-cinzel">
                                <div>{{ $order->order_number ?? '#' . $order->id }}</div>
                                @if($order->payment_method)
                                    <span class="text-[10px] text-emerald-700 bg-emerald-50 border border-emerald-200 px-1.5 py-0.5 rounded-full font-sans font-medium">
                                        {{ __('واتساب') }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-4">
                                <div class="font-bold text-[#18181B] flex items-center gap-1">
                                    <span>👤</span>
                                    <span>{{ $order->user?->name ?? __('عميل المتجر') }}</span>
                                </div>
                                @if($order->phone)
                                    <div class="mt-1 flex items-center gap-1.5">
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->phone) }}" target="_blank" class="text-xs font-bold text-emerald-700 hover:underline font-mono inline-flex items-center gap-1">
                                            <span>💬</span>
                                            <span>{{ $order->phone }}</span>
                                        </a>
                                    </div>
                                @endif
                                @if($order->address)
                                    <div class="text-[11px] text-[#71717A] mt-1 max-w-[220px] truncate" title="{{ $order->address }}">
                                        📍 {{ $order->address }}
                                    </div>
                                @endif
                                @if($order->notes)
                                    <div class="text-[10px] text-amber-700 bg-amber-50 border border-amber-200 px-2 py-0.5 rounded-lg mt-1 max-w-[220px] truncate" title="{{ $order->notes }}">
                                        📝 {{ $order->notes }}
                                    </div>
                                @endif
                            </td>
                            <td class="py-4 px-4">
                                <span class="px-2.5 py-1 rounded-full bg-[#F8F6F2] border border-[#EADBCC] text-[11px] font-semibold text-[#18181B] inline-block mb-1">
                                    {{ $order->orderItems->count() }} {{ __('عناصر') }}
                                </span>
                                @if($order->orderItems->isNotEmpty())
                                    <div class="space-y-0.5 max-w-[200px]">
                                        @foreach($order->orderItems->take(2) as $oItem)
                                            <div class="text-[11px] text-[#71717A] truncate">
                                                • {{ $oItem->product->name ?? __('منتج') }} (×{{ $oItem->quantity }})
                                            </div>
                                        @endforeach
                                        @if($order->orderItems->count() > 2)
                                            <div class="text-[10px] text-gray-400 font-bold">
                                                + {{ $order->orderItems->count() - 2 }} {{ __('منتجات إضافية') }}
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </td>
                            <td class="py-4 px-4 font-bold text-[#18181B] font-cinzel text-xs">
                                {{ format_currency($order->total_usd ?? $order->total_price ?? 0) }}
                            </td>
                            <td class="py-4 px-4">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
                                        'confirmed' => 'bg-blue-50 text-blue-700 border-blue-200',
                                        'processing' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                                        'shipped' => 'bg-purple-50 text-purple-700 border-purple-200',
                                        'delivered' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                        'cancelled' => 'bg-rose-50 text-rose-700 border-rose-200',
                                    ];
                                    $colorClass = $statusColors[$order->status] ?? 'bg-gray-50 text-gray-700 border-gray-200';
                                @endphp
                                <span class="px-2.5 py-1 rounded-full border text-[11px] font-bold {{ $colorClass }}">
                                    {{ __($order->status) }}
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="inline-flex items-center gap-1.5">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" onchange="this.form.submit()" class="text-[11px] py-1 ps-2 pe-6 rounded-lg bg-[#F8F6F2] border border-[#EADBCC] text-[#18181B] focus:outline-none focus:ring-1 focus:ring-[#C5A059]">
                                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>{{ __('قيد الانتظار') }}</option>
                                        <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>{{ __('مؤكد') }}</option>
                                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>{{ __('قيد التجهيز') }}</option>
                                        <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>{{ __('تم الشحن') }}</option>
                                        <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>{{ __('تم التسليم') }}</option>
                                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>{{ __('ملغي') }}</option>
                                    </select>
                                </form>
                            </td>
                            <td class="py-4 px-6 text-end text-[11px] text-[#71717A] font-mono">
                                {{ $order->created_at->format('Y-m-d H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-[#71717A]">
                                {{ __('لا توجد طلبات مسجلة حالياً.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
            <div class="p-4 border-t border-[#EADBCC] bg-[#F8F6F2]/30">
                {{ $orders->links() }}
            </div>
        @endif
    </div>

</div>
@endsection