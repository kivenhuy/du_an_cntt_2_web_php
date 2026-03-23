@extends('admin.layouts.app')
@section('content')

    <div class="card">
        {{-- <form id="sort_orders" action="" method="GET"> --}}
            <div class="card-header row gutters-5">
                <div class="col text-center text-md-left">
                    <h5 class="mb-md-0 h6">{{ translate('All Shipper') }}</h5>
                </div>
                {{-- <div class="col-md-3">
                    <div class="from-group mb-0">
                        <input type="text" class="form-control" id="search" name="search"
                            @isset($sort_search) value="{{ $sort_search }}" @endisset
                            placeholder="{{ translate('Type Order code & hit Enter') }}">
                    </div>
                </div> --}}
            </div>
        {{-- </form> --}}

        @if (count($shipper_data) > 0)
            <div class="card-body p-3">
                <table class="table aiz-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{translate('Shipper Name')}}</th>
                            <th>{{translate('Phone')}}</th>
                            <th>{{translate('Email Address')}}</th>
                            <th>{{translate('National ID')}}</th>
                            <th>{{translate('Type Vehicle')}}</th>
                            <th>{{translate('Carrier')}}</th>
                            <th>{{translate('Approved')}}</th>
                            <th>{{translate('Action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($shipper_data as $key => $each_shipper)
                            @if ($each_shipper != null)
                                <tr>
                                    <td>
                                        {{ $key + 1 }}
                                    </td>
                                    <td>
                                        {{ $each_shipper->name }}
                                    </td>
                                    <td>
                                        {{$each_shipper->phone}}
                                    </td>
                                    <td>
                                        {{ $each_shipper->email}}
                                    </td>
                                    <td>
                                        {{$each_shipper->national_id}}
                                    </td>
                                    <td>
                                      {{ $each_shipper->shipper_detail->vehicle}}
                                    </td>
                                    <td>
                                      @php
                                          $carrier_data = \App\Models\Carrier::find($each_shipper->carrier_id);
                                      @endphp
                                        {{$carrier_data->name}}
                                    </td>
                                    <td>
                                        @if (($each_shipper->approved) == 1)
                                            <label class="aiz-switch aiz-switch-success mb-0"> <input onchange="update_approved(this)" value="{{$each_shipper->id}}" type="checkbox" checked> <span class="slider round"></span> </label>
                                        @else
                                            <label class="aiz-switch aiz-switch-success mb-0"> <input onchange="update_approved(this)" value="{{$each_shipper->id}}" type="checkbox"> <span class="slider round"></span> </label>
                                        @endif
                                    </td>
                                    
                                    
                                    
                                    <td class="text-right">
                                      <a href="{{ route('admin.shipper_detail', $each_shipper->id) }}"
                                        class="btn btn-soft-info btn-icon btn-circle btn-sm"
                                        title="{{ translate('Shipper Details') }}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    
                                    </td>
                                       
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
                <div class="aiz-pagination">
                    {{ $shipper_data->links() }}
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

        function update_approved(el){
            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('{{ route('admin.shipper.approved') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                if(data == 1){
                    AIZ.plugins.notify('success', '{{ translate('Approved Shipper updated successfully') }}');
                }
                else{
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }
    </script>
@endsection