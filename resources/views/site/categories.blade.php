<!-- Trendy Shop By Category Section -->
<section class="trendy-category-section">
    <div class="container">
        <!-- Section Title -->
        <div class="section-header text-center mb-5">
            <h2 class="trendy-title">{{ __('Shop By Category') }}</h2>
            <p class="trendy-subtitle">{{ __('Explore collections curated for your lifestyle') }}</p>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="owl-carousel owl-theme" id="trendy-cat-slider">
                    
                    @forelse($categories as $category)
                        <div class="item">
                            <a href="{{ route('category.product', $category->id) }}" class="trendy-card">
                                <div class="card-image-wrapper">
                                    @if($category->image_url)
                                        <img src="{{ $category->image_url }}" alt="{{ $category->name }}" class="img-fluid">
                                    @else
                                        <!-- Placeholder if no image uploaded -->
                                        <div class="fallback-img-placeholder">
                                            <i class="fa fa-shopping-bag"></i>
                                        </div>
                                    @endif
                                    <div class="overlay-gradient"></div>
                                </div>
                                <div class="card-content">
                                    <h3>{{ $category->name }}</h3>
                                    <p>{{ $category->products_count }} {{ __('Products') }}</p>
                                    <span class="shop-now-btn">{{ __('Shop Now') }} <i class="fa fa-arrow-right"></i></span>
                                </div>
                                <!-- Decorative element -->
                                <div class="card-blob"></div>
                            </a>
                        </div>
                    @empty
                        <div class="col-12 text-center">
                            <p class="text-muted">{{ __('No categories found.') }}</p>
                        </div>
                    @endforelse

                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Section Styling */
.trendy-category-section {
    padding: 60px 0;
    background: #f9f9f9; /* Light clean background */
}

/* Titles */
.section-header .trendy-title {
    font-size: 36px;
    font-weight: 800;
    color: #333;
    margin-bottom: 10px;
    position: relative;
    display: inline-block;
}

.section-header .trendy-title::after {
    content: '';
    display: block;
    width: 50%;
    height: 3px;
    background: linear-gradient(90deg, #ff6b6b, #556270);
    margin: 10px auto 0;
    border-radius: 2px;
}

.trendy-subtitle {
    color: #777;
    font-size: 16px;
}

/* Card Styling */
.trendy-card {
    display: block;
    position: relative;
    background: #fff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 25px rgba(0,0,0,0.05);
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    margin: 15px 5px; /* Spacing for shadow */
    height: 320px;
    text-decoration: none !important;
}

.trendy-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 35px rgba(0,0,0,0.1);
}

.card-image-wrapper {
    height: 200px;
    width: 100%;
    position: relative;
    overflow: hidden;
    background: #f0f0f0;
    display: flex;
    align-items: center;
    justify-content: center;
}

.card-image-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.trendy-card:hover .card-image-wrapper img {
    transform: scale(1.1);
}

.fallback-img-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #e0e0e0 0%, #f5f5f5 100%);
    font-size: 50px;
    color: #ccc;
}

/* Gradient Overlay */
.overlay-gradient {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 50%;
    background: linear-gradient(to top, rgba(0,0,0,0.4) 0%, transparent 100%);
    opacity: 0.6;
    transition: opacity 0.3s;
}

.trendy-card:hover .overlay-gradient {
    opacity: 0.8;
}

/* Content */
.card-content {
    padding: 20px;
    text-align: center;
    position: relative;
    z-index: 2;
    background: #fff;
    height: 120px; /* Filling the rest of the card */
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.card-content h3 {
    font-size: 18px;
    font-weight: 700;
    color: #333;
    margin-bottom: 5px;
}

.card-content p {
    font-size: 13px;
    color: #888;
    margin-bottom: 10px;
}

.shop-now-btn {
    font-size: 13px;
    font-weight: 600;
    color: #ff6b6b; /* Trendy coral color */
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: color 0.3s;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.trendy-card:hover .shop-now-btn {
    color: #d43f3f;
}

.shop-now-btn i {
    transition: transform 0.3s;
}

.trendy-card:hover .shop-now-btn i {
    transform: translateX(5px);
}

/* Decorative Blob */
.card-blob {
    position: absolute;
    top: -50px;
    right: -50px;
    width: 100px;
    height: 100px;
    background: radial-gradient(circle, rgba(255,107,107,0.1) 0%, rgba(255,107,107,0) 70%);
    border-radius: 50%;
    z-index: 1;
    pointer-events: none;
    transition: transform 0.5s;
}

.trendy-card:hover .card-blob {
    transform: scale(1.5);
}

/* Owl Carousel Customization */
#trendy-cat-slider .owl-stage-outer {
    padding-bottom: 30px; /* Space for shadow clipping */
    margin: -15px; /* Offset margin for shadows */
    padding: 15px;
}

#trendy-cat-slider .owl-dots .owl-dot span {
    width: 12px;
    height: 6px;
    background: #e0e0e0;
    border-radius: 3px;
    transition: all 0.3s ease;
}

#trendy-cat-slider .owl-dots .owl-dot.active span {
    width: 25px;
    background: #ff6b6b;
}

</style>


</style>
<!-- Script moved to index.blade.php to ensure jQuery is loaded -->
