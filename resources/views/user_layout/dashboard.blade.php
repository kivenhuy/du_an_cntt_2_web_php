@extends('user_layout.layouts.user_panel')

@section('panel_content')
    <div class="row gutters-16 mt-2">

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
