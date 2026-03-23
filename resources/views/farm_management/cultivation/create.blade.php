@extends('farm_management.layouts.app')
@section('panel_content')
    <!-- Main content -->
    <div class="container-fluid">

        <div class="row">
          <div class="col-12">
            <div class="card">
                <div class="card-header row gutters-5">
                    <div class="col">
                        <h5 class="mb-md-0 h6">New Cultivation</h5>
                    </div>
                    
                </div>
              <div class="card-body" >
                <form action="{{route('cultivation.store')}}" method="POST">
                    @csrf
                    {{-- Farmer Name --}}
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">Farmer Name</label>
                        <div class="col-md-8">
                            <select class="form-control aiz-selectpicker" name="farmer_id" id="farmer_id">
                                    @foreach($all_farmer as $each_farmer)
                                        <option value="{{$each_farmer->id}}">{{$each_farmer->full_name}}</option>	
                                    @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Cultiavtion Name --}}
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">Cultivation Name</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="cultivation_name" placeholder="Cultivation Name">
                         </div>
                    </div>
                    
                    {{-- <div class="form-group row">
                        <label class="col-md-3 col-from-label">Famer Mobile</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="phone_number" placeholder="Farmer Phone">
                        </div>
                    </div> --}}
                    {{-- Harvest Season --}}
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">Harvest Season</label>
                        <div class="col-md-8">
                            <select class="form-control aiz-selectpicker" name="harvest_Season" id="harvest_Season">
                                    <option value="WS">Winter-Spring</option>
                                    <option value="SA">Sumer-Autum</option>
                                    <option value="AW">Autum-Winter</option>
                            </select>
                        </div>
                    </div>

                    {{-- Crop Variety --}}
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">Crop Variety</label>
                        <div class="col-md-8">
                            <select class="form-control aiz-selectpicker" name="crop_variety" id="crop_variety">
                                <option value="OM18">OM18</option>	
                                <option value="DT8">DT8</option>
                                <option value="ST24">ST24</option>
                                <option value="ST25">ST25</option>   
                                <option value="Jasmine">Jasmine</option>		
                                <option value="Nang hoa9">Nang hoa9</option>		
                                <option value="RVT">RVT</option>		
                                <option value="OM5451">OM5451</option>		
                                <option value="IR504">IR504</option>	
                                <option value="OM6976">OM6976</option>	
                                <option value="VNR20">VNR20</option>	
                                <option value="Nep">Nep</option>	
                                <option value="DS1">DS1</option>
                                {{-- @foreach ($cropinformation as $crop_data)
                                    <option value="{{ $crop_data->id }}">{{ $crop_data->name }}</option>
                                @endforeach --}}
                            </select>
                        </div>
                    </div>
                    
                    {{-- Expected Date of Harvest after Sowing --}}
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">Expected Date of Harvest after Sowing</label>
                        <div class="col-md-8">
                            <input  type="datetime-local" class="form-control" name="expected_Date_of_Harvest_after_Sowing" id="expected_Date_of_Harvest_after_Sowing">
                        </div>
                    </div>
                    {{-- Sowing Date --}}
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">Sowing Date</label>
                        <div class="col-md-8">
                            <input  type="datetime-local" class="form-control" name="sowing_Date" id="sowing_Date">
                        </div>
                    </div>
                    {{-- est_Yield --}}
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">Expected Yield</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="est_Yield" placeholder="Expected Yield Unit: đơn vị năng suất, kg: kilôgam, tonne:tấn ">
                        </div>
                    </div>
                    {{-- seed_Quantity_unit --}}
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">Seed Quantity(tonne)</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control rounded-0" value="" min="1" max="999999999" name="seed_Quantity_unit" id="seed_Quantity_unit" autocomplete="off">
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