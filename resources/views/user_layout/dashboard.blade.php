@extends('user_layout.layouts.user_panel')

@section('panel_content')
    <div class="row gutters-16 mt-2">

        {{-- Amount Order --}}
        <div class="col mb-4">
            @php
                $user_id = Auth::user()->id;
                $order_amount = \App\Models\Order::where('customer_id', $user_id)->get()->sum('grand_total');
            @endphp
            <div class="h-100">
                <div class="row h-100  row-cols-1">
                    <!-- Expenditure summary -->
                    <div class="col">
                        <div class="p-4 bg-primary  h-100 " style="margin-bottom: 2rem;">
                            <div class="d-flex align-items-center pb-4 ">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48">
                                    <g id="Group_25000" data-name="Group 25000" transform="translate(-926 -614)">
                                    <rect id="Rectangle_18646" data-name="Rectangle 18646" width="48" height="48" rx="24" transform="translate(926 614)" fill="rgba(255,255,255,0.5)"></rect>
                                    <g id="Group_24786" data-name="Group 24786" transform="translate(701.466 93)">
                                        <path id="Path_32311" data-name="Path 32311" d="M122.052,10V8.55a.727.727,0,1,0-1.455,0V10a2.909,2.909,0,0,0-2.909,2.909v.727A2.909,2.909,0,0,0,120.6,16.55h1.455A1.454,1.454,0,0,1,123.506,18v.727a1.454,1.454,0,0,1-1.455,1.455H120.6a1.454,1.454,0,0,1-1.455-1.455.727.727,0,1,0-1.455,0,2.909,2.909,0,0,0,2.909,2.909V23.1a.727.727,0,1,0,1.455,0V21.641a2.909,2.909,0,0,0,2.909-2.909V18a2.909,2.909,0,0,0-2.909-2.909H120.6a1.454,1.454,0,0,1-1.455-1.455v-.727a1.454,1.454,0,0,1,1.455-1.455h1.455a1.454,1.454,0,0,1,1.455,1.455.727.727,0,0,0,1.455,0A2.909,2.909,0,0,0,122.052,10" transform="translate(127.209 529.177)" fill="#fff"></path>
                                    </g>
                                    </g>
                                </svg>
                                <div class="ml-3 d-flex flex-column justify-content-between">
                                    <span class="fs-14 fw-400 text-white mb-1">Total Amount</span>
                                    <span class="fs-20 fw-700 text-white">{{single_price($order_amount)}}</span>
                                </div>
                            </div>
                            <a href="{{route('purchase_history.index')}}" class="fs-12 text-white">
                                Order History
                                <i class="fa fa-angle-right fs-14"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Club Point summary -->
                    
                </div>
            </div>
        </div>

        <!-- count summary -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="px-4 bg-white border h-100">
                <!-- Cart summary -->
                <div class="d-flex align-items-center py-4 border-bottom">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48">
                        <g id="Group_25000" data-name="Group 25000" transform="translate(-1367 -427)">
                        <path id="Path_32314" data-name="Path 32314" d="M24,0A24,24,0,1,1,0,24,24,24,0,0,1,24,0Z" transform="translate(1367 427)" fill="#d43533"/>
                        <g id="Group_24770" data-name="Group 24770" transform="translate(1382.999 443)">
                            <path id="Path_25692" data-name="Path 25692" d="M294.507,424.89a2,2,0,1,0,2,2A2,2,0,0,0,294.507,424.89Zm0,3a1,1,0,1,1,1-1A1,1,0,0,1,294.507,427.89Z" transform="translate(-289.508 -412.89)" fill="#fff"/>
                            <path id="Path_25693" data-name="Path 25693" d="M302.507,424.89a2,2,0,1,0,2,2A2,2,0,0,0,302.507,424.89Zm0,3a1,1,0,1,1,1-1A1,1,0,0,1,302.507,427.89Z" transform="translate(-289.508 -412.89)" fill="#fff"/>
                            <g id="LWPOLYLINE">
                            <path id="Path_25694" data-name="Path 25694" d="M305.43,416.864a1.5,1.5,0,0,0-1.423-1.974h-9a.5.5,0,0,0,0,1h9a.467.467,0,0,1,.129.017.5.5,0,0,1,.354.611l-1.581,6a.5.5,0,0,1-.483.372h-7.462a.5.5,0,0,1-.489-.392l-1.871-8.433a1.5,1.5,0,0,0-1.465-1.175h-1.131a.5.5,0,1,0,0,1h1.043a.5.5,0,0,1,.489.391l1.871,8.434a1.5,1.5,0,0,0,1.465,1.175h7.55a1.5,1.5,0,0,0,1.423-1.026Z" transform="translate(-289.508 -412.89)" fill="#fff"/>
                            </g>
                        </g>
                        </g>
                    </svg>
                    <div class="ml-3 d-flex flex-column justify-content-between">
                        @php
                            $user_id = Auth::user()->id;
                            $cart = \App\Models\Cart::where('user_id', $user_id)->get();
                        @endphp
                        <span class="fs-20 fw-700 mb-1">{{ count($cart) > 0 ? sprintf("%02d", count($cart)) : 0 }}</span>
                        <span class="fs-14 fw-400 text-secondary">{{ translate('Products in Cart') }}</span>
                    </div>
                    
                </div>
                <div class="d-flex align-items-center py-4">
                    @php
                        $user_id = Auth::user()->id;
                        $cart = \App\Models\Order::where('customer_id', $user_id)->get();
                    @endphp
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48">
                        <g id="Group_25000" data-name="Group 25000" transform="translate(-1367 -576)">
                        <path id="Path_32315" data-name="Path 32315" d="M24,0A24,24,0,1,1,0,24,24,24,0,0,1,24,0Z" transform="translate(1367 576)" fill="#85b567"></path>
                        <path id="_2e746ddacacf202af82cf4480bae6173" data-name="2e746ddacacf202af82cf4480bae6173" d="M11.483,3h-.009a.308.308,0,0,0-.1.026L4.26,6.068A.308.308,0,0,0,4,6.376V15.6a.308.308,0,0,0,.026.127v0l.009.017a.308.308,0,0,0,.157.147l7.116,3.042a.338.338,0,0,0,.382,0L18.8,15.9a.308.308,0,0,0,.189-.243q0-.008,0-.017s0-.01,0-.015,0-.01,0-.015,0,0,0,0V6.376a.308.308,0,0,0-.255-.306L11.632,3.031l-.007,0a.308.308,0,0,0-.05-.017l-.009,0-.022,0h-.062Zm.014.643L13,4.287,6.614,7.02,6.6,7.029,5.088,6.383,11.5,3.643Zm2.29.979,1.829.782L9.108,8.188a.414.414,0,0,0-.186.349v3.291l-.667-1a.308.308,0,0,0-.393-.1l-.786.392V7.493l6.712-2.87ZM16.4,5.738l1.509.645L11.5,9.124,9.99,8.48l6.39-2.733.018-.009ZM4.615,6.85l1.846.789v3.975a.308.308,0,0,0,.445.275l.987-.494,1.064,1.595v0a.308.308,0,0,0,.155.14h0l.027.009a.308.308,0,0,0,.057.012h.036l.036,0,.025,0,.018,0,.015,0a.308.308,0,0,0,.05-.022h0a.308.308,0,0,0,.156-.309V8.955l1.654.707v8.56L4.615,15.411Zm13.765,0v8.56L11.8,18.223V9.662Z" transform="translate(1379.5 588.5)" fill="#fff" stroke="#fff" stroke-width="0.25" fill-rule="evenodd"></path>
                        </g>
                    </svg>
                    <div class="ml-3 d-flex flex-column justify-content-between">
                        <span class="fs-20 fw-700 mb-1">{{ count($cart) > 0 ? sprintf("%02d", count($cart)) : 0 }}</span>
                        <span class="fs-14 fw-400 text-secondary">Total Order</span>
                    </div>
                </div>

                

            </div>
        </div>
    
        <!-- Default Shipping Address -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="p-4 border h-100">
                <h6 class="fw-700 mb-3 text-dark">{{ translate('Default Shipping Address') }}</h6>
                @if(Auth::user()->addresses != null)
                    @php
                        $address = Auth::user()->addresses;
                    @endphp
                    @if($address != null)
                        @foreach ($address as $data_address)
                        <ul class="list-unstyled mb-5">
                            <li class="fs-14 fw-400 text-derk pb-1"><span> <i class="fa fa-home" aria-hidden="true" style="margin-right: 8px"></i> {{ $data_address->address }},</span></li>
                            <li class="fs-14 fw-400 text-derk pb-1"><span>{{ $data_address->district->district_name }},</span></li>
                            <li class="fs-14 fw-400 text-derk pb-1"><span>{{ $data_address->postal_code }} - {{ $data_address->city->city_name }},</span></li>
                            <li class="fs-14 fw-400 text-derk pb-1"><span>{{ $data_address->country->country_name }}.</span></li>
                            <li class="fs-14 fw-400 text-derk pb-1"><span>{{ $data_address->phone }}</span></li>
                        </ul>
                        @endforeach
                    @endif
                @endif
                <button class="btn btn-dark btn-block fs-14 fw-500" onclick="add_new_address()" style="border-radius: 25px;">
                    <i class="fa fa-plus fs-18 fw-700 mr-2"></i>
                    {{ translate('Add New Address') }}
                </button>
            </div>
        </div>

        

    </div>
@endsection

@section('modal')
    @include('user_layout.partials.address_modal')
@endsection

@section('script')
<script type="text/javascript">
    function add_new_address(){
        $('#new-address-modal').modal('show');
    }

    $('#country_2').on('change',function()
    {
        var country = $('#country_2').val();
        // alert(country);
        if(country != "")
        {
            $.ajax
            ({
                url: "{{ route('city.filter_by_country') }}", 
                method:'post',
                data:{
                    id:country
                },
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                async:false,
                success: function(result){
                    $('#city_2').html('');
                    $('#city_2').append('<option value="" selected hidden>Select City</option>');
                    result.forEach(element => {
                        console.log(element.id);
                        $('#city_2').append('<option value="' + element.id+ '">' + element.city_name+ '</option>');
                    });
                    $('#city_2').selectpicker('refresh');
                }
            });
        }
    });

    $('#city_2').on('change',function()
    {
        var city = $('#city_2').val();
        // alert(country);
        if(city != "")
        {
            $.ajax
            ({
                url: "{{ route('district.filter_by_city') }}", 
                method:'post',
                data:{
                    id:city
                },
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                async:false,
                success: function(result){
                    $('#district_2').html('');
                    $('#district_2').append('<option value="" selected hidden>Select District</option>');
                    result.forEach(element => {
                        console.log(element.id);
                        $('#district_2').append('<option value="' + element.id+ '">' + element.district_name+ '</option>');
                    });
                    $('#district_2').selectpicker('refresh');
                }
            });
        }
    });
</script>
@endsection
