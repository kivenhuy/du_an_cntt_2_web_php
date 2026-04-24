@extends('user_layout.layouts.app')

@section('content')

{{-- ===== Full-width Hero Slider ===== --}}
<div class="hero-slider" id="heroSlider">
    <div class="hero-slider__track">
        @forelse($home_slides ?? [] as $slide)
            @php
                $slideHref = $slide->link ? trim($slide->link) : '';
                $slideHref = ($slideHref === '' || $slideHref === '#') ? route('products.all') : $slideHref;
            @endphp
            <a href="{{ $slideHref }}" class="hero-slider__slide">
                <img src="{{ uploaded_asset($slide->photo) }}"
                     alt="{{ config('app.name') }}"
                     onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
            </a>
        @empty
            @php $fallbackProductsUrl = route('products.all'); @endphp
            <a href="{{ $fallbackProductsUrl }}" class="hero-slider__slide">
                <img src="{{ static_asset('assets/img/ivSNgQP3jxEHTHTOQXNAaGWlHOO3a1PQIw3w9EPJ.jpg') }}"
                     alt="{{ config('app.name') }}">
            </a>
            <a href="{{ $fallbackProductsUrl }}" class="hero-slider__slide">
                <img src="{{ static_asset('assets/img/mrAmhwgz6ra35VyilLmTTvbYPZygvz5DpHz3rkWO.jpg') }}"
                     alt="{{ config('app.name') }}">
            </a>
        @endforelse
    </div>
    {{-- Dots navigation --}}
    <div class="hero-slider__dots" id="heroSliderDots"></div>
</div>

<style>

</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var slider = document.getElementById('heroSlider');
    if (!slider) return;
    var track = slider.querySelector('.hero-slider__track');
    var slides = slider.querySelectorAll('.hero-slider__slide');
    var dotsWrap = document.getElementById('heroSliderDots');
    var total = slides.length;
    if (total === 0) return;

    var current = 0;
    var interval = null;

    // Build dots
    for (var i = 0; i < total; i++) {
        var dot = document.createElement('button');
        dot.className = 'hero-slider__dot' + (i === 0 ? ' hero-slider__dot--active' : '');
        dot.setAttribute('aria-label', 'Slide ' + (i + 1));
        dot.dataset.index = i;
        dot.addEventListener('click', function () {
            goTo(parseInt(this.dataset.index));
            resetAutoplay();
        });
        dotsWrap.appendChild(dot);
    }

    function goTo(index) {
        current = index;
        track.style.transform = 'translateX(-' + (current * 100) + '%)';
        var dots = dotsWrap.querySelectorAll('.hero-slider__dot');
        for (var j = 0; j < dots.length; j++) {
            dots[j].classList.toggle('hero-slider__dot--active', j === current);
        }
    }

    function next() {
        goTo((current + 1) % total);
    }

    function startAutoplay() {
        interval = setInterval(next, 2000);
    }

    function resetAutoplay() {
        clearInterval(interval);
        startAutoplay();
    }

    startAutoplay();

    // Pause on hover
    slider.addEventListener('mouseenter', function () { clearInterval(interval); });
    slider.addEventListener('mouseleave', function () { startAutoplay(); });
});
</script>

{{-- Best Seliing --}}
<div id="section_best_selling" style="margin-bottom: 0px">
    <section class="mb-2 mb-md-3 mt-2 mt-md-3">
        <div class="container wow animate__animated animate__fadeIn" style="max-width: 1200px !important; width:100%;">
            <!-- Top Section -->
            <div class="home-section-title-wrap wow animate__animated animate__fadeInUp" data-wow-delay=".5s">
                <h3 class="home-section-title home-section-title--bestselling">
                    <span class="home-section-badge">🔥 {{ translate('HOT') }}</span>
                    <span>{{ translate('Top Selling') }}</span>
                </h3>
            </div>
            <!-- Product Section -->
            <div class="px-sm-3 wow animate__animated animate__fadeInUp home-product-row-scroll" data-wow-delay=".6s" id="top_selling_filter" >
                @foreach($best_selling_products as $data_selling_product)
                <div class="top_selling">
                    <div class="sub_top_selling storefront-product-card position-relative has-transition border-right border-top border-bottom  hov-animate-outline" >
                            <!-- wishlisht & compare icons -->
                                
                                
                        <div class="top_selling_img">
                            <a href="{{ route('product', $data_selling_product->slug) }}" class="d-block storefront-product-card-img-link" title="{{ $data_selling_product->name }}">
                                <img class="lazyload mx-auto img-fit has-transition img_product_top_selling storefront-product-thumb" width="180" height="180" src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                        data-src="{{ uploaded_asset($data_selling_product->thumbnail_img) }}" alt="{{ $data_selling_product->name}}"
                                        title="{{ $data_selling_product->name }}"
                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                            </a>
                        </div>
                        
                        <div class="content_top_selling ">
                            <a href="{{ route('products.category', $data_selling_product->category->slug) }}" class="storefront-card-category">{{ $data_selling_product->category->name }}</a>
                            <a href="{{ route('product', $data_selling_product->slug) }}" class="d-block h-100">
                                <div class="name_product_top_selling storefront-product-title">
                                    {{$data_selling_product->name}}
                                </div>
                            </a>
                            @if(($data_selling_product->rating ?? 0) > 0)
                            <div class="name_product_top_selling mb-1 storefront-rating-row">
                                        <span class="rating rating-mr-1">
                                            {{ renderStarRating($data_selling_product->rating) }}
                                        </span>
                            </div>
                            @endif
                            
                            <div class="price_product_top_selling storefront-product-price">
                                @auth
                                    {{ number_format($data_selling_product->unit_price, 0, ".", ",") . " VNĐ" }}
                                @else
                                    {{ guest_price_placeholder() }}
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section> 

</div>



{{-- New Products --}}
<div id="section_newest">
    @if (count($new_products) > 0)
        <section class="mb-2 mb-md-3 mt-2 mt-md-3">
            <div class="container wow animate__animated animate__fadeIn" style="max-width:1200px;width: 100%">
                <!-- Top Section -->
                <div class="home-section-title-wrap wow animate__animated animate__fadeInUp" data-wow-delay=".1s">
                    <h3 class="home-section-title home-section-title--newest">
                        <span class="home-section-badge">✨ {{ translate('NEW') }}</span>
                        <span>{{ translate('New Products') }}</span>
                    </h3>
                </div>
                <!-- Products Section -->
                <div class="px-sm-3 new_product_section home-product-row-scroll wow animate__animated animate__fadeInUp" data-wow-delay=".2s" id="new_product_filter">
                    @foreach($new_products as $new_product)
                        <div class="top_selling_news_product">
                            <div class="sub_top_selling_news_product storefront-product-card position-relative has-transition border-right border-top border-bottom border-left hov-animate-outline" >
                                    <!-- wishlisht & compare icons -->
                                <div class="show_hide_icon_hover">
                                    
                                </div>
                                
                               
                               
                                <div class="top_selling_img">
                                    <a href="{{ route('product', $new_product->slug) }}" class="d-block storefront-product-card-img-link" title="{{ $new_product->name }}">
                                        <img class="lazyload mx-auto img-fit has-transition img_product_top_selling storefront-product-thumb" width="180" height="180" src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                            data-src="{{ uploaded_asset($new_product->thumbnail_img) }}" alt="{{ $new_product->name }}"
                                            title="{{ $new_product->name }}"
                                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                    </a>
                                </div>
                                
                                <div class="content_top_selling ">
                                    <a href="{{ route('products.category', $new_product->category->slug) }}" class="storefront-card-category">{{ $new_product->category->name }}</a>
                                    <a href="{{ route('product', $new_product->slug) }}" class="d-block h-100">
                                        <div class="name_product_top_selling storefront-product-title"> 
                                            {{$new_product->name}}
                                        </div>
                                    </a>
                                    @if(($new_product->rating ?? 0) > 0)
                                    <div class="name_product_top_selling mb-1 storefront-rating-row">
                                        <span class="rating rating-mr-1">
                                            {{ renderStarRating($new_product->rating) }}
                                        </span>
                                    </div>
                                    @endif
                                    
                                    
                                    <div class="price_product_top_selling storefront-product-price">
                                        @auth
                                            {{ number_format($new_product->unit_price, 0, ".", ",") . " VNĐ" }}
                                        @else
                                            {{ guest_price_placeholder() }}
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    
                </div>
            </div>
        </section>   
    @endif
</div>





@endsection

@section('script')
    <script type="text/javascript">
       
    </script>
@endsection