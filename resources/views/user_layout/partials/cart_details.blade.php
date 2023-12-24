<div class="container" style="max-width:1200px !important;width:100%">
    
    @if( $carts && count($carts) > 0 )
    <div style="margin-bottom: 20px;">
        <span style="
            font-family: 'Quicksand',sans-serif !important;
            font-size: 40px;
            font-weight: 700;
            line-height: 48px;
            letter-spacing: -0.0004em;
            text-align: left;
            color:#2E7F25;
            ">Your Cart
        </span>
    </div>
    <div style="margin-bottom: 2rem">
        <span style="font-family: 'Roboto',sans-serif !important;
        font-size: 16px;
        font-weight: 400;
        line-height: 20px;
        letter-spacing: -0.0004em;
        text-align: left;
        color:#797979;">Your have <span class="num_of_product">{{count($carts)}}</span> product in your cart</span>
    </div>
        <div class="row" id="cart-summary-2">
            <div class="col-xxl-8 col-xl-10 mx-auto">
                <div class=" bg-white p-3 p-lg-4 text-left">
                    <div class="mb-4">
                        <!-- Headers -->
                        <div class="row gutters-5 d-none d-lg-flex border-bottom mb-3 text-secondary fs-12 header_table" >
                            <div class="col col-md-1 fw-600 text_cart_details"><input onchange = "Check_all(this)" type="checkbox"></div>
                            <div class="col-md-4 fw-600 text_cart_details" style="position: relative;left:32px">{{ translate('Product')}}</div>
                            <div class="col col-md-1 fw-600 text_cart_details">{{ translate('Qty')}}</div>
                            <div class="col fw-600 text_cart_details" style="display: flex;justify-content: center;">{{ translate('Unit')}}</div>
                            {{--<div class="col fw-600">{{ translate('Tax')}}</div> --}}
                            <div class="col fw-600 text_cart_details" >{{ translate('Total')}}</div>
                            <div class="col-auto fw-600 text_cart_details" style=" position: relative; right: 24px; ">{{ translate('Remove')}}</div>
                        </div>
                        <!-- Cart Items -->
                        <ul class="list-group list-group-flush">
                            @php
                                $total = 0;

                            @endphp
                            @foreach ($carts as $key => $cartItem)
                                @php
                                    $product = \App\Models\Products::find($cartItem['product_id']);
                                    $product_stock = $product->product_stock->where('variant',preg_replace('/\s+/', '',$cartItem['variation']))->first();
                                    // $product_stock = $product->stocks()->get();
                                    // dd($product_stock);
                                    // $total = $total + ($cartItem['price']  + $cartItem['tax']) * $cartItem['quantity'];
                                    $total = $total + cart_product_price($cartItem, $product, false) * $cartItem['quantity'];
                                    $final_total = $total+15000;
                                    $product_name_with_choice = $product->name;
                                    if ($cartItem['variation'] != null) {
                                        $product_name_with_choice = $product->name.' - '.$cartItem['variation'];
                                    }
                                @endphp
                                <li class="list-group-item px-0">
                                    <div class="row gutters-5 align-items-center">
                                        {{-- checkbxõ --}}
                                        <div class="col-md-1 ">
                                            {{-- @if($cartItem->is_checked ==1)
                                            <input onchange = "showHidePan(this)" class="check_box_child" type="checkbox" value="{{$cartItem->id}}" checked>
                                            @else --}}
                                            <input onchange = "showHidePan(this)" class="check_box_child" type="checkbox" value="{{$cartItem->id}}">
                                            {{-- @endif --}}
                                           
                                        </div>
                                        <!-- Product Image & name -->
                                        <div class="col-md-4 d-flex align-items-center mb-2 mb-md-0">
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
                                                    @if($cartItem['is_rfp'] == 0)
                                                    <button
                                                        class="btn col-auto btn-icon btn-sm btn-circle btn-light"
                                                        type="button" data-type="plus"
                                                        data-field="quantity[{{ $cartItem['id'] }}]">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                    @endif
                                                    <input type="number" name="quantity[{{ $cartItem['id'] }}]"
                                                        class="col border-0 text-left px-0 flex-grow-1 fs-14 input-number quantity_product"
                                                        placeholder="1" value="{{ $cartItem['quantity'] }}"
                                                        min="{{ $product->min_qty }}"
                                                        max="{{ $product_stock->qty }}"
                                                        onchange="updateQuantity({{ $cartItem['id'] }}, this)" style="padding-left:0.75rem !important;">
                                                    @if($cartItem['is_rfp'] == 0)
                                                    <button
                                                        class="btn col-auto btn-icon btn-sm btn-circle btn-light"
                                                        type="button" data-type="minus"
                                                        data-field="quantity[{{ $cartItem['id'] }}]">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                    @endif
                                                </div>
                                            @elseif($product->auction_product == 1)
                                                <span class="fw-700 fs-14">1</span>
                                            @endif
                                        </div>
                                        <!-- Price -->
                                        <div class="col-md col-4 order-2 order-md-0 my-3 my-md-0" style="max-width:80px !important">
                                            <span class="unit_product">{{$product->unit}}</span>
                                        </div>
                                         {{--
                                        <!-- Tax -->
                                        <div class="col-md col-4 order-3 order-md-0 my-3 my-md-0">
                                            <span class="opacity-60 fs-12 d-block d-md-none">{{ translate('Tax')}}</span>
                                            <span class="fw-700 fs-14">{{ cart_product_tax($cartItem, $product) }}</span>
                                        </div> --}}
                                        <!-- Total -->
                                        <div class="col-md col-5 order-4 order-md-0 my-3 my-md-0">
                                            <span class="opacity-60 fs-12 d-block d-md-none">{{ translate('Total')}}</span>
                                            <span class="fw-700 fs-16 text-primary total_product">{{ single_price(cart_product_price($cartItem, $product, false) * $cartItem['quantity']) }}</span>
                                        </div>
                                        <!-- Remove From Cart -->
                                        <div class="col-md-auto col-6 order-5 order-md-0 text-right">
                                            <a href="javascript:void(0)" onclick="removeFromCartView(event, {{ $cartItem['id'] }})" class="btn btn-icon btn-sm btn-soft-primary bg-soft-warning hov-bg-primary btn-circle">
                                                <i class="fa fa-trash fs-16"></i>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div style="margin-top:40px;margin-bottom:16px;">
                    <i style="font-size: 24px;margin-right: 8px;" class="fa fa-map-marker" aria-hidden="true"><span class="shipping_info">Shipping Info</span></i>
                </div>
                <div style="height: 111px !important">
                    @empty($address)
                   
                    @else
                        @foreach($address as $data_address)
                            <div style="margin-bottom: 1rem;display: flex;align-items: center">
                                <input onclick="handleClick(this);" class="radio_button_checkout" type="radio" id="{{$data_address->id}}" name="address_info" value="{{$data_address->id}}" />
                                <span for="address_info" class="delivery_type">{{$data_address->full_adress}}</span>
                            </div>
                        @endforeach
                    @endempty
                    {{-- <button class="btn add_new_address" onclick="add_new_address()"><i class="fa fa-plus" aria-hidden="true"></i> New Address</button> --}}
                </div>
            </div>
            <div class="col-xxl-3 col-xl-10 mx-auto">
                <div class="border bg-white p-3 p-lg-4 text-left">
                    <div class="mb-4">
                        <div class="px-0 py-2 mb-4  d-flex justify-content-between">
                            <span class="opacity-60 fs-14 price_product_cart_details">Subtotal</span>
                            <span class="fw-700 fs-16" id="total_price">{{ single_price($total) }}</span>
                        </div>
                        <div class="px-0 py-2 mb-4  d-flex justify-content-between">
                            <span class="opacity-60 fs-14 price_product_cart_details">Shpping</span>
                            <span class="fw-700 fs-16">đ 0</span>
                        </div>
                        <div class="px-0 py-2 mb-4 border-top d-flex justify-content-between" style="align-items:center">
                            <span class="opacity-60 fs-14 price_product_cart_details">Total</span>
                            <span class="fw-700 fs-16 final_price" id="total_price_2">{{ single_price($total) }}</span>
                        </div>
                    </div>
                    <div class="col-md-12 text-center" style="background-color: #2E7F25">
                        <a id="myLink" href="{{ route('checkout.final_checkout') }}" style="border:none;background-color: #2E7F25 !important" class="btn btn-primary fs-14 fw-700 rounded-0 px-4 disabled " >
                            Proceed To Checkout
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 text-center text-md-left order-1 order-md-0">
            <a href="{{ route('homepage') }}" class="btn btn-link fs-14 fw-700 px-0">
                <button class="btn return_to_shop">
                    <i class="fa fa-arrow-left fs-16"></i>
                    {{ translate('Return to Homepage')}}
                </button>
            </a>
        </div>
    @else
        <div class="row">
            <div class="col-xl-8 mx-auto">
                <div class="border bg-white p-4">
                    <!-- Empty cart -->
                    <div class="text-center p-3">
                        <i class="las la-frown la-3x opacity-60 mb-3"></i>
                        <h3 class="h4 fw-700">{{translate('Your Cart is empty')}}</h3>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@section('modal')
<div class="modal fade" id="new-address-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ translate('New Address') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-default" role="form" action="{{ route('addresses.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="p-3">
                        <div class="row">
                            <div class="col-md-2">
                                <label>{{ translate('Address')}}</label>
                            </div>
                            <div class="col-md-10">
                                <textarea class="form-control mb-3" placeholder="{{ translate('Your Address')}}" rows="2" name="address" required></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label>{{ translate('Country')}}</label>
                            </div>
                            <div class="col-md-10">
                                <div class="mb-3">
                                    <select class="form-control aiz-selectpicker" data-live-search="true" data-placeholder="{{ translate('Select your country') }}" name="country_id" required>
                                        <option value="">{{ translate('Select your country') }}</option>
                                        @foreach (App\Models\Country::where('status', 1)->get() as $key => $country)
                                            <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-2">
                                <label>{{ translate('City')}}</label>
                            </div>
                            <div class="col-md-10">
                                <select class="form-control mb-3 aiz-selectpicker" data-live-search="true" name="city_id" required>

                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <label>{{ translate('District')}}</label>
                            </div>
                            <div class="col-md-10">
                                <select class="form-control mb-3 aiz-selectpicker" data-live-search="true" name="district_id" required>

                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <label>{{ translate('Phone')}}</label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control mb-3" placeholder="{{ translate('+880')}}" name="phone" value="" required>
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-sm btn-primary">{{translate('Save')}}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

<script type="text/javascript">
    AIZ.extra.plusMinus();
    function handleClick(myRadio) {
        var address_id = myRadio.value;
        // var id_radio = myRadio.id;
        // var final_price = $('#final_price').val();
        
    }

    function add_new_address(){
        $('#new-address-modal').modal('show');
    }

    function showHidePan(myRadio) 
    {
        var cart_checked = myRadio.checked;
        var cart_id = myRadio.value;
        var active = 0;
        if(cart_checked == true)
        {
            active = 1;
        }
        $.ajax
                ({
                    url: "{{route('cart.update_select_item')}}",
                    method:'post',
                    data:{
                        cart_id:cart_id,
                        active:active,
                        type:0,
                    },
                    headers: {
                        'X-CSRF-Token': '{{ csrf_token() }}',
                    },
                    success: function(data){
                        $('#total_price').html(data.total);
                        $('#total_price_2').html(data.total);
                        if(data.disabled == 0)
                        {
                            $('#myLink').addClass('disabled')
                        }
                        else
                        {
                            if ($('input[class=radio_button_checkout]:checked').length > 0) {
                                $('#myLink').removeClass('disabled')
                            }
                            else
                            {
                                AIZ.plugins.notify('danger', 'Please Select Address To Checkout');
                            }
                            
                        }
                    }, 
                    error: function(){
                        
                    }
                });

    }

    function Check_all(myRadio) 
    {
        var cart_checked = myRadio.checked;
        var active = 0;
        if(cart_checked)
        {
            $(".check_box_child").attr("checked", "true");
            active = 1;
        }
        else
        {
            $(".check_box_child").removeAttr('checked');
        }
        $.ajax
                ({
                    url: "{{route('cart.update_select_item')}}",
                    method:'post',
                    data:{
                        type:1,
                        active:active,
                    },
                    headers: {
                        'X-CSRF-Token': '{{ csrf_token() }}',
                    },
                    success: function(data){
                        $('#total_price').html(data.total);
                        $('#total_price_2').html(data.total);
                        if(data.disabled == 0)
                        {
                            $('#myLink').addClass('disabled')
                        }
                        else
                        {
                            if ($('input[class=radio_button_checkout]:checked').length > 0) {
                                $('#myLink').removeClass('disabled')
                            }
                            else
                            {
                                AIZ.plugins.notify('danger', 'Please Select Address To Checkout');
                            }
                        }
                    }, 
                    error: function(){
                        
                    }
                });
    }

    function handleClick(myRadio) {
        var address_id = myRadio.value;
        // var id_radio = myRadio.id;
        // var final_price = $('#final_price').val();
        $.ajax
            ({
                url: "{{route('checkout.update_shipping_fee')}}",
                method:'post',
                data:{
                    address_id:address_id,
                },
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                success: function(data){
                    if ($('input[class=check_box_child]:checked').length > 0) {
                            $('#myLink').removeClass('disabled')
                        }
                }, 
                error: function(){
                    
                }
            });
    }
  

    
</script>
