@extends('layouts.admin')

@section('title', __('إضافة بانر جديد'))

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-[#18181B]">{{ __('إضافة بانر ترويجي جديد') }}</h2>
            <p class="text-sm text-[#71717A] mt-0.5">{{ __('تحكم في الإعلانات وشاشات العرض الترويجية بالمتجر') }}</p>
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
        <form action="{{ route('banners.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-[#18181B] mb-2">{{ __('صورة البانر') }} <span class="text-rose-500">*</span></label>
                    <input type="file" name="image" required accept="image/*"
                           class="w-full px-3.5 py-2 rounded-xl border border-[#EADBCC] bg-[#F8F6F2]/40 text-[#18181B] text-sm focus:outline-none file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#18181B] file:text-white hover:file:bg-[#27272A] cursor-pointer">
                    <small class="text-xs text-[#71717A] mt-1 block">الأبعاد المقترحة تعتمد على موضع البانر (يفضل دقة عالية)</small>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-[#18181B] mb-2">{{ __('الموضع / المربع (Slot)') }} <span class="text-rose-500">*</span></label>
                    <select name="position" class="w-full px-4 py-2.5 rounded-xl border border-[#EADBCC] bg-[#F8F6F2]/40 text-[#18181B] focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059] focus:outline-none text-sm transition-all" required>
                        <option value="1">{{ __('الموضع 1 (البانر الرئيسي / سلايدر أول)') }}</option>
                        <option value="2">{{ __('الموضع 2 (بانر فرعي أيسر)') }}</option>
                        <option value="3">{{ __('الموضع 3 (بانر فرعي أوسط)') }}</option>
                        <option value="4">{{ __('الموضع 4 (بانر فرعي أيمن)') }}</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-[#18181B] mb-2">{{ __('العنوان الرئيسي (اختياري)') }}</label>
                    <input type="text" name="title" class="w-full px-4 py-2.5 rounded-xl border border-[#EADBCC] bg-[#F8F6F2]/40 text-[#18181B] focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059] focus:outline-none text-sm transition-all" placeholder="مثال: خصومات كبرى بمناسبة الموسم" value="{{ old('title') }}">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-[#18181B] mb-2">{{ __('رابط التوجيه عند النقر (Target URL)') }}</label>
                    <input type="url" name="url" class="w-full px-4 py-2.5 rounded-xl border border-[#EADBCC] bg-[#F8F6F2]/40 text-[#18181B] focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059] focus:outline-none text-sm transition-all dir-ltr text-right" placeholder="https://..." value="{{ old('url') }}">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-[#18181B] mb-2">{{ __('الوصف الترويجي (اختياري)') }}</label>
                <textarea name="description" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-[#EADBCC] bg-[#F8F6F2]/40 text-[#18181B] focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059] focus:outline-none text-sm transition-all" placeholder="نص توضيحي يظهر فوق البانر...">{{ old('description') }}</textarea>
            </div>

            <div class="p-4 rounded-xl bg-[#F8F6F2]/60 border border-[#EADBCC]">
                <label class="block text-sm font-semibold text-[#18181B] mb-2">{{ __('حالة البانر') }}</label>
                <select name="status" class="w-full px-4 py-2 rounded-xl border border-[#EADBCC] bg-white text-[#18181B] focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059] focus:outline-none text-sm">
                    <option value="1">{{ __('مفعّل (نشط بالمتجر)') }}</option>
                    <option value="0">{{ __('معطّل (مخفي)') }}</option>
                </select>
            </div>

            <div class="pt-4 border-t border-[#EADBCC] flex items-center justify-end gap-3">
                <a href="{{ route('banners.index') }}" class="px-5 py-2.5 rounded-xl border border-[#EADBCC] bg-[#F8F6F2] hover:bg-[#EDE8DC] text-[#18181B] text-sm font-semibold transition-colors">
                    {{ __('إلغاء') }}
                </a>
                <button type="submit" class="px-7 py-2.5 rounded-xl bg-[#18181B] hover:bg-[#27272A] text-white text-sm font-semibold shadow-sm transition-all">
                    {{ __('حفظ البانر') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
