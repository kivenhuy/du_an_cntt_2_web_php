@extends('user_layout.layouts.app')

@section('content')


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
            <div class="px-sm-3 wow animate__animated animate__fadeInUp" data-wow-delay=".6s" id="top_selling_filter" style="display: flex;justify-content: flex-start;padding-left: unset !important;padding-right: unset !important; flex-wrap: wrap;">
                @foreach($best_selling_products as $data_selling_product)
                <div class="top_selling">
                    <div class="sub_top_selling position-relative has-transition border-right border-top border-bottom  hov-animate-outline" >
                            <!-- wishlisht & compare icons -->
                                <div class="show_hide_icon_hover">
                                    <div class="icon_hover_products aiz-p-hov-icon">
                                        <a href="javascript:void(0)" class="hov-svg-white" @if (Auth::check()) onclick="addToWishList({{ $data_selling_product->id }})"  @else onclick="showLoginModal()" @endif
                                            data-toggle="tooltip" data-title="{{ translate('Add to wishlist') }}" data-placement="left">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="14.4" viewBox="0 0 16 14.4">
                                                <g id="_51a3dbe0e593ba390ac13cba118295e4" data-name="51a3dbe0e593ba390ac13cba118295e4"
                                                    transform="translate(-3.05 -4.178)">
                                                    <path id="Path_32649" data-name="Path 32649"
                                                        d="M11.3,5.507l-.247.246L10.8,5.506A4.538,4.538,0,1,0,4.38,11.919l.247.247,6.422,6.412,6.422-6.412.247-.247A4.538,4.538,0,1,0,11.3,5.507Z"
                                                        transform="translate(0 0)" fill="#919199" />
                                                    <path id="Path_32650" data-name="Path 32650"
                                                        d="M11.3,5.507l-.247.246L10.8,5.506A4.538,4.538,0,1,0,4.38,11.919l.247.247,6.422,6.412,6.422-6.412.247-.247A4.538,4.538,0,1,0,11.3,5.507Z"
                                                        transform="translate(0 0)" fill="#919199" />
                                                </g>
                                            </svg>
                                        </a>
                                        <a href="javascript:void(0)" class="hov-svg-white" @if (Auth::check()) onclick="addToCompare({{ $data_selling_product->id }})" @else onclick="showLoginModal()" @endif "
                                            data-toggle="tooltip" data-title="{{ translate('Add to compare') }}" data-placement="left">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                                <path id="_9f8e765afedd47ec9e49cea83c37dfea" data-name="9f8e765afedd47ec9e49cea83c37dfea"
                                                    d="M18.037,5.547v.8a.8.8,0,0,1-.8.8H7.221a.4.4,0,0,0-.4.4V9.216a.642.642,0,0,1-1.1.454L2.456,6.4a.643.643,0,0,1,0-.909L5.723,2.227a.642.642,0,0,1,1.1.454V4.342a.4.4,0,0,0,.4.4H17.234a.8.8,0,0,1,.8.8Zm-3.685,4.86a.642.642,0,0,0-1.1.454v1.661a.4.4,0,0,1-.4.4H2.84a.8.8,0,0,0-.8.8v.8a.8.8,0,0,0,.8.8H12.854a.4.4,0,0,1,.4.4V17.4a.642.642,0,0,0,1.1.454l3.267-3.268a.643.643,0,0,0,0-.909Z"
                                                    transform="translate(-2.037 -2.038)" fill="#919199" />
                                            </svg>
                                        </a>
                                        <a href="javascript:void(0)" class="hov-svg-white" @if (Auth::check()) onclick="showAddToCartModal({{ $data_selling_product->id }})" @else onclick="showLoginModal()" @endif "
                                            data-toggle="tooltip" data-title="{{ translate('Quick View') }}" data-placement="left">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/> <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                                
                                <!-- add to cart -->
                                {{-- <a class="cart-btn absolute-bottom-left w-100 h-35px aiz-p-hov-icon text-white fs-13 fw-700 d-flex flex-column justify-content-center align-items-center @if (in_array($product->id, $cart_added)) active @endif"
                                    href="javascript:void(0)"
                                    @if (Auth::check()) onclick="showAddToCartModal({{ $product->id }})" @else onclick="showLoginModal()" @endif>
                                    <span class="cart-btn-text">
                                        {{ translate('Add to Cart') }}
                                    </span>
                                    <br>
                                    <span><i class="las la-2x la-shopping-cart"></i></span>
                                </a> --}}
                        {{-- @if (home_price($data_selling_product) != home_discounted_price($data_selling_product))
                        <div class="tag_discount">
                            <span>-{{ discount_in_percentage($data_selling_product) }}%</span>
                        </div>
                        @endif

                        @php
                        $product_url = route('product', $data_selling_product->slug);
                            if ($data_selling_product->auction_product == 1) {
                                $product_url = route('auction-product', $data_selling_product->slug);
                            }
                        @endphp --}}
                        <div class="top_selling_img">
                            {{-- <a href="{{ $product_url }}" class="d-block h-100"> --}}
                                <img class="lazyload mx-auto img-fit has-transition img_product_top_selling" width="180px" height="180px" src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                        data-src="{{ uploaded_asset($data_selling_product->thumbnail_img) }}" alt="{{ $data_selling_product->name}}"
                                        title="{{ $data_selling_product->name }}"
                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                        </div>
                        
                        <div class="content_top_selling ">
                            {{-- <a href="{{ $data_selling_product->category->category_url }}" class="mb-1">{{ $data_selling_product->category->getTranslation('name') }}</a> --}}
                            {{-- <a href="{{ $product_url }}"> --}}
                                <div class="name_product_top_selling">
                                    {{$data_selling_product->name}}
                                </div>
                            {{-- </a> --}}
                            <div class="name_product_top_selling" style="margin-bottom: 6px">
                                {{-- <span class="fa fa-star checked" style="color: orange"></span>
                                <span class="fa fa-star checked" style="color: orange"></span>
                                <span class="fa fa-star checked" style="color: orange"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span> --}}
                                
                                        <span class="rating rating-mr-1">
                                            {{ renderStarRating($data_selling_product->rating) }}
                                        </span>
                            </div>
                            <div class="name_store_top_selling" style="margin-bottom: 12px;">
                                {{translate('Sold By')}}  <a href="{{ $data_selling_product->user?->shop?->shop_url }}" style="font-weight:700">
                                   {{$data_selling_product->user?->name}}
                                </a>
                            </div>
                            <div class="price_product_top_selling">
                                {{"đ " . number_format($data_selling_product->unit_price, 0, ".", ",")  }}
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section> 

</div>

{{-- Fresh Today --}}
<div id="section_best_selling" style="margin-bottom: 90px">
    <section class="mb-2 mb-md-3 mt-2 mt-md-3">
        <div class="container" style="max-width: 1200px !important; width:100%">
            <!-- Top Section -->
            <div class="d-flex mb-2 mb-md-3 align-items-baseline parent_text_filter wow animate__animated animate__fadeInUp" data-wow-delay=".1s">
                <!-- Title -->
                <div class="title_for_section">
                    <h3 class="fs-16 fs-md-20 fw-700 mb-2 mb-sm-0">
                        <span class="top_selling_homepage">{{ translate('Best Price Today') }}</span>
                    </h3>
                </div>
            </div>
            <!-- Product Section -->
            <div class="px-sm-3 wow animate__animated animate__fadeInUp" data-wow-delay=".1s" id="best_price_filter" style="display: flex;flex-wrap: wrap;padding-left: unset !important;padding-right: unset !important">
                <div class="parent_img_best_price">
                    <div class="img_best_price">
                        <div class="text_best_price">
                            <span>
                                Tươi sống mỗi ngày
                            </span>
                        </div>
                    </div>
                    {{-- <img src="{{static_asset('uploads/all/fyvEWPLCmizQMVTja8OvtkhaCINaWF9RViHiewa8.png')}}" alt="" width="100%"> --}}
                    {{-- <img src="{{static_asset('uploads/all/owiE8yVzKzZzBn4H9GCG97UPj71nfvPTYwRQxzgQ.png')}}" alt=""> --}}
                    
                </div>
                @foreach($fresh_today_products as $data_selling_product)
                <div class="top_selling">
                    <div class="sub_top_selling position-relative has-transition border-right border-top border-bottom  hov-animate-outline" >
                            <!-- wishlisht & compare icons -->
                                <div class="show_hide_icon_hover">
                                    <div class="icon_hover_products aiz-p-hov-icon">
                                        <a href="javascript:void(0)" class="hov-svg-white" @if (Auth::check()) onclick="addToWishList({{ $data_selling_product->id }})"  @else onclick="showLoginModal()" @endif
                                            data-toggle="tooltip" data-title="{{ translate('Add to wishlist') }}" data-placement="left">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="14.4" viewBox="0 0 16 14.4">
                                                <g id="_51a3dbe0e593ba390ac13cba118295e4" data-name="51a3dbe0e593ba390ac13cba118295e4"
                                                    transform="translate(-3.05 -4.178)">
                                                    <path id="Path_32649" data-name="Path 32649"
                                                        d="M11.3,5.507l-.247.246L10.8,5.506A4.538,4.538,0,1,0,4.38,11.919l.247.247,6.422,6.412,6.422-6.412.247-.247A4.538,4.538,0,1,0,11.3,5.507Z"
                                                        transform="translate(0 0)" fill="#919199" />
                                                    <path id="Path_32650" data-name="Path 32650"
                                                        d="M11.3,5.507l-.247.246L10.8,5.506A4.538,4.538,0,1,0,4.38,11.919l.247.247,6.422,6.412,6.422-6.412.247-.247A4.538,4.538,0,1,0,11.3,5.507Z"
                                                        transform="translate(0 0)" fill="#919199" />
                                                </g>
                                            </svg>
                                        </a>
                                        <a href="javascript:void(0)" class="hov-svg-white" @if (Auth::check()) onclick="addToCompare({{ $data_selling_product->id }})" @else onclick="showLoginModal()" @endif "
                                            data-toggle="tooltip" data-title="{{ translate('Add to compare') }}" data-placement="left">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                                <path id="_9f8e765afedd47ec9e49cea83c37dfea" data-name="9f8e765afedd47ec9e49cea83c37dfea"
                                                    d="M18.037,5.547v.8a.8.8,0,0,1-.8.8H7.221a.4.4,0,0,0-.4.4V9.216a.642.642,0,0,1-1.1.454L2.456,6.4a.643.643,0,0,1,0-.909L5.723,2.227a.642.642,0,0,1,1.1.454V4.342a.4.4,0,0,0,.4.4H17.234a.8.8,0,0,1,.8.8Zm-3.685,4.86a.642.642,0,0,0-1.1.454v1.661a.4.4,0,0,1-.4.4H2.84a.8.8,0,0,0-.8.8v.8a.8.8,0,0,0,.8.8H12.854a.4.4,0,0,1,.4.4V17.4a.642.642,0,0,0,1.1.454l3.267-3.268a.643.643,0,0,0,0-.909Z"
                                                    transform="translate(-2.037 -2.038)" fill="#919199" />
                                            </svg>
                                        </a>
                                        <a href="javascript:void(0)" class="hov-svg-white" @if (Auth::check()) onclick="showAddToCartModal({{ $data_selling_product->id }})" @else onclick="showLoginModal()" @endif "
                                            data-toggle="tooltip" data-title="{{ translate('Quick View') }}" data-placement="left">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/> <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                                
                                <!-- add to cart -->
                                {{-- <a class="cart-btn absolute-bottom-left w-100 h-35px aiz-p-hov-icon text-white fs-13 fw-700 d-flex flex-column justify-content-center align-items-center @if (in_array($product->id, $cart_added)) active @endif"
                                    href="javascript:void(0)"
                                    @if (Auth::check()) onclick="showAddToCartModal({{ $product->id }})" @else onclick="showLoginModal()" @endif>
                                    <span class="cart-btn-text">
                                        {{ translate('Add to Cart') }}
                                    </span>
                                    <br>
                                    <span><i class="las la-2x la-shopping-cart"></i></span>
                                </a> --}}
                        {{-- @if (home_price($data_selling_product) != home_discounted_price($data_selling_product))
                        <div class="tag_discount">
                            <span>-{{ discount_in_percentage($data_selling_product) }}%</span>
                        </div>
                        @endif

                        @php
                        $product_url = route('product', $data_selling_product->slug);
                            if ($data_selling_product->auction_product == 1) {
                                $product_url = route('auction-product', $data_selling_product->slug);
                            }
                        @endphp --}}
                        <div class="top_selling_img">
                            {{-- <a href="{{ $product_url }}" class="d-block h-100"> --}}
                                <img class="lazyload mx-auto img-fit has-transition img_product_top_selling" width="180px" height="180px" src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                    data-src="{{ uploaded_asset($data_selling_product->thumbnail_img) }}" alt="{{ $data_selling_product->name}}"
                                    title="{{ $data_selling_product->name }}"
                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                        </div>
                        
                        <div class="content_top_selling ">
                            {{-- <a href="{{ $data_selling_product->category->category_url }}" class="mb-1">{{ $data_selling_product->category->getTranslation('name') }}</a> --}}
                            {{-- <a href="{{ $product_url }}"> --}}
                                <div class="name_product_top_selling">
                                    {{$data_selling_product->name}}
                                </div>
                            {{-- </a> --}}
                            <div class="name_product_top_selling" style="margin-bottom: 6px">
                                {{-- <span class="fa fa-star checked" style="color: orange"></span>
                                <span class="fa fa-star checked" style="color: orange"></span>
                                <span class="fa fa-star checked" style="color: orange"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span> --}}
                                
                                        <span class="rating rating-mr-1">
                                            {{ renderStarRating($data_selling_product->rating) }}
                                        </span>
                            </div>
                            <div class="name_store_top_selling" style="margin-bottom: 12px;">
                                {{translate('Sold By')}}  <a href="{{ $data_selling_product->user?->shop?->shop_url }}" style="font-weight:700">
                                   {{$data_selling_product->user?->name}}
                                </a>
                            </div>
                            <div class="price_product_top_selling">
                                {{"đ " . number_format($data_selling_product->unit_price, 0, ".", ",")  }}
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
                <div class="px-sm-3 new_product_section wow animate__animated animate__fadeInUp" data-wow-delay=".2s" id="new_product_filter">
                    @foreach($new_products as $new_product)
                        <div class="top_selling_news_product">
                            <div class="sub_top_selling_news_product position-relative has-transition border-right border-top border-bottom border-left hov-animate-outline" >
                                    <!-- wishlisht & compare icons -->
                                <div class="show_hide_icon_hover">
                                    <div class="icon_hover_products aiz-p-hov-icon">
                                        <a href="javascript:void(0)" class="hov-svg-white" @if (Auth::check()) onclick="addToWishList({{ $new_product->id }})"  @else onclick="showLoginModal()" @endif
                                            data-toggle="tooltip" data-title="{{ translate('Add to wishlist') }}" data-placement="left">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="14.4" viewBox="0 0 16 14.4">
                                                <g id="_51a3dbe0e593ba390ac13cba118295e4" data-name="51a3dbe0e593ba390ac13cba118295e4"
                                                    transform="translate(-3.05 -4.178)">
                                                    <path id="Path_32649" data-name="Path 32649"
                                                        d="M11.3,5.507l-.247.246L10.8,5.506A4.538,4.538,0,1,0,4.38,11.919l.247.247,6.422,6.412,6.422-6.412.247-.247A4.538,4.538,0,1,0,11.3,5.507Z"
                                                        transform="translate(0 0)" fill="#919199" />
                                                    <path id="Path_32650" data-name="Path 32650"
                                                        d="M11.3,5.507l-.247.246L10.8,5.506A4.538,4.538,0,1,0,4.38,11.919l.247.247,6.422,6.412,6.422-6.412.247-.247A4.538,4.538,0,1,0,11.3,5.507Z"
                                                        transform="translate(0 0)" fill="#919199" />
                                                </g>
                                            </svg>
                                        </a>
                                        <a href="javascript:void(0)" class="hov-svg-white" @if (Auth::check()) onclick="addToCompare({{ $new_product->id }})" @else onclick="showLoginModal()" @endif "
                                            data-toggle="tooltip" data-title="{{ translate('Add to compare') }}" data-placement="left">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                                <path id="_9f8e765afedd47ec9e49cea83c37dfea" data-name="9f8e765afedd47ec9e49cea83c37dfea"
                                                    d="M18.037,5.547v.8a.8.8,0,0,1-.8.8H7.221a.4.4,0,0,0-.4.4V9.216a.642.642,0,0,1-1.1.454L2.456,6.4a.643.643,0,0,1,0-.909L5.723,2.227a.642.642,0,0,1,1.1.454V4.342a.4.4,0,0,0,.4.4H17.234a.8.8,0,0,1,.8.8Zm-3.685,4.86a.642.642,0,0,0-1.1.454v1.661a.4.4,0,0,1-.4.4H2.84a.8.8,0,0,0-.8.8v.8a.8.8,0,0,0,.8.8H12.854a.4.4,0,0,1,.4.4V17.4a.642.642,0,0,0,1.1.454l3.267-3.268a.643.643,0,0,0,0-.909Z"
                                                    transform="translate(-2.037 -2.038)" fill="#919199" />
                                            </svg>
                                        </a>
                                        <a href="javascript:void(0)" class="hov-svg-white" @if (Auth::check()) onclick="showAddToCartModal({{ $new_product->id }})" @else onclick="showLoginModal()" @endif
                                            data-toggle="tooltip" data-title="{{ translate('Quick View') }}" data-placement="left">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/> <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                                
                                {{-- @if (home_price($new_product) != home_discounted_price($new_product))
                                    <div class="tag_discount">
                                        <span>-{{ discount_in_percentage($new_product) }}%</span>
                                    </div>
                                @endif --}}
                               
                                <div class="top_selling_img">
                                    {{-- <a href="{{$product_url}}" class="d-block h-100"> --}}
                                        <img class="lazyload mx-auto img-fit has-transition img_product_top_selling" width="180px" height="180px" src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                            data-src="{{ uploaded_asset($new_product->thumbnail_img) }}" alt=""
                                            title=""
                                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                    </a>
                                    {{-- <img class="img_product_top_selling" src={{ static_asset($data_selling_product->img_url) }} alt=""> --}}
                                    {{-- @if($new_product->img_url != "")
                                    
                                    @else
                                        <img class="img_product_top_selling" src={{ static_asset('assets/img/placeholder-rect.jpg') }} alt="">
                                    @endif --}}
                                </div>
                                
                                <div class="content_top_selling ">
                                    {{-- <a href="{{ $new_product->category->category_url }}" class="mb-1">{{ $new_product->category->getTranslation('name') }}</a> --}}
                                    {{-- <a href="{{$product_url}}"> --}}
                                        <div class="name_product_top_selling">
                                            {{$new_product->name}}
                                        </div>
                                    </a>
                                    <div class="name_product_top_selling" style="margin-bottom: 6px">
                                        {{-- <span class="fa fa-star checked" style="color: orange"></span>
                                        <span class="fa fa-star checked" style="color: orange"></span>
                                        <span class="fa fa-star checked" style="color: orange"></span>
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span> --}}
                                        
                                        <span class="rating rating-mr-1">
                                            {{ renderStarRating($new_product->rating) }}
                                        </span>
                                    </div>
                                    <div class="name_store_top_selling" style="margin-bottom: 12px;">
                                        {{translate('Sold By')}}  <a href="{{ $new_product->user?->shop?->shop_url }}" style="font-weight:700">
                                            {{$new_product->user?->shop?->name}}
                                        </a>
                                    </div>
                                    {{-- @if (home_price($new_product) != home_discounted_price($new_product))

                                        <div style="display:flex">
                                            <div class="price_product_top_selling">
                                                {{home_discounted_base_price($new_product)}}
                                            </div>
                                            <del class="fs-14 opacity-60 ml-2 price_product_top_selling color-7">
                                                {{ home_price($new_product) }}
                                            </del>
                                        </div>
                                    @else
                                        <div class="price_product_top_selling">
                                            {{home_discounted_base_price($new_product)}}
                                        </div>
                                    @endif --}}
                                    <div class="price_product_top_selling">
                                        {{"đ " . number_format($data_selling_product->unit_price, 0, ".", ",")  }}
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