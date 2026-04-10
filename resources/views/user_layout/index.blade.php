@extends('user_layout.layouts.app')

@section('content')

<div class="home-banner-area mb-3" >
    <div class="container wow animate__animated animate__fadeIn"  style=" max-width: 1200px !important;margin-top: 15px;height: auto;">
        <div class="d-flex flex-wrap position-relative" style="justify-content: space-between;">
            <div class="position-static d-none d-xl-block wow animate__animated animate__fadeInUp" data-wow-delay=".1s">
                @include('user_layout.partials.category_menu')
            </div>

            <!-- Sliders -->
            <div class="home-slider wow animate__animated animate__fadeInUp" data-wow-delay=".2s">
                    <div class="aiz-carousel dots-inside-bottom mobile-img-auto-height" data-autoplay="true">
                            @forelse($home_slides ?? [] as $slide)
                            @php $slideHref = $slide->link ? trim($slide->link) : ''; $slideHref = ($slideHref === '' || $slideHref === '#') ? route('products.all') : $slideHref; @endphp
                            <div class="carousel-box position-relative storefront-home-slide">
                                <a href="{{ $slideHref }}" class="d-block position-relative storefront-banner-img-link">
                                    <img class="d-block w-100 h-100 storefront-banner-img img-fit overflow-hidden h-sm-auto h-md-320px h-lg-460px b-radius-10"
                                        alt="{{ config('app.name') }}"
                                        src="{{ uploaded_asset($slide->photo) }}"
                                        style="object-fit: cover;"
                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                    <div class="storefront-banner-gradient"></div>
                                    
                                </a>
                            </div>
                            @empty
                            @php $fallbackProductsUrl = route('products.all'); @endphp
                            <div class="carousel-box position-relative storefront-home-slide">
                                <a href="{{ $fallbackProductsUrl }}" class="d-block position-relative storefront-banner-img-link">
                                    <img class="d-block w-100 h-100 storefront-banner-img img-fit overflow-hidden h-sm-auto h-md-320px h-lg-460px b-radius-10"
                                        alt="{{ config('app.name') }}"
                                        src="{{ static_asset('assets/img/ivSNgQP3jxEHTHTOQXNAaGWlHOO3a1PQIw3w9EPJ.jpg')}}"
                                        style="object-fit: cover;">
                                    <div class="storefront-banner-gradient"></div>
                                    <div class="storefront-banner-cta">
                                        <span class="btn btn-success btn-sm font-weight-bold rounded-pill px-3">Mua sắm ngay</span>
                                    </div>
                                </a>
                            </div>
                            <div class="carousel-box position-relative storefront-home-slide">
                                <a href="{{ $fallbackProductsUrl }}" class="d-block position-relative storefront-banner-img-link">
                                    <img class="d-block w-100 h-100 storefront-banner-img img-fit overflow-hidden h-sm-auto h-md-320px h-lg-460px b-radius-10"
                                        alt="{{ config('app.name') }}"
                                        src="{{ static_asset('assets/img/mrAmhwgz6ra35VyilLmTTvbYPZygvz5DpHz3rkWO.jpg')}}"
                                        style="object-fit: cover;">
                                    <div class="storefront-banner-gradient"></div>
                                    <div class="storefront-banner-cta">
                                        <span class="btn btn-success btn-sm font-weight-bold rounded-pill px-3">Mua sắm ngay</span>
                                    </div>
                                </a>
                            </div>
                            @endforelse
                    </div>
            </div>
        </div>
    </div>
</div>

{{-- Best Seliing --}}
<div id="section_best_selling" style="margin-bottom: 0px">
    <section class="mb-2 mb-md-3 mt-2 mt-md-3">
        <div class="container wow animate__animated animate__fadeIn" style="max-width: 1200px !important; width:100%;">
            <!-- Top Section -->
            <div class="d-flex mb-2 mb-md-3 align-items-baseline parent_text_filter wow animate__animated animate__fadeInUp" data-wow-delay=".5s">
                <!-- Title -->
                <div class="title_for_section">
                    <h3 class="fs-16 fs-md-20 fw-700 mb-2 mb-sm-0">
                        <span class="top_selling_homepage">{{ translate('Top Selling') }}</span>
                    </h3>
                </div>
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
                            <a href="{{ route('products.category', $data_selling_product->category->slug) }}" class="mb-1">{{ $data_selling_product->category->name }}</a>
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
                                {{number_format($data_selling_product->unit_price, 0, ".", ",")." VNĐ"  }}
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
                <div class="d-flex mb-2 mb-md-3 align-items-baseline parent_text_filter wow animate__animated animate__fadeInUp" data-wow-delay=".1s">
                    <!-- Title -->
                    <div class="title_for_section">
                        <h3 class="fs-16 fs-md-20 fw-700 mb-2 mb-sm-0">
                            <span class="top_selling_homepage">{{ translate('New Products') }}</span>
                        </h3>
                    </div>

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
                                    <a href="{{ route('products.category', $new_product->category->slug) }}" class="mb-1">{{ $new_product->category->name }}</a>
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
                                        {{number_format($new_product->unit_price, 0, ".", ",")." VNĐ"  }}
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