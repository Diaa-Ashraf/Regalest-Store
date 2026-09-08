@if(isset($banners['main_slider']) && count($banners['main_slider']) > 0)
<section class="modern-ads-section mb-5">
    <div class="container-fluid p-0">
        <div class="modern-slider-wrapper">
            <div class="owl-carousel modern-ads-carousel" id="modern-ads-carousel">
                @foreach($banners['main_slider'] as $banner)
                    <div class="modern-ad-item">
                        <div class="modern-ad-content" style="background-image: url('{{ $banner->image_url }}');">
                            <div class="container">
                                <div class="row align-items-center" style="height: 400px;">
                                    <div class="col-lg-6 col-md-8">
                                        <div class="ad-text-content">
                                            <h2 class="ad-title animate-text">{{ $banner->title }}</h2>
                                            <p class="ad-description animate-text delay-1">{{ $banner->description }}</p>
                                            @if($banner->url)
                                                <a href="{{ $banner->url }}" class="btn-modern-ad animate-text delay-2">
                                                    {{ __('تسوق الآن') }} <i class="fa fa-arrow-left mr-2"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="ad-overlay"></div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Custom Nav -->
            <div class="modern-slider-nav">
                <button class="modern-nav-btn prev-btn"><i class="fa fa-angle-left"></i></button>
                <button class="modern-nav-btn next-btn"><i class="fa fa-angle-right"></i></button>
            </div>
        </div>
    </div>
</section>

<style>
/* Modern Ads Section */
.modern-slider-wrapper {
    position: relative;
    overflow: hidden;
}

.modern-ad-item {
    position: relative;
}

.modern-ad-content {
    height: 400px;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    position: relative;
    display: flex;
    align-items: center;
}

.ad-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(90deg, rgba(0,0,0,0.6) 0%, rgba(0,0,0,0.1) 100%);
    z-index: 1;
}

.ad-text-content {
    position: relative;
    z-index: 2;
    color: #fff;
    padding: 30px;
}

.ad-title {
    font-size: 3rem;
    font-weight: 800;
    margin-bottom: 15px;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    font-family: 'Cairo', sans-serif;
}

.ad-description {
    font-size: 1.2rem;
    margin-bottom: 25px;
    opacity: 0.9;
    max-width: 500px;
}

.btn-modern-ad {
    display: inline-block;
    padding: 12px 30px;
    background: #fff;
    color: #333;
    font-weight: 700;
    border-radius: 50px;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

.btn-modern-ad:hover {
    background: #febd69; /* Amazon Orange accent */
    color: #333;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.3);
}

/* Navigation Buttons */
.modern-slider-nav {
    position: absolute;
    bottom: 30px;
    right: 50px;
    z-index: 10;
    display: flex;
    gap: 10px;
}

.modern-nav-btn {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.3);
    color: #fff;
    font-size: 20px;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(5px);
}

.modern-nav-btn:hover {
    background: #fff;
    color: #333;
}

/* Animations */
.animate-text {
    opacity: 0;
    transform: translateY(20px);
    animation: fadeInUp 0.8s forwards;
}

.delay-1 { animation-delay: 0.2s; }
.delay-2 { animation-delay: 0.4s; }

@keyframes fadeInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive */
@media (max-width: 768px) {
    .modern-ad-content {
        height: 300px;
    }
    
    .ad-title {
        font-size: 2rem;
    }
    
    .modern-slider-nav {
        right: 20px;
        bottom: 20px;
    }
}
</style>

<script>
$(document).ready(function() {
    var modernAds = $('#modern-ads-carousel').owlCarousel({
        rtl: true,
        items: 1,
        loop: true,
        margin: 0,
        nav: false,
        dots: false, // Custom nav used
        autoplay: true,
        autoplayTimeout: 6000,
        autoplayHoverPause: true,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        smartSpeed: 800
    });
    
    $('.next-btn').click(function() {
        modernAds.trigger('next.owl.carousel');
    });
    
    $('.prev-btn').click(function() {
        modernAds.trigger('prev.owl.carousel');
    });
});
</script>
@endif
