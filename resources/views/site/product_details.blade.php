@extends('layouts.site')

@section('content')
@php
    $cur = get_active_currency();
    $displayPrice = format_currency($product->final_price, $cur);
    $subPrice = $cur === 'USD' ? format_currency($product->final_price, 'SYP') : format_currency($product->final_price, 'USD');
@endphp

<div class="py-5" style="background: #080808; min-height: 80vh;">
    <div class="container">
        {{-- Breadcrumb --}}
        <div class="mb-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 small">
                    <li class="breadcrumb-item"><a href="{{ route('site.home') }}" class="text-muted text-decoration-none">الرئيسية</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('product.shop') }}" class="text-muted text-decoration-none">المتجر</a></li>
                    @if($product->category)
                        <li class="breadcrumb-item"><a href="{{ route('category.product', $product->category->id) }}" class="text-muted text-decoration-none">{{ $product->category->name }}</a></li>
                    @endif
                    <li class="breadcrumb-item active text-warning" aria-current="page">{{ $product->name }}</li>
                </ol>
            </nav>
        </div>

        {{-- Product Details Card --}}
        <div class="card border-0 p-4 p-lg-5 mb-5" style="background: #141414; border: 1px solid #262626 !important; border-radius: 16px;">
            <div class="row g-5 align-items-center">
                {{-- Product Image Gallery --}}
                <div class="col-lg-6 text-center">
                    <div class="position-relative d-inline-block p-3 rounded-4" style="background: #0d0d0d; border: 1px solid rgba(201, 168, 76, 0.2);">
                        @if($product->has_discount)
                            <span class="badge-luxury-discount" style="top: 20px; right: 20px;">-{{ $product->discount_percentage }}%</span>
                        @endif
                        @if($product->featured)
                            <span class="badge-luxury-featured" style="top: 20px; left: 20px;">⭐ مميز</span>
                        @endif

                        <img src="{{ $product->image_url ?? asset('assets/site/img/product/product-1.jpg') }}" alt="{{ $product->name }}" class="img-fluid rounded-3" style="max-height: 460px; object-fit: cover;">
                    </div>
                </div>

                {{-- Product Info & CTAs --}}
                <div class="col-lg-6">
                    <span class="text-warning small text-uppercase fw-bold" style="letter-spacing: 1px;">
                        {{ $product->category?->name ?? 'ساعات فاخرة' }}
                    </span>
                    <h1 class="display-6 fw-bold text-white mb-3 mt-1">{{ $product->name }}</h1>

                    {{-- Price Display --}}
                    <div class="mb-4 pb-3 border-bottom border-dark">
                        <div class="d-flex align-items-baseline gap-3">
                            <span class="fs-2 fw-bold text-gold-gradient">{{ $displayPrice }}</span>
                            @if($product->has_discount)
                                <span class="fs-5 text-muted text-decoration-line-through">{{ format_currency($product->price, $cur) }}</span>
                            @endif
                        </div>
                        <small class="text-secondary d-block mt-1">سعر الصرف اليومي: {{ $subPrice }}</small>
                    </div>

                    {{-- Description --}}
                    <div class="mb-4">
                        <h6 class="text-white fw-bold mb-2">وصف ومميزات الساعة:</h6>
                        <p class="text-secondary" style="line-height: 1.8;">
                            {{ $product->description ?: 'ساعة يد أصلية فاخرة مصنوعة من أرقى المواد المقاومة للصدأ، تجمع بين الكلاسيكية الفاتنة والتقنيات العصرية الدقيقة. تأتي في علبة فاخرة ومناسبة كهدية راقية.' }}
                        </p>
                    </div>

                    {{-- Stock Status --}}
                    <div class="mb-4">
                        @if($product->available_stock > 0)
                            <span class="badge bg-success py-2 px-3">
                                ✓ متوفرة وجاهزة للتوصيل الفوري (متبقي {{ $product->available_stock }} قطعة)
                            </span>
                        @else
                            <span class="badge bg-danger py-2 px-3">
                                ✕ نفدت الكمية مؤقتاً
                            </span>
                        @endif
                    </div>

                    {{-- Action Buttons (Add to Cart & Direct WhatsApp Inquiry) --}}
                    <div class="d-flex flex-column flex-sm-row gap-3 mt-4">
                        @if($product->available_stock > 0)
                            <button type="button" class="btn-gold py-3 px-4 fs-6 js-add-to-cart flex-grow-1" data-id="{{ $product->id }}">
                                <span>🛒 إضافة إلى السلة</span>
                            </button>
                        @endif

                        <a href="{{ $whatsappInquiryUrl }}" target="_blank" class="btn-outline-gold py-3 px-4 fs-6 d-inline-flex align-items-center justify-content-center gap-2 flex-grow-1">
                            <span>💬 استفسار وشراء عبر واتساب</span>
                        </a>
                    </div>

                    <div class="mt-4 pt-3 border-top border-dark d-flex gap-4 text-muted small">
                        <span>🛡️ ضمان أصالة 100%</span>
                        <span>🚚 توصيل سريع</span>
                        <span>💵 الدفع عند الاستلام</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Related Products --}}
        @if($relatedProducts->count() > 0)
            <div class="mt-5">
                <h3 class="h4 text-white fw-bold mb-4">ساعات مشابهة قد تعجبك 👑</h3>
                <div class="row g-4">
                    @foreach($relatedProducts as $relProduct)
                        <div class="col-12 col-sm-6 col-md-3">
                            <x-product-card :product="$relProduct" />
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
