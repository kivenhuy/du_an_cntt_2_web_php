@extends('user_layout.layouts.user_panel')


@section('panel_content')
    <div class="aiz-titlebar mb-4">
      <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="fs-20 fw-700 text-dark">{{ translate('Manage Profile') }}</h1>
        </div>
      </div>
    </div>

    <!-- Basic Info-->
    <div class="card rounded-0 shadow-none border">
        <div class="card-header pt-4 border-bottom-0">
            <h5 class="mb-0 fs-18 fw-700 text-dark">{{ translate('Basic Info')}}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Name-->
                <div class="form-group row">
                    <label class="col-md-2 col-form-label fs-14 fs-14">{{ translate('Your Name') }}</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control rounded-0" placeholder="{{ translate('Your Name') }}" name="name" value="{{ Auth::user()->name }}">
                    </div>
                </div>
                <!-- Phone-->
                <div class="form-group row">
                    <label class="col-md-2 col-form-label fs-14">{{ translate('Your Phone') }}</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control rounded-0" placeholder="{{ translate('Your Phone')}}" name="phone" value="{{ Auth::user()->phone }}">
                    </div>
                </div>
                <!-- Photo-->
                <div class="form-group row">
                    <label class="col-md-2 col-form-label fs-14">{{ translate('Photo') }}</label>
                    <div class="col-md-10">
                        <div class="input-group" data-toggle="aizuploader" data-type="image">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-soft-secondary font-weight-medium rounded-0">{{ translate('Browse')}}</div>
                            </div>
                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                            <input type="hidden" name="photo" value="{{ Auth::user()->avatar_original }}" class="selected-files">
                        </div>
                        <div class="file-preview box sm">
                        </div>
                    </div>
                </div>
                <!-- Password-->
                <div class="form-group row">
                    <label class="col-md-2 col-form-label fs-14">{{ translate('Your Password') }}</label>
                    <div class="col-md-10">
                        <input type="password" class="form-control rounded-0" placeholder="{{ translate('New Password') }}" name="new_password">
                    </div>
                </div>
                <!-- Confirm Password-->
                <div class="form-group row">
                    <label class="col-md-2 col-form-label fs-14">{{ translate('Confirm Password') }}</label>
                    <div class="col-md-10">
                        <input type="password" class="form-control rounded-0" placeholder="{{ translate('Confirm Password') }}" name="confirm_password">
                    </div>
                </div>
                <!-- Submit Button-->
                <div class="form-group mb-0 text-right">
                    <button type="submit" class="btn btn-primary rounded-0 w-150px mt-3">{{translate('Update Profile')}}</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Address -->
    <div class="card rounded-0 shadow-none border">
        <div class="card-header pt-4 border-bottom-0">
            <h5 class="mb-0 fs-18 fw-700 text-dark">{{ translate('Address')}}</h5>
        </div>
        <div class="card-body">
            @foreach (Auth::user()->addresses as $key => $address)
                <div class="">
                    <div class="border p-4 mb-4 position-relative">
                        <div class="row fs-14 mb-2 mb-md-0">
                            <span class="col-md-2 text-secondary">{{ translate('Address') }}:</span>
                            <span class="col-md-8 text-dark">{{ $address->address }}</span>
                        </div>
                        <div class="row fs-14 mb-2 mb-md-0">
                            <span class="col-md-2 text-secondary">{{ translate('Postal Code') }}:</span>
                            <span class="col-md-10 text-dark">{{ $address->postal_code }}</span>
                        </div>
                        <div class="row fs-14 mb-2 mb-md-0">
                            <span class="col-md-2 text-secondary">{{ translate('District') }}:</span>
                            <span class="col-md-10 text-dark">{{ ($address->district)->district_name }}</span>
                        </div>
                        <div class="row fs-14 mb-2 mb-md-0">
                            <span class="col-md-2 text-secondary">{{ translate('City') }}:</span>
                            <span class="col-md-10 text-dark">{{ ($address->city)->city_name }}</span>
                        </div>
                        <div class="row fs-14 mb-2 mb-md-0">
                            <span class="col-md-2 text-secondary">{{ translate('Country') }}:</span>
                            <span class="col-md-10 text-dark">{{ ($address->country)->country_name }}</span>
                        </div>
                        <div class="row fs-14 mb-2 mb-md-0">
                            <span class="col-md-2 text-secondary text-secondary">{{ translate('Phone') }}:</span>
                            <span class="col-md-10 text-dark">{{ $address->phone }}</span>
                        </div>
                        @if ($address->set_default)
                            <div class="absolute-md-top-right pt-2 pt-md-4 pr-md-5">
                                <span class="badge badge-inline badge-warning text-white p-3 fs-12" style="border-radius: 25px; min-width: 80px !important;">{{ translate('Default') }}</span>
                            </div>
                        @endif
                        <div class="dropdown position-absolute right-0 top-0 pt-4 mr-1">
                            <button class="btn bg-gray text-white px-1 py-1" type="button" data-toggle="dropdown">
                                <i class="fa fa-ellipsis-v"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" onclick="edit_address('{{$address->id}}')">
                                    {{ translate('Edit') }}
                                </a>
                                @if (!$address->set_default)
                                    <a class="dropdown-item" href="{{ route('addresses.set_default', $address->id) }}">{{ translate('Make This Default') }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <!-- Add New Address -->
            <div class="" onclick="add_new_address()">
                <div class="border p-3 mb-3 c-pointer text-center bg-light has-transition hov-bg-soft-light">
                    <i class="fa fa-plus la-2x"></i>
                    <div class="alpha-7 fs-14 fw-700">{{ translate('Add New Address') }}</div>
                </div>
            </div>
        </div>
    </div>


   

@endsection

@section('modal')
    <!-- Address modal -->
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