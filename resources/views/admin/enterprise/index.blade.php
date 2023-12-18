@extends('admin.layouts.app')
@section('content')
<div class="row">
    {{-- <div class="col-sm-6 col-md-6 col-xxl-3"> --}}
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
    {{-- </div> --}}
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
@endsection