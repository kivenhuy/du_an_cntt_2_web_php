<div class="text-left">
    <!-- Product Name -->

    {{-- @if (discount_in_percentage($detailedProduct) > 0)
        <span class="span_discount" 
            style="padding-top:2px;padding-bottom:2px;">-{{ discount_in_percentage($detailedProduct) }}%
        </span>
    @endif --}}


    <h1 class="mb-4 fs-16 fw-700 text-dark product_name">
        {{ $detailedProduct->name}}
    </h1>

    <div class="row align-items-center mb-3" style="height: 50px">
        <!-- Review -->
        @if ($detailedProduct->auction_product != 1)
            <div class="col-6">
                @php
                    $total = 0;
                    // $total += $detailedProduct->reviews->count();
                @endphp
                <span class="rating rating-mr-1">
                    {{ renderStarRating($detailedProduct->rating) }}
                </span>
                <span class="ml-1 opacity-50 fs-14">({{ $total }}
                    {{ translate('reviews') }})</span>
            </div>
        @endif
        <!-- Estimate Shipping Time -->
        @if ($detailedProduct->est_shipping_days)
            <div class="col-auto fs-14 mt-1">
                <small class="mr-1 opacity-50 fs-14">{{ translate('Estimate Shipping Time') }}:</small>
                <span class="fw-500">{{ $detailedProduct->est_shipping_days }} {{ translate('Days') }}</span>
            </div>
        @endif
        <!-- In stock -->
        @if ($detailedProduct->digital == 1)
            <div class="col-12 mt-1">
                <span class="badge badge-md badge-inline badge-pill badge-success">{{ translate('In stock') }}</span>
            </div>
        @endif
    </div>
    <div class="row align-items-center">
        <!-- Ask about this product -->
        {{-- <div class="col-xl-3 col-lg-4 col-md-3 col-sm-4 mb-3">
            <a href="javascript:void();" onclick="goToView('product_query')" class="text-primary fs-14 fw-600 d-flex">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 32 32">
                    <g id="Group_25571" data-name="Group 25571" transform="translate(-975 -411)">
                        <g id="Path_32843" data-name="Path 32843" transform="translate(975 411)" fill="#fff">
                            <path
                                d="M 16 31 C 11.9933500289917 31 8.226519584655762 29.43972969055176 5.393400192260742 26.60659980773926 C 2.560270071029663 23.77347946166992 1 20.00665092468262 1 16 C 1 11.9933500289917 2.560270071029663 8.226519584655762 5.393400192260742 5.393400192260742 C 8.226519584655762 2.560270071029663 11.9933500289917 1 16 1 C 20.00665092468262 1 23.77347946166992 2.560270071029663 26.60659980773926 5.393400192260742 C 29.43972969055176 8.226519584655762 31 11.9933500289917 31 16 C 31 20.00665092468262 29.43972969055176 23.77347946166992 26.60659980773926 26.60659980773926 C 23.77347946166992 29.43972969055176 20.00665092468262 31 16 31 Z"
                                stroke="none" />
                            <path
                                d="M 16 2 C 12.26045989990234 2 8.744749069213867 3.456249237060547 6.100500106811523 6.100500106811523 C 3.456249237060547 8.744749069213867 2 12.26045989990234 2 16 C 2 19.73954010009766 3.456249237060547 23.2552490234375 6.100500106811523 25.89949989318848 C 8.744749069213867 28.54375076293945 12.26045989990234 30 16 30 C 19.73954010009766 30 23.2552490234375 28.54375076293945 25.89949989318848 25.89949989318848 C 28.54375076293945 23.2552490234375 30 19.73954010009766 30 16 C 30 12.26045989990234 28.54375076293945 8.744749069213867 25.89949989318848 6.100500106811523 C 23.2552490234375 3.456249237060547 19.73954010009766 2 16 2 M 16 0 C 24.8365592956543 0 32 7.163440704345703 32 16 C 32 24.8365592956543 24.8365592956543 32 16 32 C 7.163440704345703 32 0 24.8365592956543 0 16 C 0 7.163440704345703 7.163440704345703 0 16 0 Z"
                                stroke="none" fill="#f3af3d" />
                        </g>
                        <path id="Path_32842" data-name="Path 32842"
                            d="M28.738,30.935a1.185,1.185,0,0,1-1.185-1.185,3.964,3.964,0,0,1,.942-2.613c.089-.095.213-.207.361-.344.735-.658,2.252-2.032,2.252-3.555a2.228,2.228,0,0,0-2.37-2.37,2.228,2.228,0,0,0-2.37,2.37,1.185,1.185,0,1,1-2.37,0,4.592,4.592,0,0,1,4.74-4.74,4.592,4.592,0,0,1,4.74,4.74c0,2.577-2.044,4.432-3.028,5.333l-.284.255a1.89,1.89,0,0,0-.243.948A1.185,1.185,0,0,1,28.738,30.935Zm0,3.561a1.185,1.185,0,0,1-.835-2.026,1.226,1.226,0,0,1,1.671,0,1.061,1.061,0,0,1,.148.184,1.345,1.345,0,0,1,.113.2,1.41,1.41,0,0,1,.065.225,1.138,1.138,0,0,1,0,.462,1.338,1.338,0,0,1-.065.219,1.185,1.185,0,0,1-.113.207,1.06,1.06,0,0,1-.148.184A1.185,1.185,0,0,1,28.738,34.5Z"
                            transform="translate(962.004 400.504)" fill="#f3af3d" />
                    </g>
                </svg>
                <span class="ml-2 text-primary animate-underline-blue">{{ translate('Product Inquiry') }}</span>
            </a>
        </div> --}}
        {{-- <div class="col mb-3">
            @if ($detailedProduct->auction_product != 1)
                <div class="d-flex">
                    <!-- Add to wishlist button -->
                    <a href="javascript:void(0)" onclick="addToWishList({{ $detailedProduct->id }})"
                        class="mr-3 fs-14 text-dark opacity-60 has-transitiuon hov-opacity-100">
                        <i class="la la-heart-o mr-1"></i>
                        {{ translate('Add to Wishlist') }}
                    </a>
                    <!-- Add to compare button -->
                    <a href="javascript:void(0)" onclick="addToCompare({{ $detailedProduct->id }})"
                        class="fs-14 text-dark opacity-60 has-transitiuon hov-opacity-100">
                        <i class="fa fa-sync mr-1"></i>
                        {{ translate('Add to Compare') }}
                    </a>
                </div>
            @endif
        </div> --}}
    </div>

    <hr>

   
        <!-- Without auction product -->
        @if ($detailedProduct->wholesale_product == 1)
            <!-- Wholesale -->
            <table class="table mb-3">
                <thead>
                    <tr>
                        <th class="border-top-0">{{ translate('Min Qty') }}</th>
                        <th class="border-top-0">{{ translate('Max Qty') }}</th>
                        <th class="border-top-0">{{ translate('Unit Price') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detailedProduct->stocks->first()->wholesalePrices as $wholesalePrice)
                        <tr>
                            <td>{{ $wholesalePrice->min_qty }}</td>
                            <td>{{ $wholesalePrice->max_qty }}</td>
                            <td>{{ single_price($wholesalePrice->price) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <!-- Without Wholesale -->
            @if (home_price($detailedProduct) != home_discounted_price($detailedProduct))
                <div class="row no-gutters mb-3">
                    {{-- <div class="col-sm-2">
                        <div class="text-secondary fs-14 fw-400">{{ translate('Price') }}</div>
                    </div> --}}
                    <div class="col-sm-12">
                        <div class="d-flex align-items-center">
                            <!-- Discount Price -->
                            <strong class="fs-16 fw-700 text-primary price_product">
                                {{ home_discounted_price($detailedProduct) }}
                            </strong>
                            <!-- Home Price -->
                            <del class="fs-14 opacity-60 ml-2 price_product_before_discount color-7">
                                {{ home_price($detailedProduct) }}
                            </del>
                            <!-- Unit -->
                            @if ($detailedProduct->unit != null)
                                <span class=" ml-1 price_product">/{{ $detailedProduct->getTranslation('unit') }}</span>
                            @endif
                            <!-- Discount percentage -->
                            
                            <!-- Club Point -->
                            @if (addon_is_activated('club_point') && $detailedProduct->earn_point > 0)
                                <div class="ml-2 bg-warning d-flex justify-content-center align-items-center px-3 py-1"
                                    style="width: fit-content;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                        viewBox="0 0 12 12">
                                        <g id="Group_23922" data-name="Group 23922" transform="translate(-973 -633)">
                                            <circle id="Ellipse_39" data-name="Ellipse 39" cx="6"
                                                cy="6" r="6" transform="translate(973 633)"
                                                fill="#fff" />
                                            <g id="Group_23920" data-name="Group 23920"
                                                transform="translate(973 633)">
                                                <path id="Path_28698" data-name="Path 28698"
                                                    d="M7.667,3H4.333L3,5,6,9,9,5Z" transform="translate(0 0)"
                                                    fill="#f3af3d" />
                                                <path id="Path_28699" data-name="Path 28699"
                                                    d="M5.33,3h-1L3,5,6,9,4.331,5Z" transform="translate(0 0)"
                                                    fill="#f3af3d" opacity="0.5" />
                                                <path id="Path_28700" data-name="Path 28700"
                                                    d="M12.666,3h1L15,5,12,9l1.664-4Z" transform="translate(-5.995 0)"
                                                    fill="#f3af3d" />
                                            </g>
                                        </g>
                                    </svg>
                                    <small class="fs-11 fw-500 text-white ml-2">{{ translate('Club Point') }}:
                                        {{ $detailedProduct->earn_point }}</small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @else
                <div class="row no-gutters mb-3" style="margin-bottom: 36px !important">
                    {{-- <div class="col-sm-2">
                        <div class="text-secondary fs-14 fw-400">{{ translate('Price') }}</div>
                    </div> --}}
                    <div class="col-sm-12">
                        <div class="d-flex align-items-center">
                            <!-- Discount Price -->
                            <strong class="fs-16 fw-700 text-primary price_product">
                                {{ home_discounted_price($detailedProduct) }}
                            </strong>
                            <!-- Unit -->
                            @if ($detailedProduct->unit != null)
                                <span class="opacity-70 price_product" style="color: unset !important">/{{ $detailedProduct->unit}}</span>
                            @endif
                            <!-- Club Point -->
                            
                        </div>
                    </div>
                </div>
            @endif
        @endif

     <!-- Brand Logo & Name -->
     @if ($detailedProduct->brand != null)
     <div class="d-flex flex-wrap align-items-center mb-3">
         <span class="text-secondary fs-14 fw-400 mr-4 w-70px text_brand">{{ translate('Brand') }}</span><br>
         <a href="{{ route('products.brand', $detailedProduct->brand->slug) }}"
             class="text-reset hov-text-primary fs-14 fw-700 text_brand" style="color: #2E7F25 !important">{{ $detailedProduct->brand->name }}</a>
     </div>
 @endif

    <!-- Seller Info -->
    <div class="d-flex flex-wrap align-items-center" style="margin-bottom: 30px !important">
        <div class="d-flex align-items-center mr-4">
            <!-- Shop Name -->
            <span class="text-secondary fs-14 fw-400 mr-4 w-70px text_who_sell">{{ translate('Sold by') }}</span>
            <input type="hidden" id="id_shop" value="{{$detailedProduct->user->shop->id}}">
            <a href="{{route('shop.visit', $detailedProduct->user->shop?->slug) }}"
                class="text-reset hov-text-primary fs-14 fw-700 text_who_sell" style="color: #2E7F25 !important">{{ $detailedProduct->user->shop->name }}</a>
        </div>
        
    </div>

    {{-- <div class="small_content">
        <span class="sub_content">
            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Aliquam rem officia, corrupti reiciendis minima nisi modi, quasi, odio minus dolore impedit fuga eum eligendi? Officia doloremque facere quia. Voluptatum, accusantium!
        </span>
        <span class="sub_content">    
            Uninhibited carnally hired played in whimpered dear gorilla koala depending and much yikes off far quetzal goodness and from for grimaced goodness.
        </span>
    </div> --}}
    @if ($detailedProduct->auction_product != 1)
        <form id="option-choice-form">
            @csrf
            <input type="hidden" name="id" value="{{ $detailedProduct->id }}">
            @if ($detailedProduct->digital == 0)
                <!-- Choice Options -->
                @if ($detailedProduct->choice_options != null)
                    @foreach (json_decode($detailedProduct->choice_options) as $key => $choice)
                        <div class="row no-gutters mb-3">
                            <div class="col-sm-2">
                                <div class="text-secondary fs-14 fw-400 mt-2 text_brand">
                                    {{ \App\Models\Attribute::find($choice->attribute_id)->getTranslation('name') }}
                                </div>
                            </div>
                            <div class="col-sm-10">
                                <div class="aiz-radio-inline">
                                    @foreach ($choice->values as $key => $value)
                                        <label class="aiz-megabox pl-0 mr-2 mb-2">
                                            <input type="radio" name="attribute_id_{{ $choice->attribute_id }}"
                                                value="{{ $value }}"
                                                @if ($key == 0) checked @endif>
                                            <span
                                                class="aiz-megabox-elem rounded-0 d-flex align-items-center justify-content-center py-1 px-3  text_brand">
                                                {{ $value }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

                <!-- Color Options -->
                @if ($detailedProduct->colors != null && count(json_decode($detailedProduct->colors)) > 0)
                    <div class="row no-gutters mb-3">
                        <div class="col-sm-2">
                            <div class="text-secondary fs-14 fw-400 mt-2">{{ translate('Color') }}</div>
                        </div>
                        <div class="col-sm-10">
                            <div class="aiz-radio-inline">
                                @foreach (json_decode($detailedProduct->colors) as $key => $color)
                                    <label class="aiz-megabox pl-0 mr-2 mb-0" data-toggle="tooltip"
                                        data-title="{{ \App\Models\Color::where('code', $color)->first()->name }}">
                                        <input type="radio" name="color"
                                            value="{{ \App\Models\Color::where('code', $color)->first()->name }}"
                                            @if ($key == 0) checked @endif>
                                        <span
                                            class="aiz-megabox-elem rounded-0 d-flex align-items-center justify-content-center p-1">
                                            <span class="size-25px d-inline-block rounded"
                                                style="background: {{ $color }};"></span>
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                @if(Auth::check())
                    @if(Auth::user()->user_type != "enterprise")
                        <!-- Quantity + Add to cart -->
                        <div class="row no-gutters mb-3" style="margin-bottom: 32px !important;">
                            <div class="col-sm-2">
                                <div class="text-secondary fs-14 fw-400 mt-2 text_brand">{{ translate('Quantity') }}</div>
                            </div>
                            <div class="col-sm-10">
                                <input type="hidden" name="" id="stock_qty" value="{{$detailedProduct->product_stock->qty}}">
                                <div class="product-quantity d-flex align-items-center">
                                    <div class="row no-gutters align-items-center aiz-plus-minus mr-3" style="width: 130px;">
                                        <button class="btn col-auto btn-icon btn-sm btn-light rounded-0" type="button"
                                            data-type="minus" data-field="quantity" disabled="">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                        <input type="number" name="quantity" id="quantity"
                                            class="col border-0 text-center flex-grow-1 fs-16 input-number" placeholder="1"
                                            value="{{ $detailedProduct->min_qty }}" min="{{ $detailedProduct->min_qty }}"
                                            max="{{$detailedProduct->product_stock->qty}}" is_request="0" lang="en">
                                        <button class="btn col-auto btn-icon btn-sm btn-light rounded-0" type="button"
                                            data-type="plus" data-field="quantity">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                    @php
                                        $qty = 0;
                                        // foreach ($detailedProduct->stocks as $key => $stock) {
                                            $qty += $detailedProduct->product_stock->qty;
                                        // }product_stock
                                    @endphp
                                    <div class="avialable-amount opacity-60">
                                        
                                            <span id="available-quantity">{{ $qty }}</span>
                                            {{ translate('available') }}
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @else
                    <!-- Quantity + Add to cart -->
                    <div class="row no-gutters mb-3" style="margin-bottom: 32px !important;">
                        <div class="col-sm-2">
                            <div class="text-secondary fs-14 fw-400 mt-2 text_brand">{{ translate('Quantity') }}</div>
                        </div>
                        <div class="col-sm-10">
                            <div class="product-quantity d-flex align-items-center">
                                <div class="row no-gutters align-items-center aiz-plus-minus mr-3" style="width: 130px;">
                                    <button class="btn col-auto btn-icon btn-sm btn-light rounded-0" type="button"
                                        data-type="minus" data-field="quantity" disabled="">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                    <input type="number" name="quantity"
                                        class="col border-0 text-center flex-grow-1 fs-16 input-number" placeholder="1"
                                        value="{{ $detailedProduct->min_qty }}" min="{{ $detailedProduct->min_qty }}"
                                        max="10" is_request="0" lang="en" >
                                    <button class="btn col-auto btn-icon btn-sm btn-light rounded-0" type="button"
                                        data-type="plus" data-field="quantity">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                                @php
                                    $qty = 0;
                                    // foreach ($detailedProduct->stocks as $key => $stock) {
                                        $qty += $detailedProduct->product_stock->qty;
                                    // }product_stock
                                @endphp
                                <div class="avialable-amount opacity-60">
                                    
                                        <span id="available-quantity">{{ $qty }}</span>
                                        {{ translate('available') }}
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                
                <!-- Additional Cost -->
                @if ($detailedProduct->is_use_additional_cost)
                    <div class="row no-gutters mb-3 mb-4">
                        <div class="col col-sm-2">
                            <div class="text-secondary fs-14 fw-400 text_brand">{{ translate('Additional Cost') }}</div>
                        </div>
                        <div class="col col-sm-10">
                            <strong class="fs-16 fw-700 text-primary">
                                {{ format_price(convert_price($detailedProduct->additional_cost)) }}
                            </strong>
                            <i class="fa-solid fa-circle-info ml-2 fs-14 fw-700" data-toggle="tooltip" data-placement="top" title="{{ translate('Additional Cost')}}"></i>
                        </div>
                        
                    </div>
                @endif
            @endif
        </form>
    @endif

    @if ($detailedProduct->auction_product)
    @else
        <!-- Add to cart & Buy now Buttons -->
        <div class="mt-3">
            @if ($detailedProduct->digital == 0)
                @if ($detailedProduct->external_link != null)
                    <a type="button" class="btn btn-primary buy-now fw-600 add-to-cart px-4 rounded-0"
                        href="{{ $detailedProduct->external_link }}">
                        <i class="la la-share"></i> {{ translate($detailedProduct->external_link_btn) }}
                    </a>
                @else
                    <div class="form-group-row">
                        <div class="row">
                            <input type="hidden" value="{{$detailedProduct->id}}" name="id_product" id="id_product">
                            <div class="setting_for_button" style="">
                            @if (Auth::check())
                                @if(Auth::user()->user_type != "enterprise")
                                    <div class="pl-3 pr-0" style="max-width:250px !important">
                                        <button type="button" 
                                            class="btn btn-warning buy-now fw-600 add_to_cart min-w-150px rounded-4"
                                            @if (Auth::check()) onclick="addToCart()" @else onclick="showLoginModal()" @endif>
                                                {{-- <i class="fa fa-shopping-bag"></i> --}}
                                                <i class="fa fa-shopping-bag" style="font-size: 16px"></i>
                                                {{-- <img src="{{static_asset('uploads/all/km22nnFUj9qnUYI8vD3Sa0gB6sLIUeqw921muBAb.png')}}" alt=""> --}}
                                            <span class="d-md-inline-block text_button_detail_page font-size-mobile"> {{ translate('Add to cart') }}</span>
                                        </button>
                                    </div>
                                    
                                    <div class="pl-3 pr-0" style="max-width:180px !important">
                                        <button type="button" class="btn btn-primary buy-now fw-600 add-to-cart min-w-140px rounded-4"
                                            @if (Auth::check()) onclick="buyNow()" @else onclick="showLoginModal()" @endif>
                                            <i class="fa fa-shopping-cart" style="font-size: 16px"></i> 
                                            {{-- <img src="{{static_asset('uploads/all/eP7lX2HLlbLjmFYZtMUZe0R4QVC6qnEEcurewNOq.png')}}" alt=""> --}}
                                            <span class="d-md-inline-block text_button_detail_page font-size-mobile"> {{ translate('Buy Now') }}</span>
                                        </button>
                                    </div>
                                @endif
                                @if(Auth::user()->user_type == 'enterprise')
                                    <div class="pl-3 pr-0" style="max-width:200px !important">
                                        <button type="button" class="btn btn-info buy-now fw-600 add-to-cart min-w-140px rounded-4"
                                            @if (Auth::check()) onclick="SendRFQRequest()" @else onclick="showLoginModal()" @endif>
                                            <i class="fa fa-file-contract"></i>
                                            <span class="d-md-inline-block text_button_detail_page font-size-mobile"> {{ translate('Send Request') }}</span>
                                        </button>
                                    </div>
                                @endif
                            @else 
                                    <div class="pl-3 pr-0" style="max-width:250px !important">
                                        <button type="button" 
                                            class="btn btn-warning buy-now fw-600 add_to_cart min-w-150px rounded-4"
                                            @if (Auth::check()) onclick="addToCart()" @else onclick="showLoginModal()" @endif>
                                                {{-- <i class="fa fa-shopping-bag"></i> --}}
                                                <i class="fa fa-shopping-bag" style="font-size: 16px"></i>
                                                {{-- <img src="{{static_asset('uploads/all/km22nnFUj9qnUYI8vD3Sa0gB6sLIUeqw921muBAb.png')}}" alt=""> --}}
                                            <span class="d-md-inline-block text_button_detail_page font-size-mobile"> {{ translate('Add to cart') }}</span>
                                        </button>
                                    </div>
                                    
                                    <div class="pl-3 pr-0" style="max-width:180px !important">
                                        <button type="button" class="btn btn-primary buy-now fw-600 add-to-cart min-w-140px rounded-4"
                                            @if (Auth::check()) onclick="buyNow()" @else onclick="showLoginModal()" @endif>
                                            <i class="fa fa-shopping-cart" style="font-size: 16px"></i> 
                                            {{-- <img src="{{static_asset('uploads/all/eP7lX2HLlbLjmFYZtMUZe0R4QVC6qnEEcurewNOq.png')}}" alt=""> --}}
                                            <span class="d-md-inline-block text_button_detail_page font-size-mobile"> {{ translate('Buy Now') }}</span>
                                        </button>
                                    </div>
                                    <div class="pl-3 pr-0" style="max-width:200px !important">
                                        <button type="button" class="btn btn-info buy-now fw-600 add-to-cart min-w-140px rounded-4"
                                            @if (Auth::check()) onclick="SendRFQRequest()" @else onclick="showLoginModal()" @endif>
                                            <i class="fa fa-file-contract"></i>
                                            <span class="d-md-inline-block text_button_detail_page font-size-mobile"> {{ translate('Send Request') }}</span>
                                        </button>
                                    </div>
                                
                            @endif
                                
                            </div>
                         
                            
                        </div>
                    </div>
                @endif
                <button type="button" class="btn btn-secondary out-of-stock fw-600 d-none" disabled>
                    <i class="la la-cart-arrow-down"></i> {{ translate('Out of Stock') }}
                </button>
            
            @endif
        </div>

        
    @endif

    <div class="modal fade" id="Rfq_request">
        <div class="modal-dialog modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size" role="document" style="max-width: 800px;width: 100%">
            <div class="modal-content position-relative">
                {{-- <div class="c-preloader text-center p-3">
                    <i class="las la-spinner la-spin la-3x"></i>
                </div> --}}
                <button type="button" class="close absolute-top-right btn-icon close z-1 btn-circle bg-gray mr-2 mt-2 d-flex justify-content-center align-items-center" data-dismiss="modal" aria-label="Close" style="background: #ededf2; width: calc(2rem + 2px); height: calc(2rem + 2px);">
                    <span aria-hidden="true" class="fs-24 fw-700" style="margin-left: 2px;">&times;</span>
                </button>
                <form class="form-default" role="form" action="{{route('request_for_product.store')}}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title"> {{translate('Request For Product')}} </h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <input type="hidden" name="product_id" value={{ $detailedProduct->id }}>
                            <input type="hidden" name="shop_id" value={{$detailedProduct->user->shop->id}}>
                            <div class="col-sm-4">
                                <label>{{translate('Enter custom quantity')}}</label>
                                <div class="product-quantity d-flex align-items-center">
                                    <div class="row no-gutters align-items-center aiz-plus-minus mr-3" >
                                        <button class="btn col-auto btn-icon btn-sm btn-light rounded-0" type="button" data-type="minus" data-field="quantity" disabled="disabled">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                        <input type="number" name="quantity" class="col border-0 text-center flex-grow-1 fs-16 input-number" placeholder="1" value="{{ $detailedProduct->min_qty }}" min="{{ $detailedProduct->min_qty }}" is_request="1" lang="en">
                                        <button class="btn col-auto btn-icon btn-sm btn-light rounded-0" type="button" data-type="plus" data-field="quantity">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label>{{translate('Unit')}}</label>
                                <select class="form-control aiz-selectpicker" name="unit" id="unit" >
                                    <option value="KG" >KG</option>
                                    <option value="TONS" >TONS</option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label>{{translate('Order Date')}}</label>      
                                <select class="form-control aiz-selectpicker" name="order_date" id="order_date" >
                                    <option value="1" >Every Day</option>
                                    <option value="7" >Each 7 Days</option>
                                    <option value="14" >Each 14 Days</option>
                                    <option value="30" >Each 30 Days</option>
                                </select>
                            </div>
                            
                        </div>
                        <div class="form-group row">    
                            <div class="col-sm-4">
                                <label>{{translate('From Date')}}</label>
                                <input required="" type="datetime-local" class="form-control" name="from_date" id="from_date">
                            </div>
                            <div class="col-sm-4">
                                <label>{{translate('To Date')}}</label>
                                <input required="" type="datetime-local" class="form-control" name="to_date" id="to_date">
                            </div>      
                        </div>  
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{translate('Send Request')}}</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{translate('Close')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
