@extends('admin.layouts.app')
@section('content')

<div class="aiz-titlebar mt-2 mb-4">
    <div class="row align-items-center">
        <div class="col-md-6" style="display: flex">
            <a style="display: flex;align-items: center;margin-right: 10px" href="{{route('admin.products.index')}}" ><i style="color:black;font-size: 1.73em;" class="fa fa-long-arrow-alt-left"></i></a>
            <h1 class="h3">Chi tiết sản phẩm</h1>
        </div>
    </div>
</div>

<!-- Error Meassages -->
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form class="" action="{{ route('admin.products.update', ['id' => $product->id]) }}" method="POST" enctype="multipart/form-data"
    id="choice_form">
    <div class="row gutters-5">
        <div class="col-lg-8">
            <input name="_method" type="hidden" value="POST">
            <input type="hidden" name="id" value="{{ $product->id }}">
            @csrf
            <input type="hidden" name="added_by" value="seller">
            <div class="card">
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-lg-3 col-from-label">Tên sản phẩm</label>
                        <div class="col-lg-8">
            <input type="text" class="form-control" name="name"
                                placeholder="{{translate('Product Name')}}" value="{{$product->name}}"
                                >
                        </div>
                    </div>
                    <div class="form-group row" id="category">
                        <label class="col-lg-3 col-from-label">Danh mục</label>
                        <div class="col-lg-8">
                            <select class="form-control aiz-selectpicker" name="category_id" id="category_id"
                                data-selected="{{ $product->category_id }}" data-live-search="true">
                                @foreach ($categories as $data_category)
                                    <option value="{{ $data_category->id }}" @if($product->category_id == $data_category->id) selected @endif>{{ $data_category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row" id="brand_row">
                        <label class="col-lg-3 col-from-label">Thương hiệu</label>
                        <div class="col-lg-8">
                            <select class="form-control aiz-selectpicker" name="brand_id" id="brand_id"
                                data-live-search="true">
                                <option value="">-- Không có thương hiệu --</option>
                                @foreach($brands ?? [] as $brand)
                                    <option value="{{ $brand->id }}" @if($product->brand_id == $brand->id) selected @endif>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-lg-3 col-from-label">Đơn vị</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control" name="unit"
                                placeholder="{{ translate('Unit (e.g. KG, Pc etc)') }}"
                                value="{{$product->unit}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">Dung tích <small>(ví dụ: 100ml, 500ml, 1000ml)</small></label>
                        <div class="col-md-8">
                            <input type="number" class="form-control" name="weight" value="{{ $product->weight }}" step="0.01" placeholder="0.00">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-from-label">Số lượng tối thiểu</label>
                        <div class="col-lg-8">
                            <input type="number" lang="en" class="form-control" name="min_qty"
                                value="@if($product->min_qty <= 1){{1}}@else{{$product->min_qty}}@endif" min="1"
                                >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-from-label">Tags</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control aiz-tag-input" name="tags[]" id="tags"
                                value="{{ $product->tags }}" placeholder="{{ translate('Type to add a tag') }}"
                                data-role="tagsinput" >
                        </div>
                    </div>
                    
                    
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">Hình ảnh sản phẩm</h5>
                </div>
                <div class="card-body">

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label"
                            for="signinSrEmail">Hình ảnh chi tiết sản phẩm</label>
                        <div class="col-md-8">
                            <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="true">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium" >
                                        Duyệt</div>
                                </div>
                                <div class="form-control file-amount">Chọn file</div>
                                <input type="hidden" name="photos" value="{{ $product->photos }}"
                                    class="selected-files">
                            </div>
                            <div class="file-preview box sm">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="signinSrEmail">Hình ảnh sản phẩm
                            <small>(290x300)</small></label>
                        <div class="col-md-8">
                            <div class="input-group" data-toggle="aizuploader" data-type="image">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                                        Duyệt</div>
                                </div>
                                <div class="form-control file-amount">Chọn file</div>
                                <input type="hidden" name="thumbnail_img" value="{{ $product->thumbnail_img }}"
                                    class="selected-files">
                            </div>
                            <div class="file-preview box sm">
                            </div>
                        </div>
                    </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">Giá sản phẩm + tồn kho</h5>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label class="col-lg-3 col-from-label">Giá đơn vị</label>
                <div class="col-lg-6">
                    <input type="text" placeholder="Giá đơn vị" name="unit_price" class="form-control"
                        value="{{$product->unit_price}}" required>
                </div>
            </div>

            @php
                $date_range = $product->expired_date;
                if($product->discount_start_date){
                    $start_date = date('d-m-Y H:i:s', $product->discount_start_date);
                    $end_date = date('d-m-Y H:i:s', $product->discount_end_date);
                    $date_range = $start_date.' to '.$end_date;
                }
            @endphp

            <div class="form-group row">
                <label class="col-lg-3 col-from-label" for="start_date">Ngày hết hạn</label>
                <div class="col-lg-9">
                    <input type="text" class="form-control aiz-date-range" value="{{ $date_range }}" name="date_range" placeholder="Chọn ngày" data-time-picker="true" data-format="DD-MM-Y HH:mm:ss" data-separator=" to " autocomplete="off">
                </div>
            </div>

            

            <div id="show-hide-div">
                <div class="form-group row">
                    <label class="col-lg-3 col-from-label">Số lượng</label>
                    <div class="col-lg-6">
                        <input type="number" lang="en" value="{{ $product->product_stock?->qty }}" step="1"
                            placeholder="Số lượng" name="current_stock" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-from-label">
                        Mã kho
                    </label>
                    <div class="col-md-6">
                        <input type="text" placeholder="Mã kho" value="{{ $product->product_stock?->sku }}" name="sku" class="form-control">
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 col-from-label">
                    Liên kết ngoài
                </label>
                <div class="col-md-9">
                    <input type="text" placeholder="Liên kết ngoài" name="external_link" value="{{ $product->external_link }}" class="form-control">
                    <small class="text-muted">Bỏ trống nếu bạn không sử dụng liên kết ngoài</small>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 col-from-label">
                    Text liên kết ngoài
                </label>
                <div class="col-md-9">
                    <input type="text" placeholder="Text liên kết ngoài" name="external_link_btn" value="{{ $product->external_link_btn }}" class="form-control">
                    <small class="text-muted">Bỏ trống nếu bạn không sử dụng liên kết ngoài</small>
                </div>
            </div>
            <br>
            <div class="sku_combination" id="sku_combination">

            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">Mô tả sản phẩm</h5>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label class="col-lg-3 col-from-label">Mô tả</label>
                <div class="col-lg-9">
                    <textarea class="aiz-text-editor"
                        name="description">{{ $product->description }}</textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-3 col-from-label">Thành phần</label>
                <div class="col-lg-9">
                    <textarea class="aiz-text-editor"
                        name="ingredients">{{ $product->ingredients }}</textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-3 col-from-label">Hướng dẫn sử dụng</label>
                <div class="col-lg-9">
                    <textarea class="aiz-text-editor"
                        name="usage_instructions">{{ $product->usage_instructions }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">PDF Specification</h5>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label class="col-md-3 col-form-label" for="signinSrEmail">PDF Specification</label>
                <div class="col-md-8">
                    <div class="input-group" data-toggle="aizuploader">
                        <div class="input-group-prepend">
                            <div class="input-group-text bg-soft-secondary font-weight-medium">Duyệt
                            </div>
                        </div>
                        <div class="form-control file-amount">Chọn file</div>
                        <input type="hidden" name="pdf" value="{{ $product->pdf }}" class="selected-files">
                    </div>
                    <div class="file-preview box sm">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">SEO Meta Tags</h5>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label class="col-lg-3 col-from-label">Meta Title</label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" name="meta_title" value="{{ $product->meta_title }}"
                        placeholder="Meta Title">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-3 col-from-label">Mô tả</label>
                <div class="col-lg-8">
                    <textarea name="meta_description" rows="8"
                        class="form-control">{{ $product->meta_description }}</textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 col-form-label" for="signinSrEmail">Meta Images</label>
                <div class="col-md-8">
                    <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="true">
                        <div class="input-group-prepend">
                            <div class="input-group-text bg-soft-secondary font-weight-medium">Duyệt
                            </div>
                        </div>
                        <div class="form-control file-amount">Chọn file</div>
                        <input type="hidden" name="meta_img" value="{{ $product->meta_img }}" class="selected-files">
                    </div>
                    <div class="file-preview box sm">
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-3 col-form-label">Slug</label>
                <div class="col-lg-8">
                    <input type="text" placeholder="Slug" id="slug" name="slug"
                        value="{{ $product->slug }}" class="form-control">
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="col-lg-4">

     

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">Cảnh báo số lượng tồn kho thấp</h5>
            </div>
            <div class="card-body">
                <div class="form-group mb-3">
                    <label for="name">
                        Số lượng
                    </label>
                    <input type="number" name="low_stock_quantity" value="{{ $product->low_stock_quantity }}" min="0"
                        step="1" class="form-control">
                </div>
            </div>
        </div>

        <!-- <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">
                    Trạng thái hiển thị số lượng tồn kho
                </h5>
            </div>

            <div class="card-body">

                <div class="form-group row">
                    <label class="col-md-6 col-from-label">Hiển thị số lượng tồn kho</label>
                    <div class="col-md-6">
                        <label class="aiz-switch aiz-switch-success mb-0">
                            <input type="radio" name="stock_visibility_state" value="quantity"
                                @if($product->stock_visibility_state == 'quantity') checked @endif>
                            <span></span>
                        </label>
                    </div>
                </div>

                
            </div>
        </div> -->

        

        
    </div>
    
    </div>
    <div class="text-right mt-3 mb-4">
        <button type="submit" class="btn btn-primary">
            <i class="fa fa-save mr-1"></i> Lưu thay đổi
        </button>
    </div>
</form>

@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function (){
        show_hide_shipping_div();
    });

    

    

    AIZ.plugins.tagify();




</script>
@endsection