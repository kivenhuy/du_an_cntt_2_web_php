@extends('seller.layouts.app')
@section('panel_content')
<div class="row">
    {{-- <div class="col-sm-6 col-md-6 col-xxl-3"> --}}
        <div class="container-fluid">

            <div class="row">
              <div class="col-12">
                <div class="card">
                    <div class="card-header row gutters-5">
                        <div class="col">
                            <h5 class="mb-md-0 h6">All Products</h5>
                        </div>
                        <div class="col">
                            <div class="mar-all mb-2" style=" text-align: end;">
                                <a href="{{route('seller.products.create')}}">
                                    <button type="submit" name="button" value="publish"
                                        class="btn btn-primary">Create</button>
                                </a>
                            </div>
                        </div>
                    </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
    {{-- </div> --}}
</div>
@endsection