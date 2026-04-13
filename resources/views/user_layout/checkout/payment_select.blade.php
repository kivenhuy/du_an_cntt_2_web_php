@extends('user_layout.layouts.app')

@section('content')

    <!-- Payment Info -->
    <section class="mb-4 checkout-page">
        <div class="container" style="max-width:1200px !important;width: 100%">
            <form action="{{route('checkout')}}" id="final_checkout_form" class="form-default" role="form" method="POST"  id="checkout-form">
            @csrf
                    <div class="row" style="margin-top: 24px;">
                        <div class="col-lg-12">
                                
                                @if(!($carts_normal->isEmpty()))
                                    <input type="hidden" name="owner_id" value="{{ $carts_normal[0]['owner_id'] }}">
                                @else
                                    <input type="hidden" name="owner_id" value="{{ $carts_short_shelf_life[0]['owner_id'] }}">
                                @endif
                                
                                <input type="hidden" id="total_shipping_price" name="total_shipping_price" value="0">
                                <div class="header_checkout_div">
                                    <div style="margin-bottom:48px ">
                                        <span class="header_checkout_1">Thanh Toán</span>
                                    </div>
                                </div>
                                <div class="col-xxl-12 col-xl-12 mx-auto" style="padding-left: unset;padding-right: unset;margin-bottom: 2rem">
                                    <div style="display:flex;align-items:center;gap:10px;">
                                        <span style="font-size:22px;color:#1c90d9;"><i class="fas fa-shipping-fast"></i></span>
                                        <span style="" class="header_checkout">Sản Phẩm & Dịch Vụ Giao Hàng</span>
                                    </div>
                                    <!-- Seller Products -->
                                    <div style="margin-top:1rem;display:flex;align-items:center;gap:10px;">
                                        <span style="font-size:22px;color:#1c90d9;"><i class="fas fa-box-open"></i></span>
                                        <span class="header_checkout">Thông tin sản phẩm
                                        </span>
                                    </div>
                                    @php
                                        $total_normal_product = 0;
                                        $shipping_fee = 0;
                                        $final_total_normal = 0;
                                    @endphp
                                    @if (!empty($seller_products_normal))
                                        @foreach ($seller_products_normal as $key_user => $seller_product)
                                            @php
                                                $total_normal_product = 0;
                                                $shipping_fee = 0;
                                                $final_total_normal = 0;
                                            @endphp
                                            <div class="checkout-product-card bg-white p-3 p-lg-4 text-left rounded">
                                                <div class="mb-4">
                                                    <!-- Headers -->
                                                    <div class="row gutters-5 d-none d-lg-flex border-bottom mb-3 text-secondary fs-12 header_table checkout-cart-header" >
                                                        <div class="col-md-5 fw-600 text_cart_details pl-lg-3">Sản phẩm</div>
                                                        <div class="col-md-3 fw-600 text_cart_details text-lg-center">Số lượng</div>
                                                        <div class="col-md-4 fw-600 text_cart_details text-lg-right pr-lg-3">Tổng tiền</div>
                                                    </div>
                                                    <!-- Cart Items -->
                                                    <ul class="list-group list-group-flush">
                                                        
                                                        @foreach ($carts_normal as $key => $cartItem)
                                                            @php
                                                                $product = \App\Models\Products::find($cartItem['product_id']);
                                                                $user = \App\Models\Shop::where('user_id', $key)->first();
                                                                $product_stock = $product->product_stock->where('variant', preg_replace('/\s+/', '',$cartItem['variation']))->first();
                                                                // $product_stock = $product->stocks()->get();
                                                                // 
                                                                // $total = $total + ($cartItem['price']  + $cartItem['tax']) * $cartItem['quantity'];
                                                                
                                                                
                                                                if(Auth::user()->user_type == "enterprise")
                                                                {
                                                                    $total_normal_product =  $total_normal_product + (cart_product_price($cartItem, $product, false) * $cartItem['quantity']);
                                                                }
                                                                else {
                                                                    $total_normal_product = $total_normal_product + (cart_product_price($cartItem, $product, false) * $cartItem['quantity']);
                                                                }
                                                               
                                                                
                                                                $final_total_normal = $total_normal_product+$shipping_fee;
                                                                $product_name_with_choice = $product->name;
                                                                if ($cartItem['variation'] != null) {
                                                                    $product_name_with_choice = $product->name.' - '.$cartItem['variation'];
                                                                }
                                                            @endphp
                                                            @if($product->user_id ==  $key_user)
                                                                <li class="list-group-item px-0 checkout-cart-line">
                                                    <div class="row gutters-5 checkout-cart-line__row align-items-lg-center">
                                                        
                                                        <!-- Product Image & name -->
                                                        <div class="col-md-5 col-12 d-flex align-items-center checkout-col-product mb-3 mb-lg-0">
                                                            <span class="mr-3 ml-0 flex-shrink-0">
                                                                <img src="{{ uploaded_asset($product->thumbnail_img) }}"
                                                                    class="img-fit checkout-cart-thumb"
                                                                    style="width:80px;height:80px;object-fit:cover;"
                                                                    alt="{{ $product->name  }}"
                                                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                                            </span>
                                                            <div class="d-flex flex-column">
                                                                <span class="fs-14 fw-600 checkout-cart-product-name" style="line-height:1.4;color:#222;">{{ $product_name_with_choice }}</span>
                                                                @if($product->unit)
                                                                    <span class="fs-12 mt-1" style="color:#888;">Dung tích: {{$product->weight}}{{ $product->unit }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <!-- Quantity -->
                                                        <div class="col-md-3 col-6 order-1 order-lg-0 checkout-col-qty">
                                                            <span class="checkout-cart-mob-label d-lg-none">{{ translate('Qty') }}</span>
                                                            @if ($cartItem['digital'] != 1 && $product->auction_product == 0)
                                                                <div class="d-flex flex-column align-items-start align-items-lg-center aiz-plus-minus mr-2 ml-0 w-100">
                                                                   
                                                                    <input type="number" name="quantity[{{ $cartItem['id'] }}]"
                                                                        class="col border-0 text-left text-lg-center px-0 flex-grow-1 fs-14 input-number quantity_product checkout-qty-input"
                                                                        placeholder="1" value="{{ $cartItem['quantity'] }}"
                                                                        min="{{ $product->min_qty }}"
                                                                        max="{{ $product_stock->qty }}"
                                                                        onchange="updateQuantity({{ $cartItem['id'] }}, this)" style="padding-left:0.75rem !important;">
                                                                    
                                                                </div>
                                                            @endif
                                                        </div>
                                                        
                                                        @if(Auth::user()->user_type === "enterprise")
                                                            <div class="col-md-2 col-12 order-5 order-lg-0 checkout-col-date my-2 my-lg-0">
                                                                @if(count($cartItem->shipping_date)>0)
                                                                    @foreach ($cartItem->shipping_date as $date)
                                                                        <span class="fw-700 fs-14">{{$date}}</span>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        @endif
                                                        <!-- Total -->
                                                        <div class="col-md-4 col-12 order-4 order-lg-0 checkout-col-total my-3 my-lg-0">
                                                            <span class="opacity-60 fs-12 d-block d-lg-none">{{ translate('Total')}}</span>
                                                            @if(Auth::user()->user_type === "enterprise")
                                                                <span class="fw-700 fs-16 text-primary total_product">{{ single_price(cart_product_price($cartItem, $product, false) * $cartItem['quantity']) }}</span><br>
                                                                <small style="color: red;font-weight: 900">This Price Is Total Price For All Order Date</small>
                                                            @else   
                                                                <span class="fw-700 fs-16 text-primary total_product">{{ single_price(cart_product_price($cartItem, $product, false) * $cartItem['quantity']) }}</span>
                                                            @endif
                                                        </div>
                                                        
                                                    </div>
                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="delivery_type checkout-delivery-section mb-3">
                                                <div class="checkout-delivery-heading">{{ translate('Select delivery type') }}</div>
                                                @foreach($carrier_list as $carrier_key => $carrier)
                                                    @php
                                                        $carrier_range_first = $carrier->carrier_ranges->first();
                                                        $is_carrier_free = (int) ($carrier->free_shipping ?? 0) === 1;
                                                        $data_shipping_type = $is_carrier_free ? 'free_shipping' : optional($carrier_range_first)->billing_type;
                                                    @endphp
                                                    @if($carrier_range_first || $is_carrier_free)
                                                    <div class="checkout-delivery-option">
                                                       
                                                        <input onclick="handleClick(this);" class="radio_button_checkout checkout-delivery-radio" type="radio" id="shipping_fee_{{ $key_user }}" data_cart="normal_product" data_id="{{$carrier->id}}" name="shipping_fee_{{ $key_user }}" value="{{ carrier_base_price($carts_normal, $carrier->id, $key_user) }}" data-shipping="{{ $data_shipping_type }}"/>
                                                        @if($is_carrier_free)
                                                            <span class="delivery_type checkout-delivery-label mb-0">{{ $carrier->name }} — {{ translate('Free shipping') }}</span>
                                                        @elseif($carrier_range_first->billing_type == 'weight_based')
                                                            <span class="delivery_type checkout-delivery-label mb-0">{{ $carrier->name }}</span>
                                                        @else
                                                            <span class="delivery_type checkout-delivery-label mb-0">{{ $carrier->name }} (2 hour)</span>
                                                        @endif
                                                        <span class="price_shipping checkout-delivery-price">{{ single_price(carrier_base_price($carts_normal, $carrier->id, $key_user)) }}</span>
                                                        <input type="radio" name="carrier_id_{{ $key_user }}" value="{{$carrier->id}}" checked="" style="display: none">
                                                    </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @endforeach
                                    @endif


                                    
                                    @php
                                        $total_short_product = 0;
                                        $shipping_fee = 0;
                                        $final_total_short = 0;
                                    @endphp
                                    @if (!empty($seller_products_short))
                                       
                                        @foreach ($seller_products_short as $key_user => $each_seller_products_short)
                                            @php
                                                $total_short_product = 0;
                                                $shipping_fee = 0;
                                                $final_total_short = 0;
                                            @endphp
                                            <div class="checkout-product-card bg-white p-3 p-lg-4 text-left rounded">
                                                <div class="mb-4">
                                                    <!-- Headers -->
                                                    <div class="row gutters-5 d-none d-lg-flex border-bottom mb-3 text-secondary fs-12 header_table checkout-cart-header" >
                                                        <div class="col-md-5 fw-600 text_cart_details pl-lg-3">{{ translate('Product - ')}} {{ optional(\App\Models\Shop::where('user_id', $key_user)->first())->name ?? optional(\App\Models\User::find($key_user))->name ?? translate('Official Store') }}</div>
                                                        <div class="col-md-3 fw-600 text_cart_details text-lg-center">{{ translate('Qty')}}</div>
                                                        @if(Auth::user()->user_type === 'enterprise')
                                                        <div class="col-md-2 fw-600 text_cart_details text-lg-center">{{ translate('Order Date')}}</div>
                                                        @endif
                                                        <div class="col-md-4 fw-600 text_cart_details text-lg-right pr-lg-3">{{ translate('Total')}}</div>
                                                    </div>
                                                    <!-- Cart Items -->
                                                    <ul class="list-group list-group-flush">
                                                        
                                                        @foreach ($carts_short_shelf_life as $key => $carts_short_shelf_lifeItem)
                                                            @php
                                                                $product = \App\Models\Products::find($carts_short_shelf_lifeItem['product_id']);
                                                                $user = \App\Models\Shop::where('user_id', $key)->first();
                                                                $product_stock = $product->product_stock->where('variant', preg_replace('/\s+/', '',$carts_short_shelf_lifeItem['variation']))->first();
                                                                // $product_stock = $product->stocks()->get();
                                                                // dd($product_stock);
                                                                // $total = $total + ($cartItem['price']  + $cartItem['tax']) * $cartItem['quantity'];
                                                                // $total_short_product = $total_short_product + cart_product_price($carts_short_shelf_lifeItem, $product, false) * $carts_short_shelf_lifeItem['quantity'];
                                                                
                                                                if(Auth::user()->user_type == "enterprise")
                                                                {
                                                                    $total_short_product =  $total_short_product + (cart_product_price($carts_short_shelf_lifeItem, $product, false) * $carts_short_shelf_lifeItem['quantity']);
                                                                }
                                                                else {
                                                                    $total_short_product = $total_short_product + (cart_product_price($carts_short_shelf_lifeItem, $product, false) * $carts_short_shelf_lifeItem['quantity']);
                                                                }
                                                                // var_dump()
                                                                // print_r('price is'.$total_short_product);
                                                                $final_total_short = $total_short_product+$shipping_fee;
                                                                $product_name_with_choice = $product->name;
                                                                if ($carts_short_shelf_lifeItem['variation'] != null) {
                                                                    $product_name_with_choice = $product->name.' - '.$carts_short_shelf_lifeItem['variation'];
                                                                }
                                                            @endphp
                                                            @if($product->user_id ==  $key_user)
                                                                <li class="list-group-item px-0 checkout-cart-line">
                                                                    <div class="row gutters-5 checkout-cart-line__row align-items-lg-center">
                                                                        
                                                                        <!-- Product Image & name -->
                                                                        <div class="col-md-5 col-12 d-flex align-items-center checkout-col-product mb-3 mb-lg-0">
                                                                            <span class="mr-3 ml-0 flex-shrink-0">
                                                                                <img src="{{ uploaded_asset($product->thumbnail_img) }}"
                                                                                    class="img-fit checkout-cart-thumb"
                                                                                    style="width:80px;height:80px;object-fit:cover;"
                                                                                    alt="{{ $product->name  }}"
                                                                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                                                            </span>
                                                                            <div class="d-flex flex-column">
                                                                                <span class="fs-14 fw-600 checkout-cart-product-name" style="line-height:1.4;color:#222;">{{ $product_name_with_choice }}</span>
                                                                                @if($product->unit)
                                                                                    <span class="fs-12 mt-1" style="color:#888;">Dung tích: {{ $product->unit }}</span>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                        <!-- Quantity -->
                                                                        <div class="col-md-3 col-6 order-1 order-lg-0 checkout-col-qty">
                                                                            <span class="checkout-cart-mob-label d-lg-none">{{ translate('Qty') }}</span>
                                                                            @if ($carts_short_shelf_lifeItem['digital'] != 1 && $product->auction_product == 0)
                                                                                <div class="d-flex flex-column align-items-start align-items-lg-center aiz-plus-minus mr-2 ml-0 w-100">
                                                                                   
                                                                                    <input type="number" name="quantity[{{ $carts_short_shelf_lifeItem['id'] }}]"
                                                                                        class="col border-0 text-left text-lg-center px-0 flex-grow-1 fs-14 input-number quantity_product checkout-qty-input"
                                                                                        placeholder="1" value="{{ $carts_short_shelf_lifeItem['quantity'] }}"
                                                                                        min="{{ $product->min_qty }}"
                                                                                        max="{{ $product_stock->qty }}"
                                                                                        onchange="updateQuantity({{ $carts_short_shelf_lifeItem['id'] }}, this)" style="padding-left:0.75rem !important;">
                                                                                    
                                                                                </div>
                                                                            @endif
                                                                        </div>

                                                                        @if(Auth::user()->user_type === "enterprise")
                                                                            <div class="col-md-2 col-12 order-5 order-lg-0 checkout-col-date my-2 my-lg-0">
                                                                                @if(count($carts_short_shelf_lifeItem->shipping_date)>0)
                                                                                    @foreach ($carts_short_shelf_lifeItem->shipping_date as $date)
                                                                                        <span class="fw-700 fs-14">{{$date}}</span>
                                                                                    @endforeach
                                                                                @endif
                                                                            </div>
                                                                        @endif
                                                                        <!-- Total -->
                                                                        <div class="col-md-4 col-12 order-4 order-lg-0 checkout-col-total my-3 my-lg-0">
                                                                            <span class="opacity-60 fs-12 d-block d-lg-none">{{ translate('Total')}}</span>
                                                                            @if(Auth::user()->user_type === "enterprise")
                                                                                <span class="fw-700 fs-16 text-primary total_product">{{ single_price(cart_product_price($carts_short_shelf_lifeItem, $product, false) * $carts_short_shelf_lifeItem['quantity'] ) }}</span><br>
                                                                                <small style="color: red;font-weight: 900">This Price Is Total Price For All Order Date</small>
                                                                            @else   
                                                                                <span class="fw-700 fs-16 text-primary total_product">{{ single_price(cart_product_price($carts_short_shelf_lifeItem, $product, false) * $carts_short_shelf_lifeItem['quantity']) }}</span>
                                                                            @endif
                                                                            
                                                                        </div>
                                                                        
                                                                    </div>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="delivery_type checkout-delivery-section mb-4">
                                                <div class="checkout-delivery-heading">{{ translate('Select delivery type') }}</div>
                                                @foreach($carrier_list as $carrier_key => $carrier)
                                                    @php
                                                        $carrier_range_first_short = $carrier->carrier_ranges->first();
                                                        $is_carrier_free_short = (int) ($carrier->free_shipping ?? 0) === 1;
                                                        $data_shipping_short = $is_carrier_free_short ? 'free_shipping' : optional($carrier_range_first_short)->billing_type;
                                                    @endphp
                                                    @if(optional($carrier_range_first_short)->billing_type == 'fast_shipping' || $is_carrier_free_short)
                                                        <div class="checkout-delivery-option">
                                                        
                                                            <input onclick="handleClick_short(this);" class="radio_button_checkout_short checkout-delivery-radio" type="radio" id="shipping_fee_short_{{ $key_user }}" data_cart="short_product" data_id="{{$carrier->id}}" name="shipping_fee_short_{{ $key_user }}" value="{{ carrier_base_price($carts_short_shelf_life, $carrier->id, $key_user) }}" data-shipping="{{ $data_shipping_short }}"/>
                                                            @if($is_carrier_free_short)
                                                                <span class="delivery_type checkout-delivery-label mb-0">{{ $carrier->name }} — {{ translate('Free shipping') }}</span>
                                                            @else
                                                                <span class="delivery_type checkout-delivery-label mb-0">{{ $carrier->name }} (2 hour)</span>
                                                            @endif
                                                            <span class="price_shipping checkout-delivery-price">{{ single_price(carrier_base_price($carts_short_shelf_life, $carrier->id, $key_user)) }}</span>
                                                            <input type="radio" name="carrier_id_{{ $key_user }}" value="{{$carrier->id}}" checked="" style="display: none">
                                                        </div>
                                                    @endif
                                                    
                                                @endforeach
                                            </div>
                                            @if(Auth::user()->user_type == "enterprise")
                                            <i class="fa fa-exclamation" style="font-size: 12px;color: red;margin-left:13px" aria-hidden="true">
                                                <span style="">That Shipping Price Apply For Each Of Order Date You Send In Request
                                                </span>
                                            </i>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                                
                                <div class="payment_option card rounded-0 border shadow-none">
                                    <!-- Additional Info -->
                                    

                                    <div class="card-header p-4 border-bottom-0 payment_select" style="">
                                        <span style="font-size:22px;color:#2E7F25;"><i class="fas fa-wallet"></i></span>
                                        <span class="select_payment_option" style="
                                            font-family: 'Quicksand',sans-serif !important;
                                            font-size: 22px !important;
                                            font-weight: 700 !important;
                                        ">
                                            Phương thức thanh toán
                                        </span>
                                    </div>
                                    <!-- Payment Options -->
                                    <div class="card-body pt-0">
                                        <div class="checkout-payment-options">
                                            
                                            <!-- Cash Payment -->
                                            @php
                                                $digital = 0;
                                                $cod_on = 1;
                                            @endphp
                                            @if ($digital != 1 && $cod_on == 1)
                                                <label class="checkout-payment-card" id="payment-card-cod">
                                                    <input value="cash_on_delivery" class="online_payment checkout-payment-card__radio"
                                                        type="radio" name="payment_option" checked>
                                                    <div class="checkout-payment-card__body">
                                                        <span class="checkout-payment-card__icon">💵</span>
                                                        <div class="checkout-payment-card__info">
                                                            <span class="checkout-payment-card__title">Thanh toán khi nhận hàng</span>
                                                            <span class="checkout-payment-card__desc">Trả tiền mặt khi nhận hàng (COD)</span>
                                                        </div>
                                                        <span class="checkout-payment-card__check"><i class="fas fa-check-circle"></i></span>
                                                    </div>
                                                </label>
                                            @endif
                                            <label class="checkout-payment-card" id="payment-card-bank">
                                                <input value="bank_payment" type="radio"
                                                    name="payment_option" class="offline_payment_option checkout-payment-card__radio"
                                                    onchange="toggleManualPaymentData(1)"
                                                    data-id="1">
                                                <div class="checkout-payment-card__body">
                                                    <span class="checkout-payment-card__icon">🏦</span>
                                                    <div class="checkout-payment-card__info">
                                                        <span class="checkout-payment-card__title">Chuyển khoản ngân hàng</span>
                                                        <span class="checkout-payment-card__desc">Chuyển khoản qua tài khoản ngân hàng</span>
                                                    </div>
                                                    <span class="checkout-payment-card__check"><i class="fas fa-check-circle"></i></span>
                                                </div>
                                            </label>
                                        </div>
                                            
                                            <div id="manual_payment_info_1" class="d-none">
                                                <h5>
                                                    <span style="font-weight: bolder;">Hướng dẫn tải hình ảnh chứng từ chuyển khoản</span>
                                                </h5>
                                                <div>
                                                    <br>
                                                </div>
                                                <div>
                                                    Để đảm bảo đơn hàng của bạn được xử lý, vui lòng làm theo các bước sau:
                                                </div>
                                                <div>
                                                    <br>    
                                                </div>
                                                <div>
                                                    <span style="font-weight: bolder;">Tải lên chứng từ chuyển khoản:</span>&nbsp;
                                                    Tải lên hình ảnh chứng từ chuyển khoản rõ ràng, hiển thị chi tiết giao dịch của đơn hàng.
                                                </div>
                                                <div>
                                                    <br>
                                                </div>
                                                <div>
                                                    <span style="font-weight: bolder;">Quá trình xác thực:&nbsp;</span>
                                                    Đội ngũ của chúng tôi sẽ xác thực chứng từ trước khi xử lý đơn hàng.
                                                </div>
                                                <div><br></div>
                                                <div>
                                                    <span style="font-weight: bolder;">Vấn đề chính xác:&nbsp;</span>
                                                    Đảm bảo hình ảnh chứng từ trùng khớp với số tiền đơn hàng; Sai số có thể dẫn đến đơn hàng bị trì hoãn.
                                                </div>
                                                <div><br></div>
                                                <div>
                                                    <span style="font-weight: bolder;">Tránh từ chối:&nbsp;</span>
                                                    Tải lên hình ảnh không liên quan sẽ dẫn đến tự động từ chối đơn hàng.
                                                </div>
                                                <div><br></div>
                                                <div>
                                                    Cần hỗ trợ? Vui lòng liên hệ với chúng tôi để được hỗ trợ.
                                                </div>
                                                <div>
                                                    <br style="color: rgb(121, 121, 121); font-family: Roboto, sans-serif; font-size: 14px; letter-spacing: -0.0056px;">
                                                </div>                                                                                                                            
                                                <ul>
                                                    <li>
                                                        Tên ngân hàng: Vietcombank <br>
                                                        Tên tài khoản: Tester<br>
                                                        Số tài khoản: 09125125819235<br>
                                                        Số routing: 2147483647
                                                    </li>
                                                </ul>
                                             </div>
                                            <div class="d-none mb-3 rounded border bg-white p-3 text-left">
                                                <div id="manual_payment_description" class="manual_payment_description">
    
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label class="text_trans">{{ translate('Transaction ID') }} <span
                                                            class="text-danger">*</span></label>
                                                        <input type="text" class="form-control mb-3" name="trx_id"
                                                            id="trx_id" placeholder="{{ translate('Transaction ID') }}"
                                                            required>
                                                    </div>
                                                    <div class="col-md-6">
                                                    <label class="text_trans">{{ translate('Screen Shot') }}</label>
                                                    <div class="input-group" data-toggle="aizuploader" data-type="image"
                                                        data-multiple="true">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                                {{ translate('Browse') }}</div>
                                                        </div>
                                                        <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                                    
                                                            <input type="hidden" name="photo" id="photo_checking "class="selected-files">
                                                        </div>
                                                        <div class="file-preview box sm">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            
                                        </div>
                                        
                                        <!-- Offline Payment Fields -->
                                        <!-- Offline Payment -->
                                       
                                    

                                       
                                    </div>

                                    <!-- Agree Box -->
                                    <div class="checkout-terms-box">
                                        <label class="checkout-terms-label">
                                            <input type="checkbox" required id="agree_checkbox" class="checkout-terms-checkbox">
                                            <span class="checkout-terms-checkmark"></span>
                                            <span class="checkout-terms-text">
                                                Tôi đồng ý với
                                                <a href="" class="checkout-terms-link">điều khoản sử dụng</a>,
                                                <a href="" class="checkout-terms-link">chính sách đổi trả</a> &
                                                <a href="" class="checkout-terms-link">chính sách bảo mật</a>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            
                        </div>
                       
                        <div class="col-lg-12" style="margin-top: 90px;">
                            <div class="checkout-summary-card">
                                <div class="checkout-summary-heading">
                                    <span style="font-size:18px;color:#1b1b28;"><i class="fas fa-receipt"></i></span>
                                    <span style="font-family:'Quicksand',sans-serif;font-weight:700;font-size:18px;">Tóm tắt đơn hàng</span>
                                </div>
                                <div class="mb-4">
                                    @php
                                        
                                        $total_all = $total_normal_product + $total_short_product;
                                        $final_all = $final_total_normal + $final_total_short;
                                    @endphp
                                    <div class="px-0 py-2 mb-3 d-flex justify-content-between">
                                        <span class="opacity-60 fs-14 price_product_cart_details">Tạm tính</span>
                                        <span class="fw-700 fs-16">{{ single_price($total_all) }}</span>
                                    </div>
                                    <div class="px-0 py-2 mb-3 d-flex justify-content-between">
                                        <span class="opacity-60 fs-14 price_product_cart_details">Phí vận chuyển</span>
                                        <span class="fw-700 fs-16" id="shipping_fee_view">{{single_price($shipping_fee)}}</span>
                                    </div>
                                    <div class="px-0 py-3 mb-4 border-top d-flex justify-content-between" style="align-items:center">
                                        <span class="fw-600 fs-16" style="color:#222;">Tổng cộng</span>
                                        <span class="fw-700 fs-20 final_price" id="total_price" >{{ single_price($final_all) }}</span>
                                        <input type="hidden" id="final_price" value="{{$total_all }}">
                                    </div>
                                </div>
                                <button type="submit" class="checkout-submit-btn" onclick="submitOrder(this)">
                                    <i class="fas fa-lock mr-2" style="font-size:14px;"></i> Đặt hàng
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
        </div>
    </section>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $(".online_payment").click(function() {
                $('#manual_payment_description').parent().addClass('d-none');
            });
            toggleManualPaymentData($('input[name=payment_option]:checked').data('id'));
        });

        
        function submitOrder(el) {
            $(el).prop('disabled', true);
            if ($('#agree_checkbox').is(":checked")) {
                if($('.offline_payment_option').is(":checked"))
                {
                    if ($('#trx_id').val() == '') {
                        AIZ.plugins.notify('danger', '{{ translate('You need to put Transaction id') }}');
                        $(el).prop('disabled', false);
                    }
                    else 
                    {
                        var image = $('.selected-files').val();
                        if(image.length != 0)
                        {
                            $('#final_checkout_form').submit();
                        }
                        else
                        {
                            AIZ.plugins.notify('danger', '{{ translate('You need to upload bank receipt') }}');
                            $(el).prop('disabled', false);
                        }
                    }
                }
                else
                {
                    $('#final_checkout_form').submit();
                }
                
            } else {
                AIZ.plugins.notify('danger', '{{ translate('You need to agree with our policies') }}');
                $(el).prop('disabled', false);
            }
        }

        function toggleManualPaymentData(id) {
            if (typeof id != 'undefined') {
                $('#manual_payment_description').parent().removeClass('d-none');
                $('#manual_payment_description').html($('#manual_payment_info_' + id).html());
            }
        }

        $("input:checkbox").on('click', function() {
        // in the handler, 'this' refers to the box clicked on
        var $box = $(this);
        if ($box.is(":checked")) {
            // the name of the box is retrieved using the .attr() method
            // as it is assumed and expected to be immutable
            var group = "input:checkbox[name='" + $box.attr("name") + "']";
            // the checked state of the group/box on the other hand will change
            // and the current value is retrieved using .prop() method
            $(group).prop("checked", false);
            $box.prop("checked", true);
        } else {
            $box.prop("checked", false);
        }
        });

      
        
        function handleClick(myRadio) {
            
            var total_shipping = 0 ;
            var data_id = 0 ;
            var shipping = "";
            var type_cart = "";
            var final_price = $('#final_price').val();
            var data_id_seller = myRadio.name.replace('shipping_fee_','');  
            $("input.radio_button_checkout:checked").each(function() {
                total_shipping = 0;
                type_cart = ($(this).attr("data_cart"))
                var value = $(this).val();
                shipping = $(this).attr("data-shipping");
                data_id = $(this).attr("data_id");
                total_shipping = total_shipping + parseInt(value);
            });
            $.ajax
                ({
                    url: "{{route('checkout.update_total_shipping_fee')}}",
                    method:'post',
                    data:{
                        total_shipping:total_shipping,
                        final_price:final_price,
                        data_id_seller:data_id_seller,
                        shipping_type:shipping,
                        type_cart:type_cart,
                        data_id:data_id,
                    },
                    headers: {
                        'X-CSRF-Token': '{{ csrf_token() }}',
                    },
                    success: function(data){
                        $("#total_price").html(data.total_price);
                        $("#shipping_fee_view").html(data.shipping_price);
                    }, 
                    error: function(){
                        
                    }
                });
        }

        function handleClick_short(myRadio) {
            
            var total_shipping = 0 ;
            var shipping = "";
            var type_cart = "";
            var final_price = $('#final_price').val();
            var data_id = 0 ;
            if(myRadio.name.includes('short'))
            {
                var data_id_seller = myRadio.name.replace('shipping_fee_short_','');  
            }
            else
            {
                var data_id_seller = myRadio.name.replace('shipping_fee_','');  
            }
            
            $("input.radio_button_checkout_short:checked").each(function() {
                total_shipping = 0;
                type_cart = ($(this).attr("data_cart"))
                var value = $(this).val();
                shipping = $(this).attr("data-shipping");
                data_id = $(this).attr("data_id");
                total_shipping = total_shipping + parseInt(value);
            });
            $.ajax
                ({
                    url: "{{route('checkout.update_total_shipping_fee')}}",
                    method:'post',
                    data:{
                        total_shipping:total_shipping,
                        final_price:final_price,
                        data_id_seller:data_id_seller,
                        shipping_type:shipping,
                        type_cart:type_cart,
                        data_id:data_id,
                    },
                    headers: {
                        'X-CSRF-Token': '{{ csrf_token() }}',
                    },
                    success: function(data){
                        $("#total_price").html(data.total_price);
                        $("#shipping_fee_view").html(data.shipping_price);
                    }, 
                    error: function(){
                        
                    }
                });
        }
    </script>
@endsection
