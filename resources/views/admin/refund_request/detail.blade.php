@extends('admin.layouts.app')
@section('content')
    <!-- Order id -->
    <div class="aiz-titlebar mb-4">
        <div class="row align-items-center">
            <div class="col-md-6" style="display: flex">
                <a style="display: flex;align-items: center;margin-right: 10px;margin-bottom: 0.5rem" href="{{route('refund.index')}}" ><i style="color:black;font-size: 1.73em;" class="fa fa-long-arrow-alt-left"></i></a>
                <h1 class="fs-20 fw-700 text-dark">{{ translate('Refund Code') }}: {{ $refund_request->code }}</h1>
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
                            <td class="w-50 fw-600">{{ translate('Total price amount') }}:</td>
                            <td>{{ single_price($order_detail->price + $order_detail->shipping_cost) }}
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
                                @if($order_detail->payment_status != 'paid' )
                                    <span class='badge badge-inline badge-warning'>{{ ucfirst($order_detail->payment_status) }}</span> 
                                @else
                                    <span class='badge badge-inline badge-success'>{{ ucfirst($order_detail->payment_status) }}</span> 
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <td class="w-50 fw-600">{{ translate('Shipping status') }}:</td>
                            
                            <td><span class='badge badge-inline badge-danger' style="font-size: 14px">{{ translate(ucfirst(str_replace('_', ' ', $order_detail->delivery_status))) }}</span> </td>
                        </tr>
                    
                        <tr>
                            <td class="w-50 fw-600">{{ translate('Refund Reason') }}:</td>
                            <td> {{ $refund_request->reason }}</td>
                        </tr>
                        
                        <tr>
                            <td class="w-50 fw-600">{{ translate('Refund Status') }}:</td>
                            <td> 
                                @if($refund_request->status == 0 )
                                    <span class='badge badge-inline badge-danger'>Waiting For Appore </span> 
                                @elseif($refund_request->status == 1 )
                                    <span class='badge badge-inline badge-warning'>Waiting For Refund</span> 
                                @elseif($refund_request->status == 2 )
                                    <span class='badge badge-inline badge-success'>Refunded</span> 
                                @else
                                    <span class='badge badge-inline badge-danger'>Request Rejected</span> 
                                @endif
                            </td>
                        </tr>

                    </table>
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
                        
                            <tr>
                                <td>1</td>
                                <td>
                                    @if ($order_detail->product != null && $order_detail->product->auction_product == 0)
                                        <a href="{{ route('product', $order_detail->product->slug) }}" target="_blank">
                                            <img height="50" src="{{ uploaded_asset($order_detail->product->thumbnail_img) }}">
                                        </a>
                                    @elseif ($order_detail->product != null && $order_detail->product->auction_product == 1)
                                        <a href="{{ route('auction-product', $order_detail->product->slug) }}" target="_blank">
                                            <img height="50" src="{{ uploaded_asset($order_detail->product->thumbnail_img) }}">
                                        </a>
                                    @else
                                        <strong>{{ translate('N/A') }}</strong>
                                    @endif
                                </td>
                                <td>
                                    @if ($order_detail->product != null && $order_detail->product->auction_product == 0)
                                        <strong>
                                            <a href="{{ route('product', $order_detail->product->slug) }}" target="_blank"
                                                class="text-muted">
                                                {{ $order_detail->product->name }}
                                            </a>
                                        </strong>
                                        <br>
                                        <small>
                                            @php
                                                $product_stock = json_decode($order_detail->product->product_stock, true);
                                            @endphp
                                            {{translate('SKU')}}: {{ $product_stock['sku'] }}
                                        </small>
                                    @else
                                        <strong>{{ translate('Product Unavailable') }}</strong>
                                    @endif
                                </td>
                                <td>
                                    {{ ($order_detail->shipping_type) }}
                                </td>
                                <td class="text-center">
                                    {{ $order_detail->quantity }}
                                </td>
                                <td class="text-center">
                                    {{ single_price($order_detail->price / $order_detail->quantity) }}
                                </td>
                                <td class="text-center">
                                    {{ single_price($order_detail->price) }}
                                </td>
                            </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
    </div>
    <div class="clearfix float-right" style="max-width: 340px; width: 100%">
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
        
        @if($refund_request->status == 0)
            <div class="row">
                {{-- <input type="hidden" id="product_id" value="{{$product_id}}"> --}}
                <div class="col-6">
                    <button id={{$refund_request->id}} type="button" class="btn btn-primary btn-block fw-700 fs-14 rounded-3 EdApprove">Accept Request</button>
                </div>
            
                {{-- <input type="hidden" id="product_id" value="{{$product_id}}"> --}}
                <div class="col-6">
                    <button id={{$refund_request->id}} type="button" class="btn btn-danger btn-block fw-700 fs-14 rounded-3 EdReject">Reject Request</button>
                </div>
            </div>
        @elseif($refund_request->status == 1)
            <form action="{{ route('refund.refund_success') }}" method="POST" enctype="multipart/form-data" id="final_checkout_form">
                @csrf
                    <input name="id_request" type="hidden" value="{{$refund_request->id}}">
                <div class="col-12">
                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label">{{ translate('Refund Proof Image') }}</label>
                        <div class="col-md-10">
                            <div class="input-group" data-toggle="aizuploader" data-type="image">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                <input type="hidden" name="proof_image" value="" class="selected-files">
                            </div>
                            <div class="file-preview box sm">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <button  type="button" class="btn btn-success btn-block fw-700 fs-14 rounded-4" onclick="submitOrder(this)">Refund</button>
                </div>
            </form>
        @endif
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
        $(document).on("click", ".EdApprove", function()
    {
        var serviceID = $(this).attr('id');
        $.ajax
        ({
            url: "{{route('refund.approve')}}",
            method:'post',
            data:{
                id_request:serviceID,
            },
            headers: {
                'X-CSRF-Token': '{{ csrf_token() }}',
            },
            success: function(data){
                location.reload();
                AIZ.plugins.notify('success','Aceept Request Successfully!!!!');
            }, 
            error: function(){
                location.reload();
                AIZ.plugins.notify('danger','Some Thing Went Wrong!!!!');
            }
        });
    });

    $(document).on("click", ".EdReject", function()
    {
        var serviceID = $(this).attr('id');
        $.ajax
        ({
            url: "{{route('refund.reject')}}",
            method:'post',
            data:{
                id_request:serviceID,
            },
            headers: {
                'X-CSRF-Token': '{{ csrf_token() }}',
            },
            success: function(data){
                location.reload();
                AIZ.plugins.notify('success','Reject Request Successfully!!!!');
            }, 
            error: function(){
                location.reload();
                AIZ.plugins.notify('danger','Some Thing Went Wrong!!!!');
            }
        });
    });

    function submitOrder(el) {
            $(el).prop('disabled', true);
            var image = $('.selected-files').val();
            if(image.length != 0)
            {
                $('#final_checkout_form').submit();
            }
            else
            {
                AIZ.plugins.notify('danger', '{{ translate('You need to upload image proof for refunded') }}');
                $(el).prop('disabled', false);
            }
        }
    </script>
@endsection