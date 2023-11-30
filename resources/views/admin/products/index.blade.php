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
                            <h5 class="mb-md-0 h6">All Products</h5>
                        </div>
                    </div>
                    <div class="card-body" >
                        <table id="example1" class="table table-bordered table-striped">
                          <thead>
                              <tr>
                                <th>{{translate('Products Name')}}</th>
                                <th>{{translate('Added By')}}</th>
                                <th>{{translate('Info')}}</th>
                                <th>{{translate('Total Stock')}}</th>
                                <th>{{translate('Published')}}</th>
                                <th>{{translate('Approved')}}</th>
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
                  ajax: "{{ route('admin.products.data_ajax') }}",
                  columns: [
                            {data: 'name', name: 'name', render: function(data){
                              return (data=="")?"":data;
                          }},
                            {data: 'added_by', name: 'added_by', render: function(data){
                              return (data=="")?"":data;
                          }},
                            {data: 'added_by', name: 'added_by', render: function(data, type, row){
                              return '<strong>Num of Sale:</strong>'+row.num_of_sale+' times </br><strong>Base Price:</strong>'+row.unit_price+' </br>'
                          }},
                            {data: 'total_stock', name: 'total_stock', render: function(data){
                              return (data=="")?"":data;
                          }},                          
                          {data: 'published', name: 'published', render: function(data, type, row){
                              return (data==1)?
                              '<label class="aiz-switch aiz-switch-success mb-0"> <input onchange="update_published(this)" value="'+row.id+'" type="checkbox" checked> <span class="slider round"></span> </label>'
                              :
                              '<label class="aiz-switch aiz-switch-success mb-0"> <input onchange="update_published(this)" value="'+row.id+'" type="checkbox"> <span class="slider round"></span> </label>';
                          }},
                          {data: 'approved', name: 'approved', render: function(data, type, row){
                              return (data==1)?
                              '<label class="aiz-switch aiz-switch-success mb-0"> <input onchange="update_approved(this)" value="'+row.id+'" type="checkbox" checked> <span class="slider round"></span> </label>'
                              :
                              '<label class="aiz-switch aiz-switch-success mb-0"> <input onchange="update_approved(this)" value="'+row.id+'" type="checkbox"> <span class="slider round"></span> </label>';
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

function update_approved(el){
    if(el.checked){
        var approved = 1;
    }
    else{
        var approved = 0;
    }
    $.post('{{ route('admin.products.approved') }}', {
        _token      :   '{{ csrf_token() }}', 
        id          :   el.value, 
        approved    :   approved
    }, function(data){
        if(data == 1){
            AIZ.plugins.notify('success', '{{ translate('Product approval update successfully') }}');
        }
        else{
            AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
        }
    });

}
</script>
@endsection