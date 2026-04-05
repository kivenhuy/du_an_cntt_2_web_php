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
            
                <img class="lazyload mx-auto img-fit has-transition img_product_top_selling" width="180px" height="180px" src="{{ static_asset('assets/img/placeholder.jpg') }}"
                    data-src="{{ uploaded_asset($product->thumbnail_img) }}" alt="{{ $product->name}}"
                    title="{{ $product->name}}"
                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
            
        </div>

        <div class="content_top_selling ">
            <a href="{{ $product_url }}" class="d-block">
                <div class="name_product_top_selling">
                    {{$product->name}}
                </div>
            </a>
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
            
            <div class="price_product_top_selling">
                {{home_discounted_base_price($product)}}
            </div>
        </div>
    </div>
</div>