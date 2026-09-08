<!-- Amazon-Style Deals Section -->
<section class="amazon-deals-wrapper">
    <!-- Header Strip -->
    <div class="deals-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div class="deals-title">
                    <i class="fa fa-shopping-cart"></i>
                    <span>{{ __('عروض تستاهل...') }}</span>
                    <small>{{ __('اشتري على طول') }}</small>
                </div>
                <div class="deals-subtitle">
                    <span>+ {{ __('توصيل مجاني') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Carousel -->
    <div class="deals-products-wrapper">
        <div class="container-fluid position-relative">
            
            <!-- Navigation Arrows -->
            <button class="deals-nav deals-nav-prev" id="deals-prev">
                <i class="fa fa-chevron-left"></i>
            </button>
            <button class="deals-nav deals-nav-next" id="deals-next">
                <i class="fa fa-chevron-right"></i>
            </button>

            <!-- Carousel -->
            <div class="owl-carousel deals-carousel" id="deals-carousel">
                @forelse($products->take(12) as $product)
                    <div class="deal-product-card">
                        <!-- Product Image -->
                        <div class="deal-product-img">
                            <a href="{{ route('product.details', $product->id) }}">
                                @if($product->image_url)
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                                @else
                                    <img src="{{ asset('assets/site/img/product/product-1.jpg') }}" alt="{{ $product->name }}">
                                @endif
                            </a>
                        </div>

                        <!-- Badges -->
                        <div class="deal-badges">
                            @if(isset($product->discount) && $product->discount > 0)
                                <span class="badge-discount">{{ __('خصم') }} {{ $product->discount }}%</span>
                            @endif
                            <span class="badge-limited">{{ __('عرض لمدة محدودة') }}</span>
                        </div>

                        <!-- Price & Info -->
                        <div class="deal-product-info">
                            <div class="deal-price">
                                @if(isset($product->discount_price) && $product->discount_price > 0)
                                    <span class="price-new">{{ number_format($product->discount_price, 2) }}<sup>جنيه</sup></span>
                                    <span class="price-old">{{ number_format($product->price, 2) }} جنيه</span>
                                @else
                                    <span class="price-new">{{ number_format($product->price, 2) }}<sup>جنيه</sup></span>
                                @endif
                            </div>
                            <p class="deal-product-name">{{ Str::limit($product->name, 40) }}</p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <p class="text-muted">{{ __('لا توجد عروض حالياً') }}</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Footer Strip (Optional - Savings Corner) -->
    <div class="deals-footer">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <span><strong>{{ __('ركن التوفير') }}</strong> | {{ __('اسعار على قد الايد') }}</span>
                <a href="{{ route('product.shop') }}" class="btn-start-shopping">{{ __('ابدأ تسوق') }}</a>
            </div>
        </div>
    </div>
</section>

<style>
/* Amazon Deals Wrapper */
.amazon-deals-wrapper {
    margin-top: 20px;
    margin-bottom: 30px;
}

/* Header Strip */
.deals-header {
    background-color: #febd69; /* Amazon Orange */
    padding: 12px 0;
}

.deals-title {
    font-size: 22px;
    font-weight: 700;
    color: #0F1111;
    display: flex;
    align-items: center;
    gap: 10px;
}

.deals-title i {
    font-size: 26px;
}

.deals-title small {
    font-size: 14px;
    font-weight: 400;
    color: #565959;
    margin-right: 15px;
}

.deals-subtitle {
    color: #0F1111;
    font-weight: 600;
}

/* Products Wrapper */
.deals-products-wrapper {
    background-color: #ffffff;
    padding: 20px 0;
    position: relative;
}

/* Navigation Arrows */
.deals-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 50px;
    height: 80px;
    background: rgba(255,255,255,0.95);
    border: 1px solid #ddd;
    border-radius: 4px;
    z-index: 10;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: #555;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.deals-nav:hover {
    background: #fff;
    color: #000;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.deals-nav-prev {
    left: 10px;
}

.deals-nav-next {
    right: 10px;
}

/* Product Card */
.deal-product-card {
    background: #fff;
    border: 1px solid #eee;
    border-radius: 4px;
    padding: 15px;
    text-align: center;
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.deal-product-card:hover {
    border-color: #febd69;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

/* Product Image */
.deal-product-img {
    height: 180px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 15px;
    overflow: hidden;
}

.deal-product-img img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    transition: transform 0.3s ease;
}

.deal-product-card:hover .deal-product-img img {
    transform: scale(1.05);
}

/* Badges */
.deal-badges {
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
    justify-content: center;
    margin-bottom: 10px;
}

.badge-discount {
    background-color: #cc0c39; /* Amazon Deal Red */
    color: #fff;
    padding: 4px 10px;
    border-radius: 2px;
    font-size: 12px;
    font-weight: 700;
}

.badge-limited {
    background-color: #cc0c39;
    color: #fff;
    padding: 4px 10px;
    border-radius: 2px;
    font-size: 11px;
    font-weight: 600;
}

/* Price */
.deal-product-info {
    margin-top: auto;
}

.deal-price {
    margin-bottom: 8px;
}

.price-new {
    font-size: 22px;
    font-weight: 400;
    color: #0F1111;
}

.price-new sup {
    font-size: 12px;
    margin-right: 3px;
}

.price-old {
    font-size: 13px;
    color: #565959;
    text-decoration: line-through;
    display: block;
}

.deal-product-name {
    font-size: 13px;
    color: #0F1111;
    line-height: 1.4;
    margin: 0;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Footer Strip */
.deals-footer {
    background-color: #febd69;
    padding: 10px 0;
}

.deals-footer span {
    color: #0F1111;
    font-size: 18px;
}

.btn-start-shopping {
    background-color: #0F1111;
    color: #fff;
    padding: 8px 20px;
    border-radius: 4px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-start-shopping:hover {
    background-color: #232f3e;
    color: #fff;
    text-decoration: none;
}

/* Carousel Adjustments */
.deals-carousel .owl-stage {
    display: flex;
}

.deals-carousel .owl-item {
    padding: 0 8px;
}
</style>

<script>
$(document).ready(function() {
    var owl = $('#deals-carousel').owlCarousel({
        loop: false,
        margin: 15,
        nav: false,
        dots: false,
        responsive: {
            0: { items: 1 },
            480: { items: 2 },
            768: { items: 3 },
            992: { items: 4 },
            1200: { items: 5 },
            1400: { items: 6 }
        }
    });

    // Custom Navigation
    $('#deals-prev').click(function() {
        owl.trigger('prev.owl.carousel');
    });
    
    $('#deals-next').click(function() {
        owl.trigger('next.owl.carousel');
    });
});
</script>
