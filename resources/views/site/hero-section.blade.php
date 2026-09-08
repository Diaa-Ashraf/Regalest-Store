<!-- Enhanced Hero Section -->
<section class="hero-section">
    <div class="hero-slider owl-carousel">
        <!-- Hero Slide 1 -->
        <div class="hero-slide" style="background-image: linear-gradient(135deg, rgba(44, 62, 80, 0.8) 0%, rgba(52, 152, 219, 0.8) 100%), url('{{ asset('assets/site/img/hero/banner.jpg') }}');">
            <div class="container">
                <div class="row align-items-center min-vh-100">
                    <div class="col-lg-7">
                        <div class="hero__text animate-fadeInLeft">
                            <span class="hero-label">{{ __('New_Collection') }}</span>
                            <h1 class="text-white">{{ __('Discover_Premium_Quality') }}</h1>
                            <p class="text-white-90">{{ __('Experience_the_perfect_blend_of_style_and_comfort_with_our_curated_selection') }}</p>
                            <div class="hero-buttons">
                                <a href="{{ route('product.shop') }}" class="btn-modern btn-primary btn-lg">
                                    {{ __('Shop_Now') }}
                                    <i class="fa fa-shopping-bag ms-2"></i>
                                </a>
                                <a href="#" class="btn-modern btn-outline-light btn-lg ms-3">
                                    {{ __('Learn_More') }}
                                    <i class="fa fa-play-circle ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="hero__image animate-fadeInRight">
                            <img src="{{ asset('assets/site/img/hero/hero-1.png') }}" alt="Hero Product" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Hero Slide 2 -->
        <div class="hero-slide" style="background-image: linear-gradient(135deg, rgba(231, 76, 60, 0.8) 0%, rgba(41, 128, 185, 0.8) 100%), url('{{ asset('assets/site/img/hero/banner.jpg') }}');">
            <div class="container">
                <div class="row align-items-center min-vh-100">
                    <div class="col-lg-7">
                        <div class="hero__text animate-fadeInLeft">
                            <span class="hero-label">{{ __('Special_Offer') }}</span>
                            <h1 class="text-white">{{ __('Up_to_50_Off') }}</h1>
                            <p class="text-white-90">{{ __('Limited_time_deal_on_selected_items_Dont_miss_out_on_amazing_savings') }}</p>
                            <div class="hero-buttons">
                                <a href="{{ route('product.shop') }}" class="btn-modern btn-cta btn-lg">
                                    {{ __('Get_Deal') }}
                                    <i class="fa fa-tag ms-2"></i>
                                </a>
                                <a href="#" class="btn-modern btn-outline-light btn-lg ms-3">
                                    {{ __('View_Offers') }}
                                    <i class="fa fa-gift ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="hero__image animate-fadeInRight">
                            <img src="{{ asset('assets/site/img/hero/hero-2.png') }}" alt="Special Offer" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<style>
/* Enhanced Hero Section Styles */
.hero-section {
    position: relative;
    overflow: hidden;
}

.hero-slide {
    min-height: 100vh;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    display: flex;
    align-items: center;
    position: relative;
}

.hero-slide:before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.1) 100%);
    z-index: 1;
}

.hero__text {
    position: relative;
    z-index: 2;
    padding: 40px 0;
}

.hero-label {
    display: inline-block;
    background: var(--gradient-accent);
    color: white;
    padding: 8px 20px;
    border-radius: 25px;
    font-size: 0.9rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 20px;
    box-shadow: 0 4px 15px var(--shadow-medium);
}

.hero__text h1 {
    color: white;
    font-size: 3.5rem;
    font-weight: 700;
    line-height: 1.2;
    margin-bottom: 25px;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}

.hero__text p {
    color: rgba(255, 255, 255, 0.9);
    font-size: 1.2rem;
    line-height: 1.6;
    margin-bottom: 35px;
    max-width: 600px;
}

.hero-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
}

.btn-outline-light {
    background: transparent;
    border: 2px solid white;
    color: white;
}

.btn-outline-light:hover {
    background: white;
    color: var(--primary-color);
}

.hero__image {
    position: relative;
    z-index: 2;
    text-align: center;
}

.hero__image img {
    max-width: 100%;
    height: auto;
    filter: drop-shadow(0 10px 30px rgba(0,0,0,0.2));
    transition: transform 0.5s ease;
}

.hero__image:hover img {
    transform: scale(1.05) rotate(2deg);
}

/* Advertisement Slider Section */
.ads-slider-section {
    background: var(--bg-tertiary);
    padding: 0;
    margin-top: -1px;
    position: relative;
    z-index: 5;
}

.ads-slider-wrapper {
    background: var(--bg-primary);
    border-radius: 0;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.ad-slide {
    position: relative;
    height: 200px;
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px;
}

.ad-slide__content {
    text-align: center;
    max-width: 700px;
    position: relative;
    z-index: 2;
}

.ad-slide__icon {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    width: 70px;
    height: 70px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    margin-bottom: 15px;
    border: 3px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

.ad-slide__title {
    color: white;
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 12px;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    line-height: 1.3;
}

.ad-slide__description {
    color: rgba(255, 255, 255, 0.95);
    font-size: 1rem;
    margin-bottom: 20px;
    text-shadow: 1px 1px 3px rgba(0,0,0,0.3);
    line-height: 1.5;
}

.btn-light {
    background: white;
    color: var(--text-primary);
    border: none;
}

.btn-light:hover {
    background: rgba(255, 255, 255, 0.9);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}

/* Ads Slider Navigation */
.ads-slider.owl-carousel .owl-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 100%;
    display: flex;
    justify-content: space-between;
    padding: 0 20px;
    pointer-events: none;
    z-index: 10;
}

.ads-slider.owl-carousel .owl-nav button {
    width: 45px;
    height: 45px;
    background: rgba(255, 255, 255, 0.9);
    border-radius: 50%;
    border: none;
    box-shadow: 0 2px 10px rgba(0,0,0,0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    color: var(--text-primary);
    cursor: pointer;
    transition: all 0.3s ease;
    pointer-events: all;
}

.ads-slider.owl-carousel .owl-nav button:hover {
    background: white;
    transform: scale(1.1);
    box-shadow: 0 4px 15px rgba(0,0,0,0.3);
}

.ads-slider.owl-carousel .owl-dots {
    position: absolute;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 8px;
    z-index: 10;
}

.ads-slider.owl-carousel .owl-dots button {
    width: 10px;
    height: 10px;
    background: rgba(255, 255, 255, 0.5);
    border: none;
    border-radius: 50%;
    cursor: pointer;
    transition: all 0.3s ease;
}

.ads-slider.owl-carousel .owl-dots button.active {
    background: white;
    transform: scale(1.3);
}

/* Hero Slider Navigation */
.hero-slider.owl-carousel .owl-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 100%;
    display: flex;
    justify-content: space-between;
    padding: 0 30px;
    pointer-events: none;
    z-index: 10;
}

.hero-slider.owl-carousel .owl-nav button {
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.9);
    border-radius: 50%;
    border: none;
    box-shadow: 0 4px 15px var(--shadow-medium);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: var(--primary-color);
    cursor: pointer;
    transition: all 0.3s ease;
    pointer-events: all;
}

.hero-slider.owl-carousel .owl-nav button:hover {
    background: var(--accent-color);
    color: white;
    transform: scale(1.1);
}

.hero-slider.owl-carousel .owl-dots {
    position: absolute;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 10px;
    z-index: 10;
}

.hero-slider.owl-carousel .owl-dots button {
    width: 12px;
    height: 12px;
    background: rgba(255, 255, 255, 0.5);
    border: none;
    border-radius: 50%;
    cursor: pointer;
    transition: all 0.3s ease;
}

.hero-slider.owl-carousel .owl-dots button.active {
    background: white;
    transform: scale(1.3);
}

/* Responsive Design */
@media (max-width: 1200px) {
    .hero__text h1 {
        font-size: 3rem;
    }
    
    .hero__text p {
        font-size: 1.1rem;
   }
    
    .ad-slide__title {
        font-size: 1.6rem;
    }
}

@media (max-width: 992px) {
    .hero-slide {
        min-height: 80vh;
    }
    
    .hero__text h1 {
        font-size: 2.5rem;
    }
    
    .hero-buttons {
        justify-content: center;
    }
    
    .hero__image {
        margin-top: 30px;
    }
    
    .ad-slide {
        height: 180px;
    }
}

@media (max-width: 768px) {
    .hero-slide {
        min-height: 70vh;
    }
    
    .hero__text h1 {
        font-size: 2rem;
    }
    
    .hero__text p {
        font-size: 1rem;
    }
    
    .hero-buttons {
        flex-direction: column;
        align-items: center;
    }
    
    .hero-buttons .btn-modern {
        width: 250px;
        margin: 5px 0;
    }
    
    .ad-slide {
        height: 160px;
        padding: 20px;
    }
    
    .ad-slide__icon {
        width: 50px;
        height: 50px;
        font-size: 1.5rem;
        margin-bottom: 10px;
    }
    
    .ad-slide__title {
        font-size: 1.3rem;
        margin-bottom: 8px;
    }
    
    .ad-slide__description {
        font-size: 0.9rem;
        margin-bottom: 15px;
    }
    
    .hero-slider.owl-carousel .owl-nav {
        display: none;
    }
    
    .ads-slider.owl-carousel .owl-nav {
        display: none;
    }
}

@media (max-width: 576px) {
    .hero__text {
        padding: 20px 0;
    }
    
    .hero__text h1 {
        font-size: 1.8rem;
    }
    
    .ad-slide {
        height: 140px;
    }
    
    .ad-slide__title {
        font-size: 1.1rem;
    }
    
    .ad-slide__description {
        font-size: 0.85rem;
        display: none;
    }
    
    .btn-light {
        font-size: 0.85rem;
        padding: 8px 16px;
    }
}
</style>


<script>
$(document).ready(function() {
    // Initialize hero slider
    $('.hero-slider').owlCarousel({
        items: 1,
        loop: true,
        nav: true,
        dots: true,
        autoplay: true,
        autoplayTimeout: 6000,
        autoplayHoverPause: true,
        smartSpeed: 1000,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn'
    });
    
    // Initialize advertisement slider
    $('.ads-slider').owlCarousel({
        items: 1,
        loop: true,
        nav: true,
        dots: true,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        smartSpeed: 800,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        navText: [
            '<i class="fa fa-chevron-left"></i>',
            '<i class="fa fa-chevron-right"></i>'
        ],
        responsive: {
            0: {
                items: 1,
                nav: false
            },
            768: {
                items: 1,
                nav: true
            },
            1000: {
                items: 1,
                nav: true
            }
        }
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
    
    // Observe ad slides
    document.querySelectorAll('.ad-slide').forEach(item => {
        observer.observe(item);
    });
});
</script>