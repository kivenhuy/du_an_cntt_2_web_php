@extends('user_layout.layouts.user_panel')

@section('panel_content')

    <div class="card">
        <form class="form-default" role="form" action="{{route('request_for_product.store')}}" method="POST">
            @csrf
            <div class="card-header row gutters-5">
                <div class="col text-center text-md-left">
                    <h5 class="mb-md-0 h6">{{ translate('Create Request For Products')}} </h5>
                </div>

            </div>
        

        <div class="card-body">
            <div class="form-group row">
                <input type="hidden" name="product_id" value="{{$product->id}}">
                <input type="hidden" name="shop_id" value="{{$product->user->shop->id}}">
                <input type="hidden" name="recommend" value="1">
                <label class="col-md-3 col-from-label">{{ translate('Product Name') }} <span class="text-danger">*</span></label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="product_name"
                        placeholder="{{ translate('Product Name') }}" value="{{$product->name}}" readonly>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-3 col-from-label">{{ translate('Order Quantity') }} <span class="text-danger">*</span></label>
                <div class="col-md-3">
                    <div class="row no-gutters align-items-center aiz-plus-minus mr-3" >
                        <button class="btn col-auto btn-icon btn-sm btn-light rounded-0" type="button" data-type="minus" data-field="quantity" disabled="disabled">
                            <i class="fa fa-minus"></i>
                        </button>
                        <input type="number" name="quantity" class="col border-0 text-center flex-grow-1 fs-16 input-number" placeholder="1" value="{{ $quantity }}" min="{{ $product->min_qty }}" is_request="0" max="{{$product->product_stock->qty}}">
                        <button class="btn col-auto btn-icon btn-sm btn-light rounded-0" type="button" data-type="plus" data-field="quantity">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
                
                <div class="col-md-5">
                    <input type="text" class="form-control" name="unit"
                        value="KG" readonly>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-3 col-from-label">{{ translate('Order Date') }} <span class="text-danger">*</span></label>
                <div class="col-md-8">
                    <select class="form-control aiz-selectpicker" name="order_date" id="order_date" >
                        <option value="1" >Every Day</option>
                        <option value="7" >Each 7 Days</option>
                        <option value="14" >Each 14 Days</option>
                        <option value="30" >Each 30 Days</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-3 col-from-label">{{ translate('Form Date') }} <span class="text-danger">*</span></label>
                <div class="col-md-8">
                    <input required="" type="datetime-local" class="form-control" name="from_date" id="from_date">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-3 col-from-label">{{ translate('To Date') }} <span class="text-danger">*</span></label>
                <div class="col-md-8">
                    <input required="" type="datetime-local" class="form-control" name="to_date" id="to_date">
                </div>
            </div>
        </div>

        <div class="card-footer" style="justify-content: flex-end !important">
            <button type="submit" class="btn btn-primary text-right">{{translate('Send Request')}}</button>
        </div>
        </form>
    </div>

@endsection

@section('script')
@endsection