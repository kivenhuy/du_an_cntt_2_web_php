@extends('admin.layouts.app')
@section('content')
{{-- @include('flash::message') --}}
<div class="container-fluid">

    <div class="row">
      <div class="col-12">
        <div class="card">
            <div class="card-header row gutters-5">
                <div class="col">
                    <h5 class="mb-md-0 h6">{{translate('All Commune')}}</h5>
                </div>
                <div class="col">
                    <div class="mar-all mb-2" style=" text-align: end;">
                        <a href="{{route('commune.create')}}">
                            <button type="submit" name="button" value="publish"
                                class="btn btn-primary">Create</button>
                        </a>
                    </div>
                </div>
            </div>
          <div class="card-body" >
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                  <tr>
                    <th>{{translate('Province Name')}}</th>
                    <th>{{translate('Commune Name')}}</th>
                      <th>{{translate('Commune Code')}}</th>
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
                  ajax: "{{ route('commune.data_ajax') }}",
                  columns: [
                            {data: 'province_name', name: 'province_name', render: function(data){
                              return (data=="")?"":data;
                          }},
                          {data: 'commune_name', name: 'commune_name', render: function(data){
                              return (data=="")?"":data;
                          }},
                          {data: 'commune_code', name: 'commune_code',render: function (data) {
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