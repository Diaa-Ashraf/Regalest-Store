<!-- Enhanced Featured Products Section -->
<section class="featured spad">
    <div class="container">
        <!-- Section Title -->
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title animate-fadeInUp">
                    <h2 class="text-gradient">{{ __('Featured_Product') }}</h2>
                    <p class="text-secondary">{{ __('Discover_our_handpicked_selection_of_premium_products') }}</p>
                </div>
                <div class="featured__controls">
                    <!-- Filter buttons can be added here if needed -->
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="row featured__filter">
            @forelse ($products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6 mix oranges fresh-meat mb-4">
                    <div class="product-card animate-fadeInUp">
                        <div class="product-card__image">
                            @if($product->image_url)
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="img-fluid">
                            @else
                                <img src="{{ asset('assets/site/img/product/product-1.jpg') }}" alt="{{ $product->name }}" class="img-fluid">
                            @endif
                            
                            <!-- Product Overlay Actions -->
                            <div class="product-card__overlay">
                                <div class="product-card__actions">
                                    <a href="{{ route('product.details', $product->id) }}" class="product-card__action-btn" title="{{ __('View_Details') }}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="{{ route('AddToCart', $product->id) }}" class="product-card__action-btn" title="{{ __('Add_to_Cart') }}">
                                        <i class="fa fa-shopping-cart"></i>
                                    </a>
                                    <button class="product-card__action-btn" onclick="addToWishlist({{ $product->id }})" title="{{ __('Add_to_Wishlist') }}">
                                        <i class="fa fa-heart"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Discount Badge -->
                            @if(isset($product->discount) && $product->discount > 0)
                                <div class="discount-badge">
                                    -{{ $product->discount }}%
                                </div>
                            @endif
                        </div>
                        
                        <div class="product-card__content">
                            <div class="product-card__rating">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= 4)
                                        <i class="fa fa-star"></i>
                                    @else
                                        <i class="fa fa-star-o"></i>
                                    @endif
                                @endfor
                                <span>({{ rand(10, 100) }})</span>
                            </div>
                            
                            <h5 class="product-card__title">
                                <a href="{{ route('product.details', $product->id) }}">
                                    {{ Str::limit($product->name, 50) }}
                                </a>
                            </h5>
                            
                            <div class="product-card__price">
                                @if(isset($product->discount_price) && $product->discount_price > 0)
                                    <span class="current-price">${{ number_format($product->discount_price, 2) }}</span>
                                    <span class="original-price">${{ number_format($product->price, 2) }}</span>
                                @else
                                    <span class="current-price">${{ number_format($product->price, 2) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="no-products-found">
                        <i class="fa fa-search fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">{{ __('No_featured_products_found') }}</h4>
                        <p class="text-muted">{{ __('Check_back_later_for_new_arrivals') }}</p>
                    </div>
                </div>
            @endforelse
        </div>
        
        <!-- View More Button -->
        @if($products->count() > 0)
            <div class="row">
                <div class="col-lg-12 text-center mt-4">
                    <a href="{{ route('product.shop') }}" class="btn-modern btn-primary btn-lg">
                        {{ __('View_All_Products') }}
                        <i class="fa fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        @endif
    </div>
</section>

<style>
/* Professional Featured Products Styles */
.product-card {
    background: #f8f9fa; /* Slightly darker background key to visibility */
    border-radius: 16px;
    border: 1px solid #e1e4e8; /* Stronger border */
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    box-shadow: 0 4px 6px rgba(0,0,0,0.04); /* Slightly stronger shadow */
    position: relative;
    height: 100%;
}

.product-card:hover {
    background: #ffffff;
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    border-color: #ff6b6b; /* Brand color border on hover */
}

/* Image Area */
.product-card__image {
    position: relative;
    overflow: hidden;
    padding-top: 100%; /* 1:1 Aspect Ratio */
    background: #f8f9fa;
}

.product-card__image img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s ease;
}

.product-card:hover .product-card__image img {
    transform: scale(1.08);
}

/* Overlay & Actions */
.product-card__overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.03);
    opacity: 0;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.product-card:hover .product-card__overlay {
    opacity: 1;
}

.product-card__actions {
    display: flex;
    gap: 10px;
    transform: translateY(20px);
    transition: all 0.4s cubic-bezier(0.19, 1, 0.22, 1);
    opacity: 0;
}

.product-card:hover .product-card__actions {
    transform: translateY(0);
    opacity: 1;
}

.product-card__action-btn {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: #ffffff;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #333;
    font-size: 16px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    cursor: pointer;
    text-decoration: none !important;
}

.product-card__action-btn:hover {
    background: #ff6b6b; /* Brand Hover Color */
    color: #fff;
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 8px 20px rgba(255,107,107,0.3);
}

/* Badges */
.discount-badge {
    position: absolute;
    top: 12px;
    left: 12px;
    background: #ff4757;
    color: white;
    padding: 4px 10px;
    border-radius: 4px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    z-index: 2;
    box-shadow: 0 4px 10px rgba(255,71,87,0.3);
}

/* Content Area */
.product-card__content {
    padding: 20px;
    text-align: left;
    background: transparent; /* Changed from white to transparent to inherit card bg */
    position: relative;
    z-index: 2;
}

/* Rating */
.product-card__rating {
    margin-bottom: 8px;
    font-size: 12px;
    color: #f1c40f;
}

.product-card__rating span {
    color: #a4b0be;
    margin-left: 5px;
    font-size: 11px;
}

/* Title */
.product-card__title {
    margin-bottom: 8px;
    min-height: 40px; /* Force minimum height for alignment */
}

.product-card__title a {
    color: #2d3436;
    font-size: 15px;
    font-weight: 600;
    line-height: 1.4;
    transition: color 0.2s;
    text-decoration: none;
}

.product-card__title a:hover {
    color: #ff6b6b;
}

/* Price */
.product-card__price {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-top: 10px;
}

.current-price {
    font-size: 18px;
    font-weight: 800;
    color: #2d3436;
}

.original-price {
    font-size: 13px;
    color: #b2bec3;
    text-decoration: line-through;
}

/* Empty State */
.no-products-found {
    padding: 60px 20px;
    background: #f8f9fa;
    border-radius: 16px;
    border: 2px dashed #dfe6e9;
}

/* Button override */
.btn-modern {
    padding: 12px 35px;
    border-radius: 50px;
    font-weight: 600;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .featured__filter .col-lg-3 {
        flex: 0 0 50%;
        max-width: 50%;
    }
    
    .product-card__content {
        padding: 15px;
    }
}

@media (max-width: 576px) {
    .featured__filter .col-lg-3 {
        flex: 0 0 100%;
        max-width: 100%;
    }
}
</style>

<script>
// Add to wishlist functionality
function addToWishlist(productId) {
    // Check if user is logged in
    @if(auth()->check())
        // Show loading state
        const $button = event.currentTarget;
        const originalIcon = $button.innerHTML;
        $button.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
        $button.disabled = true;
        
        // Send AJAX request to add product to wishlist
        $.ajax({
            url: '{{ route('wishlist.add', ':id') }}'.replace(':id', productId),
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    // Update wishlist count
                    updateWishlistCount(response.wishlist_count);
                    
                    // Change button to indicate item is in wishlist
                    $button.innerHTML = '<i class="fa fa-heart"></i>';
                    $button.classList.add('in-wishlist');
                    $button.title = '{{ __('Remove_from_Wishlist') }}';
                    $button.setAttribute('onclick', `removeFromWishlist(${productId})`);
                    
                    // Show success message
                    toastr.success('{{ __('Product_added_to_wishlist') }}');
                } else {
                    // Show error message
                    toastr.error(response.message || '{{ __('Error_adding_product_to_wishlist') }}');
                    // Restore original button state
                    $button.innerHTML = originalIcon;
                    $button.disabled = false;
                }
            },
            error: function(xhr) {
                let errorMessage = '{{ __("Error_adding_product_to_wishlist") }}';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.status === 419) {
                    errorMessage = '{{ __("CSRF_token_mismatch") }}';
                }
                
                toastr.error(errorMessage);
                // Restore original button state
                $button.innerHTML = originalIcon;
                $button.disabled = false;
            }
        });
    @else
        // User not logged in
        toastr.error('{{ __('Please_login_to_add_to_wishlist') }}');
        // Redirect to login page after a short delay
        setTimeout(() => {
            window.location.href = '{{ route('client.login') }}';
        }, 1500);
    @endif
}

// Remove from wishlist functionality
function removeFromWishlist(productId) {
    if (!confirm('{{ __('Are_you_sure_you_want_to_remove_this_item_from_wishlist') }}')) return;
    
    // Show loading state
    const $button = event.currentTarget;
    const originalIcon = $button.innerHTML;
    $button.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
    $button.disabled = true;
    
    $.ajax({
        url: '{{ route('wishlist.remove', ':id') }}'.replace(':id', productId),
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                // Update wishlist count
                updateWishlistCount(response.wishlist_count);
                
                // Change button to indicate item is not in wishlist
                $button.innerHTML = '<i class="fa fa-heart-o"></i>';
                $button.classList.remove('in-wishlist');
                $button.title = '{{ __('Add_to_Wishlist') }}';
                $button.setAttribute('onclick', `addToWishlist(${productId})`);
                
                // Show success message
                toastr.success('{{ __('Product_removed_from_wishlist') }}');
            } else {
                // Show error message
                toastr.error(response.message || '{{ __('Error_removing_item_from_wishlist') }}');
                // Restore original button state
                $button.innerHTML = originalIcon;
                $button.disabled = false;
            }
        },
        error: function(xhr) {
            let errorMessage = '{{ __("Error_removing_item_from_wishlist") }}';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            } else if (xhr.status === 419) {
                errorMessage = '{{ __("CSRF_token_mismatch") }}';
            }
            
            toastr.error(errorMessage);
            // Restore original button state
            $button.innerHTML = originalIcon;
            $button.disabled = false;
        }
    });
}

// Update wishlist count
function updateWishlistCount(count) {
    $('.wishlist-count').text(count || 0);
}

// Initialize animations when page loads
$(document).ready(function() {
    // Add intersection observer for scroll animations
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
    
    // Observe all product cards
    document.querySelectorAll('.product-card').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });
});
</script>
