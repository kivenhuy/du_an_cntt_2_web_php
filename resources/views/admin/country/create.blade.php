@extends('admin.layouts.app')
@section('content')
<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class="row" style="margin-bottom: 0.5rem;display: flex !important;align-items: center;">
        <div class="col-md-10">
            <h1 class="h3">Add Country</h1>
        </div>
        <div class="text-center col-md-2">
            <a href="{{route('country.index')}}" class="btn btn-secondary"><i class="las la-arrow-left"></i>Back</a>
            {{-- <a href="{{ url()->previous() }}" ><i style="color:black;font-size: 1.73em;" class="las la-arrow-left"></i></a> --}}
        </div>
         
    </div>



<form class="" action="{{ route('country.store') }}" method="POST" enctype="multipart/form-data" id="choice_form">
    <div class="row gutters-5">
        <div class="col-lg-12">
            @csrf
            <input type="hidden" name="added_by" value="seller">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{ translate('Country Information') }}</h5>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">{{ translate('Country Name') }} <span class="text-danger">*</span></label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="country_name"
                                placeholder="{{ translate('Country Name') }}"  required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">{{ translate('Country Code') }} <span class="text-danger">*</span></label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="country_code"
                                placeholder="{{ translate('Country Code') }}" onchange="" required>
                        </div>
                    </div>
                    
                    
                </div>
            </div>

        </div>

        
        <div class="col-12">
            <div class="mar-all text-right mb-2">
                <button type="submit" name="button" value="publish"
                    class="btn btn-primary">{{ translate('Create Country') }}</button>
            </div>
        </div>
    </div>

</form>
</div>
@endsection