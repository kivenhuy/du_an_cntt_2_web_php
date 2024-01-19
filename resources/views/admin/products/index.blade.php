@extends('admin.layouts.app')
@section('content')

    <div class="card">
        <form id="sort_orders" action="" method="GET">
            <div class="card-header row gutters-5">
                <div class="col text-center text-md-left">
                    <h5 class="mb-md-0 h6">{{ translate('All Product') }}</h5>
                </div>
                <div class="col-md-3">
                    <div class="from-group mb-0">
                        <input type="text" class="form-control" id="search" name="search"
                            @isset($sort_search) value="{{ $sort_search }}" @endisset
                            placeholder="{{ translate('Type Product Name & hit Enter') }}">
                    </div>
                </div>
            </div>
        </form>

        @if (count($product_data) > 0)
            <div class="card-body p-3">
                <table class="table aiz-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{translate('Products Name')}}</th>
                            <th>{{translate('Added By')}}</th>
                            <th>{{translate('Info')}}</th>
                            <th>{{translate('Total Stock')}}</th>
                            <th>{{translate('Published')}}</th>
                            <th>{{translate('Approved')}}</th>
                            <th>{{translate('Action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($product_data as $key => $each_product_data)
                            @if ($each_product_data != null)
                                <tr>
                                    <td>
                                        {{ $key + 1 }}
                                    </td>
                                    <td>
                                        {{$each_product_data->name}}
                                    </td>
                                    <td>
                                        {{$each_product_data->user->name}}
                                    </td>
                                    <td>
                                        <strong>Num of Sale:</strong>{{$each_product_data->num_of_sale}} times<br>
                                        <strong>Base Price:</strong>{{single_price($each_product_data->unit_price)}} <br>
                                    </td>
                                    <td>
                                        {{$each_product_data->product_stock->qty}}
                                    </td>
                                    <td>
                                        @if($each_product_data->published == 1)
                                            <label class="aiz-switch aiz-switch-success mb-0"> <input onchange="update_published(this)" value="{{$each_product_data->id}}" type="checkbox" checked> <span class="slider round"></span> </label>
                                        
                                        @else
                                            <label class="aiz-switch aiz-switch-success mb-0"> <input onchange="update_published(this)" value="{{$each_product_data->id}}" type="checkbox"> <span class="slider round"></span> </label>
                                   
                                        @endif
                                        
                                    </td>
                                    <td>
                                        @if($each_product_data->approved == 1)
                                            <label class="aiz-switch aiz-switch-success mb-0"> <input onchange="update_approved(this)" value="{{$each_product_data->id}}" type="checkbox" checked> <span class="slider round"></span> </label>
                                        
                                        @else
                                            <label class="aiz-switch aiz-switch-success mb-0"> <input onchange="update_approved(this)" value="{{$each_product_data->id}}" type="checkbox"> <span class="slider round"></span> </label>
                                   
                                        @endif
                                    </td>
                                    <td>
                                        <a class="btn btn-soft-info btn-icon btn-circle btn-sm" href="{{route('admin.products.edit', ['id'=>$each_product_data->id])}}" title="{{ translate('Details') }}">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
                <div class="aiz-pagination">
                    {{ $product_data->links() }}
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

        function update_published(el)
        {
            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('{{ route('seller.products.published') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                if(data == 1){
                    AIZ.plugins.notify('success', '{{ translate('Published products updated successfully') }}');
                }
                else if(data == 2){
                    AIZ.plugins.notify('danger', '{{ translate('Please upgrade your package.') }}');
                    location.reload();
                }
                else{
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                    location.reload();
                }
            });
        }

        function update_approved(el){
            if(el.checked){
                var approved = 1;
            }
            else{
                var approved = 0;
            }
            $.post('{{ route('admin.products.approved') }}', {
                _token      :   '{{ csrf_token() }}', 
                id          :   el.value, 
                approved    :   approved
            }, function(data){
                if(data == 1){
                    AIZ.plugins.notify('success', '{{ translate('Product approval update successfully') }}');
                }
                else{
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });

        }
    </script>
@endsection