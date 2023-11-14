{{-- @extends('frontend.layouts.user_register') --}}

@section('content')
    <section class="gry-bg py">
        <div class="profile">
            <div class="container" style="padding-left: 0px !important;margin-left: 0px !important;">
                <div class="row">
                    <div class="col-xl-12 col-lg-10 mx-auto">
                        <div class="card shadow-none rounded-0 border">
                            <div class="row">
                                <!-- Left Side -->
                                <div class="col-lg-9 col-md-7 p-4 p-lg-5">
                                    <!-- Titles -->
                                    <div class="col-md-4">
                                        <img src="" alt="">
                                    </div>
                                    <div class="row">
                                        <div class="text-center col-md-1" style="margin-bottom: 0.5rem;display: flex !important;align-items: center;">
                                            <a href="{{url()->previous()}}" ><i style="color:black;font-size: 1.73em;" class="fa fa-arrow-left"></i></a>
                                        </div>
                                        <div class="text-center">
                                            <h1 class="fs-20 fs-md-24 fw-700" style="color:black;">Create an account</h1>
                                        </div>
                                    </div>
                                    <!-- Register form -->
                                    <div class="pt-3 pt-lg-4">
                                        <div class="">
                                            
                                                <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist" style="margin-bottom: 2%">
                                                    <li class="nav-item" style="width: 30%;font-size:26px">
                                                        <a class="nav-link active" id="custom-content-below-home-tab" data-toggle="pill" href="#information" role="tab" aria-controls="custom-content-below-home" aria-selected="true">I`m Buyer</a>
                                                    </li>
                
                                                    <li class="nav-item" style="width: 30%;font-size:26px">
                                                        <a class="nav-link" id="custom-content-below-messages-tab" data-toggle="pill" href="#refundhistorytab" role="tab" aria-controls="custom-content-below-messages" aria-selected="false"><th>I`m Seller</th></a>
                                                    </li>

                                                    <li class="nav-item" style="width: 30%;font-size:26px">
                                                        <a class="nav-link " id="custom-content-below-enterprise-tab" data-toggle="pill" href="#enterprisetab" role="tab" aria-controls="custom-content-below-enterprise" aria-selected="false"><th>Enterprise</th></a>
                                                    </li>
                                                    
                                                </ul>

                                                <div class="tab-content" id="custom-content-below-tabContent">
                                                    <div class="tab-pane fade active show " id="information" role="tabpanel" aria-labelledby="custom-content-below-home-tab" >
                                                        <form id="reg-form-user" class="form-default" role="form" action="{{ route('register') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="user_type" value="customer">
                                                                <div class="form-group row">
                                                                    <div class="col-md-6">
                                                                        <!-- Name -->
                                                                        <div class="form-group">
                                                                            <label for="name" class="fs-12 fw-700 text-soft-dark ">{{  translate('Full Name') }}</label>
                                                                            <input type="text" required class="form-control rounded-0{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" placeholder="{{  translate('Full Name') }}" name="name">
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
                                                                            <label for="phone" class="fs-12 fw-700 text-soft-dark">{{  translate('Phone') }}</label>
                                                                            <input required type="tel" id="phone-code" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }} rounded-0" onkeypress="return isNumber(event)" value="{{ old('phone') }}" placeholder="" name="phone" autocomplete="off">
                                                                            <input type="hidden" name="country_code" value="">
                                                                        </div>
                                                                        
                                                                    </div>
                                                                </div>
                                                                
                                                                {{-- <div class="form-group row">
                                                                    <div class="col-md-6">
                                                                        <!-- Country -->
                                                                        <div class="form-group">
                                                                            <label for="password" class="fs-12 fw-700 text-soft-dark">{{  translate('Country') }}</label>
                                                                            <select required class="form-control aiz-selectpicker" id="country" name="country">
                                                                                <option value="" selected hidden>Select Country</option>
                                                                                @foreach ($country as $data_country)
                                                                                    <option value={{$data_country->id}}>{{$data_country->name}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <!-- State -->
                                                                        <div class="form-group">
                                                                            <label for="state" class="fs-12 fw-700 text-soft-dark">{{  translate('State') }}</label>
                                                                            <select required class="form-control aiz-selectpicker" id="state" name="state">
                                                                                <option value="" selected hidden>Select State</option>
                                                                                
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div> --}}

                                                                {{-- <div class="form-group row">
                                                                    <div class="col-md-6">
                                                                        <!-- City -->
                                                                        <div class="form-group">
                                                                            <label for="password_confirmation" class="fs-12 fw-700 text-soft-dark">{{  translate('City') }}</label>
                                                                            <select required class="form-control aiz-selectpicker" id="city" name="city">
                                                                                <option value="" selected hidden>Select City</option>
                                                                    
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <!-- District -->
                                                                        <div class="form-group">
                                                                            <label for="ward_code" class="fs-12 fw-700 text-soft-dark">{{  translate('District') }}</label>
                                                                            <input type="text" class="form-control rounded-0" placeholder="{{  translate('District') }}" name="district">
                                                                            <label for="" style="display: none"></label>
                                                                        </div>
                                                                    </div>
                                                                </div> --}}

                                                                {{-- <div class="form-group row">
                                                                    <div class="col-md-6">
                                                                        <!-- Ward -->
                                                                        <div class="form-group">
                                                                            <label for="ward_code" class="fs-12 fw-700 text-soft-dark">{{  translate('Ward') }}</label>
                                                                            <input type="text" class="form-control rounded-0" placeholder="{{  translate('Ward') }}" name="ward">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <!-- Address -->
                                                                        <div class="form-group">
                                                                            <label for="ward_code" class="fs-12 fw-700 text-soft-dark">{{  translate('Address') }}</label>
                                                                            <input type="text" class="form-control rounded-0" placeholder="{{  translate('Address') }}" name="address">
                                                                        </div>
                                                                    </div>
                                                                </div> --}}
                                                                <div class="form-group row">
                                                                    <div class="col-md-6">
                                                                        <!-- Email or Phone -->
                                                                        <div class="form-group">
                                                                            <label for="email" class="fs-12 fw-700 text-soft-dark">{{  translate('Email') }}</label>
                                                                            <input type="email" class="form-control rounded-0{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" placeholder="{{  translate('Email') }}" name="email">
                                                                        </div>
                                                                    </div>
                                                                    
                                                                </div>

                                                                <div class="form-group row">
                                                                    <div class="col-md-6">
                                                                        <!-- password -->
                                                                        <div class="form-group">
                                                                            <label for="password" class="fs-12 fw-700 text-soft-dark">{{  translate('Password') }}</label>
                                                                            <input type="password" required class="form-control rounded-0{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{  translate('Password must contain at least 6 digits') }}" name="password">
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
                                                                            <label for="password_confirmation" class="fs-12 fw-700 text-soft-dark">{{  translate('Confirm Password') }}</label>
                                                                            <input type="password" required class="form-control rounded-0" placeholder="{{  translate('Confirm Password') }}" name="password_confirmation">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                             <!-- Recaptcha -->
                                                            {{-- @if(get_setting('google_recaptcha') == 1)
                                                                <div class="form-group">
                                                                    <div class="g-recaptcha" data-sitekey="{{ env('CAPTCHA_KEY') }}"></div>
                                                                </div>
                                                                @if ($errors->has('g-recaptcha-response'))
                                                                    <span class="invalid-feedback" role="alert" style="display: block;">
                                                                        <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                                                    </span>
                                                                @endif
                                                            @endif --}}

                                                            <!-- Terms and Conditions -->
                                                            <div class="mb-3">
                                                                <label class="aiz-checkbox">
                                                                    <input type="checkbox" name="checkbox_example_1" required>
                                                                    <span class="">{{ translate('By signing up you agree to our ')}} <a href="{{ route('terms') }}" class="fw-500">{{ translate('terms and conditions.') }}</a></span>
                                                                    <span class="aiz-square-check"></span>
                                                                </label>
                                                            </div>

                                                            <!-- Submit Button -->
                                                            <div class="mb-4 mt-4">
                                                                <button type="btn" id="btnSubmit" class="btn btn-primary btn-block fw-600 rounded-4">{{  translate('Create Account') }}</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="tab-pane fade" id="refundhistorytab" role="tabpanel" aria-labelledby="custom-content-below-info-tab">
                                                        <form id="reg-form-seller" class="form-default" role="form" action="{{ route('shops.store') }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                            <input type="hidden" name="user_type" value="seller">

                                                            <div class="form-group row">
                                                                <div class="col-md-6">
                                                                    <!-- Name -->
                                                                    <div class="form-group">
                                                                        <label for="name" class="fs-12 fw-700 text-soft-dark">{{  translate('Shop Name') }}</label>
                                                                        <input type="text" required class="form-control rounded-0{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" placeholder="{{  translate('Full Name') }}" name="name">
                                                                        @if ($errors->has('name'))
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $errors->first('name') }}</strong>
                                                                            </span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <!-- Legal Name -->
                                                                    <div class="form-group">
                                                                        <label for="legal_name" class="fs-12 fw-700 text-soft-dark">{{  translate('Legal Name') }}</label>
                                                                        <input type="text" class="form-control rounded-0{{ $errors->has('legal_name') ? ' is-invalid' : '' }}" value="{{ old('legal_name') }}" placeholder="{{  translate('Legal Name') }}" name="legal_name">
                                                                        @if ($errors->has('legal_name'))
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $errors->first('legal_name') }}</strong>
                                                                            </span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="form-group row">
                                                                <div class="col-md-6">
                                                                    <!-- Country -->
                                                                    <div class="form-group">
                                                                        <label for="password" class="fs-12 fw-700 text-soft-dark">{{  translate('Country') }}</label>
                                                                        <select required class="form-control aiz-selectpicker" id="country_2" name="country_2">
                                                                            <option value="" selected hidden>Select Country</option>
                                                                                @foreach ($country as $data_country)
                                                                                    <option value={{$data_country->id}}>{{$data_country->name}}</option>
                                                                                @endforeach
                                                                        </select>
                                                                        {{-- <input type="text" class="form-control rounded-0{{ $errors->has('country') ? ' is-invalid' : '' }}" placeholder="{{  translate('Country') }}" name="country"> --}}
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <!-- State -->
                                                                    <div class="form-group">
                                                                        <label for="state" class="fs-12 fw-700 text-soft-dark">{{  translate('State') }}</label>
                                                                        <select required class="form-control aiz-selectpicker" id="state_2" name="state_2">
                                                                            <option value="" selected hidden>Select State</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <div class="col-md-6">
                                                                    {{-- City --}}
                                                                    <div class="form-group">
                                                                        <label for="password_confirmation" class="fs-12 fw-700 text-soft-dark">{{  translate('City') }}</label>
                                                                        <select required class="form-control aiz-selectpicker" id="city_2" name="city_2">
                                                                            <option value="" selected hidden>Select City</option>
                                                                            {{-- @foreach ($country as $data_country)
                                                                                <option value={{$data_country->id}}>{{$data_country->name}}</option>
                                                                            @endforeach --}}
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                     <!-- District -->
                                                                     <div class="form-group">
                                                                        <label for="ward_code" class="fs-12 fw-700 text-soft-dark">{{  translate('District') }}</label>
                                                                        <input type="text" class="form-control rounded-0" placeholder="{{  translate('District') }}" name="district">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="ward_code" class="fs-12 fw-700 text-soft-dark">{{  translate('Ward') }}</label>
                                                                        <input type="text" class="form-control rounded-0" placeholder="{{  translate('Ward') }}" name="ward">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <!-- Address -->
                                                                    <div class="form-group">
                                                                        <label for="ward_code" class="fs-12 fw-700 text-soft-dark">{{  translate('Address') }}</label>
                                                                        <input type="text" class="form-control rounded-0" placeholder="{{  translate('Address') }}" name="address">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <div class="col-md-6">
                                                                    <!-- Email or Phone -->
                                                                    <div class="form-group">
                                                                        <label for="email" class="fs-12 fw-700 text-soft-dark">{{  translate('Email') }}</label>
                                                                        <input type="email" class="form-control rounded-0{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" placeholder="{{  translate('Email') }}" name="email">
                                                                        @if ($errors->has('email'))
                                                                            <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $errors->first('email') }}</strong>
                                                                            </span>
                                                                         @endif
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    {{-- Phone Number --}}
                                                                    <div class="form-group phone-form-group">
                                                                        <label for="phone" class="fs-12 fw-700 text-soft-dark">{{  translate('Phone') }}</label>
                                                                        <input required type="tel" id="phone-code_1" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }} rounded-0" onkeypress="return isNumber(event)" value="{{ old('phone') }}" placeholder="" name="phone" autocomplete="off">
                                                                    </div>
                                                                    <input type="hidden" name="country_code" value="">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-md-6">
                                                                    <!-- password -->
                                                                    <div class="form-group">
                                                                        <label for="password" class="fs-12 fw-700 text-soft-dark">{{  translate('Password') }}</label>
                                                                        <input required type="password" class="form-control rounded-0{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{  translate('Password must contain at least 6 digits') }}" name="password">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <!-- password Confirm -->
                                                                    <div class="form-group">
                                                                        <label for="password_confirmation" class="fs-12 fw-700 text-soft-dark">{{  translate('Confirm Password') }}</label>
                                                                        <input required type="password" class="form-control rounded-0" placeholder="{{  translate('Confirm Password') }}" name="password_confirmation">
                                                                    </div>
                                                                    <!-- Terms and Conditions -->
                                                                    
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="category_pro" class="fs-12 fw-700 text-soft-dark">{{  translate('Category of products') }}</label>
                                                                        <select required class="form-control aiz-selectpicker" multiple id="category_pro" name="category_pro[]">
                                                                            @foreach($categories as $data_categories)
                                                                                <option value={{$data_categories->id}} >{{$data_categories->name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                             <!-- Recaptcha -->
                                                            {{-- @if(get_setting('google_recaptcha') == 1)
                                                                <div class="form-group">
                                                                    <div class="g-recaptcha" data-sitekey="{{ env('CAPTCHA_KEY') }}"></div>
                                                                </div>
                                                                @if ($errors->has('g-recaptcha-response'))
                                                                    <span class="invalid-feedback" role="alert" style="display: block;">
                                                                        <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                                                    </span>
                                                                @endif
                                                            @endif --}}
                                                            <div class="mb-3">
                                                                <label class="aiz-checkbox">
                                                                    <input type="checkbox" name="checkbox_example_1" required>
                                                                    <span class="">{{ translate('By signing up you agree to our ')}} <a href="{{ route('terms') }}" class="fw-500">{{ translate('terms and conditions.') }}</a></span>
                                                                    <span class="aiz-square-check"></span>
                                                                </label>
                                                            </div>

                                                            <!-- Submit Button -->
                                                            <div class="mb-4 mt-4">
                                                                <button type="btn" id="btnSeller" class="btn btn-primary btn-block fw-600 rounded-4">{{  translate('Create Account') }}</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="tab-pane fade  " id="enterprisetab" role="tabpanel" aria-labelledby="custom-content-below-enterprise">
                                                        <form id="reg-form-enterprise" class="form-default" role="form" action="{{ route('shops.store_enterprise') }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                            <input type="hidden" name="user_type" value="enterprise">
                                                            <label style="font-size: 24px;font-weight: 600;">Company Information</label>
                                                            <div class="form-group row">
                                                                <div class="col-md-4">
                                                                    <!-- Name -->
                                                                    <div class="form-group">
                                                                        <label for="legal_name" class="fs-12 fw-700 text-soft-dark">{{  translate('Legal Name') }}</label>
                                                                        <input required type="text" class="form-control rounded-0{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('legal_name') }}" placeholder="{{  translate('Legal Name') }}" name="legal_name">
                                                                        @if ($errors->has('legal_name'))
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $errors->first('legal_name') }}</strong>
                                                                            </span>
                                                                        @endif
                                                                    </div>


                                                                    
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <!-- Name -->
                                                                    <div class="form-group">
                                                                        <label for="bussiness_name" class="fs-12 fw-700 text-soft-dark">{{  translate('Bussiness Name') }}</label>
                                                                        <input required type="text" class="form-control rounded-0{{ $errors->has('bussiness_name') ? ' is-invalid' : '' }}" value="{{ old('bussiness_name') }}" placeholder="{{  translate('Bussiness Name') }}" name="bussiness_name">
                                                                        @if ($errors->has('bussiness_name'))
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $errors->first('bussiness_name') }}</strong>
                                                                            </span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="organization_type" class="fs-12 fw-700 text-soft-dark">{{  translate('Organization Type') }}</label>
                                                                        <select required class="form-control aiz-selectpicker" id="organization_type" name="organization_type">
                                                                                <option value="" >Select Organization Type</option>
                                                                                <option value="NGO" >NGO</option>
                                                                                <option value="Enterprise" >Enterprise</option>
                                                                                <option value="Private Limited Company" >Private Limited Company</option>
                                                                                <option value="Public Limited Company" >Public Limited Company</option>
                                                                                <option value="Sole Proprietorship" >Sole Proprietorship</option>
                                                                                <option value="Partnership" >Partnership</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="bussiness_type" class="fs-12 fw-700 text-soft-dark">{{  translate('Bussiness Type') }}</label>
                                                                        <select required class="form-control aiz-selectpicker" multiple id="bussiness_type" name="bussiness_type[]">
                                                                            <option value="Goods" >Goods</option>
                                                                            <option value="Services Suppliers" >Services Suppliers</option>
                                                                            <option value="Transportation Suppliers" >Transportation Suppliers</option>
                                                                            <option value="Production" >Production</option>
                                                                            <option value="Manufacturer" >Manufacturer</option>
                                                                            <option value="Manufacturer" >Retailer</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="form-group row">
                                                                <div class="col-md-4">
                                                                    <!-- Phone Number -->
                                                                    <div class="form-group phone-form-group">
                                                                        <label for="phone" class="fs-12 fw-700 text-soft-dark">{{  translate('Phone') }}</label>
                                                                        <input type="tel" id="phone-code_2" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }} rounded-0" onkeypress="return isNumber(event)" value="{{ old('phone') }}" placeholder="" name="phone" autocomplete="off">
                                                                    </div>
                                                                    <input type="hidden" name="country_code_2" value="">

                                                                    <div class="form-group">
                                                                        <label for="dor" class="fs-12 fw-700 text-soft-dark">{{  translate('Date Of Registration') }}</label>
                                                                        <input required type="datetime-local" class="form-control"  name="dor" id="dor">
                                                                    </div>
                                                                    
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <!-- Email -->
                                                                    <div class="form-group">
                                                                        <label for="email" class="fs-12 fw-700 text-soft-dark">{{  translate('Email') }}</label>
                                                                        <input type="email" class="form-control rounded-0{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" placeholder="{{  translate('Email') }}" name="email">
                                                                        @if ($errors->has('email'))
                                                                            <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $errors->first('email') }}</strong>
                                                                            </span>
                                                                         @endif
                                                                    </div>

                                                                    {{-- Tax Number --}}
                                                                    <div class="form-group">
                                                                        <label for="tax_number" class="fs-12 fw-700 text-soft-dark">{{  translate('Tax Number') }}</label>
                                                                        <input required type="text" class="form-control rounded-0{{ $errors->has('tax_number') ? ' is-invalid' : '' }}" value="{{ old('tax_number') }}" placeholder="{{  translate('Tax Number') }}" name="tax_number">
                                                                        @if ($errors->has('tax_number'))
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $errors->first('tax_number') }}</strong>
                                                                            </span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                     {{-- Fax Number --}}
                                                                     <div class="form-group">
                                                                        <label for="fax_number" class="fs-12 fw-700 text-soft-dark">{{  translate('Fax Number') }}</label>
                                                                        <input type="text" class="form-control rounded-0{{ $errors->has('fax_number') ? ' is-invalid' : '' }}" value="{{ old('tax_number') }}" placeholder="{{  translate('Fax Number') }}" name="fax_number">
                                                                        @if ($errors->has('fax_number'))
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $errors->first('fax_number') }}</strong>
                                                                            </span>
                                                                        @endif
                                                                    </div>

                                                                    {{-- Registration Number --}}
                                                                    <div class="form-group">
                                                                        <label for="registration_number" class="fs-12 fw-700 text-soft-dark">{{  translate('Registration Number') }}</label>
                                                                        <input required type="text" class="form-control rounded-0{{ $errors->has('registration_number') ? ' is-invalid' : '' }}" value="{{ old('registration_number') }}" placeholder="{{  translate('Registration Number') }}" name="registration_number">
                                                                        @if ($errors->has('registration_number'))
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $errors->first('registration_number') }}</strong>
                                                                            </span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <label style="font-size: 24px;font-weight: 600;">Address Information</label>
                                                            <div class="form-group row">
                                                                <div class="col-md-4">
                                                                    <!-- Country -->
                                                                    <div class="form-group">
                                                                        <label for="password" class="fs-12 fw-700 text-soft-dark">{{  translate('Country') }}</label>
                                                                        <select required class="form-control aiz-selectpicker" id="country_3" name="country_3">
                                                                            <option value="" selected hidden>Select Country</option>
                                                                            @foreach ($country as $data_country)
                                                                                <option value={{$data_country->id}}>{{$data_country->name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        {{-- <input type="text" class="form-control rounded-0{{ $errors->has('country') ? ' is-invalid' : '' }}" placeholder="{{  translate('Country') }}" name="country"> --}}
                                                                    </div>

                                                                    <!-- District -->
                                                                    <div class="form-group">
                                                                        <label for="ward_code" class="fs-12 fw-700 text-soft-dark">{{  translate('District') }}</label>
                                                                        <input type="text" class="form-control rounded-0" placeholder="{{  translate('District') }}" name="district">
                                                                    </div>

                                                                    <!-- Address -->
                                                                    <div class="form-group">
                                                                        <label for="ward_code" class="fs-12 fw-700 text-soft-dark">{{  translate('Address') }}</label>
                                                                        <input type="text" class="form-control rounded-0" placeholder="{{  translate('Address') }}" name="address">
                                                                    </div>
                                                                    
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <!-- State -->
                                                                    <div class="form-group">
                                                                        <label for="state" class="fs-12 fw-700 text-soft-dark">{{  translate('State') }}</label>
                                                                        <select required class="form-control aiz-selectpicker" id="state_3" name="state_3">
                                                                            <option value="" selected hidden>Select State</option>
                                                                        </select>
                                                                    </div>

                                                                    {{-- Ward --}}
                                                                    <div class="form-group">
                                                                        <label for="ward_code" class="fs-12 fw-700 text-soft-dark">{{  translate('Ward') }}</label>
                                                                        <input type="text" class="form-control rounded-0" placeholder="{{  translate('Ward') }}" name="ward">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    {{-- City --}}  
                                                                    <div class="form-group">
                                                                        <label for="password_confirmation" class="fs-12 fw-700 text-soft-dark">{{  translate('City') }}</label>
                                                                        <select required class="form-control aiz-selectpicker" id="city_3" name="city_3">
                                                                            <option value="" selected hidden>Select City</option>
                                                                            {{-- @foreach ($country as $data_country)
                                                                                <option value={{$data_country->id}}>{{$data_country->name}}</option>
                                                                            @endforeach --}}
                                                                        </select>
                                                                    </div>

                                                                    {{-- ZipCode --}}
                                                                    <div class="form-group">
                                                                        <label for="zipcode" class="fs-12 fw-700 text-soft-dark">{{  translate('Zipcode') }}</label>
                                                                        <input required type="text" class="form-control rounded-0" placeholder="{{  translate('Zipcode') }}" name="zipcode">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <label style="font-size: 24px;font-weight: 600;">Account Information</label>
                                                            <div class="form-group row">
                                                                <div class="col-md-6">
                                                                    <!-- password -->
                                                                    <div class="form-group">
                                                                        <label for="password" class="fs-12 fw-700 text-soft-dark">{{  translate('Password') }}</label>
                                                                        <input required type="password" class="form-control rounded-0{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{  translate('Password must contain at least 6 digits') }}" name="password">
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
                                                                        <label for="password_confirmation" class="fs-12 fw-700 text-soft-dark">{{  translate('Confirm Password') }}</label>
                                                                        <input required type="password" class="form-control rounded-0" placeholder="{{  translate('Confirm Password') }}" name="password_confirmation">
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <label style="font-size: 24px;font-weight: 600;">Bussiness Category</label>
                                                            <div class="form-group row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="category_pro" class="fs-12 fw-700 text-soft-dark">{{  translate('Category of products') }}</label>
                                                                        <select required class="form-control aiz-selectpicker" multiple id="category_pro" name="category_pro[]">
                                                                            @foreach($categories as $data_categories)
                                                                                <option value={{$data_categories->id}} >{{$data_categories->name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                             <!-- Recaptcha -->
                                                            {{-- @if(get_setting('google_recaptcha') == 1)
                                                                <div class="form-group">
                                                                    <div class="g-recaptcha" data-sitekey="{{ env('CAPTCHA_KEY') }}"></div>
                                                                </div>
                                                                @if ($errors->has('g-recaptcha-response'))
                                                                    <span class="invalid-feedback" role="alert" style="display: block;">
                                                                        <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                                                    </span>
                                                                @endif
                                                            @endif --}}
                                                            <div class="mb-3">
                                                                <label class="aiz-checkbox">
                                                                    <input type="checkbox" name="checkbox_example_1" required>
                                                                    <span class="">{{ translate('By signing up you agree to our ')}} <a href="{{ route('terms') }}" class="fw-500">{{ translate('terms and conditions.') }}</a></span>
                                                                    <span class="aiz-square-check"></span>
                                                                </label>
                                                            </div>

                                                            <!-- Submit Button -->
                                                            <div class="mb-4 mt-4">
                                                                <button type="btn" id="btnEnterprise" class="btn btn-primary btn-block fw-600 rounded-4">{{  translate('Create Account') }}</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                
                                            
                                            
                                            <!-- Social Login -->
                                            @if(get_setting('google_login') == 1 || get_setting('facebook_login') == 1 || get_setting('twitter_login') == 1 || get_setting('apple_login') == 1)
                                                <div class="text-center mb-3">
                                                    <span class="bg-white fs-12 text-gray">{{ translate('Or Join With')}}</span>
                                                </div>
                                                <ul class="list-inline social colored text-center mb-4">
                                                    @if (get_setting('facebook_login') == 1)
                                                        <li class="list-inline-item">
                                                            <a href="{{ route('social.login', ['provider' => 'facebook']) }}" class="facebook">
                                                                <i class="lab la-facebook-f"></i>
                                                            </a>
                                                        </li>
                                                    @endif
                                                    @if(get_setting('google_login') == 1)
                                                        <li class="list-inline-item">
                                                            <a href="{{ route('social.login', ['provider' => 'google']) }}" class="google">
                                                                <i class="lab la-google"></i>
                                                            </a>
                                                        </li>
                                                    @endif
                                                    @if (get_setting('twitter_login') == 1)
                                                        <li class="list-inline-item">
                                                            <a href="{{ route('social.login', ['provider' => 'twitter']) }}" class="twitter">
                                                                <i class="lab la-twitter"></i>
                                                            </a>
                                                        </li>
                                                    @endif
                                                    @if (get_setting('apple_login') == 1)
                                                        <li class="list-inline-item">
                                                            <a href="{{ route('social.login', ['provider' => 'apple']) }}" class="apple">
                                                                <i class="lab la-apple"></i>
                                                            </a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            @endif
                                        </div>

                                        <!-- Log In -->
                                        <div class="text-center">
                                            <p class="fs-12 text-gray mb-0">{{ translate('Already have an account?')}}</p>
                                            <a href="{{ route('user.login') }}" class="fs-14 fw-700 animate-underline-primary">{{ translate('Log In')}}</a>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Right Side Image -->
                                
                                <div class="col-lg-3 col-md-5 py-3 py-md-0">
                                    <img style="position: fixed;width: 35% !important;" src="{{url('/public/uploads/all/WA4OcqTGoz0gny1QUGRGU7KADCwNKPrFOVkil41Z.png')}}" alt="" class="img-fit h-100">
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
   .error {
    color: #F00;
    font-size: 14px;
    }

    .has-error {
        border: 1px solid #dc3545 !important;
    }

    .mt-100{margin-top: 100px}
    body{background: #00B4DB;
        background: -webkit-linear-gradient(to right, #0083B0, #00B4DB);
        background: linear-gradient(to right, #0083B0, #00B4DB);
        color: #514B64;min-height: 100vh}
</style>

@section('script')
    @if(get_setting('google_recaptcha') == 1)
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="../../hero/public/plugins/jquery-validation/jquery.validate.min.js"></script>
    @endif

    <script type="text/javascript">

        @if(get_setting('google_recaptcha') == 1)
        var img_1 = "{{url('/public/uploads/all/WA4OcqTGoz0gny1QUGRGU7KADCwNKPrFOVkil41Z.png')}}";
        var img_2 = "{{url('/public/uploads/all/HxjaU5EQItQSLZbeaH2mgliWvUTTO7PxarXFde1M.png')}}";
        $('#custom-content-below-home-tab').on('click',function(event){
            $('.img-fit').attr('src',img_1);
        });
        $('#custom-content-below-messages-tab').on('click',function(event){
            $('.img-fit').attr('src',img_2);
        });

        $('.aiz-selectpicker').on('change', function() {
            if ($(this).val()!="")
            {
                $(this).valid();
                $(this).parent().removeClass('has-error')
            }
        });
        
        $(document).ready(function(){
            $("#btnSubmit").on('click',function(event){
                var validator = $( "#reg-form-user" ).validate(
                {
                    highlight: function(element) {
                        $(element).addClass('has-error');
                    },
                    unhighlight: function(element) {
                        $(element).removeClass('has-error');
                    },    
                    errorPlacement: function(error, element) {
                        // return false;
                        error.insertAfter(element.parent());
                    }
                });
            });
            $("#btnSeller").on('click',function(event){
                var validator = $( "#reg-form-seller" ).validate(
                {
                    ignore: "",
                    highlight: function(element) {
                        $(element).addClass('has-error');
                    },
                    unhighlight: function(element) {
                        $(element).removeClass('has-error');
                    }, 
                    errorPlacement: function(error, element) {
                        error.insertAfter(element.parent());
                    }
                });
            });
            $("#btnEnterprise").on('click',function(event){
                var validator = $( "#reg-form-enterprise" ).validate(
                {
                    ignore: "",
                    highlight: function(element) {
                        $(element).addClass('has-error');
                    },
                    unhighlight: function(element) {
                        $(element).removeClass('has-error');
                    }, 
                    errorPlacement: function(error, element) {
                        error.insertAfter(element.parent());
                    }
                });
            });
            // $("#reg-form-user").on("submit", function(evt)
            // {
            //     var validator = $( "#reg-form-user" ).validate();
            //     
            //     // $("#reg-form-user").submit();
            // });

            $('#country').on('change',function(){
                var country = $('#country').val();
                // alert(country);
                if(country != "")
                {
                    $.ajax
                    ({
                        url: "{{ route('user.getaddress') }}", 
                        method:'post',
                        data:{
                            country:country
                        },
                        headers: {
                            'X-CSRF-Token': '{{ csrf_token() }}',
                        },
                        async:false,
                        success: function(result){
                            $('#state').html('');
                            $('#state').append('<option value="" selected hidden>Select State</option>');
                            result.forEach(element => {
                                console.log(element.id);
                                $('#state').append('<option value="' + element.id+ '">' + element.name+ '</option>');
                            });
                            $('#state').selectpicker('refresh');
                        }
                    });
                }
            });
            $('#state').on('change',function(){
                var state = $('#state').val();
                if(state != "")
                {
                    $.ajax
                    ({
                        url: "{{ route('user.getaddress') }}", 
                        method:'post',
                        data:{
                            state:state
                        },
                        headers: {
                            'X-CSRF-Token': '{{ csrf_token() }}',
                        },
                        async:false,
                        success: function(result){
                            $('#city').html('');
                            $('#city').append('<option value="" selected hidden>Select City</option>');
                            result.forEach(element => {
                                console.log(element.id);
                                $('#city').append('<option value="' + element.id+ '">' + element.name+ '</option>');
                            });
                            $('#city').selectpicker('refresh');
                    }});
                }
            });

            $('#country_2').on('change',function(){
                var country = $('#country_2').val();
                // alert(country);
                if(country != "")
                {
                    $.ajax
                    ({
                        url: "{{ route('user.getaddress') }}", 
                        method:'post',
                        data:{
                            country:country
                        },
                        headers: {
                            'X-CSRF-Token': '{{ csrf_token() }}',
                        },
                        async:false,
                        success: function(result){
                            $('#state_2').html('');
                            $('#state_2').append('<option value="" selected hidden>Select State</option>');
                            result.forEach(element => {
                                console.log(element.id);
                                $('#state_2').append('<option value="' + element.id+ '">' + element.name+ '</option>');
                            });
                            $('#state_2').selectpicker('refresh');
                        }
                    });
                }
            });
            $('#state_2').on('change',function(){
                var state = $('#state_2').val();
                if(state != "")
                {
                    $.ajax
                    ({
                        url: "{{ route('user.getaddress') }}", 
                        method:'post',
                        data:{
                            state:state
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
                                $('#city_2').append('<option value="' + element.id+ '">' + element.name+ '</option>');
                            });
                            $('#city_2').selectpicker('refresh');
                    }});
                }
            });

            $('#country_3').on('change',function(){
                var country = $('#country_3').val();
                // alert(country);
                if(country != "")
                {
                    $.ajax
                    ({
                        url: "{{ route('user.getaddress') }}", 
                        method:'post',
                        data:{
                            country:country
                        },
                        headers: {
                            'X-CSRF-Token': '{{ csrf_token() }}',
                        },
                        async:false,
                        success: function(result){
                            $('#state_3').html('');
                            $('#state_3').append('<option value="" selected hidden>Select State</option>');
                            result.forEach(element => {
                                console.log(element.id);
                                $('#state_3').append('<option value="' + element.id+ '">' + element.name+ '</option>');
                            });
                            $('#state_3').selectpicker('refresh');
                        }
                    });
                }
            });
            $('#state_3').on('change',function(){
                var state = $('#state_3').val();
                if(state != "")
                {
                    $.ajax
                    ({
                        url: "{{ route('user.getaddress') }}", 
                        method:'post',
                        data:{
                            state:state
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
                                $('#city_3').append('<option value="' + element.id+ '">' + element.name+ '</option>');
                            });
                            $('#city_3').selectpicker('refresh');
                    }});
                }
            });

        });
        @endif

        function isNumber(evt) {
            evt = (evt) ? evt : window.event;
            // var a = $('#phone-code').val();
            // var a_1 = $('#phone-code_1').val();
            // var a_2 = $('#phone-code_2').val();
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;  
	    }

        var isPhoneShown = true,
            countryData = window.intlTelInputGlobals.getCountryData(),
            input = document.querySelector("#phone-code_1"),
            input_2 = document.querySelector("#phone-code_2");
            

        for (var i = 0; i < countryData.length; i++) {
            var country = countryData[i];
            if(country.iso2 == 'bd'){
                country.dialCode = '88';
            }
        }

        var iti = intlTelInput(input, {
            separateDialCode: true,
            utilsScript: "{{ static_asset('assets/js/intlTelutils.js') }}?1590403638580",
            onlyCountries: @php echo json_encode(\App\Models\Country::where('status', 1)->pluck('code')->toArray()) @endphp,
            customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
                if(selectedCountryData.iso2 == 'bd'){
                    return "01xxxxxxxxx";
                }
                return selectedCountryPlaceholder;
            }
        });

        var iti_2 = intlTelInput(input_2, {
            separateDialCode: true,
            utilsScript: "{{ static_asset('assets/js/intlTelutils.js') }}?1590403638580",
            onlyCountries: @php echo json_encode(\App\Models\Country::where('status', 1)->pluck('code')->toArray()) @endphp,
            customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
                if(selectedCountryData.iso2 == 'bd'){
                    return "01xxxxxxxxx";
                }
                return selectedCountryPlaceholder;
            }
        });

        var country = iti.getSelectedCountryData();
        $('input[name=country_code]').val(country.dialCode);

        input.addEventListener("countrychange", function(e) {
            // var currentMask = e.currentTarget.placeholder;

            var country = iti.getSelectedCountryData();
            $('input[name=country_code]').val(country.dialCode);

        });

        var country_2 = iti_2.getSelectedCountryData();
        $('input[name=country_code_2]').val(country_2.dialCode);

        input_2.addEventListener("countrychange", function(e) {
            // var currentMask = e.currentTarget.placeholder;

            var country_2 = iti_2.getSelectedCountryData();
            $('input[name=country_code_2]').val(country_2.dialCode);

        });

        function toggleEmailPhone(el){
            if(isPhoneShown){
                $('.phone-form-group').addClass('d-none');
                $('.email-form-group').removeClass('d-none');
                isPhoneShown = false;
                $(el).html('<i>*{{ translate('Use Phone Number Instead') }}</i>');
            }
            else{
                $('.phone-form-group').removeClass('d-none');
                $('.email-form-group').addClass('d-none');
                isPhoneShown = true;
                $(el).html('*{{ translate('Use Email Instead') }}');
            }
        }
    </script>
@endsection
