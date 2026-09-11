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
                {{ __('متابعة طلبات واتساب والدفع عند الاستلام وتحديث حالات التجهيز والشحن والتسليم ومزامنة المخزون تلقائياً.') }}
            </p>
        </div>
    </div>

    @if (session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold flex items-center gap-2 shadow-xs">
            <span class="text-base">✓</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-medium space-y-1 shadow-xs">
            <span class="font-bold block text-sm">⚠️ {{ __('تنبيه في تحديث الطلب:') }}</span>
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

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
                <button type="submit" class="w-full py-2 px-4 rounded-xl bg-[#18181B] hover:bg-[#C5A059] text-white text-xs font-bold transition-all shadow-sm cursor-pointer">
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
                                <a href="{{ route('orders.show', $order->id) }}" class="hover:text-[#C5A059] transition-colors block">
                                    {{ $order->order_number ?? '#' . $order->id }}
                                </a>
                                @if($order->payment_method)
                                    <div class="mt-1">
                                        <span class="text-[10px] text-emerald-700 bg-emerald-50 border border-emerald-200 px-1.5 py-0.5 rounded-full font-sans font-medium">
                                            {{ __('واتساب') }}
                                        </span>
                                    </div>
                                @endif
                            </td>
                            <td class="py-4 px-4">
                                <div class="font-bold text-[#18181B] flex items-center gap-1.5 flex-wrap">
                                    <span>👤</span>
                                    <span>{{ $order->customer_display_name }}</span>
                                    @if(!$order->user_id)
                                        <span class="text-[9px] bg-amber-100 text-amber-800 font-bold px-1.5 py-0.5 rounded-md">
                                            {{ __('طلب مباشر') }}
                                        </span>
                                    @else
                                        <span class="text-[9px] bg-blue-100 text-blue-800 font-bold px-1.5 py-0.5 rounded-md">
                                            {{ __('عضو مسجل') }}
                                        </span>
                                    @endif
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
                                <span class="px-2.5 py-1 rounded-full border text-[11px] font-bold {{ $colorClass }} inline-block">
                                    {{ __($order->status) }}
                                </span>
                                @if($order->status === 'cancelled')
                                    <span class="block text-[9px] text-rose-600 font-bold mt-1">
                                        ✓ {{ __('المخزون مسترجع') }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-4">
                                <form id="cancelOrderForm_{{ $order->id }}" action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="inline-flex items-center gap-1.5">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="cancel_reason" value="تم الإلغاء واسترجاع المخزون">
                                    <select name="status" 
                                            data-prev-status="{{ $order->status }}"
                                            onchange="window.handleStatusChange(this, '{{ $order->id }}', '{{ $order->order_number ?? '#' . $order->id }}', '{{ addslashes($order->customer_display_name) }}')"
                                            class="text-[11px] py-1 ps-2 pe-6 rounded-lg bg-[#F8F6F2] border border-[#EADBCC] text-[#18181B] focus:outline-none focus:ring-1 focus:ring-[#C5A059] cursor-pointer font-medium">
                                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>{{ __('قيد الانتظار (محجوز)') }}</option>
                                        <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>{{ __('مؤكد (قيد الشحن)') }}</option>
                                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>{{ __('قيد التجهيز') }}</option>
                                        <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>{{ __('تم الشحن') }}</option>
                                        <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>{{ __('تم التسليم بنجاح') }}</option>
                                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>{{ __('إلغاء واسترجاع المخزون') }}</option>
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

    {{-- Luxury Custom Modal for Order Cancellation & Stock Restoration (Pure Vanilla JS for 100% Reliability) --}}
    <div id="luxuryCancelOrderModal" 
         class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/60 backdrop-blur-xs transition-opacity duration-200 opacity-0 pointer-events-none"
         dir="rtl">
        
        <div id="luxuryCancelOrderCard" 
             class="bg-white rounded-3xl border border-[#EADBCC] max-w-lg w-full p-6 sm:p-8 shadow-2xl space-y-5 transform transition-all duration-200 scale-95">
            
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-rose-50 border border-rose-200 text-rose-600 flex items-center justify-center text-2xl shrink-0 shadow-inner">
                    🔄
                </div>
                <div>
                    <h3 class="text-base sm:text-lg font-bold text-[#18181B]">{{ __('إلغاء الطلب واسترجاع كميات المخزون') }}</h3>
                    <p class="text-xs text-[#71717A] mt-0.5">
                        {{ __('الطلب:') }} <strong class="text-[#18181B]" id="cancelModalOrderNumber"></strong> &bull; <span id="cancelModalCustomerName"></span>
                    </p>
                </div>
            </div>

            <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900 text-xs leading-relaxed space-y-1">
                <div class="font-bold flex items-center gap-1.5 text-amber-900">
                    <span>📦</span>
                    <span>{{ __('مزامنة المخزون التلقائية:') }}</span>
                </div>
                <p>
                    {{ __('بمجرد تأكيد الإلغاء، سيقوم النظام تلقائياً بإعادة كامل كميات القطع المحجوزة في هذا الطلب إلى المخزون المتاح للبيع فوراً.') }}
                </p>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-gray-700">{{ __('سبب الإلغاء أو ملاحظة الإدارة (اختياري):') }}</label>
                <input type="text" 
                       id="cancelModalReasonInput" 
                       value="{{ __('تم الإلغاء واسترجاع المخزون') }}"
                       placeholder="{{ __('مثال: لم يرد العميل على واتساب، تم إلغاء الطلب بناءً على رغبته...') }}"
                       class="w-full px-4 py-2.5 text-xs rounded-xl bg-[#F8F6F2] border border-[#EADBCC] text-[#18181B] focus:outline-none focus:ring-2 focus:ring-rose-500 focus:bg-white">
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="button" 
                        onclick="window.confirmCancelOrder()"
                        class="flex-1 py-3 px-4 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold transition-all shadow-md active:scale-98 cursor-pointer flex items-center justify-center gap-2">
                    <span>✓</span>
                    <span>{{ __('تأكيد الإلغاء واسترجاع المخزون') }}</span>
                </button>

                <button type="button" 
                        onclick="window.closeCancelModal()"
                        class="py-3 px-5 rounded-xl bg-gray-100 hover:bg-gray-200 text-[#18181B] text-xs font-semibold transition-colors cursor-pointer">
                    {{ __('تراجع') }}
                </button>
            </div>

        </div>
    </div>

</div>

<script>
let currentCancelOrderId = null;
let currentCancelSelectEl = null;
let currentPrevStatus = 'pending';

window.handleStatusChange = function(selectEl, orderId, orderNumber, customerName) {
    const newStatus = selectEl.value;
    const prevStatus = selectEl.getAttribute('data-prev-status') || 'pending';

    if (newStatus === 'cancelled') {
        window.openCancelModal(orderId, orderNumber, customerName, selectEl, prevStatus);
    } else {
        selectEl.form.submit();
    }
};

window.openCancelModal = function(orderId, orderNumber, customerName, selectEl, prevStatus) {
    currentCancelOrderId = orderId;
    currentCancelSelectEl = selectEl;
    currentPrevStatus = prevStatus;

    const numEl = document.getElementById('cancelModalOrderNumber');
    const custEl = document.getElementById('cancelModalCustomerName');
    const inputEl = document.getElementById('cancelModalReasonInput');
    const modal = document.getElementById('luxuryCancelOrderModal');
    const card = document.getElementById('luxuryCancelOrderCard');

    if (numEl) numEl.textContent = orderNumber;
    if (custEl) custEl.textContent = customerName;
    if (inputEl) inputEl.value = '{{ __("تم الإلغاء واسترجاع المخزون") }}';

    if (!modal) return;

    modal.classList.remove('hidden');
    modal.classList.add('flex');
    requestAnimationFrame(() => {
        modal.classList.remove('opacity-0', 'pointer-events-none');
        modal.classList.add('opacity-100', 'pointer-events-auto');
        if (card) {
            card.classList.remove('scale-95');
            card.classList.add('scale-100');
        }
    });
};

window.closeCancelModal = function() {
    if (currentCancelSelectEl) {
        currentCancelSelectEl.value = currentPrevStatus;
    }
    const modal = document.getElementById('luxuryCancelOrderModal');
    const card = document.getElementById('luxuryCancelOrderCard');
    if (!modal) return;

    modal.classList.remove('opacity-100', 'pointer-events-auto');
    modal.classList.add('opacity-0', 'pointer-events-none');
    if (card) {
        card.classList.remove('scale-100');
        card.classList.add('scale-95');
    }
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }, 200);

    currentCancelOrderId = null;
    currentCancelSelectEl = null;
};

window.confirmCancelOrder = function() {
    if (!currentCancelOrderId) return;
    const form = document.getElementById('cancelOrderForm_' + currentCancelOrderId);
    if (form) {
        const reasonInput = form.querySelector('input[name="cancel_reason"]');
        const customReason = document.getElementById('cancelModalReasonInput')?.value;
        if (reasonInput) {
            reasonInput.value = customReason || '{{ __("تم الإلغاء واسترجاع المخزون") }}';
        }
        form.submit();
    }
};

// Close on backdrop click
document.getElementById('luxuryCancelOrderModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        window.closeCancelModal();
    }
});
</script>
@endsection