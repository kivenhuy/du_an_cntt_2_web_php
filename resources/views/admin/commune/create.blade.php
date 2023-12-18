@extends('admin.layouts.app')
@section('content')
<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class="row" style="margin-bottom: 0.5rem;display: flex !important;align-items: center;">
        <div class="col-md-10">
            <h1 class="h3">Add Commune</h1>
        </div>
        <div class="text-center col-md-2">
            <a href="{{route('commune.index')}}" class="btn btn-secondary"><i class="las la-arrow-left"></i>Back</a>
            {{-- <a href="{{ url()->previous() }}" ><i style="color:black;font-size: 1.73em;" class="las la-arrow-left"></i></a> --}}
        </div>
         
    </div>



<form class="" action="{{ route('commune.store') }}" method="POST" enctype="multipart/form-data" id="choice_form">
    <div class="row gutters-5">
        <div class="col-lg-12">
            @csrf
            <input type="hidden" name="added_by" value="seller">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{ translate('Commune Information') }}</h5>
                </div>
                <div class="card-body">
                    
                    <div class="form-group row" id="category">
                        <label class="col-md-3 col-from-label">{{ translate('Province Name') }}</label>
                        <div class="col-md-8">
                            <select class="form-control aiz-selectpicker" name="province_id" id="province_id"
                                data-live-search="true" required>
                                @foreach($province as $province_data)
                                    <option value="{{$province_data->id}}">{{$province_data->province_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">{{ translate('Commune Name') }} <span class="text-danger">*</span></label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="commune_name"
                                placeholder="{{ translate('Commune Name') }}"  required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">{{ translate('Commune Code') }} <span class="text-danger">*</span></label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="commune_code"
                                placeholder="{{ translate('Commune Code') }}" onchange="" required>
                        </div>
                    </div>
                    
                    
                </div>
            </div>

        </div>

        
        <div class="col-12">
            <div class="mar-all text-right mb-2">
                <button type="submit" name="button" value="publish"
                    class="btn btn-primary">{{ translate('Create Commune') }}</button>
            </div>
        </div>
    </div>

</form>
</div>
@endsection