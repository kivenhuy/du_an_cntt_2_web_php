@extends('user_layout.layouts.user_panel')

@section('panel_content')

    <div class="card">
        <form  action="{{ route('recommend_reqeuest.create') }}" method="POST" id="final_checkout_form">
            @csrf
            <input type="hidden" name="product_id" id="product_id" >
            <input type="hidden" name="quantity" id="quantity" >
            <div class="card-header row gutters-5">
                <div class="col text-center text-md-left">
                    <h5 class="mb-md-0 h6">{{ translate('Recommendation Request For Products') }}</h5>
                </div>

            </div>
        

            @if (count($fresh_fruit_high_quantity) > 0)
                <div class="card-body p-3">
                    <table class="table aiz-table mb-0">
                        <thead>
                            <tr>
                                <th>{{ translate('Product ID') }}</th>
                                <th data-breakpoints="lg">{{ translate('Product Name') }}</th>
                                <th data-breakpoints="lg">{{ translate('Seller') }}</th>
                                <th data-breakpoints="md">{{ translate('Quantity') }}</th>
                                <th class="text-right">{{ translate('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($fresh_fruit_high_quantity as $key => $each_fresh_fruit_high_quantity)
                                @if ($each_fresh_fruit_high_quantity != null)
                                    <tr>
                                        <td class="product_id">
                                            {{ $each_fresh_fruit_high_quantity->id }}
                                        </td>
                                        <td>
                                            @if($each_fresh_fruit_high_quantity->id != 0)
                                                <a href="{{ route('product', $each_fresh_fruit_high_quantity->slug) }}"
                                                >{{ $each_fresh_fruit_high_quantity->name }}</a>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $each_fresh_fruit_high_quantity->user->name }}
                                        </td>
                                        <td class="quantity">
                                            {{ $each_fresh_fruit_high_quantity->product_stock->qty/$count_enteprise }} KG
                                        </td>
                                    <td class="text-right">
                                        @if($each_fresh_fruit_high_quantity->id != 0)
                                            <button type="submit" class="btn btn-primary" onclick="rowClicked(this)">Request Now</button>
                                        @endif 
                                        {{-- @if(in_array($each_request_data->status,[90,97,98,99]))
                                            <a href="{{ route('request_for_product.destroy', $each_request_data->id) }}" class="btn btn-soft-danger btn-icon btn-circle btn-sm " title="Delete">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        @endif --}}
                                    
                                    </td>
                                        
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                    {{-- <div class="aiz-pagination">
                        {{ $fresh_fruit_high_quantity->links() }}
                    </div> --}}
                </div>
            @endif
        </form>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        function sort_orders(el) {
            $('#sort_orders').submit();
        }

        function rowClicked(element){
            var id = $(element).closest("tr").find('.product_id').text();
            var quantity = $(element).closest("tr").find('.quantity').text();
            $('#product_id').val(id)
            $('#quantity').val(quantity)
            // if(id != null)
            // {
                $('#final_checkout_form').submit();
            // }
        }
    </script>
@endsection