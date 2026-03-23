@extends('admin.layouts.app')
@section('content')
    <!-- Order id -->
    <div class="aiz-titlebar mb-4">
        <div class="row align-items-center">
            <div class="col-md-6" style="display: flex">
                <a style="display: flex;align-items: center;margin-right: 10px;margin-bottom: 0.5rem" href="{{route('admin.purchase_history.all_orders')}}" ><i style="color:black;font-size: 1.73em;" class="fa fa-long-arrow-alt-left"></i></a>
                <h1 class="fs-20 fw-700 text-dark">{{ translate('Order id') }}: {{ $order->code }}</h1>
            </div>
        </div>
    </div>

    <!-- Order Summary -->
    <div class="card rounded-0 shadow-none border mb-4">
        <div class="card-header border-bottom-0">
            <h5 class="fs-16 fw-700 text-dark mb-0">{{ translate('Order Summary') }}</h5>
        </div>
        <div class="card-body">
            <div class="row">

                <div class="col-lg-6">
                    <table class="table-borderless table">
                        <tr>
                            <td class="w-50 fw-600">{{ translate('Order Code') }}:</td>
                            <td>{{ $order->code }}</td>
                        </tr>
                        <tr>
                            <td class="w-50 fw-600">{{ translate('Customer') }}:</td>
                            <td>{{ json_decode($order->shipping_address)->name }}</td>
                        </tr>
                        <tr>
                            <td class="w-50 fw-600">{{ translate('Email') }}:</td>
                            @if ($order->customer_id != null)
                                <td>{{ $order->user->email }}</td>
                            @endif
                        </tr>
                        <tr>
                            <td class="w-50 fw-600">{{ translate('Shipping address') }}:</td>
                            <td>{{ json_decode($order->shipping_address)->address }},
                                {{ json_decode($order->shipping_address)->city }},
                                @if(isset(json_decode($order->shipping_address)->state)) {{ json_decode($order->shipping_address)->state }} - @endif
                                {{ json_decode($order->shipping_address)->postal_code }},
                                {{ json_decode($order->shipping_address)->country }}
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-lg-6">
                    <table class="table-borderless table">
                        <tr>
                            <td class="w-50 fw-600">{{ translate('Order date') }}:</td>
                            <td>{{ date('d-m-Y H:i A', $order->date) }}</td>
                        </tr>
                        <tr>
                            <td class="w-50 fw-600">{{ translate('Order status') }}:</td>
                            <td>{{ translate(ucfirst(str_replace('_', ' ', $order->delivery_status))) }}</td>
                        </tr>
                        <tr>
                            <td class="w-50 fw-600">{{ translate('Total order amount') }}:</td>
                            <td>{{ single_price($order->orderDetails->sum('price') + $order->orderDetails->sum('tax')) }}
                            </td>
                        </tr>
                        <tr>
                            <td class="w-50 fw-600">{{ translate('Shipping method') }}:</td>
                            <td> {{ $order->shipping_type }}</td>
                        </tr>
                        <tr>
                            <td class="w-50 fw-600">{{ translate('Payment method') }}:</td>
                            <td>{{ translate(ucfirst(str_replace('_', ' ', $order->payment_type))) }}</td>
                        </tr>
                       
                        <tr>
                            <td class="w-50 fw-600">{{ translate('Payment Status') }}:</td>
                            <td> 
                                @if($order->payment_status != 'paid' )
                                    <span class='badge badge-inline badge-warning'>{{ ucfirst($order->payment_status) }}</span> 
                                    @if($order->payment_status === 'waiting for checking' )
                                        <button  id="verify_payment">
                                            <input type="hidden" value="{{$order->id}}" id="order_id">
                                            <i class="fa fa-check"></i> Verify
                                        </button>
                                    @endif
                                @else
                                    <span class='badge badge-inline badge-success'>{{ ucfirst($order->payment_status) }}</span> 
                                @endif
                            </td>
                        </tr>
                        
                    </table>
                </div>
                <div class="row gutters-5">
                    <div class="col text-md-left text-center">
                        @if($order->payment_status === "waiting for checking" || $order->payment_status === "paid")
                        {{-- @if(Auth::user()->user_type === 'enterprise') --}}
                            @if (is_array(json_decode($order->manual_payment_data, true)))
                                
                                <div class="form-group text-left">
                                    <button type="button" 
                                    id="btn_image"
                                    class="btn btn-primary">Showing Receipt</button>
                                </div>
                            
                                <div id="hide_image" hidden="true">
                                    <div>
                                        <table class="table-borderless table">
                                            <tr>
                                                <td class="w-50 fw-600">{{ translate('Transaction ID') }}:</td>
                                                <td> {{ $order->trx_id }}</td>
                                            </tr>
                                            <tr>
                                                <td class="w-50 fw-600">{{ translate('Amound') }}:</td>
                                                <td> {{ single_price($order->amount_payment) }}</td>
                                            </tr>
                                            <tr>
                                                <td class="w-50 fw-600">{{ translate('Image Verify') }}:</td>
                                                <td>  
                                                    @foreach($order->img_url as $data_image)
                                                        <input type="hidden" value="{{$data_image}}">
                                                        <a href="{{$data_image}}" target="_blank">
                                                            <img src="{{$data_image}}" alt=""
                                                                height="100">
                                                        </a>
                                                    @endforeach
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                   
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Details -->
    <div class="card rounded-0 shadow-none border mb-4">
        <div class="row" >
            <div class="col-lg-12 table-responsive">
                <table class="table-bordered aiz-table invoice-summary table" style="background-color: white">
                    <thead>
                        <tr class="bg-trans-dark">
                            <th data-breakpoints="lg" class="min-col">#</th>
                            <th width="10%">{{ translate('Photo') }}</th>
                            <th class="text-uppercase">{{ translate('Description') }}</th>
                            <th data-breakpoints="lg" class="text-uppercase">{{ translate('Delivery Type') }}</th>
                            <th data-breakpoints="lg" class="min-col text-uppercase text-center">
                                {{ translate('Qty') }}
                            </th>
                            <th data-breakpoints="lg" class="min-col text-uppercase text-center">
                                {{ translate('Price') }}</th>
                            <th data-breakpoints="lg" class="min-col text-uppercase text-center">
                                {{ translate('Total') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderDetails as $key => $orderDetail)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    @if ($orderDetail->product != null && $orderDetail->product->auction_product == 0)
                                        <a href="{{ route('product', $orderDetail->product->slug) }}" target="_blank">
                                            <img height="50" src="{{ uploaded_asset($orderDetail->product->thumbnail_img) }}">
                                        </a>
                                    @elseif ($orderDetail->product != null && $orderDetail->product->auction_product == 1)
                                        <a href="{{ route('auction-product', $orderDetail->product->slug) }}" target="_blank">
                                            <img height="50" src="{{ uploaded_asset($orderDetail->product->thumbnail_img) }}">
                                        </a>
                                    @else
                                        <strong>{{ translate('N/A') }}</strong>
                                    @endif
                                </td>
                                <td>
                                    @if ($orderDetail->product != null && $orderDetail->product->auction_product == 0)
                                        <strong>
                                            <a href="{{ route('product', $orderDetail->product->slug) }}" target="_blank"
                                                class="text-muted">
                                                {{ $orderDetail->product->name }}
                                            </a>
                                        </strong>
                                        <small>
                                            {{ $orderDetail->variation }}
                                        </small>
                                        <br>
                                        <small>
                                            @php
                                                $product_stock = json_decode($orderDetail->product->product_stock, true);
                                            @endphp
                                            {{translate('SKU')}}: {{ $product_stock['sku'] }}
                                        </small>
                                    @elseif ($orderDetail->product != null && $orderDetail->product->auction_product == 1)
                                        <strong>
                                            <a href="{{ route('auction-product', $orderDetail->product->slug) }}" target="_blank"
                                                class="text-muted">
                                                {{ $orderDetail->product->getTranslation('name') }}
                                            </a>
                                        </strong>
                                    @else
                                        <strong>{{ translate('Product Unavailable') }}</strong>
                                    @endif
                                </td>
                                <td>
                                    {{ ($order->shipping_type) }}
                                </td>
                                <td class="text-center">
                                    {{ $orderDetail->quantity }}
                                </td>
                                <td class="text-center">
                                    {{ single_price($orderDetail->price / $orderDetail->quantity) }}
                                </td>
                                <td class="text-center">
                                    {{ single_price($orderDetail->price) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
    </div>
    <div class="clearfix float-right">
        <table class="table">
            <tbody>
                <tr>
                    <td>
                        <strong class="text-muted">{{ translate('Sub Total') }} :</strong>
                    </td>
                    <td>
                        {{ single_price($order->orderDetails->sum('price')) }}
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong class="text-muted">{{ translate('Tax') }} :</strong>
                    </td>
                    <td>
                        {{ single_price($order->orderDetails->sum('tax')) }}
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong class="text-muted">{{ translate('Shipping') }} :</strong>
                    </td>
                    <td>
                        {{ single_price($order->orderDetails->sum('shipping_cost')) }}
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong class="text-muted">{{ translate('Coupon') }} :</strong>
                    </td>
                    <td>
                        {{ single_price($order->coupon_discount) }}
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong class="text-muted">{{ translate('TOTAL') }} :</strong>
                    </td>
                    <td class="text-muted h5">
                        {{ single_price($order->grand_total) }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <style>
        #modal-size {
            position:fixed !important;
            left:0 !important;
            right:0 !important;
            bottom:0 !important;
            top:0 !important;
            display:block !important; 
        }
    </style>
@endsection

@section('modal')
    <!-- Product Review Modal -->
    <div class="modal fade" id="product-review-modal">
        <div class="modal-dialog">
            <div class="modal-content" id="product-review-modal-content">

            </div>
        </div>
    </div>

    <!-- Payment Modal -->
    <div class="modal fade" id="payment_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div id="payment_modal_body">

                </div>
            </div>
        </div>
    </div>


    
@endsection


@section('script')
    <script type="text/javascript">
        function showreceipt(){
            $('#showingreceipt').modal('show');
        }
        $('#btn_image').on('click',function() {
            $('#hide_image').removeAttr('hidden');
        });

        $('#verify_payment').on('click',function() {
            var order_id = 0;
            order_id = $('#order_id').val();
            if(order_id != 0 )
            {
                $.ajax
                ({
                    url: "{{route('admin.purchase_history.verify_payment')}}",
                    method:'post',
                    data:{
                        order_id:order_id,
                    },
                    headers: {
                        'X-CSRF-Token': '{{ csrf_token() }}',
                    },
                    success: function(data){
                        location.reload();
                        AIZ.plugins.notify('success','Update Payment Status Successfully!!!!');
                    }, 
                    error: function(){
                        AIZ.plugins.notify('danger','Some Thing Went Wrong!!!!');
                    }
                });
                
            }
            else
            {
                AIZ.plugins.notify('danger','Some Thing Went Wrong!!!!');
            }
            
        });
    </script>
@endsection