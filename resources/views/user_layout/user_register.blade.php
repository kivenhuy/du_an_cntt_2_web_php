@extends('user_layout.layouts.app')

@section('content')
    <section class="gry-bg py">
        <div class="profile">
            <div class="container" style="max-width:1440px !important;;padding-left: 0px !important;margin-left:auto !important;;margin-right:auto !important;">
                <div class="row">
                    <div class="col-xl-12 col-lg-10 mx-auto">
                        <div class="card shadow-none rounded-0 border-0">
                            <div class="row">
                                <!-- Left Side -->
                                <div class="col-lg-8 col-md-7 p-4 p-lg-5">
                                    <!-- Titles -->
                                    
                                    <div class="row align-items-center  ">
                                        <div class="text-center col-md-1 d-none d-lg-block" style="margin-bottom: 0.5rem;">
                                            <a href="{{url()->previous()}}" ><i style="color:black;font-size: 1.73em;" class="fa fa-arrow-left"></i></a>
                                        </div>
                                        <div class="text-center px-3">
                                            <h1 class="fw-700 register-mobile-header">Tạo tài khoản</h1>
                                        </div>
                                    </div>
                                    <!-- Register form -->
                                    <div class="pt-3 pt-lg-4">
                                        <div class="">
                                            
                                                <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist" style="margin-bottom: 2%">
                                                    <li class="nav-item mb-2" style="">
                                                        <a class="nav-link {{ (old('user_type') == null || old('user_type') == 'customer') ? 'active' : '' }}" id="custom-content-below-home-tab" data-toggle="pill" href="#information" role="tab" aria-controls="custom-content-below-home" aria-selected="true"><span class="text_head_register">Khách hàng</span></a>
                                                    </li>
                
                                                    

                                                                                                  
                                                </ul>

                                                <div class="tab-content mt-4" id="custom-content-below-tabContent">
                                                    <div class="tab-pane fade {{ (old('user_type') == null || old('user_type') == 'customer') ? 'active show' : '' }} " id="information" role="tabpanel" aria-labelledby="custom-content-below-home-tab" >
                                                        <form id="reg-form-user" class="form-default" role="form" action="{{ route('user.registration') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="user_type" value="customer">
                                                                <div class="form-group row">
                                                                    <div class="col-md-6">
                                                                        <!-- Name -->
                                                                        <div class="form-group">
                                                                            <label for="name" class="fs-12 fw-700 text-soft-dark ">Họ và tên</label>
                                                                            <input type="text" required class="form-control rounded-0{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" placeholder="Nhập họ và tên" name="name">
                                                                            @if ($errors->has('name'))
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $errors->first('name') }}</strong>
                                                                                </span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="col-md-6">
                                                                        <!-- Name -->
                                                                        <div class="form-group phone-form-group">
                                                                            <label for="phone" class="fs-12 fw-700 text-soft-dark">Số điện thoại</label>
                                                                            <input required type="tel" id="phone-code" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }} rounded-0" onkeypress="return isNumber(event)" value="{{ old('phone') }}" placeholder="" name="phone" autocomplete="off">
                                                                            <input type="hidden" name="country_code" value="">
                                                                        </div>
                                                                        
                                                                    </div>
                                                                </div>
                                                                
                                                               
                                                                <div class="form-group row">
                                                                    <div class="col-md-6">
                                                                        <!-- Email or Phone -->
                                                                        <div class="form-group">
                                                                            <label for="js-customer-check-email-exist" class="fs-12 fw-700 text-soft-dark">Email</label>
                                                                            <input type="email" id="js-customer-check-email-exist" class="form-control rounded-0{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" placeholder="Nhập email" name="email" autocomplete="off">
                                                                            <span class="js-customer-email-error invalid-feedback" style="display:block;color:#EB000A; font-size: 14px;"></span>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                </div>

                                                                <div class="form-group row">
                                                                    <div class="col-md-6">
                                                                        <!-- password -->
                                                                        <div class="form-group">
                                                                            <label for="password" class="fs-12 fw-700 text-soft-dark">Mật khẩu</label>
                                                                            <input type="password" required class="form-control rounded-0{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Nhập mật khẩu" name="password" autocomplete="off">
                                                                            @if ($errors->has('password'))
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $errors->first('password') }}</strong>
                                                                                </span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <!-- password Confirm -->
                                                                        <div class="form-group">
                                                                            <label for="password_confirmation" class="fs-12 fw-700 text-soft-dark">Nhập lại mật khẩu</label>
                                                                            <input type="password" required class="form-control rounded-0" placeholder="Nhập lại mật khẩu" name="password_confirmation" autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                           

                                                            <!-- Terms and Conditions -->
                                                            <div class="mb-3">
                                                                <label class="aiz-checkbox d-block">
                                                                    <input type="checkbox" name="checkbox_example_1" required>
                                                                        <span class="">Bằng cách đăng ký, bạn đồng ý với <a href="{{ route('terms') }}" class="fw-500">điều khoản và điều kiện</a></span>
                                                                    <span class="aiz-square-check"></span>
                                                                </label>
                                                            </div>

                                                            <!-- Submit Button -->
                                                            <div class="mb-4 mt-4">
                                                                <button type="btn" id="btnSubmit" class="btn btn-primary btn-block fw-600 rounded-4">Tạo tài khoản</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    

                                                    
                                                </div>
                                        </div>

                                        <!-- Log In -->
                                        <div class="text-center">
                                            <p class="fs-12 text-gray mb-0">Đã có tài khoản?</p>
                                            <a href="{{ route('user.login') }}" class="fs-14 fw-700 animate-underline-primary">Đăng nhập</a>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Right Side Image -->
                                <div class="col-lg-4 col-md-5 py-3 py-md-0">
                                    <img style="position: fixed;width: 32% !important;object-fit: contain;" src="{{ static_asset('assets/img/M1CsfH3WFfdTO8iaXkgwQq5Q3Zl6A045yaQeMr9s.jpg') }}" alt="" class="img-fit h-100">
                                </div>
                                
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection

<style>
    .text_head_register
    {
        font-size: 24px;
        font-weight: 700;
        /* line-height: 68px; */
        letter-spacing: 0px;
        text-align: left;
    }

    #custom-content-below-tab .nav-link {
        border: 1px solid black;
        border-radius: 30px;
        margin-right: 20px;
        color: black;
    }

    #custom-content-below-tab .nav-link.active {
        border: 1px solid green;
        color: green;
    }
    @media screen and (max-width: 440px) {
        #custom-content-below-tab .nav-link {
            margin-right: 10px;
        }
    }

    /* .gry-bg {
        font-family: 'Roboto',sans-serif !important;
    } */

   .error {
    color: #F00;
    font-size: 14px;
    }

    .has-error {
        border: 1px solid #dc3545 !important;
    }

    .mt-100{margin-top: 100px}
    body{
        background: #00B4DB;
        background: -webkit-linear-gradient(to right, #0083B0, #00B4DB);
        background: linear-gradient(to right, #0083B0, #00B4DB);
        color: #514B64;
        min-height: 100vh
    }

    .register-mobile-header {
        /* font-family: Roboto,sans-serif; */
        font-size: 40px;
        font-weight: 700 !important;
        line-height: 68px;
        letter-spacing: 0px;
        text-align: left;
        color:black;
    }
</style>

@section('script')
    <script type="text/javascript">
     var img_1 = "{{ static_asset('assets/img/M1CsfH3WFfdTO8iaXkgwQq5Q3Zl6A045yaQeMr9s.jpg') }}";
       var img_2 = "{{ static_asset('assets/img/IINCVVMFxX5SUOocfZB43fopY1cY1aaBCXBcKCUf.jpg') }}";
       $('#custom-content-below-home-tab').on('click',function(event){
            $('.img-fit').attr('src',img_1);
        });
       $('#custom-content-below-messages-tab').on('click',function(event){
            $('.img-fit').attr('src',img_2);
        });


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
                        $('#district').html('');
                        $('#district').append('<option value="" selected hidden>Select District</option>');
                        result.forEach(element => {
                            console.log(element.id);
                            $('#district').append('<option value="' + element.id+ '">' + element.district_name+ '</option>');
                        });
                        $('#district').selectpicker('refresh');
                    }
                });
            }
        });

        $('#country_3').on('change',function()
        {
            var country = $('#country_3').val();
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
                        $('#city_3').html('');
                        $('#city_3').append('<option value="" selected hidden>Select City</option>');
                        result.forEach(element => {
                            console.log(element.id);
                            $('#city_3').append('<option value="' + element.id+ '">' + element.city_name+ '</option>');
                        });
                        $('#city_3').selectpicker('refresh');
                    }
                });
            }
        });

        $('#city_3').on('change',function()
        {
            var city = $('#city_3').val();
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
                        $('#district_3').html('');
                        $('#district_3').append('<option value="" selected hidden>Select District</option>');
                        result.forEach(element => {
                            console.log(element.id);
                            $('#district_3').append('<option value="' + element.id+ '">' + element.district_name+ '</option>');
                        });
                        $('#district_3').selectpicker('refresh');
                    }
                });
            }
        });
            
    </script>
@endsection