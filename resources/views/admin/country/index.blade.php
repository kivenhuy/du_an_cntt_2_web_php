@extends('admin.layouts.app')
@section('content')
{{-- @include('flash::message') --}}
<div class="container-fluid">

    <div class="row">
      <div class="col-12">
        <div class="card">
            <div class="card-header row gutters-5">
                <div class="col">
                    <h5 class="mb-md-0 h6">Tất cả quốc gia</h5>
                </div>
                <div class="col">
                    <div class="mar-all mb-2" style=" text-align: end;">
                        <a href="{{route('country.create')}}">
                            <button type="button" class="btn btn-primary">
                                <i class="fa fa-plus mr-1"></i>Tạo quốc gia
                            </button>
                        </a>
                    </div>
                </div>
            </div>
          <div class="card-body" >
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                  <tr>
                      <th>Tên quốc gia</th>
                      <th>Mã quốc gia</th>
                      <th>Hành động</th>
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
                  ajax: "{{ route('country.data_ajax') }}",
                  columns: [
                          {data: 'country_name', name: 'country_name', render: function(data){
                              return (data=="")?"":data;
                          }},
                          {data: 'country_code', name: 'country_code',render: function (data) {
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