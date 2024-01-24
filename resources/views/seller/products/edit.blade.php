@extends('seller.layouts.app')
@section('panel_content')

<div class="aiz-titlebar mt-2 mb-4">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">{{ translate('Update your product') }}</h1>
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

<form class="" action="{{route('seller.products.update', $product->id)}}" method="POST" enctype="multipart/form-data"
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
                        <label class="col-lg-3 col-from-label">{{translate('Product Name')}}</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control" name="name"
                                placeholder="{{translate('Product Name')}}" value="{{$product->name}}"
                                required>
                        </div>
                    </div>
                    <div class="form-group row" id="category">
                        <label class="col-lg-3 col-from-label">{{translate('Category')}}</label>
                        <div class="col-lg-8">
                            <select class="form-control aiz-selectpicker" name="category_id" id="category_id"
                                data-selected="{{ $product->category_id }}" data-live-search="true" required>
                                @foreach ($categories as $data_category)
                                    <option value="{{ $data_category->id }}" @if($product->category_id == $data_category->id) selected @endif>{{ $data_category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" id="brand">
                        <label class="col-lg-3 col-from-label">{{translate('Brand')}}</label>
                        <div class="col-lg-8">
                            <select class="form-control aiz-selectpicker" name="brand_id" id="brand_id">
                                <option value="">{{ translate('Select Brand') }}</option>
                                
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-from-label">{{translate('Unit')}}</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control" name="unit"
                                placeholder="{{ translate('Unit (e.g. KG, Pc etc)') }}"
                                value="{{$product->unit}}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">{{translate('Weight')}} <small>({{ translate('In Kg') }})</small></label>
                        <div class="col-md-8">
                            <input type="number" class="form-control" name="weight" value="{{ $product->weight }}" step="0.01" placeholder="0.00">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-from-label">{{translate('Minimum Purchase Qty')}}</label>
                        <div class="col-lg-8">
                            <input type="number" lang="en" class="form-control" name="min_qty"
                                value="@if($product->min_qty <= 1){{1}}@else{{$product->min_qty}}@endif" min="1"
                                required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-from-label">{{translate('Tags')}}</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control aiz-tag-input" name="tags[]" id="tags"
                                value="{{ $product->tags }}" placeholder="{{ translate('Type to add a tag') }}"
                                data-role="tagsinput">
                        </div>
                    </div>
                    
                    
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{translate('Product Images')}}</h5>
                </div>
                <div class="card-body">

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label"
                            for="signinSrEmail">{{translate('Gallery Images')}}</label>
                        <div class="col-md-8">
                            <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="true">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                                        {{ translate('Browse')}}</div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                <input type="hidden" name="photos" value="{{ $product->photos }}"
                                    class="selected-files">
                            </div>
                            <div class="file-preview box sm">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="signinSrEmail">{{translate('Thumbnail Image')}}
                            <small>(290x300)</small></label>
                        <div class="col-md-8">
                            <div class="input-group" data-toggle="aizuploader" data-type="image">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                                        {{ translate('Browse')}}</div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
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
            <h5 class="mb-0 h6">{{translate('Product Videos')}}</h5>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label class="col-lg-3 col-from-label">{{translate('Video Provider')}}</label>
                <div class="col-lg-8">
                    <select class="form-control aiz-selectpicker" name="video_provider" id="video_provider">
                        <option value="youtube" <?php if($product->video_provider == 'youtube') echo "selected";?>>
                            {{translate('Youtube')}}</option>
                        <option value="dailymotion"
                            <?php if($product->video_provider == 'dailymotion') echo "selected";?>>
                            {{translate('Dailymotion')}}</option>
                        <option value="vimeo" <?php if($product->video_provider == 'vimeo') echo "selected";?>>
                            {{translate('Vimeo')}}</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-3 col-from-label">{{translate('Video Link')}}</label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" name="video_link" value="{{ $product->video_link }}"
                        placeholder="{{ translate('Video Link') }}">
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{translate('Product Variation')}}</h5>
        </div>
        
    </div>
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{translate('Product price + stock')}}</h5>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label class="col-lg-3 col-from-label">{{translate('Unit price')}}</label>
                <div class="col-lg-6">
                    <input type="text" placeholder="{{translate('Unit price')}}" name="unit_price" class="form-control"
                        value="{{$product->unit_price}}" required>
                </div>
            </div>

            @php
                $date_range = '';
                if($product->discount_start_date){
                    $start_date = date('d-m-Y H:i:s', $product->discount_start_date);
                    $end_date = date('d-m-Y H:i:s', $product->discount_end_date);
                    $date_range = $start_date.' to '.$end_date;
                }
            @endphp

            <div class="form-group row">
                <label class="col-lg-3 col-from-label" for="start_date">{{translate('Discount Date Range')}}</label>
                <div class="col-lg-9">
                    <input  type="datetime-local" class="form-control " value="{{ $product->expired_date }}" name="expired_date" autocomplete="off">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-lg-3 col-from-label">{{translate('Discount')}}</label>
                <div class="col-lg-6">
                    <input type="number" lang="en" min="0" step="0.01" placeholder="{{translate('Discount')}}"
                        name="discount" class="form-control" value="{{ $product->discount }}" required>
                </div>
                <div class="col-lg-3">
                    <select class="form-control aiz-selectpicker" name="discount_type" required>
                        <option value="amount" <?php if($product->discount_type == 'amount') echo "selected";?>>
                            {{translate('Flat')}}</option>
                        <option value="percent" <?php if($product->discount_type == 'percent') echo "selected";?>>
                            {{translate('Percent')}}</option>
                    </select>
                </div>
            </div>

            <div id="show-hide-div">
                <div class="form-group row">
                    <label class="col-lg-3 col-from-label">{{translate('Quantity')}}</label>
                    <div class="col-lg-6">
                        <input type="number" lang="en" value="{{ $product->product_stock?->qty }}" step="1"
                            placeholder="{{translate('Quantity')}}" name="current_stock" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-from-label">
                        {{translate('SKU')}}
                    </label>
                    <div class="col-md-6">
                        <input type="text" placeholder="{{ translate('SKU') }}" value="{{ $product->product_stock?->sku }}" name="sku" class="form-control">
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 col-from-label">
                    {{translate('External link')}}
                </label>
                <div class="col-md-9">
                    <input type="text" placeholder="{{ translate('External link') }}" name="external_link" value="{{ $product->external_link }}" class="form-control">
                    <small class="text-muted">{{translate('Leave it blank if you do not use external site link')}}</small>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 col-from-label">
                    {{translate('External link button text')}}
                </label>
                <div class="col-md-9">
                    <input type="text" placeholder="{{ translate('External link button text') }}" name="external_link_btn" value="{{ $product->external_link_btn }}" class="form-control">
                    <small class="text-muted">{{translate('Leave it blank if you do not use external site link')}}</small>
                </div>
            </div>
            <br>
            <div class="sku_combination" id="sku_combination">

            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{translate('Product Description')}}</h5>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label class="col-lg-3 col-from-label">{{translate('Description')}}</label>
                <div class="col-lg-9">
                    <textarea class="aiz-text-editor"
                        name="description">{{$product->description}}</textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{translate('PDF Specification')}}</h5>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label class="col-md-3 col-form-label" for="signinSrEmail">{{translate('PDF Specification')}}</label>
                <div class="col-md-8">
                    <div class="input-group" data-toggle="aizuploader">
                        <div class="input-group-prepend">
                            <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}
                            </div>
                        </div>
                        <div class="form-control file-amount">{{ translate('Choose File') }}</div>
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
            <h5 class="mb-0 h6">{{translate('SEO Meta Tags')}}</h5>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label class="col-lg-3 col-from-label">{{translate('Meta Title')}}</label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" name="meta_title" value="{{ $product->meta_title }}"
                        placeholder="{{translate('Meta Title')}}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-3 col-from-label">{{translate('Description')}}</label>
                <div class="col-lg-8">
                    <textarea name="meta_description" rows="8"
                        class="form-control">{{ $product->meta_description }}</textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 col-form-label" for="signinSrEmail">{{translate('Meta Images')}}</label>
                <div class="col-md-8">
                    <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="true">
                        <div class="input-group-prepend">
                            <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}
                            </div>
                        </div>
                        <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                        <input type="hidden" name="meta_img" value="{{ $product->meta_img }}" class="selected-files">
                    </div>
                    <div class="file-preview box sm">
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-3 col-form-label">{{translate('Slug')}}</label>
                <div class="col-lg-8">
                    <input type="text" placeholder="{{translate('Slug')}}" id="slug" name="slug"
                        value="{{ $product->slug }}" class="form-control">
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
                            <input value="{{$product->short_shelf_life}}" type="checkbox" name="short_shelf_life" id="short_shelf_life" @if($product->short_shelf_life == 1) checked @endif >
                            <span></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6" class="dropdown-toggle" data-toggle="collapse" data-target="#collapse_2">
                    {{translate('Shipping Configuration')}}
                </h5>
            </div>
            <div class="card-body collapse show" id="collapse_2">
                

                <p>
                    {{ translate('Shipping configuration is maintained by Admin.') }}
                </p>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{translate('Low Stock Quantity Warning')}}</h5>
            </div>
            <div class="card-body">
                <div class="form-group mb-3">
                    <label for="name">
                        {{translate('Quantity')}}
                    </label>
                    <input type="number" name="low_stock_quantity" value="{{ $product->low_stock_quantity }}" min="0"
                        step="1" class="form-control">
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">
                    {{translate('Stock Visibility State')}}
                </h5>
            </div>

            <div class="card-body">

                <div class="form-group row">
                    <label class="col-md-6 col-from-label">{{translate('Show Stock Quantity')}}</label>
                    <div class="col-md-6">
                        <label class="aiz-switch aiz-switch-success mb-0">
                            <input type="radio" name="stock_visibility_state" value="quantity"
                                @if($product->stock_visibility_state == 'quantity') checked @endif>
                            <span></span>
                        </label>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-6 col-from-label">{{translate('Show Stock With Text Only')}}</label>
                    <div class="col-md-6">
                        <label class="aiz-switch aiz-switch-success mb-0">
                            <input type="radio" name="stock_visibility_state" value="text"
                                @if($product->stock_visibility_state == 'text') checked @endif>
                            <span></span>
                        </label>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-6 col-from-label">{{translate('Hide Stock')}}</label>
                    <div class="col-md-6">
                        <label class="aiz-switch aiz-switch-success mb-0">
                            <input type="radio" name="stock_visibility_state" value="hide"
                                @if($product->stock_visibility_state == 'hide') checked @endif>
                            <span></span>
                        </label>
                    </div>
                </div>

            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{translate('Cash On Delivery')}}</h5>
            </div>
            <div class="card-body">
               
                <p>
                    {{ translate('Cash On Delivery activation is maintained by Admin.') }}
                </p>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{translate('Estimate Shipping Time')}}</h5>
            </div>
            <div class="card-body">
                <div class="form-group mb-3">
                    <label for="name">
                        {{translate('Shipping Days')}}
                    </label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="est_shipping_days"
                            value="{{ $product->est_shipping_days }}" min="1" step="1" placeholder="{{translate('Shipping Days')}}">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroupPrepend">{{translate('Days')}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{translate('VAT & Tax')}}</h5>
            </div>
            <div class="card-body">
                
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="mar-all text-right mb-2">
            <button type="submit" name="button" value="publish"
                class="btn btn-primary">{{ translate('Update Product') }}</button>
        </div>
    </div>
    </div>
</form>

@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function (){
        show_hide_shipping_div();
    });

    $("[name=shipping_type]").on("change", function (){
        show_hide_shipping_div();
    });

    function show_hide_shipping_div() {
        var shipping_val = $("[name=shipping_type]:checked").val();

        $(".flat_rate_shipping_div").hide();

        if(shipping_val == 'flat_rate'){
            $(".flat_rate_shipping_div").show();
        }
    }


    

    $('input[name="colors_active"]').on('change', function() {
        if(!$('input[name="colors_active"]').is(':checked')){
            $('#colors').prop('disabled', true);
            AIZ.plugins.bootstrapSelect('refresh');
        }
        else{
            $('#colors').prop('disabled', false);
            AIZ.plugins.bootstrapSelect('refresh');
        }
        update_sku();
    });

    $(document).on("change", ".attribute_choice",function() {
        update_sku();
    });

    $('#colors').on('change', function() {
        update_sku();
    });

    function delete_row(em){
        $(em).closest('.form-group').remove();
        update_sku();
    }

    function delete_variant(em){
        $(em).closest('.variant').remove();
    }

    

    AIZ.plugins.tagify();


    $(document).ready(function(){
        update_sku();

        $('.remove-files').on('click', function(){
            $(this).parents(".col-md-4").remove();
        });
    });

    $('#choice_attributes').on('change', function() {
        $.each($("#choice_attributes option:selected"), function(j, attribute){
            flag = false;
            $('input[name="choice_no[]"]').each(function(i, choice_no) {
                if($(attribute).val() == $(choice_no).val()){
                    flag = true;
                }
            });
            if(!flag){
                add_more_customer_choice_option($(attribute).val(), $(attribute).text());
            }
        });

        var str = @php echo $product->attributes @endphp;

        $.each(str, function(index, value){
            flag = false;
            $.each($("#choice_attributes option:selected"), function(j, attribute){
                if(value == $(attribute).val()){
                    flag = true;
                }
            });
            if(!flag){
                $('input[name="choice_no[]"][value="'+value+'"]').parent().parent().remove();
            }
        });

        update_sku();
    });


</script>
@endsection