@extends('user_layout.layouts.user_panel')

@section('panel_content')
<div class="row">
        <div class="container-fluid">

            <div class="row">
              <div class="col-12">
                <div class="card">
                    <div class="card-header row gutters-5">
                        <div class="col">
                            <h5 class="mb-md-0 h6">All Order History</h5>
                        </div>
                    </div>
                    <div class="card-body" >
                        <table id="example1" class="table table-bordered table-striped">
                          <thead>
                              <tr>
                                <th>{{translate('Code')}}</th>
                                <th>{{translate('Order Date')}}</th>
                                <th>{{translate('Amount')}}</th>
                                <th>{{translate('Shipping Status')}}</th>
                                <th>{{translate('Payment Status')}}</th>
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
            ajax: "{{ route('purchase_history.data_ajax') }}",
            columns: [
                    {data: 'code', name: 'code', render: function(data){
                        return (data=="")?"":data;
                    }},
                    {data: 'order_date', name: 'order_date', render: function(data){
                        return (data=="")?"":data;
                    }},
                    {data: 'order_date', name: 'order_date', render: function(data){
                        return (data=="")?"":data;
                    }},
                    {data: 'delivery_status', name: 'delivery_status', render: function(data){
                        return "<span class='badge badge-inline badge-secondary'>"+ data +"</span>";
                    }},
                    {data: 'payment_status', name: 'payment_status', render: function(data){
                        return "<span class='badge badge-inline badge-secondary'>" + data +"</span>";
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
