@extends('farm_management.layouts.app') 

@section('panel_content')
    <!-- Main content -->
    <div class="container-fluid">

        <div class="row">
          <div class="col-12">
            <div class="card">
                <div class="card-header row gutters-5">
                    <div class="col">
                        <h5 class="mb-md-0 h6">All Farmer</h5>
                    </div>
                    <div class="col">
                        <div class="mar-all mb-2" style=" text-align: end;">
                            <a href="{{route('farmer.create')}}">
                                <button type="submit" name="button" value="publish"
                                    class="btn btn-primary">Create</button>
                            </a>
                        </div>
                    </div>
                </div>
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                          <th>Farmer Name</th>
                          <th>Farmer Code</th>
                          <th>Contact Number</th>
                          <th>Gender</th>
                          <th>Status</th>
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
      <script>
        @if(Session::has('success'))
        toastr.options =
        {
          "closeButton" : true,
          "progressBar" : true
        }
        toastr.success("{{ session('success') }}");
        @endif
        @if(Session::has('add'))
        toastr.options =
        {
          "closeButton" : true,
          "progressBar" : true
        }
        toastr.success("{{ session('add') }}");
        @endif
        @if(Session::has('delete'))
        toastr.options =
        {
          "closeButton" : true,
          "progressBar" : true
        }
            toastr.success("{{ session('delete') }}");
        @endif
      </script>
@stop

@section('script')
<script type="text/javascript">


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
          deferRender: true,
          ajax: {
                url:"{{route('farmer.dtajax')}}",
                pages: 20
              },
          columns: [
              {data: 'full_name', name: 'full_name', render: function(data,type,row){
                return (data=="")?"":data;
              }},
              {data: 'farmer_code', name: 'farmer_code', render: function(data,type,row){
                return (data=="")?"":data;
              }},
              {data: 'phone_number', name: 'phone_number',render: function (data) {
                return (data=="")?"":data;
              }},
              {data: 'gender', name: 'gender',render: function (data) {
                return (data==1)?"Male":"Female";
              }},
              {data: 'status', name: 'status',render: function (data) {
                return (data=="active")?"Active":"Block";
              }},
          ],
          drawCallback:function(setting){
          
          $('[data-toggle="tooltip"]').tooltip();
          var abc = $(this).find('.dataTables_empty').length;
          console.log("aaaaaa" + abc);
          if ($(this).find('.dataTables_empty').length == 1) {
                // $('th').hide();
                // $('#example1_info').hide();
                $('#example1_paginate').hide();
          }
        },
        fnDrawCallback: function () {
          var abc = $(this).find('.dataTables_empty').length;
          console.log("aaaaaa" + abc);
        }
        });
    });

    
</script>
@endsection