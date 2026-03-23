@extends('farm_management.layouts.app')
@section('panel_content')
    <!-- Main content -->
    <div class="container-fluid">

        <div class="row">
          <div class="col-12">
            <div class="card">
                <div class="card-header row gutters-5">
                    <div class="col">
                        <h5 class="mb-md-0 h6">New Farmer</h5>
                    </div>
                    
                </div>
              <div class="card-body" >
                <form action="{{route('farmer.store')}}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">Farmer Name</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="full_name" placeholder="Farmer Name">
                         </div>
                    </div>
                    {{-- Farmer Name --}}
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">Famer Mobile</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="phone_number" placeholder="Farmer Phone">
                        </div>
                    </div>
                    {{-- Farmer Number --}}
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">Gender</label>
                        <div class="col-md-8">
                            <select class="form-control aiz-selectpicker" name="gender" id="gender">
                                    <option value="1">Male</option>
                                    <option value="0">Female</option>
                            </select>
                        </div>
                    </div>
                    
                    {{-- Village --}}
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">Province</label>
                        <div class="col-md-8">
                            <select class="form-control aiz-selectpicker" name="province_id" id="province_id">
                                    @foreach ($province as $province_data)
                                        <option value="{{ $province_data->id }}">{{ $province_data->province_name }}</option>
                                    @endforeach
                            </select>
                        </div>
                    </div>
                    {{-- Province --}}
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">Commune</label>
                        <div class="col-md-8">
                            <select class="form-control aiz-selectpicker" name="commune_id" id="commune_id">
                                    @foreach ($commune as $commune_data)
                                        <option value="{{ $commune_data->id }}">{{ $commune_data->commune_name }}</option>
                                    @endforeach
                            </select>
                        </div>
                    </div>
                    {{-- gender --}}
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">Famer Village</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="village" placeholder="Village Name">
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-md-3 col-from-label">Photo</label>
                        <div class="col-md-8">
                            <img class="mb-3 js-image-upload d-none" src="" width="200" alt="Author icon">
                            <input id="js-photo-input" 
                                name="photo" type="file" 
                                accept=".jpeg, .png, .jpg, .gif"
                                data-parsley-trigger="change"
                                data-parsley-filemaxmegabytes="10"
                                data-parsley-fileextensions="jpeg, png, jpg, gif"
                                data-parsley-fileextensions-message="Upload jpeg, png, jpg or gif file"
                                data-parsley-errors-container="#js-photo-error">
                            <div id="js-photo-error" class="text-nowrap mt-2"></div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="mar-all mb-2" style=" text-align: end;">
                            <button type="submit" name="button" value="publish"
                                class="btn btn-primary">Create</button>
                        </div>
                    </div>
                </form>
              </div>
              
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
   
@stop