@extends('layouts.admin')

@section('title', __('تعديل العرض المجمع'))

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-[#18181B] tracking-tight">🎁 {{ __('تعديل العرض المجمع') }}: {{ $bundle->name }}</h2>
            <p class="text-sm text-[#71717A] mt-0.5">{{ __('تعديل المنتجات المشمولة، سعر العرض المخفض، أو المواعيد') }}</p>
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

    <form action="{{ route('admin.bundles.update', $bundle->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            {{-- Left column: Details --}}
            <div class="lg:col-span-7 space-y-6">
                <div class="bg-white border border-[#EADBCC] rounded-2xl p-6 shadow-sm space-y-5">
                    <h3 class="font-bold text-[#18181B] text-base border-b border-[#EADBCC] pb-3">1. معلومات العرض المجمع</h3>
                    
                    <div>
                        <label class="block text-sm font-semibold text-[#18181B] mb-2">{{ __('اسم العرض المجمع') }} <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" class="w-full px-4 py-2.5 rounded-xl border border-[#EADBCC] bg-[#F8F6F2]/40 text-[#18181B] focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059] focus:outline-none text-sm transition-all" value="{{ old('name', $bundle->name) }}" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-[#18181B] mb-2">{{ __('وصف مختصر للعرض') }}</label>
                        <textarea name="description" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-[#EADBCC] bg-[#F8F6F2]/40 text-[#18181B] focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059] focus:outline-none text-sm transition-all">{{ old('description', $bundle->description) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-[#18181B] mb-2">{{ __('سعر العرض الإجمالي') }} ($ USD) <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <input type="number" step="0.01" name="bundle_price" class="w-full pl-12 pr-4 py-2.5 rounded-xl border border-emerald-300 bg-emerald-50 text-emerald-800 font-bold text-sm focus:outline-none" value="{{ old('bundle_price', $bundle->bundle_price) }}" required>
                                <span class="absolute left-3 top-2.5 text-xs text-emerald-600 font-bold">$ USD</span>
                            </div>
                            <small class="text-xs text-[#71717A] mt-1 block">السعر الأصلي: {{ $bundle->formatted_original_total }} (خصم: {{ $bundle->discount_percent }}%)</small>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-[#18181B] mb-2">{{ __('صورة العرض الترويجي') }}</label>
                            @if($bundle->image_url)
                                <div class="mb-2">
                                    <img src="{{ $bundle->image_url }}" alt="" class="w-12 h-12 rounded-xl object-cover border border-[#EADBCC]">
                                </div>
                            @endif
                            <input type="file" name="image" class="w-full px-3.5 py-2 rounded-xl border border-[#EADBCC] bg-[#F8F6F2]/40 text-[#18181B] text-sm focus:outline-none file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#18181B] file:text-white hover:file:bg-[#27272A] cursor-pointer" accept="image/*">
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-[#EADBCC] rounded-2xl p-6 shadow-sm space-y-4">
                    <h3 class="font-bold text-[#18181B] text-base border-b border-[#EADBCC] pb-3">3. توقيت العرض والحالة</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-[#18181B] mb-2">{{ __('تاريخ بدء العرض') }}</label>
                            <input type="datetime-local" name="starts_at" class="w-full px-4 py-2.5 rounded-xl border border-[#EADBCC] bg-[#F8F6F2]/40 text-[#18181B] focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059] focus:outline-none text-sm transition-all" value="{{ old('starts_at', $bundle->starts_at?->format('Y-m-d\TH:i')) }}">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-[#18181B] mb-2">{{ __('تاريخ انتهاء العرض') }}</label>
                            <input type="datetime-local" name="ends_at" class="w-full px-4 py-2.5 rounded-xl border border-[#EADBCC] bg-[#F8F6F2]/40 text-[#18181B] focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059] focus:outline-none text-sm transition-all" value="{{ old('ends_at', $bundle->ends_at?->format('Y-m-d\TH:i')) }}">
                        </div>
                    </div>
                    <div class="p-4 rounded-xl bg-[#F8F6F2]/60 border border-[#EADBCC]">
                        <label class="inline-flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 border-[#EADBCC]" {{ $bundle->is_active ? 'checked' : '' }}>
                            <span class="text-sm font-semibold text-[#18181B]">تفعيل هذا العرض في المتجر</span>
                        </label>
                    </div>
                </div>
            </div>

            {{-- Right column: Products selector --}}
            <div class="lg:col-span-5">
                <div class="bg-white border border-[#EADBCC] rounded-2xl p-6 shadow-sm space-y-5">
                    <div>
                        <h3 class="font-bold text-[#18181B] text-base">2. المنتجات المشمولة في العرض</h3>
                        <p class="text-xs text-[#71717A] mt-0.5">يمكنك تعديل المنتجات المرتبطة بهذا العرض.</p>
                    </div>

                    @php
                        $selectedProducts = $bundle->products->pluck('id')->toArray();
                    @endphp

                    <div class="space-y-4">
                        @for($i = 0; $i < 3; $i++)
                            @php
                                $currentId = $selectedProducts[$i] ?? null;
                            @endphp
                            <div class="p-4 rounded-xl bg-[#F8F6F2]/60 border border-[#EADBCC]">
                                <label class="block text-xs font-bold {{ $i < 2 ? 'text-[#C5A059]' : 'text-[#71717A]' }} uppercase tracking-wider mb-2">
                                    المنتج رقم {{ $i + 1 }} {{ $i < 2 ? '*' : '(اختياري)' }}
                                </label>
                                <select name="products[{{ $i }}][id]" class="w-full px-3.5 py-2.5 rounded-xl border border-[#EADBCC] bg-white text-[#18181B] focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059] focus:outline-none text-sm" {{ $i < 2 ? 'required' : '' }}>
                                    <option value="">-- {{ $i < 2 ? 'اختر المنتج' : 'لا يوجد منتج' }} --</option>
                                    @foreach($products as $p)
                                        <option value="{{ $p->id }}" {{ $currentId == $p->id ? 'selected' : '' }}>
                                            {{ $p->name }} ({{ $p->formatted_price }})
                                        </option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="products[{{ $i }}][quantity]" value="1">
                            </div>
                        @endfor
                    </div>

                    <div class="pt-4 border-t border-[#EADBCC]">
                        <button type="submit" class="w-full py-3.5 rounded-xl bg-[#18181B] hover:bg-[#27272A] text-white font-bold text-sm shadow-sm transition-all flex items-center justify-center gap-2">
                            <span>💾</span>
                            <span>حفظ التعديلات</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
