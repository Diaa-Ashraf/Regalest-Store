<!-- Amazon-Style Deals Section - عروض تستاهل -->
@if(isset($deals) && $deals->count() > 0)
<section class="amazon-deals-section">
    <!-- Header Strip -->
    <div class="deals-header-strip">
        <div class="container">
            <div class="deals-header-content">
                <div class="deals-header-right">
                    <div class="deals-title-wrapper">
                        <i class="fa fa-shopping-cart deals-cart-icon"></i>
                        <h2 class="deals-main-title">{{ __('عروض تستاهل...') }}</h2>
                        <span class="deals-shop-now">{{ __('أشتري على طول') }}</span>
                    </div>
                    <span class="deals-free-shipping">{{ __('+ توصيل مجاني') }}</span>
                </div>
                <a href="{{ route('product.shop') }}" class="deals-see-more">
                    {{ __('عرض المزيد') }} <i class="fa fa-arrow-left"></i>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Deals Products Slider -->
    <div class="deals-products-wrapper">
        <div class="container">
            <div class="deals-slider-container">
                <!-- Navigation Arrows -->
                <button class="deals-arrow deals-arrow-right" id="deals-prev">
                    <i class="fa fa-chevron-right"></i>
                </button>
                
                <div class="deals-slider-viewport">
                    <div class="owl-carousel" id="amazon-deals-slider">
                        @foreach($deals as $deal)
                            <div class="deal-card-item">
                                <a href="{{ route('product.details', $deal->product_id) }}" class="deal-card-link">
                                    <!-- Product Image -->
                                    <div class="deal-image-container">
                                        @if($deal->product && $deal->product->image)
                                            <img src="{{ asset('storage/products/' . $deal->product->image) }}" 
                                                 alt="{{ $deal->product->name ?? 'Product' }}" 
                                                 class="deal-product-img">
                                        @else
                                            <img src="{{ asset('assets/site/img/products/product-1.jpg') }}" 
                                                 alt="Product" 
                                                 class="deal-product-img">
                                        @endif
                                    </div>
                                    
                                    <!-- Badges Row -->
                                    <div class="deal-badges-row">
                                        <span class="deal-badge-discount">{{ __('خصم') }} {{ $deal->discount_percent }}%</span>
                                        <span class="deal-badge-limited">{{ $deal->badge_text }}</span>
                                    </div>
                                    
                                    <!-- Price Section -->
                                    <div class="deal-price-row">
                                        <span class="deal-new-price">{{ $deal->formatted_deal_price }}<sup>{{ __('جنيه') }}</sup></span>
                                        <span class="deal-old-price">{{ $deal->formatted_original_price }} {{ __('جنيه') }}</span>
                                    </div>
                                    
                                    <!-- Product Title -->
                                    <h4 class="deal-product-title">{{ Str::limit($deal->product->name ?? '', 50) }}</h4>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <button class="deals-arrow deals-arrow-left" id="deals-next">
                    <i class="fa fa-chevron-left"></i>
                </button>
            </div>
        </div>
    </div>
</section>

<style>
/* Amazon Deals Section Styles */
.amazon-deals-section {
    background: #e3e6e6;
    padding: 0;
    margin: 20px 0;
}

/* Header Strip - Orange */
.deals-header-strip {
    background: linear-gradient(135deg, #ff9900 0%, #ff6600 100%);
    padding: 15px 0;
}

.deals-header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.deals-header-right {
    display: flex;
    align-items: center;
    gap: 20px;
}

.deals-title-wrapper {
    display: flex;
    align-items: center;
    gap: 12px;
}

.deals-cart-icon {
    font-size: 28px;
    color: #fff;
    background: rgba(255,255,255,0.2);
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
}

.deals-main-title {
    font-size: 26px;
    font-weight: 800;
    color: #fff;
    margin: 0;
    font-family: 'Cairo', sans-serif;
}

.deals-shop-now {
    background: #232f3e;
    color: #febd69;
    padding: 6px 14px;
    border-radius: 4px;
    font-size: 13px;
    font-weight: 600;
}

.deals-free-shipping {
    background: #fff;
    color: #ff6600;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 700;
}

.deals-see-more {
    color: #fff;
    font-size: 15px;
    font-weight: 600;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 6px;
    transition: all 0.3s;
}

.deals-see-more:hover {
    text-decoration: underline;
    color: #fff;
}

/* Products Wrapper */
.deals-products-wrapper {
    background: #febd69;
    padding: 20px 0 25px;
}

.deals-slider-container {
    position: relative;
    padding: 0 50px;
}

/* Navigation Arrows */
.deals-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 45px;
    height: 80px;
    background: #fff;
    border: 1px solid #ddd;
    color: #333;
    font-size: 18px;
    cursor: pointer;
    z-index: 10;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.deals-arrow:hover {
    background: #f5f5f5;
    color: #ff9900;
}

.deals-arrow-right {
    right: 0;
    border-radius: 4px 0 0 4px;
}

.deals-arrow-left {
    left: 0;
    border-radius: 0 4px 4px 0;
}

/* Deal Card */
.deal-card-item {
    background: #fff;
    border-radius: 4px;
    overflow: hidden;
    margin: 5px;
    transition: all 0.3s;
    box-shadow: 0 1px 3px rgba(0,0,0,0.08);
}

.deal-card-item:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    transform: translateY(-3px);
}

.deal-card-link {
    display: block;
    text-decoration: none;
    padding: 15px;
}

/* Product Image */
.deal-image-container {
    height: 180px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 10px;
    margin-bottom: 12px;
}

.deal-product-img {
    max-width: 100%;
    max-height: 160px;
    object-fit: contain;
    transition: transform 0.3s;
}

.deal-card-item:hover .deal-product-img {
    transform: scale(1.05);
}

/* Badges */
.deal-badges-row {
    display: flex;
    gap: 8px;
    margin-bottom: 10px;
    flex-wrap: wrap;
}

.deal-badge-discount {
    background: #cc0c39;
    color: #fff;
    padding: 4px 10px;
    border-radius: 3px;
    font-size: 12px;
    font-weight: 700;
}

.deal-badge-limited {
    background: #febd69;
    color: #232f3e;
    padding: 4px 10px;
    border-radius: 3px;
    font-size: 11px;
    font-weight: 600;
}

/* Price */
.deal-price-row {
    display: flex;
    align-items: baseline;
    gap: 10px;
    margin-bottom: 8px;
}

.deal-new-price {
    font-size: 22px;
    font-weight: 400;
    color: #0f1111;
}

.deal-new-price sup {
    font-size: 12px;
    margin-right: 2px;
}

.deal-old-price {
    font-size: 13px;
    color: #565959;
    text-decoration: line-through;
}

/* Product Title */
.deal-product-title {
    font-size: 13px;
    font-weight: 400;
    color: #007185;
    margin: 0;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: 36px;
}

.deal-card-link:hover .deal-product-title {
    color: #c7511f;
    text-decoration: underline;
}

/* Responsive */
@media (max-width: 991px) {
    .deals-header-content {
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }
    
    .deals-header-right {
        flex-direction: column;
        gap: 10px;
    }
    
    .deals-slider-container {
        padding: 0 30px;
    }
}

@media (max-width: 576px) {
    .deals-main-title {
        font-size: 20px;
    }
    
    .deals-title-wrapper {
        flex-wrap: wrap;
        justify-content: center;
    }
    
    .deal-image-container {
        height: 140px;
    }
}
</style>

<script>
$(document).ready(function() {
    var dealsOwl = $('#amazon-deals-slider').owlCarousel({
        rtl: true,
        loop: true,
        margin: 15,
        nav: false,
        dots: false,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        smartSpeed: 500,
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
    $('#deals-next').click(function() {
        dealsOwl.trigger('next.owl.carousel');
    });
    
    $('#deals-prev').click(function() {
        dealsOwl.trigger('prev.owl.carousel');
    });
});
</script>
@endif
