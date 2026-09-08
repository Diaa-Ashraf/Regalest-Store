@extends('layouts.admin')

@section('title', __('التصنيفات والأقسام'))

@section('content')
<div class="space-y-6">
    
    <!-- Top Header -->
    <div class="bg-white border border-[#EADBCC] rounded-2xl p-6 sm:p-8 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="text-xs font-bold text-[#C5A059] uppercase tracking-wider">📁 Categories Architecture</span>
            </div>
            <h1 class="font-cinzel text-2xl sm:text-3xl font-bold text-[#18181B]">
                {{ __('التصنيفات والأقسام') }}
            </h1>
            <p class="text-xs sm:text-sm text-[#71717A] mt-1">
                {{ __('تنظيم المنتجات وتصنيفها في أقسام تظهر في القائمة العلوية والسلايدر الرئيسي.') }}
            </p>
        </div>

        <a href="{{ route('categories.create') }}" class="px-5 py-3 rounded-xl bg-[#18181B] hover:bg-[#C5A059] text-white text-xs font-bold shadow-sm transition-all flex items-center gap-2 shrink-0">
            <span>+</span>
            <span>{{ __('إضافة تصنيف جديد') }}</span>
        </a>
    </div>

    <!-- Categories Table -->
    <div class="bg-white border border-[#EADBCC] rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-start text-xs">
                <thead class="bg-[#F8F6F2] text-[#71717A] uppercase text-[11px] border-b border-[#EADBCC]">
                    <tr>
                        <th class="py-3.5 px-6 text-start font-semibold" style="width: 80px;">#</th>
                        <th class="py-3.5 px-4 text-start font-semibold">{{ __('الصورة') }}</th>
                        <th class="py-3.5 px-6 text-start font-semibold">{{ __('اسم التصنيف') }}</th>
                        <th class="py-3.5 px-6 text-start font-semibold">{{ __('الوصف') }}</th>
                        <th class="py-3.5 px-6 text-end font-semibold">{{ __('إجراءات') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#EADBCC]">
                    @forelse($categories as $category)
                        <tr class="hover:bg-[#F8F6F2]/50 transition-colors">
                            <td class="py-4 px-6 font-bold text-[#71717A]">
                                {{ $loop->iteration }}
                            </td>
                            <td class="py-4 px-4">
                                <div class="w-12 h-12 rounded-xl bg-[#F8F6F2] border border-[#EADBCC] p-1 flex-shrink-0 flex items-center justify-center overflow-hidden">
                                    @if($category->image_url)
                                        <img src="{{ $category->image_url }}" 
                                             alt="{{ $category->name }}"
                                             class="w-full h-full object-cover rounded-lg">
                                    @else
                                        <span class="text-xl">🎁</span>
                                    @endif
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <span class="font-bold text-[#18181B] text-xs block">{{ $category->name }}</span>
                            </td>
                            <td class="py-4 px-6 text-[#71717A] max-w-md">
                                {{ Str::limit($category->description, 70) ?: '-' }}
                            </td>
                            <td class="py-4 px-6 text-end">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('categories.edit', $category->id) }}" class="px-3 py-1.5 rounded-lg border border-[#EADBCC] bg-[#F8F6F2] hover:bg-[#EADBCC] text-[#18181B] font-semibold text-xs transition-colors">
                                        {{ __('تعديل') }}
                                    </a>
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" data-confirm-message="{{ __('هل أنت متأكد من رغبتك في حذف التصنيف: ') . $category->name . '؟' }}">
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
                            <td colspan="5" class="py-12 text-center text-[#71717A]">
                                {{ __('لا توجد تصنيفات مسجلة حتى الآن.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($categories, 'hasPages') && $categories->hasPages())
            <div class="p-4 border-t border-[#EADBCC] bg-[#F8F6F2]/30">
                {{ $categories->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
