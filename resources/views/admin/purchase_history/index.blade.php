@extends('admin.layouts.app')
@section('content')

    <div class="card">
        <form id="sort_orders" action="" method="GET">
            <div class="card-header row gutters-5">
                <div class="col text-center text-md-left">
                    <h5 class="mb-md-0 h6">Đơn hàng</h5>
                </div>
                <div class="col-md-3 ml-auto">
                    <select class="form-control aiz-selectpicker"
                        data-placeholder="Lọc theo trạng thái thanh toán" name="payment_status"
                        onchange="sort_orders()">
                        <option value="">Lọc theo trạng thái thanh toán</option>
                        <option value="paid"
                            @isset($payment_status) @if ($payment_status == 'paid') selected @endif @endisset>
                            Đã thanh toán</option>
                        <option value="unpaid"
                            @isset($payment_status) @if ($payment_status == 'unpaid') selected @endif @endisset>
                            Chưa thanh toán</option>
                    </select>
                </div>

                <div class="col-md-3 ml-auto">
                    <select class="form-control aiz-selectpicker"
                        data-placeholder="Lọc theo trạng thái giao hàng" name="delivery_status"
                        onchange="sort_orders()">
                        <option value="">Lọc theo trạng thái giao hàng</option>
                        <option value="waiting"
                            @isset($delivery_status) @if ($delivery_status == 'waiting') selected @endif @endisset>
                            Chờ xác nhận</option>
                        <option value="confirmed"
                            @isset($delivery_status) @if ($delivery_status == 'confirmed') selected @endif @endisset>
                            Đã xác nhận</option>
                        <option value="on_delivery"
                            @isset($delivery_status) @if ($delivery_status == 'on_delivery') selected @endif @endisset>
                            Đang giao hàng</option>
                        <option value="delivered"
                            @isset($delivery_status) @if ($delivery_status == 'delivered') selected @endif @endisset>
                            Đã giao hàng</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="from-group mb-0">
                        <input type="text" class="form-control" id="search" name="search"
                            @isset($sort_search) value="{{ $sort_search }}" @endisset
                            placeholder="Nhập mã đơn hàng & nhấn Enter">
                    </div>
                </div>
            </div>
        </form>

        @if (count($orders) > 0)
            <div class="card-body p-3">
                <table class="table aiz-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Mã đơn hàng</th>
                            <th data-breakpoints="lg">Số lượng sản phẩm</th>
                            <th data-breakpoints="lg">Tên khách hàng</th>
                            <th data-breakpoints="lg">Tên người bán</th>
                            <th data-breakpoints="lg">Ngày đặt hàng</th>
                            <th data-breakpoints="md">Tổng tiền</th>
                            <th data-breakpoints="lg">Trạng thái giao hàng</th>
                            <th data-breakpoints="lg">Phương thức thanh toán</th>
                            <th>Trạng thái thanh toán</th>
                            <th class="text-right">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $key => $order)
                            @if ($order != null)
                                <tr>
                                    <td>
                                        {{ $key + 1 }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.purchase_history.get_detail', ($order->id)) }}">{{ $order->code }}</a>
                                    </td>
                                    <td>
                                        {{ count($order->orderDetails->where('seller_id', $order->seller_id)) }}
                                    </td>
                                    <td>
                                        @if ($order->customer_id != null)
                                            {{ optional($order->user)->name }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($order->seller_id != null)
                                            {{ optional($order->seller->shop)->name }}
                                        @endif
                                    </td>
                                    <td>
                                        {{ ($order->order_date) }}
                                    </td>
                                    
                                    <td>
                                        {{ single_price($order->grand_total) }}
                                    </td>
                                    <td>
                                        @php
                                            $status = $order->delivery_status;
                                        @endphp
                                        {{ translate(ucfirst(str_replace('_', ' ', $status))) }}
                                    </td>
                                    <td>
                                        {{ ucfirst(str_replace('_', ' ', $order->payment_type))}}
                                    </td>
                                    <td>
                                        @if ($order->payment_status == 'paid')
                                            <span class="badge badge-inline badge-success">Đã thanh toán</span>
                                        @else
                                            <span class="badge badge-inline badge-danger">Chưa thanh toán</span>
                                        @endif
                                    </td>
                                    <td class="text-right">
                                       
                                        <a href="{{ route('admin.purchase_history.get_detail', ($order->id)) }}"
                                            class="btn btn-soft-primary btn-icon btn-circle btn-sm"
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
                    {{ $orders->links() }}
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