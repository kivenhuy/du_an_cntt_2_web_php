@extends('admin.layouts.app')
@section('content')
    <div class="aiz-titlebar mt-2 mb-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h4 class="text-primary" style="color: #181827 !important">{{ translate('Admin Dashboard') }}</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6 col-md-6 col-xxl-3">
            <div class="card shadow-none mb-4 bg-primary py-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <p class="small text-muted mb-0">
                                <span class="fe fe-arrow-down fe-12"></span>
                                <span class="fs-14 text-light">{{ translate('All Products') }}</span>
                            </p>
                            <h3 class="mb-0 text-white fs-30">
                                {{ $product }}
                            </h3>

                        </div>
                        <div class="col-auto text-right">
                            <svg xmlns="http://www.w3.org/2000/svg" width="64.001" height="64" viewBox="0 0 64.001 64">
                                <path id="Path_66" data-name="Path 66"
                                    d="M146.431,117.56l-26.514-10.606a8.014,8.014,0,0,0-5.944,0L87.458,117.56a4,4,0,0,0-2.514,3.714v34.217a4,4,0,0,0,2.514,3.714l26.514,10.606a8.013,8.013,0,0,0,5.944,0L146.431,159.2a4,4,0,0,0,2.514-3.714V121.274a4,4,0,0,0-2.514-3.714m-31.714-8.748a5.981,5.981,0,0,1,4.456,0l26.1,10.44a1,1,0,0,1,0,1.858l-12.332,4.932-30.654-12.26Zm1.228,59.633L88.2,157.347a2,2,0,0,1-1.258-1.856V122.6l29,11.6Zm1-36L88.612,121.11a1,1,0,0,1,0-1.858L99.6,114.858l30.654,12.262Zm30,23.048a2,2,0,0,1-1.258,1.856l-27.742,11.1V134.2l13-5.2V146.61a1.035,1.035,0,0,0,2-.466V128.2l14-5.6Z"
                                    transform="translate(-84.944 -106.382)" fill="#FFFFFF" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        <div class="col-sm-6 col-md-6 col-xxl-3">
            <div class="card shadow-none mb-4 bg-primary py-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <p class="small text-muted mb-0">
                                <span class="fe fe-arrow-down fe-12"></span>
                                <span class="fs-14 text-light">{{ translate('All Customer') }}</span>
                            </p>
                            <h3 class="mb-0 text-white fs-30">
                                {{$customer }}
                            </h3>
                        </div>
                        <div class="col-auto text-right">
                            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="white" class="bi bi-person" viewBox="0 0 16 16">
                                <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                              </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       

    </div>

    {{-- Doanh thu + biểu đồ trạng thái đơn hàng --}}
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 h6">Doanh thu &amp; trạng thái đơn hàng</h5>
                    <small class="text-muted">Doanh thu: tổng <code>grand_total</code> các đơn có <strong>Đã thanh toán</strong>. Biểu đồ: số đơn theo trạng thái giao hàng.</small>
                </div>
                <div class="card-body">
                    <div class="row align-items-stretch">
                        <div class="col-lg-4 mb-4 mb-lg-0">
                            <div class="rounded p-4 mb-3 admin-dash-revenue-total">
                                <p class="text-muted small mb-1">Tổng doanh thu (đã thanh toán)</p>
                                <h3 class="mb-0 font-weight-bold text-success">{{ single_price($revenue_paid_total) }}</h3>
                            </div>
                            <div class="border rounded p-4 mb-3">
                                <p class="text-muted small mb-1">Doanh thu tháng {{ now()->format('m/Y') }}</p>
                                <h4 class="mb-0 font-weight-bold text-primary">{{ single_price($revenue_month) }}</h4>
                            </div>
                            <p class="mb-0 text-muted">
                                <i class="fa fa-shopping-bag mr-1"></i>
                                Tổng số đơn: <strong>{{ $orders_count }}</strong>
                            </p>
                        </div>
                        <div class="col-8">
                            <div id="container_3" class="w-100"></div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div id="container_1"></div>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <div id="chart_order_status" class="w-100 admin-dash-chart-pie"></div>
                    @if(!empty($shipping_status))
                        <div class="table-responsive mt-3">
                            <table class="table table-sm table-bordered mb-0 bg-white">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Trạng thái giao hàng</th>
                                        <th class="text-right" style="width:120px">Số đơn</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($shipping_status as $row)
                                        <tr>
                                            <td>{{ $row[0] }}</td>
                                            <td class="text-right font-weight-bold">{{ $row[1] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
                
            </div>
        </div>
    </div>

    <style>
        .bg-primary
        {
            background-color: #181827 !important;
        }
        .admin-dash-revenue-total {
            background: rgba(46, 127, 37, 0.08);
            border: 1px solid rgba(46, 127, 37, 0.2);
        }
        .admin-dash-chart-pie {
            min-height: 380px;
            height: 380px;
            width: 100%;
        }
    </style>
@endsection

@section('script')
{{-- Phiên bản cố định (UMD), tránh lỗi bundle mới của CDN --}}
<script src="https://cdn.jsdelivr.net/npm/highcharts@10.3.3/highcharts.js"></script>
<script>
    var data_revenue = {!! json_encode($data_revenue, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) !!};
    var shipping_status = {!! json_encode($shipping_status ?? [], JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) !!};
    var quantity_product = {!! json_encode($quantity_product, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) !!};

    function renderOrderStatusPie() {
        var el = document.getElementById('chart_order_status');
        if (!el) return;
        if (typeof Highcharts === 'undefined') {
            el.innerHTML = '<p class="text-danger small mb-0">Không tải được thư viện biểu đồ (Highcharts). Kiểm tra mạng hoặc chặn CDN.</p>';
            return;
        }
        if (!shipping_status || !shipping_status.length) {
            el.innerHTML = '<p class="text-muted text-center py-5 mb-0">Chưa có dữ liệu đơn hàng để hiển thị biểu đồ.</p>';
            return;
        }
        try {
            Highcharts.chart('chart_order_status', {
                chart: {
                    type: 'pie',
                    height: 380,
                    backgroundColor: 'transparent'
                },
                title: { text: 'Đơn hàng theo trạng thái giao hàng' },
                subtitle: { text: 'Mỗi phần = một đơn hàng' },
                tooltip: {
                    pointFormat: '<b>{point.y}</b> đơn ({point.percentage:.1f}%)'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.y}'
                        },
                        showInLegend: true
                    }
                },
                credits: { enabled: false },
                series: [{
                    name: 'Số đơn',
                    colorByPoint: true,
                    data: shipping_status.map(function (row) {
                        return { name: row[0], y: Number(row[1]) };
                    })
                }]
            });
        } catch (e) {
            el.innerHTML = '<p class="text-danger small mb-0">Lỗi vẽ biểu đồ: ' + (e && e.message ? e.message : '') + '</p>';
        }
    }

    if (window.jQuery) {
        jQuery(function () {
            setTimeout(renderOrderStatusPie, 50);
        });
    } else {
        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(renderOrderStatusPie, 50);
        });
    }

    if (typeof Highcharts !== 'undefined') {
    Highcharts.chart('container_1', 
    {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Tồn kho theo sản phẩm'
            },
            subtitle: {
                text: 'Tổng số lượng còn (current_stock)'
            },
            xAxis: {
                type: 'category',
            },
            yAxis: {
                title: {
                    text: 'Số lượng còn'
                },
                allowDecimals: false,
                min: 0
            },
            plotOptions: {
                column: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            series: [{
                name: 'Số lượng còn',
                data: quantity_product
            }]
    });

    Highcharts.chart('container_3',
    {
        chart: {
            type: 'pie'
        },
        title: {
            text: 'Doanh thu theo hình thức thanh toán (tất cả đơn)'
        },
        subtitle: {
            text: 'Tổng grand_total theo payment_type'
        },
        tooltip: {
            pointFormat: '<span style="color:{point.color}">\u25CF</span> {series.name}: <b>{point.y:,.0f} đ</b> ({point.percentage:.1f}%)'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.y:,.0f} đ'
                },
                showInLegend: true
            }
        },
        credits: { enabled: false },
        series: [{
            name: 'Doanh thu',
            colorByPoint: true,
            data: data_revenue.map(function (row) {
                return { name: row[0], y: row[1] };
            })
        }]
    });
    }
</script>

@endsection