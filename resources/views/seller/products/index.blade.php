{{-- @extends('seller.layouts.app')
@section('panel_content')
<div class="row">
        <div class="container-fluid">

            <div class="row">
              <div class="col-12">
                <div class="card">
                    <div class="card-header row gutters-5">
                        <div class="col">
                            <h5 class="mb-md-0 h6">All Products</h5>
                        </div>
                        @if (Auth::user()->shop->verification_status == 1)
                            <div class="col">
                                <div class="mar-all mb-2" style=" text-align: end;">
                                    <a href="{{route('seller.products.create')}}">
                                        <button type="submit" name="button" value="publish"
                                            class="btn btn-primary">Create</button>
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="card-body" >
                        <table id="example1" class="table table-bordered table-striped">
                          <thead>
                              <tr>
                                <th>{{translate('Products Name')}}</th>
                                <th>{{translate('Category Name')}}</th>
                                <th>{{translate('Quantity')}}</th>
                                <th>{{translate('Unit Price')}}</th>
                                <th>{{translate('Approved')}}</th>
                                <th>{{translate('Published')}}</th>
                                <th>{{translate('Action')}}</th>
                              </tr>
                          </thead>
                          <tbody>
                              <tr>
                              </tr>
                          </tbody>
                        </table>
                      </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
</div>
@endsection

    

@section('script')
<script>
$(document).ready(function()
  {   
  
          var rfq_table = $("#example1").DataTable
          ({
              lengthChange: true,
              responsive: true,
              processing: true,
              searching: false,
              bSort:false,
              serverSide: true,
                  ajax: "{{ route('seller.products.data_ajax') }}",
                  columns: [
                            {data: 'name', name: 'name', render: function(data){
                              return (data=="")?"":data;
                          }},
                          {data: 'category_name', name: 'category_name', render: function(data){
                              return (data=="")?"":data;
                          }},
                          {data: 'current_stock', name: 'current_stock',render: function (data) {
                                return (data=="")?"":data;
                            }},
                            {data: 'unit_price', name: 'unit_price', render: function(data){
                              return (data=="")?"":data;
                          }},
                          {data: 'approved', name: 'approved', render: function(data){
                              return (data==1)?'<span class="badge badge-inline badge-success">Approved</span>':'<span class="badge badge-inline badge-primary">Pending</span>';
                          }},
                          {data: 'published', name: 'published', render: function(data, type, row){
                              return (data==1)?
                              '<label class="aiz-switch aiz-switch-success mb-0"> <input onchange="update_published(this)" value="'+row.id+'" type="checkbox" checked> <span class="slider round"></span> </label>'
                              :
                              '<label class="aiz-switch aiz-switch-success mb-0"> <input onchange="update_published(this)" value="'+row.id+'" type="checkbox"> <span class="slider round"></span> </label>';
                          }},
                            {
                                    data: 'action', 
                                    name: 'action', 
                                    orderable: true, 
                                    searchable: true
                            },
                  ],
          }).buttons().container().appendTo('#example1_wrapper .col-md-6');
  });

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
</script>
@endsection --}}

@extends('seller.layouts.app')
@section('panel_content')

    <div class="card">
        <div class="card-header row gutters-5">
            <div class="col">
                <h5 class="mb-md-0 h6">All Products</h5>
            </div>
            @if (Auth::user()->shop->verification_status == 1)
                <div class="col">
                    <div class="mar-all mb-2" style=" text-align: end;">
                        <a href="{{route('seller.products.create')}}">
                            <button type="submit" name="button" value="publish"
                                class="btn btn-primary">Create</button>
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <form id="sort_orders" action="" method="GET">
            <div class="card-header row gutters-5">
                

                <div class="col-md-3 ml-auto">
                    <select class="form-control aiz-selectpicker"
                        data-placeholder="{{ translate('Filter by Status') }}" name="status"
                        onchange="sort_orders()">
                        <option value="">{{ translate('Filter by Status') }}</option>
                        <option value="0"
                            @isset($status) @if ($status == 0) selected @endif @endisset>
                            {{ translate('Pending') }}</option>
                        <option value="1"
                            @isset($status) @if ($status == 1) selected @endif @endisset>
                            {{ translate('Aprrove') }}</option>
                    </select>
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

        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th width="30%">{{ translate('Name')}}</th>
                        <th data-breakpoints="md">{{ translate('Category')}}</th>
                        <th data-breakpoints="md">{{ translate('Current Qty')}}</th>
                        <th>{{ translate('Price')}}</th>
                        {{-- @if(get_setting('product_approve_by_admin') == 1) --}}
                        <th data-breakpoints="md">{{ translate('Approval')}}</th>
                        {{-- @endif --}}
                        <th data-breakpoints="md">{{ translate('Published')}}</th>
                        <th data-breakpoints="md" class="text-right">{{ translate('Options')}}</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($products as $key => $product)
                        <tr>
                            <td>
                                {{ $key + 1 }}
                            </td>
                            <td>
                                <a href="{{ route('product', $product->slug) }}" target="_blank" class="text-reset">
                                    {{ $product->name }}
                                </a>
                            </td>
                            <td>
                                @if ($product->category != null)
                                    {{ $product->category->name }}
                                @endif
                            </td>
                            <td>
                                {{$product->product_stock->qty}}
                            </td>
                            <td>{{ $product->unit_price }}</td>
                            
                            <td>
                                @if ($product->approved == 1)
                                    <span class="badge badge-inline badge-success">{{ translate('Approved')}}</span>
                                @else
                                    <span class="badge badge-inline badge-info">{{ translate('Pending')}}</span>
                                @endif
                            </td>
                            <td>
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input onchange="" value="{{ $product->id }}" type="checkbox" <?php if($product->published == 1) echo "checked";?> >
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <td class="text-right">
                            <a class="btn btn-soft-info btn-icon btn-circle btn-sm" href="{{route('seller.products.edit', ['id'=>$product->id, 'lang'=>env('DEFAULT_LANGUAGE')])}}" title="{{ translate('Edit') }}">
                                <i class="fa fa-edit"></i>
                            </a>
                            
                        </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination">
                {{ $products->links() }}
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        function sort_orders(el) {
            $('#sort_orders').submit();
        }
    </script>
@endsection