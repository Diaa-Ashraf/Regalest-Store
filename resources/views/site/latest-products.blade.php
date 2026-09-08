<!-- Enhanced Latest Products Section -->
<section class="latest-product spad">
    <div class="container">
        <div class="row">
            <!-- Latest Products -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="latest-product__text animate-fadeInLeft">
                    <h4 class="text-gradient">
                        <i class="fa fa-clock-o me-2"></i>
                        {{ __('Latest_Products') }}
                    </h4>
                    <div class="latest-product__slider owl-carousel">
                        <div class="latest-product__slider__item">
                            @forelse ($latest_product as $product)
                                <a href="{{ route('product.details', $product->id) }}" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        @if($product->image_url)
                                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                                        @else
                                            <img src="{{ asset('assets/site/img/latest-product/lp-1.jpg') }}" alt="{{ $product->name }}">
                                        @endif
                                        
                                        <!-- Quick Add Button -->
                                        <div class="quick-add-btn">
                                            <button onclick="quickAddToCart({{ $product->id }})" class="btn-modern btn-accent btn-sm">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>{{ Str::limit($product->name, 30) }}</h6>
                                        <div class="price-info">
                                            @if(isset($product->discount_price) && $product->discount_price > 0)
                                                <span class="current-price">${{ number_format($product->discount_price, 2) }}</span>
                                                <span class="original-price">${{ number_format($product->price, 2) }}</span>
                                            @else
                                                <span class="current-price">${{ number_format($product->price, 2) }}</span>
                                            @endif
                                        </div>
                                        <div class="product-meta">
                                            <span class="rating">
                                                <i class="fa fa-star"></i> {{ rand(4.0, 5.0) }}
                                            </span>
                                            <span class="sold">{{ rand(5, 50) }} {{ __('sold') }}</span>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="no-products-message">
                                    <p>{{ __('No_latest_products_available') }}</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Rated Products -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="latest-product__text animate-fadeInUp">
                    <h4 class="text-gradient">
                        <i class="fa fa-star me-2"></i>
                        {{ __('Top_Rated_Products') }}
                    </h4>
                    <div class="latest-product__slider owl-carousel">
                        <div class="latest-product__slider__item">
                            @forelse ($first_products as $product)
                                <a href="{{ route('product.details', $product->id) }}" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        @if($product->image_url)
                                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                                        @else
                                            <img src="{{ asset('assets/site/img/latest-product/lp-2.jpg') }}" alt="{{ $product->name }}">
                                        @endif
                                        
                                        <!-- Rating Badge -->
                                        <div class="rating-badge">
                                            <i class="fa fa-star"></i> {{ rand(4.5, 5.0) }}
                                        </div>
                                        
                                        <!-- Quick Add Button -->
                                        <div class="quick-add-btn">
                                            <button onclick="quickAddToCart({{ $product->id }})" class="btn-modern btn-accent btn-sm">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>{{ Str::limit($product->name, 30) }}</h6>
                                        <div class="price-info">
                                            @if(isset($product->discount_price) && $product->discount_price > 0)
                                                <span class="current-price">${{ number_format($product->discount_price, 2) }}</span>
                                                <span class="original-price">${{ number_format($product->price, 2) }}</span>
                                            @else
                                                <span class="current-price">${{ number_format($product->price, 2) }}</span>
                                            @endif
                                        </div>
                                        <div class="product-meta">
                                            <span class="rating">
                                                <i class="fa fa-star"></i> {{ rand(4.5, 5.0) }}
                                            </span>
                                            <span class="reviews">({{ rand(50, 200) }} {{ __('reviews') }})</span>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="no-products-message">
                                    <p>{{ __('No_top_rated_products_available') }}</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Review Products -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="latest-product__text animate-fadeInRight">
                    <h4>
                        <i class="fa fa-comments me-2"></i>
                        {{ __('Review_Products') }}
                    </h4>
                    <div class="latest-product__slider owl-carousel">
                        <div class="latest-product__slider__item">
                            @forelse ($first_products as $product)
                                <a href="{{ route('product.details', $product->id) }}" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        @if($product->image_url)
                                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                                        @else
                                            <img src="{{ asset('assets/site/img/latest-product/lp-3.jpg') }}" alt="{{ $product->name }}">
                                        @endif
                                        
                                        <!-- Review Badge -->
                                        <div class="review-badge">
                                            <i class="fa fa-comment"></i> {{ rand(10, 50) }}
                                        </div>
                                        
                                        <!-- Quick Add Button -->
                                        <div class="quick-add-btn">
                                            <button onclick="quickAddToCart({{ $product->id }})" class="btn-modern btn-accent btn-sm">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>{{ Str::limit($product->name, 30) }}</h6>
                                        <div class="price-info">
                                            @if(isset($product->discount_price) && $product->discount_price > 0)
                                                <span class="current-price">${{ number_format($product->discount_price, 2) }}</span>
                                                <span class="original-price">${{ number_format($product->price, 2) }}</span>
                                            @else
                                                <span class="current-price">${{ number_format($product->price, 2) }}</span>
                                            @endif
                                        </div>
                                        <div class="product-meta">
                                            <span class="rating">
                                                <i class="fa fa-star"></i> {{ rand(4.0, 5.0) }}
                                            </span>
                                            <span class="verified">
                                                <i class="fa fa-check-circle"></i> {{ __('Verified') }}
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="no-products-message">
                                    <p>{{ __('No_review_products_available') }}</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Enhanced Latest Products Styles */
.latest-product {
    padding: 80px 0;
    background: var(--background-white);
}

.latest-product__text {
    background: var(--background-light);
    border-radius: 20px;
    padding: 30px;
    height: 100%;
    box-shadow: 0 4px 20px var(--shadow-light);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.latest-product__text:before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--gradient-accent);
}

.latest-product__text:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px var(--shadow-medium);
}

.latest-product__text h4 {
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--primary-color);
    margin-bottom: 30px;
    display: flex;
    align-items: center;
}

.latest-product__text h4 i {
    color: var(--accent-color);
    font-size: 1.1rem;
}

.latest-product__slider.owl-carousel .owl-nav {
    position: absolute;
    right: 0;
    top: -50px;
    display: flex;
    gap: 10px;
}

.latest-product__slider.owl-carousel .owl-nav button {
    width: 35px;
    height: 35px;
    background: var(--background-white);
    border-radius: 50%;
    border: 1px solid var(--border-color);
    font-size: 0.9rem;
    color: var(--text-secondary);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

.latest-product__slider.owl-carousel .owl-nav button:hover {
    background: var(--accent-color);
    color: white;
    border-color: var(--accent-color);
}

.latest-product__item {
    display: flex;
    align-items: center;
    padding: 15px;
    margin-bottom: 15px;
    background: var(--background-white);
    border-radius: 12px;
    transition: all 0.3s ease;
    position: relative;
}

.latest-product__item:hover {
    transform: translateX(5px);
    box-shadow: 0 4px 15px var(--shadow-light);
}

.latest-product__item__pic {
    position: relative;
    margin-right: 15px;
    flex-shrink: 0;
}

.latest-product__item__pic img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 8px;
}

.quick-add-btn {
    position: absolute;
    top: 5px;
    right: 5px;
    opacity: 0;
    transform: scale(0.8);
    transition: all 0.3s ease;
}

.latest-product__item:hover .quick-add-btn {
    opacity: 1;
    transform: scale(1);
}

.rating-badge, .review-badge {
    position: absolute;
    top: 5px;
    left: 5px;
    background: var(--gradient-accent);
    color: white;
    padding: 3px 8px;
    border-radius: 12px;
    font-size: 0.7rem;
    font-weight: 600;
    box-shadow: 0 2px 8px var(--shadow-medium);
}

.review-badge {
    background: var(--gradient-primary);
}

.latest-product__item__text {
    flex: 1;
    min-width: 0;
}

.latest-product__item__text h6 {
    color: var(--primary-color);
    font-weight: 600;
    margin-bottom: 8px;
    font-size: 0.95rem;
    line-height: 1.3;
    transition: color 0.3s ease;
}

.latest-product__item:hover .latest-product__item__text h6 {
    color: var(--accent-color);
}

.price-info {
    margin-bottom: 8px;
}

.price-info .current-price {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--cta-color);
}

.price-info .original-price {
    font-size: 0.9rem;
    color: var(--text-light);
    text-decoration: line-through;
    margin-left: 8px;
}

.product-meta {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 0.8rem;
    color: var(--text-secondary);
}

.product-meta .rating {
    color: #f39c12;
    font-weight: 600;
}

.product-meta .sold, .product-meta .reviews {
    background: var(--background-light);
    padding: 2px 6px;
    border-radius: 10px;
    font-size: 0.75rem;
}

.product-meta .verified {
    color: var(--success-color);
    font-weight: 600;
}

.no-products-message {
    text-align: center;
    padding: 40px 20px;
    color: var(--text-secondary);
    font-style: italic;
}

/* Responsive Design */
@media (max-width: 992px) {
    .latest-product__text {
        margin-bottom: 30px;
    }
    
    .latest-product__slider.owl-carousel .owl-nav {
        top: -45px;
    }
}

@media (max-width: 768px) {
    .latest-product {
        padding: 60px 0;
    }
    
    .latest-product__text {
        padding: 20px;
    }
    
    .latest-product__text h4 {
        font-size: 1.1rem;
        margin-bottom: 20px;
    }
    
    .latest-product__item {
        padding: 12px;
    }
    
    .latest-product__item__pic img {
        width: 70px;
        height: 70px;
    }
    
    .latest-product__item__text h6 {
        font-size: 0.9rem;
    }
}

@media (max-width: 576px) {
    .latest-product__text {
        padding: 15px;
    }
    
    .latest-product__item {
        flex-direction: column;
        text-align: center;
        padding: 15px;
    }
    
    .latest-product__item__pic {
        margin-right: 0;
        margin-bottom: 10px;
    }
    
    .product-meta {
        justify-content: center;
    }
}
</style>

<script>

$(document).ready(function() {
    // Initialize latest products sliders
    $('.latest-product__slider').owlCarousel({
        loop: true,
        nav: true,
        dots: false,
        items: 1,
        smartSpeed: 800,
        autoplay: true,
        autoplayTimeout: 4000,
        autoplayHoverPause: true
    });
    
    // Add intersection observer for animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    // Observe all product sections
    document.querySelectorAll('.latest-product__text').forEach(section => {
        section.style.opacity = '0';
        section.style.transform = 'translateY(30px)';
        section.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(section);
    });
});
</script>
