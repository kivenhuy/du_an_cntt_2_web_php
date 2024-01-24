@extends('user_layout.layouts.user_panel')

@section('panel_content')
    <!-- Order id -->
    <div class="aiz-titlebar mb-4">
        <div class="row align-items-center">
            <div class="col-md-6">
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
                            <td>Success</td>
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
                       
                        @if ($order->tracking_code)
                            <tr>
                                <td class="w-50 fw-600">{{ translate('Tracking code') }}:</td>
                                <td>{{ $order->tracking_code }}</td>
                            </tr>
                        @endif
                    </table>
                </div>
                <div class="row gutters-5">
                    <div class="col text-md-left text-center">
                        @if (is_array(json_decode($order->manual_payment_data, true)))
                            {{-- <div class="form-group text-left">
                                <button type="button" 
                                id="btn_image"
                                class="btn btn-primary">Showing Receipt</button>
                            </div> --}}
                           
                            <div id="hide_image" hidden="true">
                                @foreach($order->img_url as $data_image)
                                    <input type="hidden" value="{{$data_image}}">
                                    <a href="{{url('public/'.$data_image)}}" target="_blank">
                                        <img src="{{url('public/'.$data_image)}}" alt=""
                                            height="100">
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Details -->
    <div class="row gutters-16">
        <div class="col-md-12">
            <div class="card rounded-0 shadow-none border mt-2 mb-4">
                <div class="card-header border-bottom-0">
                    <h5 class="fs-16 fw-700 text-dark mb-0">{{ translate('Order Details') }}</h5>
                </div>
                <div class="card-body table-responsive">
                    <table class="aiz-table table">
                        <thead class="text-gray fs-12">
                            <tr>
                                <th class="pl-0">#</th>
                                <th width="20%">{{ translate('Product') }}</th>
                                <th>{{ translate('Quantity') }}</th>
                                @if(Auth::user()->user_type === 'enterprise')
                                    <th>{{ translate('Shipping Date') }}</th>
                                @endif
                                <th data-breakpoints="md">{{ translate('Delivery Type') }}</th>
                                <th>{{ translate('Price') }}</th>
                                <th>{{ translate('Shipping Status') }}</th>
                                <th data-breakpoints="md" class="text-right pr-0">{{ translate('Review') }}</th>
                            </tr>
                        </thead>
                        <tbody class="fs-14">
                            @foreach ($order->orderDetails as $key => $orderDetail)
                                <tr>
                                    <td class="pl-0">{{ sprintf('%02d', $key+1) }}</td>
                                    <td>
                                        @if ($orderDetail->product != null && $orderDetail->product->auction_product == 0)
                                            <a href="{{ route('product', $orderDetail->product->slug) }}"
                                                target="_blank">{{ $orderDetail->product->name}}</a>
                                        @elseif($orderDetail->product != null && $orderDetail->product->auction_product == 1)
                                            <a href="{{ route('auction-product', $orderDetail->product->slug) }}"
                                                target="_blank">{{ $orderDetail->product->name}}</a>
                                        @else
                                            <strong>{{ translate('Product Unavailable') }}</strong>
                                        @endif
                                    </td>
                                   
                                    <td>
                                        {{ $orderDetail->quantity }}
                                    </td>
                                    @if(Auth::user()->user_type === 'enterprise')
                                    <td>
                                        {{ date('d-m-Y H:i', strtotime($orderDetail->shipping_date)) }}
                                    </td>
                                    @endif
                                    <td>
                                        {{ $orderDetail->shipping_type }}
                                    </td>
                                    <td class="fw-700">{{ single_price($orderDetail->price) }}</td>
                                    @if ($orderDetail->delivery_status == 'delivered')
                                    <td>
                                            <span class="badge badge-inline badge-success">{{ucfirst(str_replace('_', ' ', $orderDetail->delivery_status))}}</span>
                                            @if(count($orderDetail->shipping_history)>0)
                                                <a href="javascript:void(0);"
                                                    onclick="shipping_history('{{ $orderDetail->id }}')"
                                                    class="btn btn-soft-info btn-icon btn-circle btn-sm"
                                                    title="{{ translate('Shipping History') }}">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            @endif
                                    </td>
                                    @else
                                    <td>
                                        <span class="badge badge-inline badge-warning">
                                            {{ ucfirst(str_replace('_', ' ', $orderDetail->delivery_status)) }}
                                        </span>
                                        @if(count($orderDetail->shipping_history)>0)
                                            <a href="javascript:void(0);"
                                                onclick="shipping_history('{{ $orderDetail->id }}')"
                                                class="btn btn-soft-info btn-icon btn-circle btn-sm"
                                                title="{{ translate('Shipping History') }}">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        @endif
                                    </td>
                                    @endif
                                    <td class="text-xl-right pr-0">
                                        @if ($orderDetail->delivery_status === 'delivered')
                                            <a href="javascript:void(0);"
                                                onclick="product_review('{{ $orderDetail->product_id }}')"
                                                class="btn btn-primary btn-sm rounded-0"> {{ translate('Review') }} </a>
                                        @else
                                            <span class="text-danger">{{ translate('Not Delivered Yet') }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row gutters-16">
        <!-- Order Ammount -->
        <div class="col-md-8"></div>
        <div class="col-md-4">
            <div class="card rounded-0 shadow-none border mt-2">
                <div class="card-header border-bottom-0">
                    <b class="fs-16 fw-700 text-dark">{{ translate('Order Ammount') }}</b>
                </div>
                <div class="card-body pb-0">
                    <table class="table-borderless table">
                        <tbody>
                            <tr>
                                <td class="w-50 fw-600">{{ translate('Subtotal') }}</td>
                                <td class="text-right">
                                    <span class="strong-600">{{ single_price($order->orderDetails->sum('price')) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="w-50 fw-600">{{ translate('Shipping') }}</td>
                                <td class="text-right">
                                    <span class="text-italic">{{ single_price($order->orderDetails->sum('shipping_cost')) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="w-50 fw-600">{{ translate('Tax') }}</td>
                                <td class="text-right">
                                    <span class="text-italic">{{ single_price($order->orderDetails->sum('tax')) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="w-50 fw-600">{{ translate('Coupon') }}</td>
                                <td class="text-right">
                                    <span class="text-italic">{{ single_price($order->coupon_discount) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="w-50 fw-600">{{ translate('Total') }}</td>
                                <td class="text-right">
                                    <strong>{{ single_price($order->grand_total) }}</strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($order->manual_payment && $order->manual_payment_data == null)
                <button onclick="show_make_payment_modal({{ $order->id }})"
                    class="btn btn-block btn-primary">{{ translate('Make Payment') }}</button>
            @endif
        </div>
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
        .timeline-with-icons {
        border-left: 1px solid hsl(0, 0%, 90%);
        position: relative;
        list-style: none;
        }

        .timeline-with-icons .timeline-item {
        position: relative;
        }

        .timeline-with-icons .timeline-item:after {
        position: absolute;
        display: block;
        top: 0;
        }

        .timeline-with-icons .timeline-icon {
        position: absolute;
        left: -54px;
        background-color: hsl(217, 88.2%, 90%);
        color: hsl(217, 88.8%, 35.1%);
        border-radius: 50%;
        height: 31px;
        width: 31px;
        display: flex;
        align-items: center;
        justify-content: center;
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

    <div class="modal fade" id="shipping-history-modal">
        <div class="modal-dialog">
            <div class="modal-content" id="shipping-history-modal-content">

            </div>
        </div>
    </div>

   


    
@endsection


@section('script')
    <script type="text/javascript">
        
        function product_review(product_id) {
            $.post('{{ route('product_review_modal') }}', {
                _token:'{{ csrf_token() }}',
                product_id: product_id
            }, function(data) {
                $('#product-review-modal-content').html(data);
                $('#product-review-modal').modal('show', {
                    backdrop: 'static'
                });
                AIZ.extra.inputRating();
            });
        }

        function shipping_history(order_detail_id) {
            $.post('{{ route('shipping_history') }}', {
                _token:'{{ csrf_token() }}',
                order_detail_id: order_detail_id
            }, function(data) {
                $('#product-review-modal-content').html(data);
                $('#product-review-modal').modal('show', {
                    backdrop: 'static'
                });
                AIZ.extra.inputRating();
            });
        }


        function showreceipt(){
            $('#showingreceipt').modal('show');
        }
        $('#btn_image').on('click',function() {
            $('#hide_image').removeAttr('hidden');
        });
    </script>
@endsection