@extends('admin.layouts.app')
@section('content')
<div class="row">
        <div class="container-fluid">

            <div class="row">
              <div class="col-12">
                <div class="card">
                    <div class="card-header row gutters-5">
                        <div class="col">
                            <h5 class="mb-md-0 h6">All Request For Product</h5>
                        </div>
                    </div>
                    <div class="card-body" >
                        <table id="example1" class="table table-bordered table-striped">
                          <thead>
                              <tr>
                                <th>{{translate('Code')}}</th>
                                <th>{{translate('Products Name')}}</th>
                                <th>{{translate('Seller Name')}}</th>
                                <th>{{translate('Buyer Name')}}</th>
                                <th>{{translate('Quantity')}}</th>
                                <th>{{translate('Unit Price')}}</th>
                                <th>{{translate('Status')}}</th>
                                <th>{{translate('Apprrove')}}</th>
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

@section('modal')
    <!-- Wallet Recharge Modal -->
    
    
    <!-- Address modal Modal -->
    {{-- @include('frontend.partials.address_modal') --}}
@endsection

@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

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
            ajax: "{{ route('request_for_product.admin_dataajax') }}",
            columns: [
                    {data: 'code', name: 'code', render: function(data){
                        return (data=="")?"":data;
                    }},
                    {data: 'product_name', name: 'product_name', render: function(data){
                        return (data=="")?"":data;
                    }},
                    {data: 'seller_name', name: 'seller_name', render: function(data){
                        return (data=="")?"":data;
                    }},
                    {data: 'buyer_name', name: 'buyer_name', render: function(data){
                        return (data=="")?"":data;
                    }},
                    {data: 'quantity', name: 'quantity',render: function (data,type,row) {
                        return (data=="")?"":row.quantity + " "+ row.unit;
                    }},
                    {data: 'price', name: 'price', render: function(data){
                        return data;
                    }},
                    {data: 'status', name: 'status', render: function(data){
                        if(data == 0)
                        {
                            return "<span class='badge badge-inline badge-secondary'>{{translate('Pending Admin Approval')}}</span>";
                        }
                        if(data == 1)
                        {
                            return "<span class='badge badge-inline badge-secondary'>{{translate('Pending Seller Accept')}}</span>";
                        }
                        else if(data == 2)
                        {
                            return "<span class='badge badge-inline badge-warning'>{{translate('Pending Price Update')}}</span>";
                        }
                        else if(data == 3)
                        {
                            return "<span class='badge badge-inline badge-info' >{{translate('Waiting For Customer')}}</span>";
                        }
                        else if(data == 4)
                        {
                            return "<span class='badge badge-inline badge-success' style='background-color:#28a745 !important'>{{translate('Process To Checkout')}}</span>";
                        }
                    }},
                    {data: 'status', name: 'update_status', render: function(data, type, row){
                        if(data !=0)
                        {
                            return '<label class="aiz-switch aiz-switch-success mb-0"> <input onchange="update_approved(this)" value="'+row.id+'" type="checkbox" checked> <span class="slider round"></span> </label>';
                        }
                        else
                        {
                            return '<label class="aiz-switch aiz-switch-success mb-0"> <input onchange="update_approved(this)" value="'+row.id+'" type="checkbox"> <span class="slider round"></span> </label>';
                        }
                        
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

function update_approved(el)
{
    if(el.checked){
        var status = 1;
    }
    else{
        var status = 0;
    }
    $.post('{{ route('request_for_product.admin_approved') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
        if(data == 1){
            AIZ.plugins.notify('success', '{{ translate('Approved request updated successfully') }}');
            $('#example1').DataTable().ajax.reload();
        }
        else{
            AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
            $('#example1').DataTable().ajax.reload();
        }
    });
}
</script>
