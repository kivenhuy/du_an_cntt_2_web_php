{{-- @extends('admin.layouts.app')
@section('content')
<div class="row">
    
        <div class="container-fluid">

            <div class="row">
              <div class="col-12">
                <div class="card">
                    <div class="card-header row gutters-5">
                        <div class="col">
                            <h5 class="mb-md-0 h6">All Products</h5>
                        </div>
                    </div>
                    <div class="card-body" >
                        <table id="example1" class="table table-bordered table-striped">
                          <thead>
                              <tr>
                                <th>{{translate('Seller Name')}}</th>
                                <th>{{translate('Phone')}}</th>
                                <th>{{translate('Email Address')}}</th>
                                <th>{{translate('Verification Info')}}</th>
                                <th>{{translate('Approved')}}</th>
                                <th>{{translate('Num.of Products')}}</th>
                                <th>{{translate('Due to seller')}}</th>
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
    <script type="text/javascript">
        $(document).on("change", ".check-all", function() {
            if(this.checked) {
                // Iterate each checkbox
                $('.check-one:checkbox').each(function() {
                    this.checked = true;                        
                });
            } else {
                $('.check-one:checkbox').each(function() {
                    this.checked = false;                       
                });
            }
          
        });


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
                  ajax: "{{ route('admin.sellers.data_ajax') }}",
                  columns: [
                            {data: 'name', name: 'name', render: function(data){
                              return (data=="")?"":data;
                          }},
                            {data: 'phone', name: 'phone', render: function(data){
                              return (data=="")?"":data;
                          }},
                            {data: 'email', name: 'email', render: function(data, type, row){
                                return (data=="")?"":data;
                          }},
                            {data: 'verification_info', name: 'verification_info', render: function(data){
                              return (data=="")?"":data;
                          }},                          
                          {data: 'verification_status', name: 'verification_status', render: function(data, type, row){
                              return (data==1)?
                              '<label class="aiz-switch aiz-switch-success mb-0"> <input onchange="update_approved(this)" value="'+row.id+'" type="checkbox" checked> <span class="slider round"></span> </label>'
                              :
                              '<label class="aiz-switch aiz-switch-success mb-0"> <input onchange="update_approved(this)" value="'+row.id+'" type="checkbox"> <span class="slider round"></span> </label>';
                          }},
                          {data: 'num_product', name: 'num_product'},   
                          {data: 'due_to_seller', name: 'due_to_seller'},   
                            {
                                    data: 'action', 
                                    name: 'action', 
                                    orderable: true, 
                                    searchable: true
                            },
                  ],
          }).buttons().container().appendTo('#example1_wrapper .col-md-6');
        });
        
        

        function update_approved(el){
            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('{{ route('admin.sellers.approved') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                if(data == 1){
                    AIZ.plugins.notify('success', '{{ translate('Approved sellers updated successfully') }}');
                }
                else{
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }

        

    </script>
@endsection --}}

@extends('admin.layouts.app')
@section('content')

    <div class="card">
        <form id="sort_orders" action="" method="GET">
            <div class="card-header row gutters-5">
                <div class="col text-center text-md-left">
                    <h5 class="mb-md-0 h6">{{ translate('All Request Product') }}</h5>
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

        @if (count($shop_data) > 0)
            <div class="card-body p-3">
                <table class="table aiz-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{translate('Seller Name')}}</th>
                            <th>{{translate('Phone')}}</th>
                            <th>{{translate('Email Address')}}</th>
                            <th>{{translate('Verification Info')}}</th>
                            <th>{{translate('Approved')}}</th>
                            <th>{{translate('Num.of Products')}}</th>
                            <th>{{translate('Action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($shop_data as $key => $each_shop_data)
                            @if ($each_shop_data != null)
                                <tr>
                                    <td>
                                        {{ $key + 1 }}
                                    </td>
                                    <td>
                                        {{ $each_shop_data->name }}
                                    </td>
                                    <td>
                                        {{$each_shop_data->user->phone}}
                                    </td>
                                    <td>
                                        {{ $each_shop_data->user->email}}
                                    </td>
                                    <td>
                                        {{$each_shop_data->verification_info}}
                                    </td>
                                    <td>
                                        @if ($each_shop_data->verification_status == 1)
                                            <label class="aiz-switch aiz-switch-success mb-0"> <input onchange="update_approved(this)" value="{{$each_shop_data->id}}" type="checkbox" checked> <span class="slider round"></span> </label>
                                        @else
                                            <label class="aiz-switch aiz-switch-success mb-0"> <input onchange="update_approved(this)" value="{{$each_shop_data->id}}" type="checkbox"> <span class="slider round"></span> </label>
                                        @endif
                                    </td>
                                    <td>
                                        {{$each_shop_data->user->products->count()}}
                                    </td>
                                    
                                    
                                    
                                    <td class="text-right">
                                        
                                    
                                    </td>
                                       
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
                <div class="aiz-pagination">
                    {{ $shop_data->links() }}
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
            $.post('{{ route('admin.sellers.approved') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                if(data == 1){
                    AIZ.plugins.notify('success', '{{ translate('Approved sellers updated successfully') }}');
                }
                else{
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }
    </script>
@endsection