@extends('admin.layouts.app')
@section('content')

@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="aiz-titlebar mt-2 mb-4">
    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row" style="margin-bottom: 0.5rem;display: flex !important;align-items: center;">
            <div class="col-md-10">
                <h1 class="h3">Tạo sản phẩm</h1>
            </div>
            <div class="text-center col-md-2">
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary"><i style="margin-right:8px" class="fa fa-arrow-left"></i>Quay lại</a>
                {{-- <a href="{{ url()->previous() }}" ><i style="color:black;font-size: 1.73em;" class="las la-arrow-left"></i></a> --}}
            </div>
             
        </div>



        <form class="" action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="choice_form">
        <div class="row gutters-5">
            <div class="col-lg-8">
                @csrf
                <input type="hidden" name="added_by" value="admin">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">Thông tin sản phẩm</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">Tên sản phẩm <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="name"
                                    placeholder="Tên sản phẩm" onchange="update_sku()" required>
                            </div>
                        </div>
                        <div class="form-group row" id="category">
                            <label class="col-md-3 col-from-label">Danh mục</label>
                            <div class="col-md-8">
                                <select class="form-control aiz-selectpicker" name="category_id" id="category_id"data-live-search="true" required>
                                    <option value="" selected hidden>Chọn danh mục</option>
                                    @foreach ($category as $data_category)
                                        <option value="{{ $data_category->id }}">{{ $data_category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row" id="brand">
                            <label class="col-md-3 col-from-label">Thương hiệu</label>
                            <div class="col-md-8">
                                <select class="form-control aiz-selectpicker" name="brand_id" id="brand_id"
                                    data-live-search="true">
                                    <option value="" selected hidden>Chọn thương hiệu</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">Đơn vị <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="unit"
                                    placeholder="Đơn vị (ví dụ: sản phẩm, )" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">Dung tích <span class="text-danger">*</span></label>
                                
                            <div class="col-md-8">
                                <input type="number" class="form-control" name="weight"  value="" required
                                    placeholder="1ml">
                                    <small>(ví dụ: 100ml, 500ml, 1000ml)</small> 
                            </div>
                            
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">Số lượng tối thiểu <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="number" lang="en" class="form-control" name="min_qty" value="1"
                                    min="1" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">Tags</label>
                            <div class="col-md-8">
                                <input  type="text" class="form-control aiz-tag-input" name="tags[]"
                                    placeholder="Nhập tên thẻ & nhấn Enter" >
                                    <small class="text-muted">{{translate('This is used for search. Input those words by which cutomer can find this product.')}}</small>
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
                                for="signinSrEmail">Hình ảnh chi tiết sản phẩm (600x600)</label>
                            <div class="col-md-8">
                                <div class="input-group" data-toggle="aizuploader" data-type="image"
                                    data-multiple="true">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                            Duyệt</div>
                                    </div>
                                    <div class="form-control file-amount">Chọn file</div>
                                    <input type="hidden" name="photos" class="selected-files">
                                </div>
                                <div class="file-preview box sm">
                                </div>
                                <small class="text-muted">Các hình ảnh này sẽ hiển thị trong trang chi tiết sản phẩm. Sử dụng kích thước 600x600.</small>
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
                                    <input type="hidden" name="thumbnail_img" class="selected-files">
                                </div>
                                <div class="file-preview box sm">
                                </div>
                                <small class="text-muted">Các hình ảnh này sẽ hiển thị trong trang chủ. Sử dụng kích thước 300x300.</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">Biến thể sản phẩm</h5>
                        <div class="col-md-1">
                            <label class="aiz-switch aiz-switch-success mb-0">
                                <input value="1" type="checkbox" name="colors_active_show">
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="card-body" id="variation_show" hidden=true>
                        <div class="form-group row">
                            <div class="col-md-3">
                                <input type="text" class="form-control" value="Màu sắc" disabled>
                            </div>
                            <div class="col-md-8">
                                <select class="form-control aiz-selectpicker" data-live-search="true" name="colors[]"
                                    data-selected-text-format="count" id="colors" multiple disabled>
                                    
                                </select>
                            </div>
                            <div class="col-md-1">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input value="1" type="checkbox" name="colors_active">
                                    <span></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-3">
                                <input type="text" class="form-control" value="{{ translate('Attributes') }}"
                                    disabled>
                            </div>
                            <div class="col-md-8">
                                <select name="choice_attributes[]" id="choice_attributes"
                                    class="form-control aiz-selectpicker" data-live-search="true"
                                    data-selected-text-format="count" multiple
                                    data-placeholder="Chọn thuộc tính">
                                   
                                </select>
                            </div>
                        </div>
                        <div>
                            <p>Chọn các thuộc tính của sản phẩm và sau đó nhập giá trị cho mỗi thuộc tính
                            </p>
                            <br>
                        </div>

                        <div class="customer_choice_options" id="customer_choice_options">

                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">Giá sản phẩm + tồn kho</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">Giá đơn vị <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input type="number" lang="en" min="0" value="0" step="0.01"
                                    placeholder="Giá đơn vị" name="unit_price" class="unit_price form-control"
                                    required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 control-label"
                                for="start_date">Ngày hết hạn</label>
                            <div class="col-md-9">
                                <input type="datetime-local" class="form-control " name="expired_date"
                                    placeholder="Chọn ngày"  autocomplete="off" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">Giảm giá </label>
                            <div class="col-md-6">
                                <input type="number" lang="en" min="0" value="0" step="0.01"
                                    placeholder="Giảm giá" name="discount" class="form-control"
                                    required>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control aiz-selectpicker" name="discount_type">
                                    <option value="amount">Flat</option>
                                    <option value="percent">Percent</option>
                                </select>
                            </div>
                        </div>

                        <div id="show-hide-div">
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">Số lượng <span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <input type="number" lang="en" min="0" value="0" step="1"
                                        placeholder="Số lượng" name="current_stock"
                                        class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">
                                    Mã kho
                                </label>
                                <div class="col-md-6">
                                    <input type="text" placeholder="Mã kho" name="sku"
                                        class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">
                                Liên kết ngoài
                            </label>
                            <div class="col-md-9">
                                <input type="text" placeholder="Liên kết ngoài"
                                    name="external_link" class="form-control">
                                <small class="text-muted">Bỏ trống nếu bạn không sử dụng liên kết ngoài</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">
                                Văn bản nút liên kết ngoài
                            </label>
                            <div class="col-md-9">
                                <input type="text" placeholder="Văn bản nút liên kết ngoài"
                                    name="external_link_btn" class="form-control">
                                <small
                                    class="text-muted">Bỏ trống nếu bạn không sử dụng liên kết ngoài</small>
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
                            <label class="col-md-3 col-from-label">Mô tả</label>
                            <div class="col-md-8">
                                <textarea class="aiz-text-editor" name="description"></textarea>
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
                            <label class="col-md-3 col-form-label"
                                for="signinSrEmail">PDF Specification</label>
                            <div class="col-md-8">
                                <div class="input-group" data-toggle="aizuploader" data-type="document">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                            Duyệt</div>
                                    </div>
                                    <div class="form-control file-amount">Chọn file</div>
                                    <input type="hidden" name="pdf" class="selected-files">
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
                            <label class="col-md-3 col-from-label">Meta Title</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="meta_title"
                                    placeholder="Meta Title">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">Mô tả</label>
                            <div class="col-md-8">
                                <textarea name="meta_description" rows="8" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label"
                                for="signinSrEmail">Meta Image (600x600)</label>
                            <div class="col-md-8">
                                <div class="input-group" data-toggle="aizuploader" data-type="image">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                            Duyệt</div>
                                    </div>
                                    <div class="form-control file-amount">Chọn file</div>
                                    <input type="hidden" name="meta_img" class="selected-files">
                                </div>
                                <div class="file-preview box sm">
                                </div>
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
                            <input type="number" name="low_stock_quantity" value="1" min="0"
                                step="1" class="form-control">
                        </div>
                    </div>
                </div>


                <div class="card">
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
                                    <input type="radio" name="stock_visibility_state" value="quantity" checked>
                                    <span></span>
                                </label>
                            </div>
                        </div>

                        

                    </div>
                </div>

                

                

            </div>
            <div class="col-12">
                <div class="mar-all text-right mb-2">
                    <button type="submit" name="button" value="publish"
                        class="btn btn-primary">Tải lên sản phẩm</button>
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
<style>
    .error
    {
        color: red;
    }
</style>
@endsection

@section('script')
    <script type="text/javascript">
        $("[name=shipping_type]").on("change", function() {
            $(".product_wise_shipping_div").hide();
            $(".flat_rate_shipping_div").hide();
            if ($(this).val() == 'product_wise') {
                $(".product_wise_shipping_div").show();
            }
            if ($(this).val() == 'flat_rate') {
                $(".flat_rate_shipping_div").show();
            }

        });


        function isNumber(evt) {
            evt = (evt) ? evt : window.event;
            // var a = $('#phone-code').val();
            // var a_1 = $('#phone-code_1').val();
            // var a_2 = $('#phone-code_2').val();
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;  
	    }
        
       

        $('input[name="colors_active"]').on('change', function() {
            if (!$('input[name="colors_active"]').is(':checked')) {
                $('#colors').prop('disabled', true);
                $('#variation_show').attr('hidden', true);
                AIZ.plugins.bootstrapSelect('refresh');
            } else {
                $('#colors').prop('disabled', false);
                $('#variation_show').removeAttr('hidden');
                AIZ.plugins.bootstrapSelect('refresh');
            }
            update_sku();
        });

        $('input[name="colors_active_show"]').on('change', function() {
            if (!$('input[name="colors_active_show"]').is(':checked')) {
                $('#variation_show').attr('hidden', true);
            } else {
                $('#variation_show').removeAttr('hidden');
            }
        });

        $('#js-is-use-additional-cost').change(function() {
            let addionalCostStatus = $('#js-is-use-additional-cost').is(':checked');
            if (addionalCostStatus) {
                $('#js-additional-cost-body').removeAttr('hidden');
            } else {
                $('#js-additional-cost-body').attr('hidden', true);
            }
        });

        $('#js-is_use_order_sample').change(function() {
            let addionalCostStatus = $('#js-is_use_order_sample').is(':checked');
            if (addionalCostStatus) {
                $('#js-is_use_order_sample-body').removeAttr('hidden');
            } else {
                $('#js-is_use_order_sample-body').attr('hidden', true);
            }
        });

        $('#js-is_use_order_sample_price').change(function() {
            let addionalCostStatus = $('#js-is_use_order_sample_price').is(':checked');
            if (addionalCostStatus) {
                $('#js-is_use_order_sample_price-body').removeAttr('hidden');
            } else {
                $('#js-is_use_order_sample_price-body').attr('hidden', true);
            }
        });

        $('#short_shelf_life').change(function() {
            let short_shelf_life = $('#short_shelf_life').is(':checked');
            if (short_shelf_life) {
                $('#short_shelf_life').val(1);
            } else {
                $('#short_shelf_life').val(0);
            }
        });

        

        $(".btn-primary").on('click',function(){
            var image = $('input[name="photos"]').val();
            var color_data = $('#colors').val();
            var validator = $( "#choice_form" ).validate(
            {
                rules: 
                {
                    min_qty: 
                    {
                        required: true,
                        min:1
                    },
                    weight: 
                    {
                        required: true,
                        min:0
                    },
                    current_stock: 
                    {
                        required: true,
                        min:1
                    }
                },
                highlight: function(element) {
                    $(element).addClass('has-error');
                },
                unhighlight: function(element) {
                    $(element).removeClass('has-error');
                },    
                errorPlacement: function(error, element) {
                    // return false;
                    error.insertAfter(element);
                }
            });
            if ($('input[name="colors_active_show"]').is(':checked')){
                $('.color_check').each(function (item) {
                    $(this).rules("add", {
                        required: true,
                        min:1
                    });
                });
                $('.quantity_check').each(function (item) {
                    $(this).rules("add", {
                        required: true,
                        min:1
                    });
                });
                $('.unit_price').each(function (item) {
                    $(this).rules("add", {
                        required: true,
                        min:0
                    });
                });
                
            }
            else
            {
                $('.unit_price').each(function (item) {
                    $(this).rules("add", {
                        required: true,
                        min:1
                    });
                });
            }
            if($( "#choice_form" ).valid())
            {
                $('#choice_form').submit(function(e){ e.preventDefault(); });
                if(image.length>0)
                {
                    
                    document.getElementById("choice_form").submit(function(e){});     
                }
                else
                {
                    AIZ.plugins.notify('danger','Please Select Image');
                }
                // 
            }
           
        });

        $(document).on("change", ".attribute_choice", function() {
            update_sku();
        });

        $('#colors').on('change', function() {
            update_sku();
        });

        $('input[name="unit_price"]').on('keyup', function() {
            update_sku();
        });
        

        function delete_row(em) {
            $(em).closest('.form-group row').remove();
            update_sku();
        }

        function delete_variant(em) {
            $(em).closest('.variant').remove();
        }

       
        $('#choice_attributes').on('change', function() {
            $('#customer_choice_options').html(null);
            $.each($("#choice_attributes option:selected"), function() {
                add_more_customer_choice_option($(this).val(), $(this).text());
            });
            update_sku();
        });
    </script>
@endsection