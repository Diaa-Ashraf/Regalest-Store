@extends('layouts.admin')

@section('title', __('إضافة منتج جديد'))

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-[#18181B] tracking-tight">{{ __('إضافة منتج جديد') }}</h2>
            <p class="text-sm text-[#71717A] mt-0.5">{{ __('أدخل تفاصيل ومواصفات المنتج لإضافته لكتالوج المتجر') }}</p>
        </div>
        <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-[#EADBCC] bg-[#F8F6F2] hover:bg-[#EDE8DC] text-[#18181B] text-sm font-semibold transition-colors">
            <span>&rarr;</span>
            <span>{{ __('العودة لقائمة المنتجات') }}</span>
        </a>
    </div>

    {{-- Error Alert --}}
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

    {{-- Main Form Card --}}
    <div class="bg-white border border-[#EADBCC] rounded-2xl p-6 sm:p-8 shadow-sm">
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- Category Selection --}}
            <div class="p-4 rounded-xl bg-[#F8F6F2]/60 border border-[#EADBCC]">
                <label for="category_id" class="block text-sm font-semibold text-[#18181B] mb-2">
                    {{ __('التصنيف الرئيسي') }} <span class="text-rose-500">*</span>
                </label>
                <select id="category_id" name="category_id" class="w-full px-4 py-2.5 rounded-xl border border-[#EADBCC] bg-white text-[#18181B] focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059] focus:outline-none text-sm transition-all @error('category_id') border-rose-500 @enderror" required>
                    <option value="">-- {{ __('اختر التصنيف') }} --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            {{-- Product Names (Multilingual) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name_ar" class="block text-sm font-semibold text-[#18181B] mb-2">
                        {{ __('اسم المنتج') }} (العربية) <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="name_ar" name="ar[name]" 
                           class="w-full px-4 py-2.5 rounded-xl border border-[#EADBCC] bg-[#F8F6F2]/40 text-[#18181B] focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059] focus:outline-none text-sm transition-all @error('ar.name') border-rose-500 @enderror" 
                           value="{{ old('ar.name') }}" required placeholder="مثال: ساعة رويال الذهبية الفاخرة">
                    @error('ar.name')
                        <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="name_en" class="block text-sm font-semibold text-[#18181B] mb-2">
                        {{ __('اسم المنتج') }} (English)
                    </label>
                    <input type="text" id="name_en" name="en[name]" 
                           class="w-full px-4 py-2.5 rounded-xl border border-[#EADBCC] bg-[#F8F6F2]/40 text-[#18181B] focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059] focus:outline-none text-sm transition-all @error('en.name') border-rose-500 @enderror" 
                           value="{{ old('en.name') }}" placeholder="Royal Gold Luxury Watch">
                    @error('en.name')
                        <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Product Descriptions --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="desc_ar" class="block text-sm font-semibold text-[#18181B] mb-2">
                        {{ __('وصف المنتج') }} (العربية)
                    </label>
                    <textarea id="desc_ar" name="ar[description]" rows="3"
                           class="w-full px-4 py-2.5 rounded-xl border border-[#EADBCC] bg-[#F8F6F2]/40 text-[#18181B] focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059] focus:outline-none text-sm transition-all @error('ar.description') border-rose-500 @enderror" 
                           placeholder="اكتب مواصفات المنتج ومميزاته بالتفصيل...">{{ old('ar.description') }}</textarea>
                    @error('ar.description')
                        <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="desc_en" class="block text-sm font-semibold text-[#18181B] mb-2">
                        {{ __('وصف المنتج') }} (English)
                    </label>
                    <textarea id="desc_en" name="en[description]" rows="3"
                           class="w-full px-4 py-2.5 rounded-xl border border-[#EADBCC] bg-[#F8F6F2]/40 text-[#18181B] focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059] focus:outline-none text-sm transition-all @error('en.description') border-rose-500 @enderror" 
                           placeholder="Enter product description and specifications...">{{ old('en.description') }}</textarea>
                    @error('en.description')
                        <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Keywords --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="keywords_ar" class="block text-sm font-semibold text-[#18181B] mb-2">
                        {{ __('الكلمات المفتاحية') }} (العربية)
                    </label>
                    <input type="text" id="keywords_ar" name="ar[keywords]" 
                           class="w-full px-4 py-2.5 rounded-xl border border-[#EADBCC] bg-[#F8F6F2]/40 text-[#18181B] focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059] focus:outline-none text-sm transition-all @error('ar.keywords') border-rose-500 @enderror" 
                           value="{{ old('ar.keywords') }}" placeholder="ساعات، هدايا، إكسسوارات، فخامة">
                    @error('ar.keywords')
                        <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="keywords_en" class="block text-sm font-semibold text-[#18181B] mb-2">
                        {{ __('الكلمات المفتاحية') }} (English)
                    </label>
                    <input type="text" id="keywords_en" name="en[keywords]" 
                           class="w-full px-4 py-2.5 rounded-xl border border-[#EADBCC] bg-[#F8F6F2]/40 text-[#18181B] focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059] focus:outline-none text-sm transition-all @error('en.keywords') border-rose-500 @enderror" 
                           value="{{ old('en.keywords') }}" placeholder="watches, gifts, luxury, accessories">
                    @error('en.keywords')
                        <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Slug & Image --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="slug" class="block text-sm font-semibold text-[#18181B] mb-2">
                        {{ __('الرابط الدائم (Slug)') }}
                    </label>
                    <input type="text" id="slug" name="slug" 
                           class="w-full px-4 py-2.5 rounded-xl border border-[#EADBCC] bg-[#F8F6F2]/40 text-[#18181B] focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059] focus:outline-none text-sm transition-all @error('slug') border-rose-500 @enderror" 
                           value="{{ old('slug') }}" placeholder="royal-gold-watch">
                    <small class="text-[#71717A] text-xs mt-1 block">{{ __('اتركه فارغاً للتوليد التلقائي من الاسم') }}</small>
                    @error('slug')
                        <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="image" class="block text-sm font-semibold text-[#18181B] mb-2">
                        {{ __('صورة المنتج الرئيسية') }}
                    </label>
                    <input type="file" id="image" name="image" accept="image/*"
                           class="w-full px-3.5 py-2 rounded-xl border border-[#EADBCC] bg-[#F8F6F2]/40 text-[#18181B] text-sm focus:outline-none file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#18181B] file:text-white hover:file:bg-[#27272A] cursor-pointer @error('image') border-rose-500 @enderror">
                    @error('image')
                        <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Pricing & Stock --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-2">
                <div>
                    <label for="price" class="block text-sm font-semibold text-[#18181B] mb-2">
                        {{ __('السعر الأساسي') }} ($ USD) <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="number" step="0.01" id="price" name="price" 
                               class="w-full pl-12 pr-4 py-2.5 rounded-xl border border-[#EADBCC] bg-[#F8F6F2]/40 text-[#18181B] focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059] focus:outline-none text-sm font-bold transition-all @error('price') border-rose-500 @enderror" 
                               value="{{ old('price') }}" placeholder="0.00" required>
                        <span class="absolute left-3 top-2.5 text-xs font-bold text-[#71717A]">$ USD</span>
                    </div>
                    @error('price')
                        <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="discount_price" class="block text-sm font-semibold text-[#18181B] mb-2">
                        {{ __('سعر الخصم (اختياري)') }} ($ USD)
                    </label>
                    <div class="relative">
                        <input type="number" step="0.01" id="discount_price" name="discount_price" 
                               class="w-full pl-12 pr-4 py-2.5 rounded-xl border border-[#EADBCC] bg-[#F8F6F2]/40 text-[#18181B] focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059] focus:outline-none text-sm transition-all @error('discount_price') border-rose-500 @enderror" 
                               value="{{ old('discount_price') }}" placeholder="اتركه فارغاً إن لم يكن مخفضاً">
                        <span class="absolute left-3 top-2.5 text-xs font-bold text-[#71717A]">$ USD</span>
                    </div>
                    @error('discount_price')
                        <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="stock_quantity" class="block text-sm font-semibold text-[#18181B] mb-2">
                        {{ __('المخزون المتوفر') }} <span class="text-rose-500">*</span>
                    </label>
                    <input type="number" id="stock_quantity" name="stock_quantity" 
                           class="w-full px-4 py-2.5 rounded-xl border border-[#EADBCC] bg-[#F8F6F2]/40 text-[#18181B] focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059] focus:outline-none text-sm transition-all @error('stock_quantity') border-rose-500 @enderror" 
                           value="{{ old('stock_quantity', 10) }}" placeholder="0" required>
                    @error('stock_quantity')
                        <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Flags & Switches --}}
            <div class="p-4 rounded-xl bg-[#F8F6F2]/60 border border-[#EADBCC] flex flex-wrap items-center gap-8">
                <label class="inline-flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="featured" value="1" class="w-4 h-4 rounded text-[#C5A059] focus:ring-[#C5A059] border-[#EADBCC]" {{ old('featured') ? 'checked' : '' }}>
                    <span class="text-sm font-semibold text-[#18181B]">⭐ تمييز في الصفحة الرئيسية (Featured)</span>
                </label>

                <label class="inline-flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 border-[#EADBCC]" checked>
                    <span class="text-sm font-semibold text-[#18181B]">✓ تفعيل المنتج بالمتجر مباشرة</span>
                </label>
            </div>

            {{-- Submit Actions --}}
            <div class="pt-4 border-t border-[#EADBCC] flex items-center justify-end gap-3">
                <a href="{{ route('products.index') }}" class="px-5 py-2.5 rounded-xl border border-[#EADBCC] bg-[#F8F6F2] hover:bg-[#EDE8DC] text-[#18181B] text-sm font-semibold transition-colors">
                    {{ __('إلغاء') }}
                </a>
                <button type="submit" class="px-7 py-2.5 rounded-xl bg-[#18181B] hover:bg-[#27272A] text-white text-sm font-semibold shadow-sm transition-all">
                    {{ __('حفظ ونشر المنتج') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection