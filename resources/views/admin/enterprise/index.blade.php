{{-- @extends('admin.layouts.app')
@section('content')
<div class="row">
        <div class="container-fluid">

            <div class="row">
              <div class="col-12">
                <div class="card">
                    <div class="card-header row gutters-5">
                        <div class="col">
                            <h5 class="mb-md-0 h6">All Enterprise</h5>
                        </div>
                    </div>
                    <div class="card-body" >
                        <table id="example1" class="table table-bordered table-striped">
                          <thead>
                              <tr>
                                <th>{{translate('Entprise Name')}}</th>
                                <th>{{translate('Phone')}}</th>
                                <th>{{translate('Email Address')}}</th>
                                <th>{{translate('Business Type')}}</th>
                                <th>{{translate('Organization Type')}}</th>
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
                  ajax: "{{ route('admin.enterprise.data_ajax') }}",
                  columns: [
                            {data: 'bussiness_name', name: 'bussiness_name', render: function(data){
                              return (data=="")?"":data;
                            }},
                            {data: 'phone', name: 'phone', render: function(data){
                                return (data=="")?"":data;
                            }},
                            {data: 'email', name: 'email', render: function(data, type, row){
                                return (data=="")?"":data;
                            }},
                            {data: 'bussiness_type', name: 'bussiness_type', render: function(data, type, row){
                                return (data=="")?"":data;
                            }},
                            {data: 'organization_type', name: 'organization_type', render: function(data){
                                return (data=="")?"":data;
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
    </script>
@endsection --}}


@extends('admin.layouts.app')
@section('content')

    <div class="card">
        <form id="sort_orders" action="" method="GET">
            <div class="card-header row gutters-5">
                <div class="col text-center text-md-left">
                    <h5 class="mb-md-0 h6">{{ translate('All Enterprie ') }}</h5>
                </div>
                <div class="col-md-3">
                    <div class="from-group mb-0">
                        <input type="text" class="form-control" id="search" name="search"
                            @isset($sort_search) value="{{ $sort_search }}" @endisset
                            placeholder="{{ translate('Type Enterprise Name code & hit Enter') }}">
                    </div>
                </div>
            </div>
        </form>

        @if (count($enterprise_data) > 0)
            <div class="card-body p-3">
                <table class="table aiz-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{translate('Entprise Name')}}</th>
                            <th>{{translate('Phone')}}</th>
                            <th>{{translate('Email Address')}}</th>
                            <th>{{translate('Organization Type')}}</th>
                            <th>{{translate('Action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($enterprise_data as $key => $each_enterprise_data)
                            @if ($each_enterprise_data != null)
                                <tr>
                                    <td>
                                        {{ $key + 1 }}
                                    </td>
                                    <td>
                                        {{ $each_enterprise_data->enterprise_detail->bussiness_name }}
                                    </td>
                                    <td>
                                        {{$each_enterprise_data->phone}}
                                    </td>
                                    <td>
                                        {{ $each_enterprise_data->email}}
                                    </td>
                                    
                                    <td>
                                        {{$each_enterprise_data->enterprise_detail->organization_type}}
                                    </td>
                                    
                                    
                                    
                                    
                                    <td class="text-right">
                                        
                                    
                                    </td>
                                       
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
                <div class="aiz-pagination">
                    {{ $enterprise_data->links() }}
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