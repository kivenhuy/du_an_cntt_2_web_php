@extends('user_layout.layouts.app')

@section('content')

    <!-- Payment Info -->
    <section class="mb-4">
        <div class="container" style="max-width:1200px !important;width: 100%">
            <form action="{{route('checkout')}}" id="final_checkout_form" class="form-default" role="form" method="POST"  id="checkout-form">
            @csrf
                    <div class="row" style="margin-top: 24px;">
                        <div class="col-lg-9">
                                
                                @if(!($carts_normal->isEmpty()))
                                    <input type="hidden" name="owner_id" value="{{ $carts_normal[0]['owner_id'] }}">
                                @else
                                    <input type="hidden" name="owner_id" value="{{ $carts_short_shelf_life[0]['owner_id'] }}">
                                @endif
                                
                                <input type="hidden" id="total_shipping_price" name="total_shipping_price" value="0">
                                <div class="header_checkout_div">
                                    <div style="margin-bottom:48px ">
                                        <span class="header_checkout">Checkout</span>
                                    </div>
                                </div>
                                <div class="col-xxl-12 col-xl-12 mx-auto" style="padding-left: unset;padding-right: unset;margin-bottom: 2rem">
                                    <div>
                                        <i class="fas fa-shipping-fast" style="font-size: 24px;">
                                            <span style="
                                            font-family: 'Quicksand',sans-serif !important;
                                            font-size: 24px !important;
                                            font-weight: 700 !important;
                                            line-height: 32px;
                                            letter-spacing: -0.0004em;
                                            text-align: left;
                                            margin-left: 10px ;
                                            
                                            ">Products & Delivery</span>
                                        </i>
                                    </div>
                                    <!-- Seller Products -->
                                    <div style=" margin-top:1rem;">
                                        <span style="
                                            font-family: 'Quicksand',sans-serif !important;
                                            font-size: 24px !important;
                                            font-weight: 700 !important;
                                            line-height: 32px;
                                            letter-spacing: -0.0004em;
                                            text-align: left;
                                            margin-left: 10px ;
                                            ">Normal Products
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
                                            <div class=" bg-white p-3 p-lg-4 text-left">
                                                <div class="mb-4">
                                                    <!-- Headers -->
                                                    <div class="row gutters-5 d-none d-lg-flex border-bottom mb-3 text-secondary fs-12 header_table" >
                                                        <div class="col-md-3 fw-600 text_cart_details" style="position: relative;left:32px">{{ translate('Product - ')}} {{ \App\Models\Shop::where('user_id', $key_user)->first()->name }}</div>
                                                        <div class="col col-md-2 fw-600 text_cart_details">{{ translate('Qty')}}</div>
                                                        <div class="col col-md-1 fw-600 text_cart_details">{{ translate('Unit')}}</div>
                                                        @if(Auth::user()->user_type === 'enterprise')
                                                        <div class="col col-md-2 fw-600 text_cart_details">{{ translate('Order Date')}}</div>
                                                        @endif
                                                       
                                                        <div class="col  col-md-4 fw-600 text_cart_details" >{{ translate('Total')}}</div>
                                                        
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
                                                                    $total_normal_product =  $total_normal_product + (cart_product_price($cartItem, $product, false) * $cartItem['quantity']) * count($cartItem->shipping_date);
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
                                                                <li class="list-group-item px-0">
                                                                    <div class="row gutters-5 align-items-center">
                                                                        
                                                                        <!-- Product Image & name -->
                                                                        <div class="col-md-3 d-flex align-items-center mb-2 mb-md-0">
                                                                            <span class="mr-2 ml-0">
                                                                                <img src="{{ uploaded_asset($product->thumbnail_img) }}"
                                                                                    class="img-fit size-70px"
                                                                                    alt="{{ $product->name  }}"
                                                                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                                                            </span>
                                                                            <span class="fs-14 text_name_product">{{ $product_name_with_choice }}</span>
                                                                        </div>
                                                                        <!-- Quantity -->
                                                                        <div class="col-md-2 col order-1 order-md-0">
                                                                            @if ($cartItem['digital'] != 1 && $product->auction_product == 0)
                                                                                <div class="d-flex flex-column align-items-start aiz-plus-minus mr-2 ml-0">
                                                                                   
                                                                                    <input type="number" name="quantity[{{ $cartItem['id'] }}]"
                                                                                        class="col border-0 text-left px-0 flex-grow-1 fs-14 input-number quantity_product"
                                                                                        placeholder="1" value="{{ $cartItem['quantity'] }}"
                                                                                        min="{{ $product->min_qty }}"
                                                                                        max="{{ $product_stock->qty }}"
                                                                                        onchange="updateQuantity({{ $cartItem['id'] }}, this)" style="padding-left:0.75rem !important;">
                                                                                    
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                        <!-- Price -->
                                                                        <div class="col-md-1 col-4 order-2 order-md-0 my-3 my-md-0" style="max-width:130px !important">
                                                                            <span class="unit_product">{{$product->unit}}</span>
                                                                        </div>
                                                                        
                                                                        <!-- Tax -->
                                                                       
                                                                        @if(Auth::user()->user_type === "enterprise")
                                                                            <div class="col-md-2 col-4 order-5 order-md-0 my-3 my-md-0">
                                                                                @if(count($cartItem->shipping_date)>0)
                                                                                    @foreach ($cartItem->shipping_date as $date)
                                                                                        <span class="fw-700 fs-14">{{$date}}</span>
                                                                                    @endforeach
                                                                                @endif
                                                                            </div>
                                                                        @endif
                                                                        <!-- Total -->
                                                                        <div class="col-md-4 col-5 order-4 order-md-0 my-3 my-md-0">
                                                                            <span class="opacity-60 fs-12 d-block d-md-none">{{ translate('Total')}}</span>
                                                                            @if(Auth::user()->user_type === "enterprise")
                                                                                <span class="fw-700 fs-16 text-primary total_product" style="">{{ single_price(cart_product_price($cartItem, $product, false) * $cartItem['quantity'] * count($cartItem['shipping_date'])) }}</span><br>
                                                                                <small style="color: red;font-weight: 900">This Price Is Total Price For All Order Date</small>
                                                                            @else   
                                                                                <span class="fw-700 fs-16 text-primary total_product" style="">{{ single_price(cart_product_price($cartItem, $product, false) * $cartItem['quantity']) }}</span><br>
                                                                            @endif
                                                                        </div>
                                                                        
                                                                    </div>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                            <div style="margin-bottom: 16px;" class="delivery_type">
                                                Select Delivery Type:
                                                @foreach($carrier_list as $carrier_key => $carrier)
                                                    <div style="margin-bottom: 1rem;display: flex;align-items: center">
                                                       
                                                        <input onclick="handleClick(this);" class="radio_button_checkout" type="radio" id="shipping_fee_{{ $key_user }}" data_cart="normal_product" data_id="{{$carrier->id}}" name="shipping_fee_{{ $key_user }}" value="{{carrier_base_price($carts_normal, $carrier->id, $key_user)}}" data-shipping="{{$carrier->carrier_ranges->first()->billing_type}}"/>
                                                        @if($carrier->carrier_ranges->first()->billing_type == 'weight_based')
                                                            <span for="shipping_fee" class="delivery_type">{{ $carrier->name }}</span>
                                                        @else
                                                            <span for="shipping_fee" class="delivery_type">{{ $carrier->name }} (2 hour)</span>
                                                        @endif
                                                        <div style="position: relative;left: 16px;">
                                                            <span class="price_shipping">{{ single_price(carrier_base_price($carts_normal, $carrier->id, $key_user)) }}</span>
                                                        </div>
                                                        <input type="radio" name="carrier_id_{{ $key_user }}" value="{{$carrier->id}}" checked="" style="display: none">
                                                    </div>
                                                    
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


                                    <div style=" margin-top:1rem;">
                                        <span style="
                                            font-family: 'Quicksand',sans-serif !important;
                                            font-size: 24px !important;
                                            font-weight: 700 !important;
                                            line-height: 32px;
                                            letter-spacing: -0.0004em;
                                            text-align: left;
                                            margin-left: 10px ;
                                           
                                            ">Short Shelf Life Products
                                        </span>
                                    </div>
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
                                            <div class=" bg-white p-3 p-lg-4 text-left">
                                                <div class="mb-4">
                                                    <!-- Headers -->
                                                    <div class="row gutters-5 d-none d-lg-flex border-bottom mb-3 text-secondary fs-12 header_table" >
                                                        <div class="col-md-3 fw-600 text_cart_details" style="position: relative;left:32px">{{ translate('Product - ')}} {{ \App\Models\Shop::where('user_id', $key_user)->first()->name }}</div>
                                                        <div class="col col-md-2 fw-600 text_cart_details">{{ translate('Qty')}}</div>
                                                        <div class="col-md-1  fw-600 text_cart_details">{{ translate('Unit')}}</div>
                                                        @if(Auth::user()->user_type === 'enterprise')
                                                        <div class="col col-md-2 fw-600 text_cart_details">{{ translate('Order Date')}}</div>
                                                        @endif
                                                        
                                                        <div class="col-md-4 fw-600 text_cart_details" >{{ translate('Total')}}</div>
                                                        
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
                                                                    $total_short_product =  $total_short_product + (cart_product_price($carts_short_shelf_lifeItem, $product, false) * $cartItem['quantity']) * count($carts_short_shelf_lifeItem->shipping_date);
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
                                                                <li class="list-group-item px-0">
                                                                    <div class="row gutters-5 align-items-center">
                                                                        
                                                                        <!-- Product Image & name -->
                                                                        <div class="col-md-3 d-flex align-items-center mb-2 mb-md-0">
                                                                            <span class="mr-2 ml-0">
                                                                                <img src="{{ uploaded_asset($product->thumbnail_img) }}"
                                                                                    class="img-fit size-70px"
                                                                                    alt="{{ $product->name  }}"
                                                                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                                                            </span>
                                                                            <span class="fs-14 text_name_product">{{ $product_name_with_choice }}</span>
                                                                        </div>
                                                                        <!-- Quantity -->
                                                                        <div class="col-md-2 col order-1 order-md-0">
                                                                            @if ($carts_short_shelf_lifeItem['digital'] != 1 && $product->auction_product == 0)
                                                                                <div class="d-flex flex-column align-items-start aiz-plus-minus mr-2 ml-0">
                                                                                   
                                                                                    <input type="number" name="quantity[{{ $carts_short_shelf_lifeItem['id'] }}]"
                                                                                        class="col border-0 text-left px-0 flex-grow-1 fs-14 input-number quantity_product"
                                                                                        placeholder="1" value="{{ $carts_short_shelf_lifeItem['quantity'] }}"
                                                                                        min="{{ $product->min_qty }}"
                                                                                        max="{{ $product_stock->qty }}"
                                                                                        onchange="updateQuantity({{ $carts_short_shelf_lifeItem['id'] }}, this)" style="padding-left:0.75rem !important;">
                                                                                    
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                        <!-- Price -->
                                                                        <div class="col-md-1 col-4 order-2 order-md-0 my-3 my-md-0" style="max-width:130px !important">
                                                                            <span class="unit_product">{{$product->unit}}</span>
                                                                        </div>

                                                                        @if(Auth::user()->user_type === "enterprise")
                                                                            <div class="col-md-2 col-4 order-5 order-md-0 my-3 my-md-0">
                                                                                @if(count($carts_short_shelf_lifeItem->shipping_date)>0)
                                                                                    @foreach ($carts_short_shelf_lifeItem->shipping_date as $date)
                                                                                        <span class="fw-700 fs-14">{{$date}}</span>
                                                                                    @endforeach
                                                                                @endif
                                                                            </div>
                                                                        @endif
                                                                        <!-- Total -->
                                                                        <div class="col-md-4 col-5 order-4 order-md-0 my-3 my-md-0">
                                                                            <span class="opacity-60 fs-12 d-block d-md-none">{{ translate('Total')}}</span>
                                                                            @if(Auth::user()->user_type === "enterprise")
                                                                                <span class="fw-700 fs-16 text-primary total_product" style="">{{ single_price(cart_product_price($carts_short_shelf_lifeItem, $product, false) * $carts_short_shelf_lifeItem['quantity'] * count($carts_short_shelf_lifeItem['shipping_date'])) }}</span><br>
                                                                                <small style="color: red;font-weight: 900">This Price Is Total Price For All Order Date</small>
                                                                            @else   
                                                                                <span class="fw-700 fs-16 text-primary total_product" style="">{{ single_price(cart_product_price($carts_short_shelf_lifeItem, $product, false) * $carts_short_shelf_lifeItem['quantity']) }}</span><br>
                                                                            @endif
                                                                            
                                                                        </div>
                                                                        
                                                                    </div>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                            <div style="margin-bottom: 34px;" class="delivery_type">
                                                Select Delivery Type:
                                                @foreach($carrier_list as $carrier_key => $carrier)
                                                    @if($carrier->carrier_ranges->first()->billing_type == 'fast_shipping')
                                                        <div style="margin-bottom: 1rem;display: flex;align-items: center">
                                                        
                                                            <input onclick="handleClick_short(this);" class="radio_button_checkout_short" type="radio" id="shipping_fee_{{ $key_user }}" data_cart="short_product" data_id="{{$carrier->id}}" name="shipping_fee_{{ $key_user }}" value="{{carrier_base_price($carts_short_shelf_life, $carrier->id, $key_user)}}" data-shipping="{{$carrier->carrier_ranges->first()->billing_type}}"/>
                                                            
                                                                <span for="shipping_fee" class="delivery_type">{{ $carrier->name }} (2 hour)</span>
                                                            
                                                            <div style="position: relative;left: 16px;">
                                                                <span class="price_shipping">{{ single_price(carrier_base_price($carts_short_shelf_life, $carrier->id, $key_user)) }}</span>
                                                            </div>
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
                                    

                                    <div class="card-header p-4 border-bottom-0">
                                        <i class="fa fa-credit-card" aria-hidden="true" style="font-size: 24px">
                                            <span class="select_payment_option" style="margin-left: 8px;">
                                                {{ translate('Payment Method') }}
                                            </span>
                                        </i>
                                    </div>
                                    <!-- Payment Options -->
                                    <div class="card-body text-center px-4 pt-0">
                                        <div class="row gutters-10">
                                            
                                            <!-- Cash Payment -->
                                            @php
                                                $digital = 0;
                                                $cod_on = 1;
                                            @endphp
                                            @if ($digital != 1 && $cod_on == 1)
                                                <div class="col-6 col-xl-4 col-md-4" style="max-width: 221px !important">
                                                    <label class="aiz-megabox d-block mb-3">
                                                        <input value="cash_on_delivery" class="online_payment"
                                                            type="radio" name="payment_option" checked>
                                                        <span class="d-block aiz-megabox-elem rounded-0 p-3">
                                                            {{-- <img src="{{ static_asset('assets/img/cards/cod.png') }}"
                                                                class="img-fit mb-2"> --}}
                                                            <span class="d-block text-center">
                                                                <span
                                                                    class="d-block fw-600 fs-15 text_method">{{ translate('Cash on Delivery') }}</span>
                                                            </span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endif
                                            
                                            <div class="col-6 col-xl-3 col-md-4">
                                                <label class="aiz-megabox d-block mb-3">
                                                    <input value="bank_payment" type="radio"
                                                        name="payment_option" class="offline_payment_option"
                                                        onchange="toggleManualPaymentData(1)"
                                                        data-id="1">
                                                    <span class="d-block aiz-megabox-elem rounded-0 p-3">
                                                        
                                                        <span class="d-block text-center">
                                                            <span
                                                                class="d-block fw-600 fs-15 text_method">Bank transfer
                                                            </span>
                                                        </span>
                                                    </span>
                                                </label>
                                            </div>
                                        
                                            <div id="manual_payment_info_1" class="d-none">
                                                <h5>
                                                    <span style="font-weight: bolder;">Guidline Upload Your Bank Transfer Receipt</span>
                                                </h5>
                                                <div>
                                                    <br>
                                                </div>
                                                <div>
                                                    To ensure your order setup is shared, please follow these steps:
                                                </div>
                                                <div>
                                                    <br>
                                                </div>
                                                <div>
                                                    <span style="font-weight: bolder;">Upload relevant receipts:</span>&nbsp;
                                                    Upload a clear bank receipt showing the exact transaction details for your order.
                                                </div>
                                                <div>
                                                    <br>
                                                </div>
                                                <div>
                                                    <span style="font-weight: bolder;">Verification process:&nbsp;</span>
                                                    Our team will verify receipts before processing your order.
                                                </div>
                                                <div><br></div>
                                                <div>
                                                    <span style="font-weight: bolder;">Exact problem:&nbsp;</span>
                                                    Make sure the uploaded receipt matches the order amount; Inaccuracies may cause delays.
                                                </div>
                                                <div><br></div>
                                                <div>
                                                    <span style="font-weight: bolder;">Avoid rejection:&nbsp;</span>
                                                    Uploading irrelevant files will result in automatic order rejection..
                                                </div>
                                                <div><br></div>
                                                <div>
                                                    Need help? Please contact our support for assistance.
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
                                    <div class="pt-3 px-4 fs-14">
                                        <label class="aiz-checkbox">
                                            <input type="checkbox" required id="agree_checkbox">
                                            <span class="aiz-square-check"></span>
                                            <span>{{ translate('I agree to the') }}</span>
                                        </label>
                                        <a href="" class="fw-700">{{ translate('terms and conditions') }}</a>,
                                        <a href="" class="fw-700">{{ translate('return policy') }}</a> &
                                        <a href="" class="fw-700">{{ translate('privacy policy') }}</a>
                                    </div>
                                </div>
                            
                        </div>
                       
                        <div class="col-lg-3" style="margin-top: 90px;">
                            <div class="border bg-white p-3 p-lg-4 text-left">
                                <div class="mb-4">
                                    @php
                                        $total_all = $total_normal_product + $total_short_product;
                                        $final_all = $final_total_normal + $final_total_short;
                                    @endphp
                                    <div class="px-0 py-2 mb-4  d-flex justify-content-between">
                                        <span class="opacity-60 fs-14 price_product_cart_details">Subtotal</span>
                                        <span class="fw-700 fs-16">{{ single_price($total_all) }}</span>
                                    </div>
                                    <div class="px-0 py-2 mb-4  d-flex justify-content-between">
                                        <span class="opacity-60 fs-14 price_product_cart_details">Shipping</span>
                                        <span class="fw-700 fs-16" id="shipping_fee_view">{{single_price($shipping_fee)}}</span>
                                    </div>
                                    <div class="px-0 py-2 mb-4 border-top d-flex justify-content-between" style="align-items:center">
                                        <span class="opacity-60 fs-14 price_product_cart_details">Total</span>
                                        <span class="fw-700 fs-16 final_price" id="total_price">{{ single_price($final_all) }}</span>
                                        <input type="hidden" id="final_price" value="{{$total_all }}">
                                    </div>
                                </div>
                                <div class="col-md-12 text-center" style="background-color: #2E7F25">
                                    <button type="submit" href="#" style="border:none;background-color: #2E7F25 !important" class="btn btn-primary fs-14 fw-700 rounded-0 px-4" onclick="submitOrder(this)">
                                        Proceed To Checkout
                                    </button>
                            </div>
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
            $("input[class=radio_button_checkout]:checked").each(function() {
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
            var data_id_seller = myRadio.name.replace('shipping_fee_','');  
            $("input[class=radio_button_checkout_short]:checked").each(function() {
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
