@extends('layouts.admin')

@section('title', __('تفاصيل الطلب') . ' ' . ($order->order_number ?? '#' . $order->id))

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    
    <!-- Header -->
    <div class="bg-white border border-[#EADBCC] rounded-2xl p-6 sm:p-8 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route('admin.orders.index') }}" class="text-xs font-bold text-[#C5A059] hover:underline flex items-center gap-1">
                    <span>&larr;</span>
                    <span>{{ __('العودة لقائمة الطلبات') }}</span>
                </a>
            </div>
            <h1 class="font-cinzel text-2xl sm:text-3xl font-bold text-[#18181B] flex items-center gap-3">
                <span>📦</span>
                <span>{{ $order->order_number ?? '#' . $order->id }}</span>
            </h1>
            <p class="text-xs sm:text-sm text-[#71717A] mt-1 font-mono">
                {{ __('تاريخ الطلب:') }} {{ $order->created_at->format('Y-m-d H:i') }} ({{ $order->created_at->diffForHumans() }})
            </p>
        </div>

        <div class="flex items-center gap-2">
            @if($order->phone)
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->phone) }}" target="_blank" class="px-4 py-2.5 rounded-xl bg-[#25D366] hover:bg-[#1eb857] text-white text-xs font-bold transition-all flex items-center gap-2 shadow-sm">
                    <span>💬</span>
                    <span>{{ __('محادثة العميل واتساب') }}</span>
                </a>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-bold flex items-center gap-2">
            <span>✓</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- 2 Column Grid: Info & Status -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Left 2 Cols: Customer & Products -->
        <div class="md:col-span-2 space-y-6">
            
            <!-- Customer Card -->
            <div class="bg-white border border-[#EADBCC] rounded-2xl p-6 shadow-sm space-y-4">
                <h3 class="text-sm font-bold text-[#18181B] flex items-center gap-2 border-b border-[#EADBCC] pb-3">
                    <span>👤</span>
                    <span>{{ __('بيانات العميل والشحن') }}</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div>
                        <span class="text-[#71717A] block mb-1">{{ __('اسم المستلم:') }}</span>
                        <span class="font-bold text-[#18181B] text-sm">{{ $order->customer_display_name }}</span>
                        @if(!$order->user_id)
                            <span class="inline-block mt-1 text-[10px] bg-amber-100 text-amber-800 font-bold px-2 py-0.5 rounded-md">
                                {{ __('طلب مباشر بدون حساب') }}
                            </span>
                        @endif
                    </div>

                    <div>
                        <span class="text-[#71717A] block mb-1">{{ __('رقم الهاتف / واتساب:') }}</span>
                        <span class="font-bold text-[#18181B] font-mono text-sm" dir="ltr">{{ $order->phone ?: __('غير محدد') }}</span>
                    </div>

                    <div class="sm:col-span-2">
                        <span class="text-[#71717A] block mb-1">{{ __('عنوان التوصيل:') }}</span>
                        <span class="font-medium text-[#18181B] leading-relaxed bg-[#F8F6F2] p-3 rounded-xl block border border-[#EADBCC]">
                            📍 {{ $order->address ?: __('غير محدد') }}
                        </span>
                    </div>

                    @if($order->notes)
                        <div class="sm:col-span-2">
                            <span class="text-[#71717A] block mb-1">{{ __('ملاحظات العميل:') }}</span>
                            <span class="font-medium text-amber-900 leading-relaxed bg-amber-50 p-3 rounded-xl block border border-amber-200">
                                📝 {{ $order->notes }}
                            </span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Ordered Items Card -->
            <div class="bg-white border border-[#EADBCC] rounded-2xl p-6 shadow-sm space-y-4">
                <h3 class="text-sm font-bold text-[#18181B] flex items-center gap-2 border-b border-[#EADBCC] pb-3">
                    <span>🛍️</span>
                    <span>{{ __('المنتجات المطلوبة') }} ({{ $order->orderItems->count() }})</span>
                </h3>

                <div class="divide-y divide-[#EADBCC]">
                    @foreach($order->orderItems as $item)
                        <div class="py-3.5 first:pt-0 last:pb-0 flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl bg-[#F8F6F2] border border-[#EADBCC] overflow-hidden flex items-center justify-center shrink-0">
                                    @if($item->product && $item->product->primary_image_url)
                                        <img src="{{ $item->product->primary_image_url }}" alt="" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-lg">👑</span>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-[#18181B]">
                                        {{ $item->product->name ?? __('منتج محذوف') }}
                                    </h4>
                                    <span class="text-[11px] text-[#71717A] block mt-0.5">
                                        {{ format_currency($item->price, $order->currency ?? 'USD') }} × {{ $item->quantity }}
                                    </span>
                                </div>
                            </div>

                            <div class="text-end">
                                <span class="text-xs font-bold text-[#18181B] tabular-nums font-mono">
                                    {{ format_currency($item->total_price ?? ($item->price * $item->quantity), $order->currency ?? 'USD') }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="border-t border-[#EADBCC] pt-4 flex items-center justify-between text-xs">
                    <span class="font-bold text-[#18181B] text-sm">{{ __('الإجمالي النهائي:') }}</span>
                    <span class="font-cinzel text-lg font-black text-[#C5A059] tabular-nums">
                        {{ format_currency($order->total_usd ?? $order->total_price ?? 0) }}
                    </span>
                </div>
            </div>

        </div>

        <!-- Right 1 Col: Status & Actions -->
        <div class="space-y-6">
            
            <div class="bg-white border border-[#EADBCC] rounded-2xl p-6 shadow-sm space-y-4">
                <h3 class="text-sm font-bold text-[#18181B] flex items-center gap-2 border-b border-[#EADBCC] pb-3">
                    <span>⚡</span>
                    <span>{{ __('إدارة حالة الطلب والمخزون') }}</span>
                </h3>

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

                <div class="p-3.5 rounded-xl border {{ $colorClass }} space-y-1">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] text-[#71717A]">{{ __('الحالة الحالية:') }}</span>
                        <span class="font-bold text-xs">{{ __($order->status) }}</span>
                    </div>
                    @if($order->status === 'cancelled')
                        <span class="text-[10px] text-rose-700 font-bold block pt-1 border-t border-rose-200">
                            ✓ تم استرجاع كميات المخزون المحجوزة تلقائياً للمنتجات
                        </span>
                    @else
                        <span class="text-[10px] text-emerald-700 font-bold block pt-1 border-t border-emerald-200">
                            ✓ الكميات مخصومة ومحجوزة للطلب
                        </span>
                    @endif
                </div>

                <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="space-y-3">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-[11px] font-bold text-gray-700 mb-1">{{ __('تحديث الحالة:') }}</label>
                        <select name="status" class="w-full px-3 py-2 text-xs rounded-xl bg-[#F8F6F2] border border-[#EADBCC] text-[#18181B] focus:outline-none focus:ring-2 focus:ring-[#C5A059]">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>{{ __('قيد الانتظار (حجز المخزون)') }}</option>
                            <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>{{ __('مؤكد عبر واتساب') }}</option>
                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>{{ __('قيد التجهيز والتغليف') }}</option>
                            <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>{{ __('تم الشحن والتسليم لشركة الشحن') }}</option>
                            <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>{{ __('تم التسليم واستلام المبلغ') }}</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>{{ __('إلغاء الطلب واسترجاع المخزون') }}</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-gray-700 mb-1">{{ __('سبب الإلغاء / ملاحظة الإدارة (اختياري):') }}</label>
                        <textarea name="cancel_reason" rows="2" class="w-full p-2.5 text-xs rounded-xl bg-[#F8F6F2] border border-[#EADBCC] text-[#18181B] focus:outline-none focus:ring-2 focus:ring-[#C5A059]" placeholder="{{ __('مثال: العميل لم يرد على واتساب، تم إلغاء الطلب...') }}">{{ $order->cancel_reason }}</textarea>
                    </div>

                    <button type="submit" class="w-full py-2.5 rounded-xl bg-[#18181B] hover:bg-[#C5A059] text-white text-xs font-bold transition-all shadow-sm">
                        {{ __('حفظ التغييرات ومزامنة المخزون') }}
                    </button>
                </form>
            </div>

            <div class="bg-white border border-[#EADBCC] rounded-2xl p-6 shadow-sm space-y-3">
                <h4 class="text-xs font-bold text-rose-600">{{ __('حذف الطلب:') }}</h4>
                <p class="text-[11px] text-[#71717A] leading-relaxed">
                    {{ __('عند حذف الطلب سيتم استرجاع المخزون تلقائياً للمنتجات إذا لم يكن ملغياً بالفعل.') }}
                </p>
                <form action="{{ route('orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('{{ __('هل أنت متأكد من رغبتك في حذف هذا الطلب نهائياً؟') }}');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full py-2 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 text-xs font-bold transition-all">
                        🗑️ {{ __('حذف الطلب نهائياً') }}
                    </button>
                </form>
            </div>

        </div>

    </div>

</div>
@endsection