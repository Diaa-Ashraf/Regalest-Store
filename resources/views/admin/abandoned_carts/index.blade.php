@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-[#18181B] tracking-tight">🛒 السلات المتروكة | Abandoned Carts</h2>
            <p class="text-sm text-[#71717A] mt-0.5">قائمة بالعملاء الذين أضافوا منتجات إلى سلتهم ولم يكملوا الطلب، لمتابعتهم وتقديم عروض تحفيزية.</p>
        </div>
    </div>

    {{-- Main Table Card --}}
    <div class="bg-white border border-[#EADBCC] rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-right border-collapse">
                <thead>
                    <tr class="border-b border-[#EADBCC] bg-[#F8F6F2]/70 text-[#71717A] text-xs uppercase font-semibold">
                        <th class="py-3.5 px-5">العميل</th>
                        <th class="py-3.5 px-5">بيانات الاتصال</th>
                        <th class="py-3.5 px-5">محتويات السلة</th>
                        <th class="py-3.5 px-5">إجمالي القيمة</th>
                        <th class="py-3.5 px-5">آخر نشاط</th>
                        <th class="py-3.5 px-5">الحالة</th>
                        <th class="py-3.5 px-5 text-center">إجراءات المتابعة</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#F0ECE1] text-sm text-[#18181B]">
                    @forelse($carts as $cart)
                        @php
                            $phone = $cart->customer_phone ?? $cart->user?->phone;
                            $cleanPhone = $phone ? preg_replace('/[^0-9]/', '', $phone) : null;
                            $storeName = settings('site_name', 'Regalest Store');
                            $waFollowupMsg = urlencode("مرحباً بك من متجر {$storeName} 👑! لاحظنا أنك تركت بعض المنتجات الفاخرة في سلتك. هل تواجهك أي مشكلة في إتمام طلبك؟ نحن هنا لمساعدتك ويسعدنا تقديم كود خصم خاص بك!");
                        @endphp
                        <tr class="hover:bg-[#F8F6F2]/40 transition-colors">
                            <td class="py-4 px-5">
                                <div class="font-bold text-[#18181B]">
                                    {{ $cart->customer_name ?? $cart->user?->name ?? 'زائر / ضيف' }}
                                </div>
                                @if($cart->user_id)
                                    <span class="inline-flex items-center gap-1 text-[10px] font-semibold text-emerald-700 bg-emerald-50 px-1.5 py-0.5 rounded border border-emerald-200 mt-1">
                                        عضو مسجل
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-5">
                                @if($phone)
                                    <div class="font-mono text-xs font-bold text-[#C5A059] dir-ltr inline-block">{{ $phone }}</div>
                                @endif
                                @if($cart->customer_email ?? $cart->user?->email)
                                    <span class="text-xs text-[#71717A] block mt-0.5">{{ $cart->customer_email ?? $cart->user?->email }}</span>
                                @endif
                                @if(!$phone && !($cart->customer_email ?? $cart->user?->email))
                                    <span class="text-xs text-[#A1A1AA]">لم تتوفر بيانات تواصل</span>
                                @endif
                            </td>
                            <td class="py-4 px-5">
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-semibold bg-[#F8F6F2] text-[#71717A] border border-[#EADBCC]">
                                    {{ $cart->item_count }} منتجات
                                </span>
                                <div class="text-xs text-[#71717A] mt-1 space-y-0.5">
                                    @foreach(array_slice($cart->cart_data ?? [], 0, 2) as $item)
                                        <div class="truncate max-w-[180px]">• {{ $item['name'] ?? '' }} (×{{ $item['quantity'] ?? 1 }})</div>
                                    @endforeach
                                    @if(count($cart->cart_data ?? []) > 2)
                                        <div class="text-[11px] text-[#C5A059] font-medium">+ {{ count($cart->cart_data) - 2 }} أخرى</div>
                                    @endif
                                </div>
                            </td>
                            <td class="py-4 px-5 font-bold text-[#C5A059]">
                                {{ format_currency($cart->total_amount) }}
                            </td>
                            <td class="py-4 px-5 text-xs text-[#71717A] whitespace-nowrap">
                                {{ $cart->last_activity_at?->diffForHumans() }}
                            </td>
                            <td class="py-4 px-5">
                                @if($cart->is_recovered)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        ✓ تم الاسترداد
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                        متروكة
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-5 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    @if($cleanPhone && !$cart->is_recovered)
                                        <a href="https://wa.me/{{ $cleanPhone }}?text={{ $waFollowupMsg }}" target="_blank" class="px-2.5 py-1.5 rounded-lg border border-emerald-300 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-semibold text-xs flex items-center gap-1 transition-colors">
                                            <span>💬</span>
                                            <span>واتساب</span>
                                        </a>
                                    @endif
                                    @if(!$cart->is_recovered)
                                        <form action="{{ route('admin.abandoned-carts.recover', $cart->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="px-2.5 py-1.5 rounded-lg border border-[#EADBCC] bg-[#F8F6F2] hover:bg-[#EDE8DC] text-[#18181B] font-semibold text-xs transition-colors" title="تعيين كمستردة">
                                                ✓ تم الشراء
                                            </button>
                                        </form>
                                    @endif
                                    <form action="{{ route('admin.abandoned-carts.destroy', $cart->id) }}" method="POST" data-confirm-message="{{ __('هل أنت متأكد من رغبتك في حذف سجل سلة التسوق هذه؟') }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1.5 rounded-lg border border-rose-200 bg-rose-50 hover:bg-rose-100 text-rose-600 font-semibold text-xs transition-colors">
                                            حذف
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-[#71717A]">
                                لا توجد سلات تسوق متروكة حالياً.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($carts, 'hasPages') && $carts->hasPages())
            <div class="p-4 border-t border-[#EADBCC] bg-[#F8F6F2]/30">
                {{ $carts->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
