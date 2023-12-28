@extends('admin.layouts.app')


@section('content')
<div class="container-fluid">

    <div class="row">
      <div class="col-12">
        <div class="card">
            <div class="card-header row gutters-5">
                <div class="col">
                    <h5 class="mb-md-0 h6">{{translate('All Carriers')}}</h5>
                </div>
                <div class="col">
                    <div class="mar-all mb-2" style=" text-align: end;">
                        <a href="{{route('carriers.create')}}">
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
                    <th>{{translate('Logo')}}</th>
                    <th>{{translate('Carrier Name')}}</th>
                    <th>{{translate('Shipping Times')}}</th>
                    <th>{{translate('Status')}}</th>
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

@section('modal')
@endsection

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
                  ajax: "{{ route('carriers.data_ajax') }}",
                  columns: [
                            {data: 'logo', name: 'logo', render: function(data, type, row){
                              return (data=="")?
                              '<img src="" alt="" class="mw-100 ">'
                              :
                              '<img src="'+row.logo+'" alt="" class="mw-100" style="width:80px;height:60px">';
                            }},
                            {data: 'name', name: 'name', render: function(data){
                              return (data=="")?"":data;
                            }},
                            {data: 'transit_time', name: 'transit_time', render: function(data){
                                return (data=="")?"":data;
                            }},
                            {data: 'status', name: 'status', render: function(data, type, row){
                              return (data==1)?
                              '<label class="aiz-switch aiz-switch-success mb-0"> <input onchange="update_status(this)" value="'+row.id+'" type="checkbox" checked> <span class="slider round"></span> </label>'
                              :
                              '<label class="aiz-switch aiz-switch-success mb-0"> <input onchange="update_status(this)" value="'+row.id+'" type="checkbox"> <span class="slider round"></span> </label>';
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

        function update_status(el){
            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('{{ route('carriers.update_status') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                if(data == 1){
                    AIZ.plugins.notify('success', '{{ translate('Carrier Status updated successfully') }}');
                }
                else{
                    AIZ.plugins.notify('danger', '{{ translate('Carrier Status went wrong') }}');
                }
            });
        }

    </script>
@endsection
