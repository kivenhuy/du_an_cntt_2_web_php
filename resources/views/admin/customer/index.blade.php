@extends('admin.layouts.app')
@section('content')

    <div class="card">
        <form id="sort_orders" action="" method="GET">
            <div class="card-header row gutters-5">
                <div class="col text-center text-md-left">
                    <h5 class="mb-md-0 h6">{{ translate('All Customer') }}</h5>
                </div>
                <div class="col-md-3">
                    <div class="from-group mb-0">
                        <input type="text" class="form-control" id="search" name="search"
                            @isset($sort_search) value="{{ $sort_search }}" @endisset
                            placeholder="{{ translate('Type Customer Name code & hit Enter') }}">
                    </div>
                </div>
            </div>
        </form>

        @if (count($customer_data) > 0)
            <div class="card-body p-3">
                <table class="table aiz-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{translate('Customer Name')}}</th>
                            <th>{{translate('Phone')}}</th>
                            <th>{{translate('Email Address')}}</th>
                            <th>{{translate('Action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customer_data as $key => $each_customer_data)
                            @if ($each_customer_data != null)
                                <tr>
                                    <td>
                                        {{ $key + 1 }}
                                    </td>
                                    <td>
                                        {{ $each_customer_data->name }}
                                    </td>
                                    <td>
                                        {{$each_customer_data->phone}}
                                    </td>
                                    <td>
                                        {{ $each_customer_data->email}}
                                    </td>
                                    
                                    
                                    
                                    
                                    <td>
                                        <a href="{{ route('admin.customer.detail', $each_customer_data->id) }}"
                                            class="btn btn-soft-info btn-icon btn-circle btn-sm"
                                            title="{{ translate('Customer Details') }}">
                                            <i class="fa fa-eye"></i>
                                    
                                    </td>
                                       
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
                <div class="aiz-pagination">
                    {{ $customer_data->links() }}
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