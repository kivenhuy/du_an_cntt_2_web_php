@extends('admin.layouts.app')
@section('content')

    <div class="aiz-titlebar mt-2 mb-4">
      <div class="row align-items-center">
        <a style="display: flex;align-items: center;margin-right: 10px" href="{{route('admin.enterprise.index')}}" ><i style="color:black;font-size: 1.73em;" class="fa fa-long-arrow-alt-left"></i></a>
        <div class="col-md-6">
            <h1 class="h3">{{ translate('Enterprise Information')}}
                
            </h1>
        </div>
      </div>
    </div>

    <!-- Basic Info -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ translate('Basic Info') }}</h5>
        </div>
        <div class="card-body">
            <input type="hidden" name="shipper_data_id" value="{{ $data_enterprise->id }}">
                <div class="row">
                    <label class="col-md-2 col-form-label">{{ translate('Enterprise Name') }}<span class="text-danger text-danger">*</span></label>
                    <div class="col-md-10">
                        <input type="text" class="form-control mb-3" placeholder="{{ translate('Seller Name')}}" name="name" value="{{ $data_enterprise->name }}" disabled>
                    </div>
                </div>

                <div class="row">
                    <label class="col-md-2 col-form-label">{{ translate('Bussiness Name') }}<span class="text-danger text-danger">*</span></label>
                    <div class="col-md-10">
                        <input type="text" class="form-control mb-3" placeholder="{{ translate('Seller Name')}}" name="name" value="{{ $data_enterprise->enterprise_detail->bussiness_name }}" disabled>
                    </div>
                </div>

                <div class="row">
                    <label class="col-md-2 col-form-label">{{ translate('Organization Type') }}<span class="text-danger text-danger">*</span></label>
                    <div class="col-md-10">
                        <input type="text" class="form-control mb-3" placeholder="{{ translate('Seller Name')}}" name="name" value="{{ $data_enterprise->enterprise_detail->organization_type }}" disabled>
                    </div>
                </div>

                <div class="row">
                    <label class="col-md-2 col-form-label">{{ translate('Bussiness Type') }}<span class="text-danger text-danger">*</span></label>
                    <div class="col-md-10">
                        <input type="text" class="form-control mb-3" placeholder="{{ translate('Seller Name')}}" name="name" value="{{ ($data_enterprise->enterprise_detail->business_type) }}" disabled>
                    </div>
                </div>
               
                
                <div class="row mb-3">
                    <label class="col-md-2 col-form-label">{{ translate('Enterprise Avatar') }}</label>
                    <div class="col-md-10">
                        <a href="{{uploaded_asset($data_enterprise->avatar_original)}}" target="_blank">
                            <img width="200px" height="200px" src="{{uploaded_asset($data_enterprise->avatar_original)}}" alt="" >
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <label>{{ translate('Enterprise Phone') }} <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-10">
                        <input type="text" class="form-control mb-3" placeholder="{{ translate('Phone')}}" name="phone" value="{{ $data_enterprise->phone }}" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <label>{{ translate('Enterprise Email') }} <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-10">
                        <input type="text" class="form-control mb-3" placeholder="{{ translate('Email')}}" name="phone" value="{{ $data_enterprise->email }}" disabled>
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-2 col-form-label">{{ translate('Enterprise Address') }} <span class="text-danger text-danger">*</span></label>
                    <div class="col-md-10">
                        <input type="text" class="form-control mb-3" placeholder="{{ translate('Address')}}" name="address" value="{{ $data_enterprise->full_adress }}" disabled>
                    </div>
                </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ translate('Tax Info') }}</h5>
        </div>
        <div class="card-body">
                <div class="row">
                    <label class="col-md-2 col-form-label">{{ translate('Tax Number') }}<span class="text-danger text-danger">*</span></label>
                    <div class="col-md-10">
                        <input type="text" class="form-control mb-3" placeholder="{{ translate('Seller Name')}}" name="name" value="{{ $data_enterprise->enterprise_detail->tax_number }}" disabled>
                    </div>
                </div>

                <div class="row">
                    <label class="col-md-2 col-form-label">{{ translate('Fax Number') }}<span class="text-danger text-danger">*</span></label>
                    <div class="col-md-10">
                        <input type="text" class="form-control mb-3" placeholder="{{ translate('Seller Name')}}" name="name" value="{{ $data_enterprise->enterprise_detail->fax_number }}" disabled>
                    </div>
                </div>

                <div class="row">
                    <label class="col-md-2 col-form-label">{{ translate('Registration Number') }}<span class="text-danger text-danger">*</span></label>
                    <div class="col-md-10">
                        <input type="text" class="form-control mb-3" placeholder="{{ translate('Seller Name')}}" name="name" value="{{ $data_enterprise->enterprise_detail->regis_number }}" disabled>
                    </div>
                </div>

                <div class="row">
                    <label class="col-md-2 col-form-label">{{ translate('Date Of Registration') }}<span class="text-danger text-danger">*</span></label>
                    <div class="col-md-10">
                        <input type="text" class="form-control mb-3" placeholder="{{ translate('Seller Name')}}" name="name" value="{{ date('d-m-Y', strtotime(($data_enterprise->enterprise_detail->date_of_regis))) }}" disabled>
                    </div>
                </div>
        </div>
    </div>


    

@endsection

@section('script')


@endsection