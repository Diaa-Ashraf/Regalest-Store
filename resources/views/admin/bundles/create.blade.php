@extends('layouts.admin')

@section('title', __('إنشاء عرض مجمع'))

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-[#18181B] tracking-tight">🎁 {{ __('إنشاء عرض مجمع جديد | Create Bundle Offer') }}</h2>
            <p class="text-sm text-[#71717A] mt-0.5">{{ __('اختر من منتجين إلى 3 منتجات وحدد السعر المخفض الإجمالي للباقة') }}</p>
        </div>
        <a href="{{ route('admin.bundles.index') }}" class="px-4 py-2 rounded-xl border border-[#EADBCC] bg-[#F8F6F2] hover:bg-[#EDE8DC] text-[#18181B] text-sm font-semibold transition-colors">
            {{ __('العودة للعروض المجمعة') }}
        </a>
    </div>

    @if ($errors->any())
        <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm">
            <div class="font-bold mb-1">{{ __('يرجى تصحيح الأخطاء التالية:') }}</div>
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.bundles.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            {{-- Left column: Details --}}
            <div class="lg:col-span-7 space-y-6">
                <div class="bg-white border border-[#EADBCC] rounded-2xl p-6 shadow-sm space-y-5">
                    <h3 class="font-bold text-[#18181B] text-base border-b border-[#EADBCC] pb-3">1. معلومات العرض المجمع</h3>
                    
                    <div>
                        <label class="block text-sm font-semibold text-[#18181B] mb-2">{{ __('اسم العرض المجمع') }} <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" class="w-full px-4 py-2.5 rounded-xl border border-[#EADBCC] bg-[#F8F6F2]/40 text-[#18181B] focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059] focus:outline-none text-sm transition-all" placeholder="مثال: بكج الفخامة المزدوج (ساعتين كلاسيك)" value="{{ old('name') }}" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-[#18181B] mb-2">{{ __('وصف مختصر للعرض') }}</label>
                        <textarea name="description" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-[#EADBCC] bg-[#F8F6F2]/40 text-[#18181B] focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059] focus:outline-none text-sm transition-all" placeholder="اكتب تفاصيل ومزايا هذا العرض المجمع...">{{ old('description') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-[#18181B] mb-2">{{ __('سعر العرض الإجمالي') }} ($ USD) <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <input type="number" step="0.01" name="bundle_price" class="w-full pl-12 pr-4 py-2.5 rounded-xl border border-emerald-300 bg-emerald-50 text-emerald-800 font-bold text-sm focus:outline-none" placeholder="0.00" value="{{ old('bundle_price') }}" required>
                                <span class="absolute left-3 top-2.5 text-xs text-emerald-600 font-bold">$ USD</span>
                            </div>
                            <small class="text-xs text-[#71717A] mt-1 block">السعر النهائي بعد التخفيض للزبون</small>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-[#18181B] mb-2">{{ __('صورة العرض الترويجي') }}</label>
                            <input type="file" name="image" class="w-full px-3.5 py-2 rounded-xl border border-[#EADBCC] bg-[#F8F6F2]/40 text-[#18181B] text-sm focus:outline-none file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#18181B] file:text-white hover:file:bg-[#27272A] cursor-pointer" accept="image/*">
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-[#EADBCC] rounded-2xl p-6 shadow-sm space-y-4">
                    <h3 class="font-bold text-[#18181B] text-base border-b border-[#EADBCC] pb-3">3. توقيت العرض والحالة</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-[#18181B] mb-2">{{ __('تاريخ بدء العرض') }}</label>
                            <input type="datetime-local" name="starts_at" class="w-full px-4 py-2.5 rounded-xl border border-[#EADBCC] bg-[#F8F6F2]/40 text-[#18181B] focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059] focus:outline-none text-sm transition-all" value="{{ old('starts_at') }}">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-[#18181B] mb-2">{{ __('تاريخ انتهاء العرض') }}</label>
                            <input type="datetime-local" name="ends_at" class="w-full px-4 py-2.5 rounded-xl border border-[#EADBCC] bg-[#F8F6F2]/40 text-[#18181B] focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059] focus:outline-none text-sm transition-all" value="{{ old('ends_at') }}">
                        </div>
                    </div>
                    <div class="p-4 rounded-xl bg-[#F8F6F2]/60 border border-[#EADBCC]">
                        <label class="inline-flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 border-[#EADBCC]" checked>
                            <span class="text-sm font-semibold text-[#18181B]">تفعيل هذا العرض في المتجر فوراً</span>
                        </label>
                    </div>
                </div>
            </div>

            {{-- Right column: Products selector --}}
            <div class="lg:col-span-5">
                <div class="bg-white border border-[#EADBCC] rounded-2xl p-6 shadow-sm space-y-5">
                    <div>
                        <h3 class="font-bold text-[#18181B] text-base">2. المنتجات المشمولة في العرض</h3>
                        <p class="text-xs text-[#71717A] mt-0.5">اختر قطعتين أو 3 قطع لتكوين هذا العرض المجمع.</p>
                    </div>

                    <div class="space-y-4">
                        {{-- Row 1 --}}
                        <div class="p-4 rounded-xl bg-[#F8F6F2]/60 border border-[#EADBCC]">
                            <label class="block text-xs font-bold text-[#C5A059] uppercase tracking-wider mb-2">المنتج الأول <span class="text-rose-500">*</span></label>
                            <select name="products[0][id]" class="w-full px-3.5 py-2.5 rounded-xl border border-[#EADBCC] bg-white text-[#18181B] focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059] focus:outline-none text-sm" required>
                                <option value="">-- اختر المنتج الأول --</option>
                                @foreach($products as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }} ({{ $p->formatted_price }})</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="products[0][quantity]" value="1">
                        </div>

                        {{-- Row 2 --}}
                        <div class="p-4 rounded-xl bg-[#F8F6F2]/60 border border-[#EADBCC]">
                            <label class="block text-xs font-bold text-[#C5A059] uppercase tracking-wider mb-2">المنتج الثاني <span class="text-rose-500">*</span></label>
                            <select name="products[1][id]" class="w-full px-3.5 py-2.5 rounded-xl border border-[#EADBCC] bg-white text-[#18181B] focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059] focus:outline-none text-sm" required>
                                <option value="">-- اختر المنتج الثاني --</option>
                                @foreach($products as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }} ({{ $p->formatted_price }})</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="products[1][quantity]" value="1">
                        </div>

                        {{-- Row 3 (Optional) --}}
                        <div class="p-4 rounded-xl bg-[#F8F6F2]/60 border border-[#EADBCC]">
                            <label class="block text-xs font-bold text-[#71717A] uppercase tracking-wider mb-2">المنتج الثالث (اختياري)</label>
                            <select name="products[2][id]" class="w-full px-3.5 py-2.5 rounded-xl border border-[#EADBCC] bg-white text-[#18181B] focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059] focus:outline-none text-sm">
                                <option value="">-- لا يوجد منتج ثالث --</option>
                                @foreach($products as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }} ({{ $p->formatted_price }})</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="products[2][quantity]" value="1">
                        </div>
                    </div>

                    <div class="pt-4 border-t border-[#EADBCC]">
                        <button type="submit" class="w-full py-3.5 rounded-xl bg-[#18181B] hover:bg-[#27272A] text-white font-bold text-sm shadow-sm transition-all flex items-center justify-center gap-2">
                            <span>💾</span>
                            <span>حفظ ونشر العرض المجمع</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
