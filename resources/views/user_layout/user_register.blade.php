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
                                            <h1 class="fw-700 register-mobile-header">{{ translate('Create an account')}}</h1>
                                        </div>
                                    </div>
                                    <!-- Register form -->
                                    <div class="pt-3 pt-lg-4">
                                        <div class="">
                                            
                                                <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist" style="margin-bottom: 2%">
                                                    <li class="nav-item mb-2" style="">
                                                        <a class="nav-link {{ (old('user_type') == null || old('user_type') == 'customer') ? 'active' : '' }}" id="custom-content-below-home-tab" data-toggle="pill" href="#information" role="tab" aria-controls="custom-content-below-home" aria-selected="true"><span class="text_head_register">{{ translate('Buyer') }}</span></a>
                                                    </li>
                
                                                    <li class="nav-item" style="">
                                                        <a class="nav-link {{ (old('user_type') == 'seller') ? 'active' : '' }}" id="custom-content-below-messages-tab" data-toggle="pill" href="#refundhistorytab" role="tab" aria-controls="custom-content-below-messages" aria-selected="false" ><span class="text_head_register">{{ translate('Seller') }}</span></a>
                                                    </li>

                                                    <li class="nav-item" style="">
                                                        <a class="nav-link " id="custom-content-below-enterprise-tab" data-toggle="pill" href="#enterprisetab" role="tab" aria-controls="custom-content-below-enterprise" aria-selected="false"><span class="text_head_register">{{ translate('Enterprise') }}</a>
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
                                                                            <label for="phone" class="fs-12 fw-700 text-soft-dark">{{  translate('Mobile Phone') }}</label>
                                                                            <input required type="tel" id="phone-code" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }} rounded-0" onkeypress="return isNumber(event)" value="{{ old('phone') }}" placeholder="" name="phone" autocomplete="off">
                                                                            <input type="hidden" name="country_code" value="">
                                                                        </div>
                                                                        
                                                                    </div>
                                                                </div>
                                                                
                                                               
                                                                <div class="form-group row">
                                                                    <div class="col-md-6">
                                                                        <!-- Email or Phone -->
                                                                        <div class="form-group">
                                                                            <label for="js-customer-check-email-exist" class="fs-12 fw-700 text-soft-dark">{{  translate('Email') }}</label>
                                                                            <input type="email" id="js-customer-check-email-exist" class="form-control rounded-0{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" placeholder="{{  translate('Email') }}" name="email" autocomplete="off">
                                                                            <span class="js-customer-email-error invalid-feedback" style="display:block;color:#EB000A; font-size: 14px;"></span>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                </div>

                                                                <div class="form-group row">
                                                                    <div class="col-md-6">
                                                                        <!-- password -->
                                                                        <div class="form-group">
                                                                            <label for="password" class="fs-12 fw-700 text-soft-dark">{{  translate('Password') }}</label>
                                                                            <input type="password" required class="form-control rounded-0{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{  translate('Password must contain at least 6 digits') }}" name="password" autocomplete="off">
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
                                                                            <input type="password" required class="form-control rounded-0" placeholder="{{  translate('Confirm Password') }}" name="password_confirmation" autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                           

                                                            <!-- Terms and Conditions -->
                                                            <div class="mb-3">
                                                                <label class="aiz-checkbox d-block">
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
                                                    <div class="tab-pane fade  {{ (old('user_type') == 'seller') ? 'active show' : '' }}" id="refundhistorytab" role="tabpanel" aria-labelledby="custom-content-below-info-tab">
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
                                                                        <select required class="form-control aiz-selectpicker" id="country_2" name="country_2" data-live-search="true">
                                                                            <option value="" hidden>Select Country</option>
                                                                            @foreach($country as $data_country)
                                                                                <option value="{{$data_country->id}}">{{$data_country->country_name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        {{-- <input type="text" class="form-control rounded-0{{ $errors->has('country') ? ' is-invalid' : '' }}" placeholder="{{  translate('Country') }}" name="country"> --}}
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    {{-- City --}}
                                                                    <div class="form-group">
                                                                        <label for="password_confirmation" class="fs-12 fw-700 text-soft-dark">{{  translate('City') }}</label>
                                                                        <select required class="form-control aiz-selectpicker" id="city_2" name="city_2" data-live-search="true">
                                                                            <option value="" selected hidden>Select City</option>
                                                                           
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                
                                                                <div class="col-md-6">
                                                                     <!-- District -->
                                                                     <div class="form-group">
                                                                        <label for="ward_code" class="fs-12 fw-700 text-soft-dark">{{  translate('District') }}</label>
                                                                        <select required class="form-control aiz-selectpicker" id="district" name="district" data-live-search="true">
                                                                            <option value="" selected hidden>Select District</option>
                                                                           
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="ward_code" class="fs-12 fw-700 text-soft-dark">{{  translate('Ward') }}</label>
                                                                        <input type="text" class="form-control rounded-0" placeholder="{{  translate('Ward') }}" name="ward" value="{{ old('ward')}}">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                               
                                                                <div class="col-md-6">
                                                                    <!-- Address -->
                                                                    <div class="form-group">
                                                                        <label for="ward_code" class="fs-12 fw-700 text-soft-dark">{{  translate('Address') }}</label>
                                                                        <input type="text" class="form-control rounded-0" placeholder="{{  translate('Address') }}" name="address" value="{{ old('address')}}">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <div class="col-md-6">
                                                                    <!-- Email or Phone -->
                                                                    <div class="form-group">
                                                                        <label for="email" class="fs-12 fw-700 text-soft-dark">{{  translate('Email') }}</label>
                                                                        <input type="email" id="js-seller-check-email-exist" class="form-control rounded-0{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" placeholder="{{  translate('Email') }}" name="email" autocomplete="off">
                                                                        @if ($errors->has('email'))
                                                                            <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $errors->first('email') }}</strong>
                                                                            </span>
                                                                         @endif
                                                                        <span class="js-seller-email-error invalid-feedback" style="display:block;color:#EB000A; font-size: 14px;"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    {{-- Phone Number --}}
                                                                    <div class="form-group phone-form-group">
                                                                        <label for="phone" class="fs-12 fw-700 text-soft-dark">{{  translate('Mobile Phone') }}</label>
                                                                        <input required type="tel" id="phone-code_1" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }} rounded-0" onkeypress="return isNumber(event)" value="{{ old('phone') }}" placeholder="" name="phone" autocomplete="off">
                                                                    </div>
                                                                    <input type="hidden" name="country_code" value="{{ old('country_code') }}">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-md-6">
                                                                    <!-- password -->
                                                                    <div class="form-group">
                                                                        <label for="password" class="fs-12 fw-700 text-soft-dark">{{  translate('Password') }}</label>
                                                                        <input required type="password" class="form-control rounded-0{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{  translate('Password must contain at least 6 digits') }}" name="password" autocomplete="off">
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
                                                            

                                                            <!-- Submit Button -->
                                                            <div class="mb-4 mt-4">
                                                                <button type="btn" id="btnSeller" class="btn btn-primary btn-block fw-600 rounded-4">{{  translate('Create Account') }}</button>
                                                            </div>
                                                        </form>
                                                    </div>  

                                                    <div class="tab-pane fade  " id="enterprisetab" role="tabpanel" aria-labelledby="custom-content-below-enterprise">
                                                        <form id="reg-form-enterprise" class="form-default" role="form" action="{{ route('enterprise.registration') }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                            <input type="hidden" name="user_type" value="enterprise">
                                                            <label style="font-size: 24px;font-weight: 600;">Company Information</label>
                                                            <div class="form-group row">
                                                                <div class="col-md-4">
                                                                    <!-- Name -->
                                                                    <div class="form-group">
                                                                        <label for="legal_name" class="fs-12 fw-700 text-soft-dark">{{  translate('Legal Name') }}</label>
                                                                        <input required type="text" class="form-control rounded-0{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" placeholder="{{  translate('Legal Name') }}" name="name">
                                                                        @if ($errors->has('name'))
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $errors->first('name') }}</strong>
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
                                                                                <option value={{$data_country->id}}>{{$data_country->country_name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        {{-- <input type="text" class="form-control rounded-0{{ $errors->has('country') ? ' is-invalid' : '' }}" placeholder="{{  translate('Country') }}" name="country"> --}}
                                                                    </div>

                                                                    

                                                                    <!-- Address -->
                                                                    <div class="form-group">
                                                                        <label for="ward_code" class="fs-12 fw-700 text-soft-dark">{{  translate('Address') }}</label>
                                                                        <input type="text" class="form-control rounded-0" placeholder="{{  translate('Address') }}" name="address_3">
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

                                                                    {{-- Ward --}}
                                                                    <div class="form-group">
                                                                        <label for="ward_code" class="fs-12 fw-700 text-soft-dark">{{  translate('Ward') }}</label>
                                                                        <input type="text" class="form-control rounded-0" placeholder="{{  translate('Ward') }}" name="ward_3">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    
                                                                    <!-- District -->
                                                                    <div class="form-group">
                                                                        <label for="ward_code" class="fs-12 fw-700 text-soft-dark">{{  translate('District') }}</label>
                                                                        <select required class="form-control aiz-selectpicker" id="district_3" name="district_3" data-live-search="true">
                                                                            <option value="" selected hidden>Select District</option>
                                                                           
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


                                                           
                                                    

                                                            <!-- Submit Button -->
                                                            <div class="mb-4 mt-4">
                                                                <button type="btn" id="btnEnterprise" class="btn btn-primary btn-block fw-600 rounded-4">{{  translate('Create Account') }}</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                        </div>

                                        <!-- Log In -->
                                        <div class="text-center">
                                            <p class="fs-12 text-gray mb-0">{{ translate('Already have an account?')}}</p>
                                            <a href="{{ route('user.login') }}" class="fs-14 fw-700 animate-underline-primary">{{ translate('Log In')}}</a>
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