@extends('seller.layouts.app')
@section('panel_content')
<div class="aiz-titlebar mt-2 mb-4">
    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row" style="margin-bottom: 0.5rem;display: flex !important;align-items: center;">
            <div class="col-md-10">
                <h1 class="h3">Add Your Product</h1>
            </div>
            <div class="text-center col-md-2">
                <a href="{{route('seller.products')}}" class="btn btn-secondary"><i style="margin-right:8px" class="fa fa-arrow-left"></i>Back</a>
                {{-- <a href="{{ url()->previous() }}" ><i style="color:black;font-size: 1.73em;" class="las la-arrow-left"></i></a> --}}
            </div>
             
        </div>



        <form class="" action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data" id="choice_form">
        <div class="row gutters-5">
            <div class="col-lg-8">
                @csrf
                <input type="hidden" name="added_by" value="seller">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('Product Information') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Product Name') }} <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="name"
                                    placeholder="{{ translate('Product Name') }}" onchange="update_sku()" required>
                            </div>
                        </div>
                        <div class="form-group row" id="category">
                            <label class="col-md-3 col-from-label">{{ translate('Category') }}</label>
                            <div class="col-md-8">
                                <select class="form-control aiz-selectpicker" name="category_id" id="category_id"data-live-search="true" required>
                                    <option value="" selected hidden>Select Category</option>
                                    @foreach ($category as $data_category)
                                        <option value="{{ $data_category->id }}">{{ $data_category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row" id="brand">
                            <label class="col-md-3 col-from-label">{{ translate('Brand') }}</label>
                            <div class="col-md-8">
                                <select class="form-control aiz-selectpicker" name="brand_id" id="brand_id"
                                    data-live-search="true">
                                    <option value="" selected hidden>{{ translate('Select Brand') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Unit') }} <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="unit"
                                    placeholder="{{ translate('Unit (e.g. KG, Pc etc)') }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Weight') }}
                                <small>({{ translate('In Kg') }})</small> <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="number" class="form-control" name="weight" step="0.01" value="" required
                                    placeholder="0.00">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Minimum Purchase Qty') }} <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="number" lang="en" class="form-control" name="min_qty" value="1"
                                    min="1" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Tags') }}</label>
                            <div class="col-md-8">
                                <input  type="text" class="form-control aiz-tag-input" name="tags[]"
                                    placeholder="{{ translate('Type and hit enter to add a tag') }}" >
                                    <small class="text-muted">{{translate('This is used for search. Input those words by which cutomer can find this product.')}}</small>
                            </div>
                        </div>
                       
                       
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('Product Images') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label"
                                for="signinSrEmail">{{ translate('Gallery Images') }} (600x600)</label>
                            <div class="col-md-8">
                                <div class="input-group" data-toggle="aizuploader" data-type="image"
                                    data-multiple="true">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                            {{ translate('Browse') }}</div>
                                    </div>
                                    <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                    <input type="hidden" name="photos" class="selected-files">
                                </div>
                                <div class="file-preview box sm">
                                </div>
                                <small class="text-muted">{{translate('These images are visible in product details page gallery. Use 600x600 sizes images.')}}</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="signinSrEmail">{{ translate('Thumbnail Image') }}
                                <small>(290x300)</small></label>
                            <div class="col-md-8">
                                <div class="input-group" data-toggle="aizuploader" data-type="image">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                            {{ translate('Browse') }}</div>
                                    </div>
                                    <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                    <input type="hidden" name="thumbnail_img" class="selected-files">
                                </div>
                                <div class="file-preview box sm">
                                </div>
                                <small class="text-muted">{{translate('This image is visible in all product box. Use 300x300 sizes image. Keep some blank space around main object of your image as we had to crop some edge in different devices to make it responsive.')}}</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('Product Variation') }}</h5>
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
                                <input type="text" class="form-control" value="{{ translate('Colors') }}" disabled>
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
                                    data-placeholder="{{ translate('Choose Attributes') }}">
                                   
                                </select>
                            </div>
                        </div>
                        <div>
                            <p>{{ translate('Choose the attributes of this product and then input values of each attribute') }}
                            </p>
                            <br>
                        </div>

                        <div class="customer_choice_options" id="customer_choice_options">

                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('Product price + stock') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Unit price') }} <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input type="number" lang="en" min="0" value="0" step="0.01"
                                    placeholder="{{ translate('Unit price') }}" name="unit_price" class="unit_price form-control"
                                    required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 control-label"
                                for="start_date">{{ translate('Discount Date Range') }}</label>
                            <div class="col-md-9">
                                <input type="datetime-local" class="form-control " name="expired_date"
                                    placeholder="{{ translate('Select Date') }}"  autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Discount') }} </label>
                            <div class="col-md-6">
                                <input type="number" lang="en" min="0" value="0" step="0.01"
                                    placeholder="{{ translate('Discount') }}" name="discount" class="form-control"
                                    required>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control aiz-selectpicker" name="discount_type">
                                    <option value="amount">{{ translate('Flat') }}</option>
                                    <option value="percent">{{ translate('Percent') }}</option>
                                </select>
                            </div>
                        </div>

                        <div id="show-hide-div">
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">{{ translate('Quantity') }} <span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <input type="number" lang="en" min="0" value="0" step="1"
                                        placeholder="{{ translate('Quantity') }}" name="current_stock"
                                        class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">
                                    {{ translate('SKU') }}
                                </label>
                                <div class="col-md-6">
                                    <input type="text" placeholder="{{ translate('SKU') }}" name="sku"
                                        class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">
                                {{ translate('External link') }}
                            </label>
                            <div class="col-md-9">
                                <input type="text" placeholder="{{ translate('External link') }}"
                                    name="external_link" class="form-control">
                                <small class="text-muted">{{ translate('Leave it blank if you do not use external site link') }}</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">
                                {{ translate('External link button text') }}
                            </label>
                            <div class="col-md-9">
                                <input type="text" placeholder="{{ translate('External link button text') }}"
                                    name="external_link_btn" class="form-control">
                                <small
                                    class="text-muted">{{ translate('Leave it blank if you do not use external site link') }}</small>
                            </div>
                        </div>
                        <br>
                        <div class="sku_combination" id="sku_combination">

                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('Product Description') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Description') }}</label>
                            <div class="col-md-8">
                                <textarea class="aiz-text-editor" name="description"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('PDF Specification') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label"
                                for="signinSrEmail">{{ translate('PDF Specification') }}</label>
                            <div class="col-md-8">
                                <div class="input-group" data-toggle="aizuploader" data-type="document">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                            {{ translate('Browse') }}</div>
                                    </div>
                                    <div class="form-control file-amount">{{ translate('Choose File') }}</div>
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
                        <h5 class="mb-0 h6">{{ translate('SEO Meta Tags') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Meta Title') }}</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="meta_title"
                                    placeholder="{{ translate('Meta Title') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Description') }}</label>
                            <div class="col-md-8">
                                <textarea name="meta_description" rows="8" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label"
                                for="signinSrEmail">{{ translate('Meta Image') }} (600x600)</label>
                            <div class="col-md-8">
                                <div class="input-group" data-toggle="aizuploader" data-type="image">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                            {{ translate('Browse') }}</div>
                                    </div>
                                    <div class="form-control file-amount">{{ translate('Choose File') }}</div>
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
                        <h5 class="mb-0 h6">
                            {{ translate('Food with short shelf life') }}
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-6 col-from-label">{{ translate('Short Shelf Life') }}</label>
                            <div class="col-md-6">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input value="null" type="checkbox" name="short_shelf_life" id="short_shelf_life">
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">
                            {{ translate('Shipping Configuration') }}
                        </h5>
                    </div>

                    <div class="card-body">
                       
                            <p>
                                {{ translate('Shipping configuration is maintained by Admin.') }}
                            </p>
                    </div>
                </div>


                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('Low Stock Quantity Warning') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="name">
                                {{ translate('Quantity') }}
                            </label>
                            <input type="number" name="low_stock_quantity" value="1" min="0"
                                step="1" class="form-control">
                        </div>
                    </div>
                </div>


                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">
                            {{ translate('Stock Visibility State') }}
                        </h5>
                    </div>

                    <div class="card-body">

                        <div class="form-group row">
                            <label class="col-md-6 col-from-label">{{ translate('Show Stock Quantity') }}</label>
                            <div class="col-md-6">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="radio" name="stock_visibility_state" value="quantity" checked>
                                    <span></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-6 col-from-label">{{ translate('Show Stock With Text Only') }}</label>
                            <div class="col-md-6">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="radio" name="stock_visibility_state" value="text">
                                    <span></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-6 col-from-label">{{ translate('Hide Stock') }}</label>
                            <div class="col-md-6">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="radio" name="stock_visibility_state" value="hide">
                                    <span></span>
                                </label>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('Cash On Delivery') }}</h5>
                    </div>
                    <div class="card-body">
                            <p>
                                {{ translate('Cash On Delivery activation is maintained by Admin.') }}
                            </p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('Estimate Shipping Time') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="name">
                                {{ translate('Shipping Days') }}
                            </label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="est_shipping_days" min="1"
                                    step="1" placeholder="{{ translate('Shipping Days') }}">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupPrepend">{{ translate('Days') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                

            </div>
            <div class="col-12">
                <div class="mar-all text-right mb-2">
                    <button type="submit" name="button" value="publish"
                        class="btn btn-primary">{{ translate('Upload Product') }}</button>
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

@section('script')
    <script src="../../public/plugins/jquery-validation/jquery.validate.min.js"></script>
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