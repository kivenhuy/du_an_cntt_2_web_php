@extends('admin.layouts.app')
@section('content')

    <div class="card">
        <form id="sort_orders" action="" method="GET">
            <div class="card-header row gutters-5">
                <div class="col text-center text-md-left">
                    <h5 class="mb-md-0 h6">{{ translate('All Request Product') }}</h5>
                </div>
                <div class="col-md-3 ml-auto">
                    <select class="form-control aiz-selectpicker"
                        data-placeholder="{{ translate('Filter by Status') }}" name="status"
                        onchange="sort_orders()">
                        <option value="">{{ translate('Filter by Status') }}</option>
                        <option value="0"
                            @isset($status) @if ($status == 0) selected @endif @endisset>
                            {{ translate('Pending Admin Approve') }}</option>
                        <option value="1"
                            @isset($status) @if ($status == 1) selected @endif @endisset>
                            {{ translate('Pending Seller Accept') }}</option>
                        <option value="2"
                            @isset($status) @if ($status == 2) selected @endif @endisset>
                            {{ translate('Pending Price Update')}}</option>
                        <option value="3"
                            @isset($status) @if ($status == 3) selected @endif @endisset>
                            {{ translate('Waiting For Customer') }}</option>
                        <option value="4"
                            @isset($status) @if ($status == 4) selected @endif @endisset>
                            {{ translate('Added To Cart') }}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="from-group mb-0">
                        <input type="text" class="form-control" id="search" name="search"
                            @isset($sort_search) value="{{ $sort_search }}" @endisset
                            placeholder="{{ translate('Type Order code & hit Enter') }}">
                    </div>
                </div>
            </div>
        </form>

        @if (count($request_data) > 0)
            <div class="card-body p-3">
                <table class="table aiz-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{translate('Code')}}</th>
                            <th>{{translate('Products Name')}}</th>
                            <th>{{translate('Seller Name')}}</th>
                            <th>{{translate('Buyer Name')}}</th>
                            <th>{{translate('Quantity')}}</th>
                            <th>{{translate('Unit Price')}}</th>
                            <th>{{translate('Status')}}</th>
                            <th>{{translate('Apprrove')}}</th>
                            <th>{{translate('Action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($request_data as $key => $each_request_data)
                            @if ($each_request_data != null)
                                <tr>
                                    <td>
                                        {{ $key + 1 }}
                                    </td>
                                    <td>
                                        <a href="{{ route('request_for_product.get_details_data', $each_request_data->id) }}"
                                            >{{ $each_request_data->code }}</a>
                                    </td>
                                    <td>
                                        {{$each_request_data->product_name}}
                                    </td>
                                    <td>
                                        {{$each_request_data->seller_name}}
                                    </td>
                                    <td>
                                        {{$each_request_data->user->name}}
                                    </td>
                                    <td>
                                        {{$each_request_data->quantity}}
                                    </td>
                                    <td>
                                        {{$each_request_data->price}}
                                    </td>
                                    
                                    <td>
                                        @if ($each_request_data->status == 0)
                                            <span class='badge badge-inline badge-secondary'>{{translate('Pending Admin Approval')}}</span>
                                        @elseif($each_request_data->status == 1)
                                            <span class='badge badge-inline badge-secondary'>{{translate('Pending Seller Accept')}}</span>
                                        @elseif($each_request_data->status == 2)
                                            <span class='badge badge-inline badge-warning'>{{translate('Pending Price Update')}}</span>
                                        @elseif($each_request_data->status == 3)
                                            <span class='badge badge-inline badge-info' >{{translate('Waiting For Customer')}}</span>
                                        @else
                                            <span class='badge badge-inline badge-success' style='background-color:#28a745 !important'>{{translate('Process To Checkout')}}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($each_request_data->status != 0)
                                            <label class="aiz-switch aiz-switch-success mb-0"> <input onchange="update_approved(this)" value="{{$each_request_data->id}}" type="checkbox" checked> <span class="slider round"></span> </label>
                                        
                                        @else
                                            <label class="aiz-switch aiz-switch-success mb-0"> <input onchange="update_approved(this)" value="{{$each_request_data->id}}" type="checkbox"> <span class="slider round"></span> </label>
                                   
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        <a href="{{ route('request_for_product.get_details_data', $each_request_data->id) }}"
                                            class="btn btn-soft-info btn-icon btn-circle btn-sm"
                                            title="{{ translate('Request Details') }}">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    
                                    </td>
                                       
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
                <div class="aiz-pagination">
                    {{ $request_data->links() }}
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

        function update_approved(el)
{
        if(el.checked){
            var status = 1;
        }
        else{
            var status = 0;
        }
        $.post('{{ route('request_for_product.admin_approved') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
            if(data == 1){
                AIZ.plugins.notify('success', '{{ translate('Approved request updated successfully') }}');
                location.reload();
            }
            else{
                AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                location.reload();
            }
        });
    }
    </script>
@endsection