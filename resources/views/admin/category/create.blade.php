@extends('admin.layouts.app')
@section('content')
<div class="aiz-titlebar mt-2 mb-4">
    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row" style="margin-bottom: 0.5rem;display: flex !important;align-items: center;">
            <div class="col-md-10">
                <h1 class="h3">Tạo danh mục</h1>
            </div>
            <div class="text-center col-md-2">
                <a href="{{route('categories.index')}}" class="btn btn-secondary"><i style="margin-right:8px" class="fa fa-arrow-left"></i>Quay lại</a>
                {{-- <a href="{{ url()->previous() }}" ><i style="color:black;font-size: 1.73em;" class="las la-arrow-left"></i></a> --}}
            </div>
             
        </div>



    <form class="" action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data" id="choice_form">
        <div class="row gutters-5">
            <div class="col-lg-12">
                @csrf
                <input type="hidden" name="added_by" value="seller">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">Thông tin danh mục</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">Tên danh mục <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="name"
                                    placeholder="Tên danh mục" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label"
                                for="signinSrEmail">Icon</label>
                            <div class="col-md-8">
                                <div class="input-group" data-toggle="aizuploader" data-type="image"
                                    data-multiple="false">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                            Duyệt</div>
                                    </div>
                                    <div class="form-control file-amount">Chọn file</div>
                                    <input type="hidden" name="icon" class="selected-files">
                                </div>
                                <div class="file-preview box sm">
                                </div>
                                <small class="text-muted">Icon cho danh mục trên trang chủ (ví dụ: 64x64 hoặc PNG vuông).</small>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-md-3 col-form-label"
                                for="signinSrEmail">Banner</label>
                            <div class="col-md-8">
                                <div class="input-group" data-toggle="aizuploader" data-type="image"
                                    data-multiple="true">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                            Duyệt</div>
                                    </div>
                                    <div class="form-control file-amount">Chọn file</div>
                                    <input type="hidden" name="banner" class="selected-files">
                                </div>
                                <div class="file-preview box sm">
                                </div>
                                <small class="text-muted">Các hình ảnh này sẽ hiển thị trong trang chi tiết sản phẩm. Sử dụng kích thước 600x600.</small>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-md-3 col-form-label"
                                for="signinSrEmail">Hình ảnh sản phẩm (600x600)</label>
                            <div class="col-md-8">
                                <div class="input-group" data-toggle="aizuploader" data-type="image"
                                    data-multiple="false">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                            Duyệt</div>
                                    </div>
                                    <div class="form-control file-amount">Chọn file</div>
                                    <input type="hidden" name="cover_image" class="selected-files">
                                </div>
                                <div class="file-preview box sm">
                                </div>
                                <small class="text-muted">Các hình ảnh này sẽ hiển thị trong trang chi tiết sản phẩm. Sử dụng kích thước 600x600.</small>
                            </div>
                        </div>
                        

                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">Meta Title <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="meta_title"
                                    placeholder="Meta Title" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">Meta Description <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="meta_description"
                                    placeholder="Meta Description" required>
                            </div>
                        </div>
                        
                    </div>
                </div>
                
            </div>

            
            <div class="col-12">
                <div class="mar-all text-right mb-2">
                    <button type="submit" name="button" value="publish"
                        class="btn btn-primary">Lưu</button>
                </div>
            </div>
        </div>

    </form>
    </div>
    {{-- <div class="row align-items-center">
        <div class="col-md-6">
            
        </div>
    </div> --}}
</div>
@endsection