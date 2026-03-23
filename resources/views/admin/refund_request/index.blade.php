@extends('admin.layouts.app')
@section('content')

    <div class="card">
        <form id="sort_orders" action="" method="GET">
            <div class="card-header row gutters-5">
                <div class="col text-center text-md-left">
                    <h5 class="mb-md-0 h6">{{ translate('Refund Request') }}</h5>
                </div>
                {{-- <div class="col-md-3 ml-auto">
                    <select class="form-control aiz-selectpicker"
                        data-placeholder="{{ translate('Filter by Payment Status') }}" name="payment_status"
                        onchange="sort_orders()">
                        <option value="">{{ translate('Filter by Payment Status') }}</option>
                        <option value="paid"
                            @isset($payment_status) @if ($payment_status == 'paid') selected @endif @endisset>
                            {{ translate('Paid') }}</option>
                        <option value="unpaid"
                            @isset($payment_status) @if ($payment_status == 'unpaid') selected @endif @endisset>
                            {{ translate('Unpaid') }}</option>
                    </select>
                </div>

                <div class="col-md-3 ml-auto">
                    <select class="form-control aiz-selectpicker"
                        data-placeholder="{{ translate('Filter by Payment Status') }}" name="delivery_status"
                        onchange="sort_orders()">
                        <option value="">{{ translate('Filter by Deliver Status') }}</option>
                        <option value="waiting"
                            @isset($delivery_status) @if ($delivery_status == 'waiting') selected @endif @endisset>
                            {{ translate('Waiting') }}</option>
                        <option value="confirmed"
                            @isset($delivery_status) @if ($delivery_status == 'confirmed') selected @endif @endisset>
                            {{ translate('Confirmed') }}</option>
                        <option value="on_delivery"
                            @isset($delivery_status) @if ($delivery_status == 'on_delivery') selected @endif @endisset>
                            {{ translate('On delivery') }}</option>
                        <option value="delivered"
                            @isset($delivery_status) @if ($delivery_status == 'delivered') selected @endif @endisset>
                            {{ translate('Delivered') }}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="from-group mb-0">
                        <input type="text" class="form-control" id="search" name="search"
                            @isset($sort_search) value="{{ $sort_search }}" @endisset
                            placeholder="{{ translate('Type Order code & hit Enter') }}">
                    </div>
                </div> --}}
            </div>
        </form>

        @if (count($refund_request) > 0)
            <div class="card-body p-3">
                <table class="table aiz-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th data-breakpoints="lg">{{ translate('Refund Code') }}</th>
                            <th data-breakpoints="lg">{{ translate('Customer Name') }}</th>
                            <th data-breakpoints="lg">{{ translate('Product Name') }}</th>
                            <th data-breakpoints="lg">{{ translate('Order Date') }}</th>
                            <th data-breakpoints="md">{{ translate('Total Amount') }}</th>
                            <th data-breakpoints="lg">{{ translate('Delivery Status') }}</th>
                            <th data-breakpoints="lg">{{ translate('Payment Type') }}</th>
                            <th>{{ translate('Payment Status') }}</th>
                            <th class="text-right">{{ translate('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($refund_request as $key => $each_refund_request)
                            @if ($each_refund_request != null)
                                <tr>
                                    <td>
                                        {{ $key + 1 }}
                                    </td>
                                    <td>
                                        <a href="{{ route('refund.detail', ($each_refund_request->id)) }}">{{ $each_refund_request->code }}</a>
                                    </td>
                                    <td>
                                        @if ($each_refund_request->buyer_id != null)
                                            {{ optional($each_refund_request->user)->name }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($each_refund_request->order_detail != null)
                                            {{ optional($each_refund_request->order_detail)->product->name }}
                                        @endif
                                    </td>
                                    <td>
                                        {{ ($each_refund_request->order_detail->order->order_date) }}
                                    </td>
                                    
                                    <td>
                                        {{ single_price($each_refund_request->order_detail->price + $each_refund_request->order_detail->shipping_costg) }}

                                    </td>
                                    <td>
                                        @php
                                            $status =$each_refund_request->order_detail->delivery_status;
                                        @endphp
                                        {{ translate(ucfirst(str_replace('_', ' ', $status))) }}
                                    </td>
                                    <td>
                                        {{ ucfirst(str_replace('_', ' ', $each_refund_request->order_detail->order->payment_type))}}
                                    </td>
                                    <td>
                                        @if ($each_refund_request->order_detail->payment_status == 'paid')
                                            <span class="badge badge-inline badge-success">{{ translate('Paid') }}</span>
                                        @else
                                            <span class="badge badge-inline badge-danger">{{ translate('Unpaid') }}</span>
                                        @endif
                                    </td>
                                    <td class="text-right">
                                       
                                        <a href="{{ route('refund.detail', ($each_refund_request->id)) }}"
                                            class="btn btn-soft-info btn-icon btn-circle btn-sm"
                                            title="{{ translate('Order Details') }}">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                       
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
                <div class="aiz-pagination">
                    {{ $refund_request->links() }}
                </div>
            </div>
        @endif
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        function sort_orders(el) {
            $('#sort_orders').submit();
        }
    </script>
@endsection