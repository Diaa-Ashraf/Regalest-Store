@extends('layouts.admin')

@section('title', __('إضافة تخفيض حصري'))

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-[#18181B]">{{ __('إضافة تخفيض حصري (Flash Deal)') }}</h2>
            <p class="text-sm text-[#71717A] mt-0.5">{{ __('تحديد خصم مئوي وموعد انتهاء لمنتج معين مع شارة عرض') }}</p>
        </div>
        <a href="{{ route('deals.index') }}" class="px-4 py-2 rounded-xl border border-[#EADBCC] bg-[#F8F6F2] hover:bg-[#EDE8DC] text-[#18181B] text-sm font-semibold transition-colors">
            {{ __('العودة للعروض') }}
        </a>
    </div>

    @if($errors->any())
        <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm">
            <div class="font-bold mb-1">{{ __('يرجى تصحيح الأخطاء التالية:') }}</div>
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white border border-[#EADBCC] rounded-2xl p-6 sm:p-8 shadow-sm">
        <form action="{{ route('deals.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="product_id" class="block text-sm font-semibold text-[#18181B] mb-2">{{ __('اختر المنتج') }} <span class="text-rose-500">*</span></label>
                    <select name="product_id" id="product_id" class="w-full px-4 py-2.5 rounded-xl border border-[#EADBCC] bg-[#F8F6F2]/40 text-[#18181B] focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059] focus:outline-none text-sm transition-all" required onchange="updatePrices()">
                        <option value="">-- {{ __('اختر المنتج المعني') }} --</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" 
                                    data-price="{{ $product->price }}"
                                    {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                {{ $product->name }} - {{ number_format($product->price, 2) }} $
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="discount_percent" class="block text-sm font-semibold text-[#18181B] mb-2">{{ __('نسبة الخصم المئوية') }} (%) <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <input type="number" name="discount_percent" id="discount_percent" 
                               class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-[#EADBCC] bg-[#F8F6F2]/40 text-[#18181B] focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059] focus:outline-none text-sm font-bold transition-all" min="1" max="99" 
                               value="{{ old('discount_percent', 10) }}" 
                               required oninput="calculateDealPrice()">
                        <span class="absolute left-3.5 top-2.5 text-xs font-bold text-[#71717A]">%</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4 rounded-xl bg-[#F8F6F2]/50 border border-[#EADBCC]">
                <div>
                    <label for="original_price" class="block text-xs font-semibold text-[#71717A] mb-1.5">{{ __('السعر الأصلي') }} <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <input type="number" step="0.01" name="original_price" id="original_price" 
                               class="w-full pl-12 pr-4 py-2 rounded-xl border border-[#EADBCC] bg-white text-[#18181B] text-sm font-bold focus:outline-none" min="0" 
                               value="{{ old('original_price') }}" 
                               required oninput="calculateDealPrice()">
                        <span class="absolute left-3 top-2 text-xs text-[#71717A]">$ USD</span>
                    </div>
                </div>

                <div>
                    <label for="deal_price" class="block text-xs font-semibold text-[#71717A] mb-1.5">{{ __('سعر العرض بعد الخصم') }} <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <input type="number" step="0.01" name="deal_price" id="deal_price" 
                               class="w-full pl-12 pr-4 py-2 rounded-xl border border-emerald-300 bg-emerald-50 text-emerald-800 text-sm font-bold focus:outline-none" min="0" 
                               value="{{ old('deal_price') }}" required>
                        <span class="absolute left-3 top-2 text-xs text-emerald-600 font-bold">$ USD</span>
                    </div>
                    <small class="text-[#71717A] text-[11px] mt-1 block">يُحسب تلقائياً وفق نسبة الخصم المحددة</small>
                </div>
            </div>

            <div>
                <label for="badge_text" class="block text-sm font-semibold text-[#18181B] mb-2">{{ __('نص الشارة الترويجية (Badge Text)') }}</label>
                <input type="text" name="badge_text" id="badge_text" 
                       class="w-full px-4 py-2.5 rounded-xl border border-[#EADBCC] bg-[#F8F6F2]/40 text-[#18181B] focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059] focus:outline-none text-sm transition-all" 
                       value="{{ old('badge_text', 'عرض لمدة محدودة') }}" 
                       placeholder="مثال: خصم خاطف 50% أو عرض حصري">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="starts_at" class="block text-sm font-semibold text-[#18181B] mb-2">{{ __('تاريخ وبدء العرض') }}</label>
                    <input type="datetime-local" name="starts_at" id="starts_at" 
                           class="w-full px-4 py-2.5 rounded-xl border border-[#EADBCC] bg-[#F8F6F2]/40 text-[#18181B] focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059] focus:outline-none text-sm transition-all" value="{{ old('starts_at') }}">
                    <small class="text-[#71717A] text-xs mt-1 block">اتركه فارغاً ليبدأ العرض فوراً</small>
                </div>

                <div>
                    <label for="ends_at" class="block text-sm font-semibold text-[#18181B] mb-2">{{ __('تاريخ انتهاء العرض (عداد التنازلي)') }}</label>
                    <input type="datetime-local" name="ends_at" id="ends_at" 
                           class="w-full px-4 py-2.5 rounded-xl border border-[#EADBCC] bg-[#F8F6F2]/40 text-[#18181B] focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059] focus:outline-none text-sm transition-all" value="{{ old('ends_at') }}">
                    <small class="text-[#71717A] text-xs mt-1 block">اتركه فارغاً إذا كان العرض مستمراً دون مؤقت</small>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
                <div>
                    <label for="sort_order" class="block text-sm font-semibold text-[#18181B] mb-2">{{ __('ترتيب الظهور') }}</label>
                    <input type="number" name="sort_order" id="sort_order" 
                           class="w-full px-4 py-2.5 rounded-xl border border-[#EADBCC] bg-[#F8F6F2]/40 text-[#18181B] focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059] focus:outline-none text-sm transition-all" value="{{ old('sort_order', 0) }}" min="0">
                </div>

                <div class="p-4 rounded-xl bg-[#F8F6F2]/60 border border-[#EADBCC] mt-6">
                    <label class="inline-flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 border-[#EADBCC]" {{ old('is_active', true) ? 'checked' : '' }}>
                        <span class="text-sm font-semibold text-[#18181B]">تفعيل العرض فوراً بالمتجر</span>
                    </label>
                </div>
            </div>

            <div class="pt-4 border-t border-[#EADBCC] flex items-center justify-end gap-3">
                <a href="{{ route('deals.index') }}" class="px-5 py-2.5 rounded-xl border border-[#EADBCC] bg-[#F8F6F2] hover:bg-[#EDE8DC] text-[#18181B] text-sm font-semibold transition-colors">
                    {{ __('إلغاء') }}
                </a>
                <button type="submit" class="px-7 py-2.5 rounded-xl bg-[#18181B] hover:bg-[#27272A] text-white text-sm font-semibold shadow-sm transition-all">
                    {{ __('حفظ ونشر العرض') }}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function updatePrices() {
    var select = document.getElementById('product_id');
    var selectedOption = select.options[select.selectedIndex];
    var price = selectedOption.getAttribute('data-price');
    
    if (price) {
        document.getElementById('original_price').value = parseFloat(price).toFixed(2);
        calculateDealPrice();
    }
}

function calculateDealPrice() {
    var originalPrice = parseFloat(document.getElementById('original_price').value) || 0;
    var discountPercent = parseInt(document.getElementById('discount_percent').value) || 0;
    
    var dealPrice = originalPrice - (originalPrice * discountPercent / 100);
    document.getElementById('deal_price').value = dealPrice.toFixed(2);
}

document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('original_price').value) {
        calculateDealPrice();
    }
});
</script>
@endsection
