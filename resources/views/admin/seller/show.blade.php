@extends('admin.layouts.app')
@section('content')

    <div class="aiz-titlebar mt-2 mb-4">
      <div class="row align-items-center">
        <a style="display: flex;align-items: center;margin-right: 10px" href="{{route('admin.sellers.index')}}" ><i style="color:black;font-size: 1.73em;" class="fa fa-long-arrow-alt-left"></i></a>
        <div class="col-md-6">
            <h1 class="h3">{{ translate('Seller Information')}}
                
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
            <input type="hidden" name="shipper_data_id" value="{{ $data_seller->id }}">
                <div class="row">
                    <label class="col-md-2 col-form-label">{{ translate('Seller Name') }}<span class="text-danger text-danger">*</span></label>
                    <div class="col-md-10">
                        <input type="text" class="form-control mb-3" placeholder="{{ translate('Seller Name')}}" name="name" value="{{ $data_seller->name }}" disabled>
                    </div>
                </div>

                <div class="row">
                    <label class="col-md-2 col-form-label">{{ translate('Legal Name') }}<span class="text-danger text-danger">*</span></label>
                    <div class="col-md-10">
                        <input type="text" class="form-control mb-3" placeholder="{{ translate('Seller Name')}}" name="name" value="{{ $data_seller->name }}" disabled>
                    </div>
                </div>
               
                
                <div class="row mb-3">
                    <label class="col-md-2 col-form-label">{{ translate('Seller Avatar') }}</label>
                    <div class="col-md-10">
                        <a href="{{uploaded_asset($data_seller->logo)}}" target="_blank">
                            <img width="200px" height="200px" src="{{uploaded_asset($data_seller->logo)}}" alt="" >
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <label>{{ translate('Seller Phone') }} <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-10">
                        <input type="text" class="form-control mb-3" placeholder="{{ translate('Phone')}}" name="phone" value="{{ $data_seller->phone }}" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <label>{{ translate('Seller Email') }} <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-10">
                        <input type="text" class="form-control mb-3" placeholder="{{ translate('Email')}}" name="phone" value="{{ $data_seller->user->email }}" disabled>
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-2 col-form-label">{{ translate('Seller Address') }} <span class="text-danger text-danger">*</span></label>
                    <div class="col-md-10">
                        <input type="text" class="form-control mb-3" placeholder="{{ translate('Address')}}" name="address" value="{{ $data_seller->full_adress }}" disabled>
                    </div>
                </div>
        </div>
    </div>


    

@endsection

@section('script')


@endsection