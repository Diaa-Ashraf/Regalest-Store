@extends('layouts.admin')

@section('title', __('كتالوج المنتجات والمخزون'))

@section('content')
<div class="space-y-6">
    
    <!-- Top Header -->
    <div class="bg-white border border-[#EADBCC] rounded-2xl p-6 sm:p-8 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="text-xs font-bold text-[#C5A059] uppercase tracking-wider">📦 Catalog & Inventory</span>
            </div>
            <h1 class="font-cinzel text-2xl sm:text-3xl font-bold text-[#18181B]">
                {{ __('كتالوج المنتجات والمخزون') }}
            </h1>
            <p class="text-xs sm:text-sm text-[#71717A] mt-1">
                {{ __('إدارة المنتجات، تحديد المنتجات المميزة، وتحديث كميات المخزون والأسعار.') }}
            </p>
        </div>

        <a href="{{ route('admin.products.create') }}" class="px-5 py-3 rounded-xl bg-[#18181B] hover:bg-[#C5A059] text-white text-xs font-bold shadow-sm transition-all flex items-center gap-2 shrink-0">
            <span>+</span>
            <span>{{ __('إضافة منتج جديد') }}</span>
        </a>
    </div>

    <!-- Filter Card -->
    <div class="bg-white border border-[#EADBCC] rounded-2xl p-4 sm:p-6 shadow-sm">
        <form method="GET" action="{{ route('admin.products.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 items-center">
            <div class="lg:col-span-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('ابحث باسم المنتج...') }}" 
                       class="w-full px-4 py-2 text-xs rounded-xl bg-[#F8F6F2] border border-[#EADBCC] text-[#18181B] placeholder-[#71717A] focus:outline-none focus:ring-2 focus:ring-[#C5A059] focus:bg-white">
            </div>

            <div class="lg:col-span-3">
                <select name="category_id" class="w-full px-3 py-2 text-xs rounded-xl bg-[#F8F6F2] border border-[#EADBCC] text-[#18181B] focus:outline-none focus:ring-2 focus:ring-[#C5A059] focus:bg-white">
                    <option value="">{{ __('-- جميع الأقسام والتصنيفات --') }}</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="lg:col-span-3">
                <select name="featured" class="w-full px-3 py-2 text-xs rounded-xl bg-[#F8F6F2] border border-[#EADBCC] text-[#18181B] focus:outline-none focus:ring-2 focus:ring-[#C5A059] focus:bg-white">
                    <option value="">{{ __('-- كل المنتجات --') }}</option>
                    <option value="1" {{ request('featured') === '1' ? 'selected' : '' }}>⭐ {{ __('المميزة فقط (Featured)') }}</option>
                </select>
            </div>

            <div class="lg:col-span-2">
                <button type="submit" class="w-full py-2 px-4 rounded-xl bg-[#18181B] hover:bg-[#C5A059] text-white text-xs font-bold transition-all shadow-sm">
                    {{ __('تصفية') }}
                </button>
            </div>
        </form>
    </div>

    <!-- Products Table -->
    <div class="bg-white border border-[#EADBCC] rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-start text-xs">
                <thead class="bg-[#F8F6F2] text-[#71717A] uppercase text-[11px] border-b border-[#EADBCC]">
                    <tr>
                        <th class="py-3.5 px-6 text-start font-semibold">{{ __('الصورة والمنتج') }}</th>
                        <th class="py-3.5 px-4 text-start font-semibold">{{ __('التصنيف') }}</th>
                        <th class="py-3.5 px-4 text-start font-semibold">{{ __('السعر الأساسي') }}</th>
                        <th class="py-3.5 px-4 text-start font-semibold">{{ __('سعر الخصم') }}</th>
                        <th class="py-3.5 px-4 text-start font-semibold">{{ __('المخزون') }}</th>
                        <th class="py-3.5 px-4 text-center font-semibold">{{ __('المميز بالرئيسية') }}</th>
                        <th class="py-3.5 px-6 text-end font-semibold">{{ __('إجراءات') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#EADBCC]">
                    @forelse($products as $product)
                        <tr class="hover:bg-[#F8F6F2]/50 transition-colors">
                            <td class="py-4 px-6 flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl bg-[#F8F6F2] border border-[#EADBCC] p-1 flex-shrink-0 flex items-center justify-center overflow-hidden">
                                    <img src="{{ $product->image_url ?? asset('assets/site/img/product/product-1.jpg') }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover rounded-lg">
                                </div>
                                <div class="min-w-0">
                                    <span class="font-bold text-[#18181B] truncate block max-w-xs text-xs">{{ $product->name }}</span>
                                    <span class="text-[11px] text-[#71717A] truncate block max-w-xs">{{ Str::limit($product->description, 40) }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <span class="px-2.5 py-1 rounded-lg bg-[#F8F6F2] border border-[#EADBCC] text-[11px] font-medium text-[#18181B]">
                                    {{ $product->category?->name ?? __('غير مصنف') }}
                                </span>
                            </td>
                            <td class="py-4 px-4 font-bold text-[#18181B] font-cinzel">
                                {{ $product->formatted_price }}
                            </td>
                            <td class="py-4 px-4">
                                @if($product->has_discount)
                                    <div class="flex items-center gap-1.5">
                                        <span class="font-bold text-rose-600 font-cinzel">{{ format_currency($product->discount_price) }}</span>
                                        <span class="px-1.5 py-0.5 rounded-full bg-rose-50 border border-rose-200 text-rose-600 text-[10px] font-bold">-{{ $product->discount_percentage }}%</span>
                                    </div>
                                @else
                                    <span class="text-[#71717A]">-</span>
                                @endif
                            </td>
                            <td class="py-4 px-4">
                                @if($product->available_stock > 5)
                                    <span class="px-2.5 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 text-[11px] font-bold">
                                        {{ $product->available_stock }} {{ __('قطعة') }}
                                    </span>
                                @elseif($product->available_stock > 0)
                                    <span class="px-2.5 py-1 rounded-full bg-amber-50 border border-amber-200 text-amber-700 text-[11px] font-bold">
                                        {{ $product->available_stock }} {{ __('منخفض') }}
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full bg-rose-50 border border-rose-200 text-rose-700 text-[11px] font-bold">
                                        {{ __('نفدت الكمية') }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-4 text-center">
                                <form action="{{ route('admin.products.toggle-featured', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 rounded-full text-[11px] font-bold transition-all {{ $product->featured ? 'bg-[#C5A059] text-white shadow-xs' : 'bg-[#F8F6F2] text-[#71717A] border border-[#EADBCC] hover:bg-[#EADBCC]' }}">
                                        {{ $product->featured ? '⭐ ' . __('مميز') : '☆ ' . __('عادي') }}
                                    </button>
                                </form>
                            </td>
                            <td class="py-4 px-6 text-end">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="px-3 py-1.5 rounded-lg border border-[#EADBCC] bg-[#F8F6F2] hover:bg-[#EADBCC] text-[#18181B] font-semibold text-xs transition-colors">
                                        {{ __('تعديل') }}
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" data-confirm-message="{{ __('هل أنت متأكد من رغبتك في حذف المنتج: ') . $product->name . '؟' }}">
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
                            <td colspan="7" class="py-12 text-center text-[#71717A]">
                                {{ __('لا توجد منتجات مسجلة. اضغط على "إضافة منتج جديد" لإضافة أول منتج للمتجر.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($products->hasPages())
            <div class="p-4 border-t border-[#EADBCC] bg-[#F8F6F2]/30">
                {{ $products->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
