@extends('layouts.admin')

@section('title', __('البانرات والإعلانات'))

@section('content')
<div class="space-y-6">
    
    <!-- Top Header -->
    <div class="bg-white border border-[#EADBCC] rounded-2xl p-6 sm:p-8 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="text-xs font-bold text-[#C5A059] uppercase tracking-wider">🖼️ Visual Hero Management</span>
            </div>
            <h1 class="font-cinzel text-2xl sm:text-3xl font-bold text-[#18181B]">
                {{ __('البانرات والإعلانات الترويجية') }}
            </h1>
            <p class="text-xs sm:text-sm text-[#71717A] mt-1">
                {{ __('إدارة شرائح البانر الرئيسي المتحرك أعلى الصفحة والعروض الترويجية المصورة.') }}
            </p>
        </div>

        <a href="{{ route('banners.create') }}" class="px-5 py-3 rounded-xl bg-[#18181B] hover:bg-[#C5A059] text-white text-xs font-bold shadow-sm transition-all flex items-center gap-2 shrink-0">
            <span>+</span>
            <span>{{ __('إضافة بانر جديد') }}</span>
        </a>
    </div>

    <!-- Banners Table -->
    <div class="bg-white border border-[#EADBCC] rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-start text-xs">
                <thead class="bg-[#F8F6F2] text-[#71717A] uppercase text-[11px] border-b border-[#EADBCC]">
                    <tr>
                        <th class="py-3.5 px-6 text-start font-semibold" style="width: 80px;">#</th>
                        <th class="py-3.5 px-4 text-start font-semibold">{{ __('الصورة') }}</th>
                        <th class="py-3.5 px-6 text-start font-semibold">{{ __('العنوان') }}</th>
                        <th class="py-3.5 px-6 text-start font-semibold">{{ __('الترتيب / الموضع') }}</th>
                        <th class="py-3.5 px-4 text-start font-semibold">{{ __('الحالة') }}</th>
                        <th class="py-3.5 px-6 text-end font-semibold">{{ __('إجراءات') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#EADBCC]">
                    @forelse($banners as $banner)
                        <tr class="hover:bg-[#F8F6F2]/50 transition-colors">
                            <td class="py-4 px-6 font-bold text-[#71717A]">
                                {{ $loop->iteration }}
                            </td>
                            <td class="py-4 px-4">
                                <div class="w-20 h-12 rounded-xl bg-[#F8F6F2] border border-[#EADBCC] p-1 flex-shrink-0 flex items-center justify-center overflow-hidden">
                                    <img src="{{ $banner->image_url }}" alt="Banner" class="w-full h-full object-cover rounded-lg">
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <span class="font-bold text-[#18181B] text-xs block">{{ $banner->title ?? '-' }}</span>
                                <span class="text-[11px] text-[#71717A] block truncate max-w-sm">{{ $banner->description ?? '' }}</span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-1 rounded-lg bg-[#F8F6F2] border border-[#EADBCC] text-[11px] font-semibold text-[#18181B]">
                                    {{ __('موضع') }} {{ $banner->position }}
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                @if($banner->status)
                                    <span class="px-2.5 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 text-[11px] font-bold">
                                        {{ __('نشط') }}
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full bg-gray-50 border border-gray-200 text-gray-500 text-[11px] font-bold">
                                        {{ __('غير نشط') }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-end">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('banners.edit', $banner->id) }}" class="px-3 py-1.5 rounded-lg border border-[#EADBCC] bg-[#F8F6F2] hover:bg-[#EADBCC] text-[#18181B] font-semibold text-xs transition-colors">
                                        {{ __('تعديل') }}
                                    </a>
                                    <form action="{{ route('banners.destroy', $banner->id) }}" method="POST" data-confirm-message="{{ __('هل أنت متأكد من رغبتك في حذف هذا البانر الإعلاني؟') }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 rounded-lg border border-rose-200 bg-rose-50 hover:bg-rose-100 text-rose-600 font-semibold text-xs transition-colors">
                                            {{ __('حذف') }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-[#71717A]">
                                {{ __('لا توجد بانرات ترويجية مسجلة حالياً.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
