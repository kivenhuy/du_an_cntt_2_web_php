@extends('seller.layouts.app')
@section('panel_content')
<div class="row">
    {{-- <div class="col-sm-6 col-md-6 col-xxl-3"> --}}
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
    {{-- </div> --}}
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
@endsection