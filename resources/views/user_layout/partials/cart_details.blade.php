<div class="container" style="max-width:1200px !important;width:100%">
    
    @if( $carts && count($carts) > 0 )
    @include('user_layout.partials.cart_page_heading')
        <div class="cart-v2" id="cart-summary-2">
            <!-- LEFT COLUMN: Products + Shipping -->
            <div class="cart-v2__left">
                <!-- Cart Table -->
                <div class="cart-v2__card">
                    <!-- Continue shopping -->
                    <a href="{{ route('homepage') }}" class="cart-v2__continue" style="margin-bottom: 8px;">
                        <i class="fa fa-arrow-left"></i>
                        {{ translate('Tiếp tục mua hàng') }}
                    </a>

                    <!-- Desktop Header -->
                    <div class="cart-v2__header d-none d-lg-flex">
                        <div class="cart-v2__header-check"><input onchange="Check_all(this)" type="checkbox"></div>
                        <div class="cart-v2__header-product">{{ translate('Product')}}</div>
                        <div class="cart-v2__header-qty">{{ translate('Qty')}}</div>
                        <div class="cart-v2__header-total">{{ translate('Total')}}</div>
                        <div class="cart-v2__header-remove"></div>
                    </div>

                    <!-- Cart Items -->
                    @php $total = 0; @endphp
                    @foreach ($carts as $key => $cartItem)
                        @php
                            $product = \App\Models\Products::find($cartItem['product_id']);
                            $product_stock = $product->product_stock->where('variant',preg_replace('/\s+/', '',$cartItem['variation']))->first();
                            if ($cartItem['is_checked']) {
                                $total = $total + cart_product_price($cartItem, $product, false) * $cartItem['quantity'];
                            }
                            $final_total = $total+15000;
                            $product_name_with_choice = $product->name;
                            if ($cartItem['variation'] != null) {
                                $product_name_with_choice = $product->name.' - '.$cartItem['variation'];
                            }
                        @endphp
                        <div class="cart-v2__item">
                            <!-- Checkbox -->
                            <div class="cart-v2__item-check">
                                <input onchange="showHidePan(this)" class="check_box_child" type="checkbox" value="{{ $cartItem['id'] }}" {{ $cartItem['is_checked'] ? 'checked' : '' }}>
                            </div>
                            <!-- Product -->
                            <div class="cart-v2__item-product">
                                <a href="{{ route('product', $product->slug) }}">
                                    <img src="{{ uploaded_asset($product->thumbnail_img) }}"
                                        class="cart-v2__item-img"
                                        alt="{{ $product->name }}"
                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                </a>
                                <div class="cart-v2__item-info">
                                    <div class="cart-v2__item-name">{{ $product_name_with_choice }}</div>
                                    <div class="cart-v2__item-unit-price">{{ $product->weight }} {{ $product->unit }}</div>
                                </div>
                            </div>
                            <!-- Quantity -->
                            <div class="cart-v2__item-qty">
                                @if ($cartItem['digital'] != 1 && $product->auction_product == 0)
                                    <div class="d-flex align-items-center gap-1 aiz-plus-minus">
                                        @if($cartItem['is_rfp'] == 0)
                                        <button class="cart-v2__qty-btn" type="button" data-type="minus" data-field="quantity[{{ $cartItem['id'] }}]">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                        @endif
                                        <input type="number" name="quantity[{{ $cartItem['id'] }}]"
                                            class="cart-v2__qty-input input-number"
                                            placeholder="1" value="{{ $cartItem['quantity'] }}"
                                            min="{{ $product->min_qty }}"
                                            max="{{ $product_stock->qty }}"
                                            data-cart-id="{{ $cartItem['id'] }}">
                                        @if($cartItem['is_rfp'] == 0)
                                        <button class="cart-v2__qty-btn" type="button" data-type="plus" data-field="quantity[{{ $cartItem['id'] }}]">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                        @endif
                                    </div>
                                @elseif($product->auction_product == 1)
                                    <span class="fw-700 fs-14">1</span>
                                @endif
                            </div>

                            <!-- Total -->
                            <div class="cart-v2__item-total">{{ single_price(cart_product_price($cartItem, $product, false) * $cartItem['quantity']) }}</div>
                            <!-- Remove -->
                            <div class="cart-v2__item-remove">
                                <button class="cart-v2__delete-btn" onclick="removeFromCartView(event, {{ $cartItem['id'] }})" title="{{ translate('Xóa') }}">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Shipping Info -->
                <div class="cart-v2__card">
                    <div class="cart-v2__section-title">
                        <i class="fa fa-map-marker"></i>
                        {{ translate('Thông tin giao hàng') }}
                    </div>
                    @empty($address)
                    @else
                        @foreach($address as $data_address)
                            <label class="cart-v2__address-card" for="addr_{{$data_address->id}}">
                                <input onclick="handleClick(this);" class="radio_button_checkout" type="radio" id="addr_{{$data_address->id}}" name="address_info" value="{{$data_address->id}}" />
                                <div class="cart-v2__address-info">
                                    <div class="cart-v2__address-detail">{{$data_address->full_adress}}</div>
                                </div>
                            </label>
                        @endforeach
                    @endempty
                    <button type="button" class="cart-v2__add-address" onclick="add_new_address()">
                        <i class="fa fa-plus"></i>
                        {{ translate('Thêm địa chỉ mới') }}
                    </button>
                </div>
            </div>

            <!-- RIGHT COLUMN: Order Summary (sticky) -->
            <div class="cart-v2__right">
                <div class="cart-v2__card cart-v2__card--summary">
                    <div class="cart-v2__summary-title">{{ translate('Đơn hàng của bạn') }}</div>
                    <div class="cart-v2__summary-row">
                        <span class="cart-v2__summary-label">{{ translate('Tạm tính') }}</span>
                        <span class="cart-v2__summary-value" id="total_price">{{ single_price($total) }}</span>
                    </div>
                    <div class="cart-v2__summary-row">
                        <span class="cart-v2__summary-label">{{ translate('Phí vận chuyển') }}</span>
                        <span class="cart-v2__summary-value" id="cart_shipping_fee_display">{{ single_price(0) }}</span>
                    </div>
                    <div class="cart-v2__summary-total">
                        <span class="cart-v2__summary-total-label">{{ translate('Tổng cộng') }}</span>
                        <span class="cart-v2__summary-total-value" id="total_price_2">{{ single_price($total) }}</span>
                    </div>
                    <a id="myLink" href="{{ route('checkout.final_checkout') }}" class="cart-v2__checkout-btn disabled">
                        {{ translate('Thanh toán ngay') }}
                    </a>
                    <div class="cart-v2__checkout-hint">{{ translate('Vui lòng chọn sản phẩm và địa chỉ giao hàng') }}</div>
                </div>
            </div>
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
@include('user_layout.partials.address_modal')
@endsection

@section('script')
<script type="text/javascript">
    $('#country_2').on('change', function() {
        var country = $(this).val();
        if (country != "") {
            $.ajax({
                url: "{{ route('city.filter_by_country') }}",
                method: 'post',
                data: { id: country },
                headers: { 'X-CSRF-Token': '{{ csrf_token() }}' },
                success: function(result) {
                    $('#city_2').html('<option value="" selected hidden>{{ translate("Select City") }}</option>');
                    result.forEach(function(element) {
                        $('#city_2').append('<option value="' + element.id + '">' + element.city_name + '</option>');
                    });
                    $('#city_2').selectpicker('refresh');
                }
            });
        }
    });
</script>
@endsection

@push('append-scripts')
<script type="text/javascript">
    if (typeof AIZ !== 'undefined' && AIZ.extra) { AIZ.extra.plusMinus(); }
    else { (function(){ if (typeof AIZ !== 'undefined' && AIZ.extra) AIZ.extra.plusMinus(); }); }

    // Hook into quantity change AFTER plusMinus initializes
    // plusMinus uses .off('change').on('change') which overrides onchange attribute
    // We use a delegated event on document (survives .off on element) with debounce
    var _cartQtyTimer = null;
    $(document).off('change.cartQty').on('change.cartQty', '.cart-v2__qty-input', function() {
        var el = this;
        var cartId = $(el).data('cart-id');
        if (!cartId) return;
        clearTimeout(_cartQtyTimer);
        _cartQtyTimer = setTimeout(function() {
            updateQuantity(cartId, el);
        }, 300);
    });

    // Update checkout button state and hint text
    function updateCheckoutState() {
        var hasCheckedProducts = $('input[class=check_box_child]:checked').length > 0;
        var hasSelectedAddress = $('input[class=radio_button_checkout]:checked').length > 0;

        if (hasCheckedProducts && hasSelectedAddress) {
            $('#myLink').removeClass('disabled');
            $('.cart-v2__checkout-hint').html('');
        } else {
            $('#myLink').addClass('disabled');
            var hints = [];
            if (!hasCheckedProducts) hints.push('chọn sản phẩm');
            if (!hasSelectedAddress) hints.push('chọn địa chỉ giao hàng');
            $('.cart-v2__checkout-hint').html('Vui lòng ' + hints.join(' và '));
        }
    }

    // Init on page load
    updateCheckoutState();

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
                        updateCheckoutState();
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
            $(".check_box_child").prop("checked", true);
            active = 1;
        }
        else
        {
            $(".check_box_child").prop("checked", false);
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
                        updateCheckoutState();
                    }, 
                    error: function(){
                        
                    }
                });
    }

    function handleClick(myRadio) {
        var address_id = myRadio.value;
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
                    updateCheckoutState();
                }, 
                error: function(){
                    
                }
            });
    }
  

    
</script>
@endpush

