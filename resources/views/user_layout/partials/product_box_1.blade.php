@php
    if (auth()->user() != null) {
        $user_id = Auth::user()->id;
        $cart = \App\Models\Cart::where('user_id', $user_id)->get();
    } else {
        $temp_user_id = Session()->get('temp_user_id');
        if ($temp_user_id) {
            $cart = \App\Models\Cart::where('temp_user_id', $temp_user_id)->get();
        }
    }
    
    $cart_added = [];
    if (isset($cart) && count($cart) > 0) {
        $cart_added = $cart->pluck('product_id')->toArray();
    }
@endphp
<div class="top_selling_v2">
    <div class="sub_top_selling_v2 position-relative has-transition border-right border-top border-bottom  hov-animate-outline" >
    @if ($product->auction_product == 0)
        <!-- wishlisht & compare icons -->
            <div class="show_hide_icon_hover">
                <div class="icon_hover_products aiz-p-hov-icon">
                    <a href="javascript:void(0)" class="hov-svg-white" @if (Auth::check()) onclick="addToWishList({{ $product->id }})"  @else onclick="showLoginModal()" @endif
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
                    <a href="javascript:void(0)" class="hov-svg-white" @if (Auth::check()) onclick="addToCompare({{ $product->id }})" @else onclick="showLoginModal()" @endif "
                        data-toggle="tooltip" data-title="{{ translate('Add to compare') }}" data-placement="left">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                            <path id="_9f8e765afedd47ec9e49cea83c37dfea" data-name="9f8e765afedd47ec9e49cea83c37dfea"
                                d="M18.037,5.547v.8a.8.8,0,0,1-.8.8H7.221a.4.4,0,0,0-.4.4V9.216a.642.642,0,0,1-1.1.454L2.456,6.4a.643.643,0,0,1,0-.909L5.723,2.227a.642.642,0,0,1,1.1.454V4.342a.4.4,0,0,0,.4.4H17.234a.8.8,0,0,1,.8.8Zm-3.685,4.86a.642.642,0,0,0-1.1.454v1.661a.4.4,0,0,1-.4.4H2.84a.8.8,0,0,0-.8.8v.8a.8.8,0,0,0,.8.8H12.854a.4.4,0,0,1,.4.4V17.4a.642.642,0,0,0,1.1.454l3.267-3.268a.643.643,0,0,0,0-.909Z"
                                transform="translate(-2.037 -2.038)" fill="#919199" />
                        </svg>
                    </a>
                    <a href="javascript:void(0)" class="hov-svg-white" @if (Auth::check()) onclick="showAddToCartModal({{ $product->id }})" @else onclick="showLoginModal()" @endif "
                        data-toggle="tooltip" data-title="{{ translate('Quick View') }}" data-placement="left">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/> <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                        </svg>
                    </a>
                </div>
            </div>
    @endif
    {{-- <div class="position-relative h-140px h-md-200px img-fit overflow-hidden">
        @php
            $product_url = route('product', $product->slug);
            if ($product->auction_product == 1) {
                $product_url = route('auction-product', $product->slug);
            }
        @endphp
        <!-- Image -->
        <a href="{{ $product_url }}" class="d-block h-100">
            <img class="lazyload mx-auto img-fit has-transition" width="180px" height="180px" src="{{ static_asset('assets/img/placeholder.jpg') }}"
                data-src="{{ uploaded_asset($product->thumbnail_img) }}" alt="{{ $product->getTranslation('name') }}"
                title="{{ $product->getTranslation('name') }}"
                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
        </a>
        <!-- Discount percentage tag -->
        @if (discount_in_percentage($product) > 0)
            <span class="absolute-top-left bg-primary ml-1 mt-1 fs-11 fw-700 text-white w-35px text-center"
                style="padding-top:2px;padding-bottom:2px;">-{{ discount_in_percentage($product) }}%</span>
        @endif
        <!-- Wholesale tag -->
        @if ($product->wholesale_product)
            <span class="absolute-top-left fs-11 text-white fw-700 px-2 lh-1-8 ml-1 mt-1"
                style="background-color: #455a64; @if (discount_in_percentage($product) > 0) top:25px; @endif">
                {{ translate('Wholesale') }}
            </span>
        @endif
        
        @if (
            $product->auction_product == 1 &&
                $product->auction_start_date <= strtotime('now') &&
                $product->auction_end_date >= strtotime('now'))
            <!-- Place Bid -->
            @php
                $highest_bid = $product->bids->max('amount');
                $min_bid_amount = $highest_bid != null ? $highest_bid + 1 : $product->starting_bid;
            @endphp
            <a class="cart-btn absolute-bottom-left w-100 h-35px aiz-p-hov-icon text-white fs-13 fw-700 d-flex flex-column justify-content-center align-items-center @if (in_array($product->id, $cart_added)) active @endif"
                href="javascript:void(0)" onclick="bid_single_modal({{ $product->id }}, {{ $min_bid_amount }})">
                <span class="cart-btn-text">{{ translate('Place Bid') }}</span>
                <br>
                <span><i class="las la-2x la-gavel"></i></span>
            </a>
        @endif
    </div> --}}
        <div class="top_selling_img_v2">
            @php
            $product_url = route('product', $product->slug);
                if ($product->auction_product == 1) {
                    $product_url = route('auction-product', $product->slug);
                }
            @endphp
            {{-- <img class="img_product_top_selling" src={{ static_asset($product->img_url) }} alt=""> --}}
            <a href="{{ $product_url }}" class="d-block">
                <img class="lazyload mx-auto img-fit has-transition img_product_top_selling" width="180px" height="180px" src="{{ static_asset('assets/img/placeholder.jpg') }}"
                    data-src="{{ uploaded_asset($product->thumbnail_img) }}" alt="{{ $product->name}}"
                    title="{{ $product->name}}"
                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
            </a>
        </div>

        <div class="content_top_selling ">
            <div class="name_product_top_selling">
                {{$product->name}}
            </div>
            <div class="name_product_top_selling" style="margin-bottom: 6px">
                {{-- <span class="fa fa-star checked" style="color: orange"></span>
                <span class="fa fa-star checked" style="color: orange"></span>
                <span class="fa fa-star checked" style="color: orange"></span>
                <span class="fa fa-star"></span>
                <span class="fa fa-star"></span> --}}
                @php
                    $total = 0;
                    $total += $product->reviews->count();
                @endphp
                <span class="rating rating-mr-1">
                    {{ renderStarRating($product->rating) }}
                </span>
            </div>
            <div class="name_store_top_selling" style="margin-bottom: 12px;">
                {{translate('Sold By')}}  <a href="{{route('shop.visit', $product->user?->shop?->slug) }}" style="font-weight:700">
                    {{$product->user?->shop?->name}}
                </a>
            </div>
            <div class="price_product_top_selling">
                {{home_discounted_base_price($product)}}
            </div>
        </div>
    </div>
</div>