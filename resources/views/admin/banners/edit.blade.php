@extends('layouts.admin')

@section('title', __('تعديل البانر'))

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-[#18181B]">{{ __('تعديل البانر') }} #{{ $banner->id }}</h2>
            <p class="text-sm text-[#71717A] mt-0.5">{{ __('تحديث بيانات وموضع البانر الترويجي') }}</p>
        </div>
        <a href="{{ route('banners.index') }}" class="px-4 py-2 rounded-xl border border-[#EADBCC] bg-[#F8F6F2] hover:bg-[#EDE8DC] text-[#18181B] text-sm font-semibold transition-colors">
            {{ __('العودة للبانرات') }}
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

    <div class="bg-white border border-[#EADBCC] rounded-2xl p-6 sm:p-8 shadow-sm">
        <form action="{{ route('banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-[#18181B] mb-2">{{ __('صورة البانر') }}</label>
                    @if($banner->image_url)
                        <div class="mb-3">
                            <img src="{{ $banner->image_url }}" alt="Current Banner" class="h-24 w-auto rounded-xl object-cover border border-[#EADBCC]">
                            <span class="text-xs text-[#71717A] block mt-1">اترك الحقل فارغاً للإبقاء على الصورة الحالية</span>
                        </div>
                    @endif
                    <input type="file" name="image" accept="image/*"
                           class="w-full px-3.5 py-2 rounded-xl border border-[#EADBCC] bg-[#F8F6F2]/40 text-[#18181B] text-sm focus:outline-none file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#18181B] file:text-white hover:file:bg-[#27272A] cursor-pointer">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-[#18181B] mb-2">{{ __('الموضع / المربع (Slot)') }} <span class="text-rose-500">*</span></label>
                    <select name="position" class="w-full px-4 py-2.5 rounded-xl border border-[#EADBCC] bg-[#F8F6F2]/40 text-[#18181B] focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059] focus:outline-none text-sm transition-all" required>
                        <option value="1" {{ $banner->position == 1 ? 'selected' : '' }}>{{ __('الموضع 1 (البانر الرئيسي / سلايدر أول)') }}</option>
                        <option value="2" {{ $banner->position == 2 ? 'selected' : '' }}>{{ __('الموضع 2 (بانر فرعي أيسر)') }}</option>
                        <option value="3" {{ $banner->position == 3 ? 'selected' : '' }}>{{ __('الموضع 3 (بانر فرعي أوسط)') }}</option>
                        <option value="4" {{ $banner->position == 4 ? 'selected' : '' }}>{{ __('الموضع 4 (بانر فرعي أيمن)') }}</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-[#18181B] mb-2">{{ __('العنوان الرئيسي (اختياري)') }}</label>
                    <input type="text" name="title" class="w-full px-4 py-2.5 rounded-xl border border-[#EADBCC] bg-[#F8F6F2]/40 text-[#18181B] focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059] focus:outline-none text-sm transition-all" value="{{ old('title', $banner->title) }}">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-[#18181B] mb-2">{{ __('رابط التوجيه عند النقر (Target URL)') }}</label>
                    <input type="url" name="url" class="w-full px-4 py-2.5 rounded-xl border border-[#EADBCC] bg-[#F8F6F2]/40 text-[#18181B] focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059] focus:outline-none text-sm transition-all dir-ltr text-right" value="{{ old('url', $banner->url) }}">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-[#18181B] mb-2">{{ __('الوصف الترويجي (اختياري)') }}</label>
                <textarea name="description" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-[#EADBCC] bg-[#F8F6F2]/40 text-[#18181B] focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059] focus:outline-none text-sm transition-all">{{ old('description', $banner->description) }}</textarea>
            </div>

            <div class="p-4 rounded-xl bg-[#F8F6F2]/60 border border-[#EADBCC]">
                <label class="block text-sm font-semibold text-[#18181B] mb-2">{{ __('حالة البانر') }}</label>
                <select name="status" class="w-full px-4 py-2 rounded-xl border border-[#EADBCC] bg-white text-[#18181B] focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059] focus:outline-none text-sm">
                    <option value="1" {{ $banner->status == 1 ? 'selected' : '' }}>{{ __('مفعّل (نشط بالمتجر)') }}</option>
                    <option value="0" {{ $banner->status == 0 ? 'selected' : '' }}>{{ __('معطّل (مخفي)') }}</option>
                </select>
            </div>

            <div class="pt-4 border-t border-[#EADBCC] flex items-center justify-end gap-3">
                <a href="{{ route('banners.index') }}" class="px-5 py-2.5 rounded-xl border border-[#EADBCC] bg-[#F8F6F2] hover:bg-[#EDE8DC] text-[#18181B] text-sm font-semibold transition-colors">
                    {{ __('إلغاء') }}
                </a>
                <button type="submit" class="px-7 py-2.5 rounded-xl bg-[#18181B] hover:bg-[#27272A] text-white text-sm font-semibold shadow-sm transition-all">
                    {{ __('تحديث البانر') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
