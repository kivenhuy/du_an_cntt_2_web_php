@extends('admin.layouts.app')
@section('content')

    <div class="aiz-titlebar mt-2 mb-4">
      <div class="row align-items-center">
        <a style="display: flex;align-items: center;margin-right: 10px" href="{{route('admin.shipper.index')}}" ><i style="color:black;font-size: 1.73em;" class="fa fa-long-arrow-alt-left"></i></a>
        <div class="col-md-6">
            <h1 class="h3">{{ translate('Shipper Information')}}
                
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
            <input type="hidden" name="shipper_data_id" value="{{ $shipper_data->id }}">
                <div class="row">
                    <label class="col-md-2 col-form-label">{{ translate('Shipper Carrier') }}<span class="text-danger text-danger">*</span></label>
                    <div class="col-md-10">
                        <input type="text" class="form-control mb-3" placeholder="{{ translate('Shipper Carrier')}}" name="name" value="{{ $shipper_data->carrier_name }}" disabled>
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-2 col-form-label">{{ translate('Shipper Name') }}<span class="text-danger text-danger">*</span></label>
                    <div class="col-md-10">
                        <input type="text" class="form-control mb-3" placeholder="{{ translate('Shipper Name')}}" name="name" value="{{ $shipper_data->name }}" disabled>
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-2 col-form-label">{{ translate('Shipper National ID') }}<span class="text-danger text-danger">*</span></label>
                    <div class="col-md-10">
                        <input type="text" class="form-control mb-3" placeholder="{{ translate('Shipper National ID')}}" name="name" value="{{ $shipper_data->national_id }}" disabled>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-md-2 col-form-label">{{ translate('Shipper ID Proof') }}</label>
                    <div class="col-md-10">
                        <a href="{{$shipper_data->img_id}}" target="_blank">
                            <img width="200px" height="100px" src="{{$shipper_data->img_id}}" alt="" >
                        </a>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-md-2 col-form-label">{{ translate('Shipper Avatar') }}</label>
                    <div class="col-md-10">
                        <a href="{{$shipper_data->img_logo}}" target="_blank">
                            <img width="200px" height="200px" src="{{$shipper_data->img_logo}}" alt="" >
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <label>{{ translate('Shipper Phone') }} <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-10">
                        <input type="text" class="form-control mb-3" placeholder="{{ translate('Phone')}}" name="phone" value="{{ $shipper_data->phone }}" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <label>{{ translate('Shipper Email') }} <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-10">
                        <input type="text" class="form-control mb-3" placeholder="{{ translate('Email')}}" name="phone" value="{{ $shipper_data->email }}" disabled>
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-2 col-form-label">{{ translate('Shipper Address') }} <span class="text-danger text-danger">*</span></label>
                    <div class="col-md-10">
                        <input type="text" class="form-control mb-3" placeholder="{{ translate('Address')}}" name="address" value="{{ $shipper_data->full_adress }}" disabled>
                    </div>
                </div>
        </div>
    </div>

    

    <!-- Banner Settings -->
    <div class="card-header">
        <h5 class="mb-0 h6">{{ translate('Shipper Vehicle') }}</h5>
    </div>
    <div class="card-body">
            <div class="row mb-3">
                <label class="col-md-2 col-form-label">{{ translate('Type Vehicle') }} <span class="text-danger text-danger">*</span></label>
                <div class="col-md-10">
                    <input type="text" class="form-control mb-3" placeholder="{{ translate('License Plates')}}" name="license_plates" value="{{ $shipper_data->shipper_detail->vehicle }}" disabled>
                </div>
            </div>
            
            <div class="row mb-3">
                <label class="col-md-2 col-form-label">{{ translate('Vehicle Image') }}</label>
                <div class="col-md-10">
                    @foreach ($shipper_data->vehicle_image as $data_image)
                        <a href="{{$data_image}}" target="_blank">
                            <img width="200px" height="100px" src="{{$data_image}}" alt="" >
                        </a>
                    @endforeach
                    
                </div>
            </div>

            <div class="row">
                <label class="col-md-2 col-form-label">{{ translate('License Plates') }} <span class="text-danger text-danger">*</span></label>
                <div class="col-md-10">
                    <input type="text" class="form-control mb-3" placeholder="{{ translate('License Plates')}}" name="license_plates" value="{{ $shipper_data->shipper_detail->license_plates }}" disabled>
                </div>
            </div>
            
            <div class="row mb-3">
                <label class="col-md-2 col-form-label">{{ translate('Driver Lincense') }}</label>
                <div class="col-md-10">
                    @foreach ($shipper_data->license_image as $data_image)
                        <a href="{{$data_image}}" target="_blank">
                            <img width="200px" height="100px" src="{{$data_image}}" alt="" >
                        </a>
                    @endforeach
                    
                </div>
            </div>

            
    </div>

    

@endsection

@section('script')


@endsection