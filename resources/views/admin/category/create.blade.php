@extends('layouts.admin')

@section('title', __('إضافة تصنيف جديد'))

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-[#18181B]">{{ __('إضافة تصنيف جديد') }}</h2>
            <p class="text-sm text-[#71717A] mt-0.5">{{ __('إضافة فئة جديدة لعرض المنتجات في المتجر') }}</p>
        </div>
        <a href="{{ route('categories.index') }}" class="px-4 py-2 rounded-xl border border-[#EADBCC] bg-[#F8F6F2] hover:bg-[#EDE8DC] text-[#18181B] text-sm font-semibold transition-colors">
            {{ __('العودة للتصنيفات') }}
        </a>
    </div>

    <div class="bg-white border border-[#EADBCC] rounded-2xl p-6 sm:p-8 shadow-sm">
        <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- Multilingual Inputs --}}
            <div class="space-y-4">
                @foreach (['ar' => 'العربية', 'en' => 'الإنجليزية'] as $locale => $language)
                    <div class="p-4 rounded-xl bg-[#F8F6F2]/50 border border-[#EADBCC]">
                        <span class="text-xs font-bold text-[#C5A059] uppercase tracking-wider block mb-3">بيانات التصنيف باللغة {{ $language }}</span>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="name_{{ $locale }}" class="block text-xs font-semibold text-[#18181B] mb-1.5">{{ __('اسم التصنيف') }} ({{ $language }})</label>
                                <input type="text" id="name_{{ $locale }}" name="{{ $locale }}[name]" 
                                       class="w-full px-3.5 py-2 rounded-xl border border-[#EADBCC] bg-white text-[#18181B] focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059] focus:outline-none text-sm transition-all"
                                       value="{{ old($locale.'.name') }}" required>
                            </div>
                            <div>
                                <label for="desc_{{ $locale }}" class="block text-xs font-semibold text-[#18181B] mb-1.5">{{ __('الوصف') }} ({{ $language }})</label>
                                <input type="text" id="desc_{{ $locale }}" name="{{ $locale }}[description]" 
                                       class="w-full px-3.5 py-2 rounded-xl border border-[#EADBCC] bg-white text-[#18181B] focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059] focus:outline-none text-sm transition-all"
                                       value="{{ old($locale.'.description') }}">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="image" class="block text-sm font-semibold text-[#18181B] mb-2">{{ __('صورة التصنيف') }}</label>
                    <input type="file" id="image" name="image" 
                           class="w-full px-3.5 py-2 rounded-xl border border-[#EADBCC] bg-[#F8F6F2]/40 text-[#18181B] text-sm focus:outline-none file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#18181B] file:text-white hover:file:bg-[#27272A] cursor-pointer @error('image') border-rose-500 @enderror">
                    @error('image')
                        <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="slug" class="block text-sm font-semibold text-[#18181B] mb-2">{{ __('الرابط الدائم (Slug)') }}</label>
                    <input type="text" id="slug" name="slug" 
                           class="w-full px-4 py-2.5 rounded-xl border border-[#EADBCC] bg-[#F8F6F2]/40 text-[#18181B] focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059] focus:outline-none text-sm transition-all @error('slug') border-rose-500 @enderror" 
                           value="{{ old('slug') }}" placeholder="luxury-watches">
                    @error('slug')
                        <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="pt-4 border-t border-[#EADBCC] flex items-center justify-end gap-3">
                <a href="{{ route('categories.index') }}" class="px-5 py-2.5 rounded-xl border border-[#EADBCC] bg-[#F8F6F2] hover:bg-[#EDE8DC] text-[#18181B] text-sm font-semibold transition-colors">
                    {{ __('إلغاء') }}
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#18181B] hover:bg-[#27272A] text-white text-sm font-semibold shadow-sm transition-all">
                    {{ __('حفظ التصنيف') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection