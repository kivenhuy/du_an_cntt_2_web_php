@extends('seller.layouts.app')
@section('panel_content')

<div class="card">
    <div class="card-body">
        <div class="form-group row">
            <div class="col-12 data_user">
                <div class="row" style="margin-bottom:1rem">
                    @if($data_request->is_supermarket_request === 0)
                        <a style="display: flex;align-items: center;margin-right: 10px" href="{{route('request_for_product.seller_index')}}" ><i style="color:black;font-size: 1.73em;" class="fa fa-long-arrow-alt-left"></i></a>
                    @else
                    <a style="display: flex;align-items: center;margin-right: 10px" href="{{route('request_for_product.seller_supermarket_index')}}" ><i style="color:black;font-size: 1.73em;" class="fa fa-long-arrow-alt-left"></i></a>
                    @endif
                        <span class="rfp_code">
                        {{translate('RFQ Code')}}: {{$data_request->code}}
                    </span>
                </div>

                {{-- RFQ Details --}}
                <div>
                    <table class="padding text-left small border-bottom" style="width: 100%">
                        <thead>
                            <tr class="gry-color" style="background: #F5F5F5;">
                                <th width="40%" style="color:#000000; font-family:'Quicksand',sans-serif; font-size:16px; line-height:16px;">{{ translate('Product') }} <br> <span style="font-family: 'Quicksand',sans-serif !important;font-size: 12px !important;
                                    font-weight: 500;
                                    line-height: 16px;
                                    letter-spacing: -0.0004em;
                                    text-align: left;
                                    ">{{translate('Product Raised Date')}}:{{$data_request->created_at->format('d-m-Y')}} </span></th>
                                <th width="15%" style="color:#000000; font-family:'Quicksand', sans-serif; font-size:16px; line-height:16px;">{{ translate('Quantity') }}</th>
                                <th width="30%" style="color:#000000; font-family:'Quicksand', sans-serif; font-size:16px; line-height:16px;">{{ translate('Quote Price') }}</th>
                                <th width="15%" style="color:#000000; font-family:'Quicksand', sans-serif; font-size:16px; line-height:16px;" >{{ translate('Status') }}</th>
                            </tr>
                        </thead>
                        <tbody class="strong">
                            {{-- @foreach ($order->orderDetails as $key => $orderDetail) --}}
                                @if (isset($data_request))
                                    <tr class="" style="height: auto">
                                        @if(!empty($product))
                                            <td style="padding-top:24px">
                                                <div style="display: flex;align-items: center">
                                                    <img src="{{ uploaded_asset($product->thumbnail_img) }}" width="115px" height="115px" alt="">
                                                    <div style="display: flex;flex-direction: column;padding-left: 16px;">
                                                        <span class="rfp_product_name" style="margin-bottom:6px;" >{{ $product->name }}</span>
                                                    </div>

                                                </div>  
                                            </td>
                                        @else
                                            <td style="padding-top:24px">
                                                <div style="display: flex;align-items: center">
                                                    <img src="" width="115px" height="115px" alt="">
                                                    <div style="display: flex;flex-direction: column;padding-left: 16px;">
                                                        <span class="rfp_product_name" style="margin-bottom:6px;" >{{ $data_request->product_name }}</span>
                                                    </div>

                                                </div>  
                                            </td>
                                        @endif
                                        <td>
                                            
                                                <span class="rfp_product_name">{{$data_request->quantity}} x {{$data_request->unit}}</span>
                                            
                                            
                                        </td>
                                        <td>
                                            <div id="rfp_price">
                                                <div style="">
                                                    <span class="rfp_product_name">{{ single_price($data_request->price) }}</span>
                                                </div>
                                                @if(($data_request->status == 2 || $data_request->status == 3 ) && (Auth::user()->shop->id  === $data_request->shop_id))
                                                <div>
                                                    <span style="font-family: 'Roboto',sans-serif !important;
                                                    font-size: 12px;
                                                    font-weight: 400;
                                                    line-height: 18px;
                                                    letter-spacing: 0em;
                                                    text-align: left;
                                                    color:#589951
                                                    " onclick="open_update_price(this);">{{translate('Change Price')}}</span>
                                                </div>
                                                @endif
                                            </div>
                                            <div style="display: flex" id="rfp_price_update" hidden>
                                                <input id="unit_price"  @if(!empty($data_request->price)) value="{{$data_request->price}}" @endif   class="rfp_price_update" type="number" placeholder="Your price" />
                                                <button id={{$data_request->id}} class="EdSubmitFinal">{{translate('Update Price')}}</button>
                                            </div>
                                        </td>
                                        <td>
                                            @if($data_request->status == 0)
                                            
                                            <span class='badge badge-inline badge-secondary'>{{translate('Pending Admin Approval')}}</span>
                                            
                                            @elseif($data_request->status == 1)
                                            
                                                <span class='badge badge-inline badge-secondary'>{{translate('Pending Seller Accept')}}</span>
                                            
                                            @elseif($data_request->status == 2)
                                            
                                                <span class='badge badge-inline badge-warning'>{{translate('Pending Price Update')}}</span>
                                            
                                            @elseif($data_request->status == 3)
                                                <span class='badge badge-inline badge-info' >{{translate('Waiting For Customer')}}</span>
                                            @elseif($data_request->status == 4)
                                            
                                                <span class='badge badge-inline badge-success' style='background-color:#28a745 !important'>{{translate('Added To Cart')}}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            {{-- @endforeach --}}
                        </tbody>
                    </table>
                   
                </div>

                <div class="row">
                    <div class="addtional_info_buyer col-8">
                        <div class="head_addtional_info_buyer">
                            <span>{{translate('Additional Detail Buyer')}}</span>
                        </div>
                        <div class="body_addtional_info_buyer col-12">
                            <div class="col-6">
                                <div class="sub_data_addition_info">
                                    <span class="title_addtional_info">{{translate('Buyer Name')}}</span>
                                    <div class="data_addtional_info">
                                        {{$buyer->name}}
                                    </div>
                                </div>
                                <div>
                                    <span class="title_addtional_info">{{translate('Mobile')}}</span>
                                    <div class="data_addtional_info"> 
                                        {{$buyer->phone}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="sub_data_addition_info">
                                    <span class="title_addtional_info">{{translate('Email')}}</span>
                                    <div class="data_addtional_info">
                                        {{$buyer->email}}
                                    </div>
                                </div>
                                <div>
                                    <span class="title_addtional_info">{{translate('Address')}}</span>
                                    <div class="data_addtional_info">
                                        {{$buyer->address}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="addtional_info_shipping_schdule col-4">
                        <div class="head_addtional_info_buyer">
                            <span>{{translate('Schedule For Shipping')}}</span>
                        </div>
                        <div class="body_addtional_info_buyer col-12">
                            <div class="col-6">
                                <div class="sub_data_addition_info">
                                    <span class="title_addtional_info">{{translate('Shipping Date')}}</span>
                                    @foreach (json_decode($data_request->shipping_date) as $each_day)
                                        <div class="data_addtional_info">
                                            {{date('d-m-Y', strtotime($each_day))}}
                                        </div>
                                    @endforeach
                                </div>
                                
                            </div>
                            
                        </div>
                    </div>
                </div>
                

            </div>
        </div>
    </div>

    <div class="card-footer">
        @if($data_request->shop_id == 0)
            @if($is_accept != 0)
                <input type="hidden" id="product_id" value="{{$product_id}}">
                <div class="col-3">
                    <button id={{$data_request->id}} type="button" class="btn btn-primary btn-block fw-700 fs-14 rounded-4 EdApprove">Accept Request</button>
                </div>
            @endif
        @else
            @if($data_request->status == 1)
                <input type="hidden" id="product_id" value="{{$data_request->product_id}}">
                <div class="col-3">
                    <button id={{$data_request->id}} type="button" class="btn btn-primary btn-block fw-700 fs-14 rounded-4 EdApprove">Accept Request</button>
                </div>
            @endif
        @endif
        
        
    </div>
</div>

<style>
    .rfp_price_update {
        background: white;
        border:1px solid #D1D1D1;
        border-radius: 10px;
        color: black;
        padding: 20px;
        width: 70%;
        font-family: 'Roboto',sans-serif !important;
        font-size: 14px !important;
        font-weight: 700 !important;
        line-height: 28px;
        letter-spacing: 0.25px;
    }

    .rfp_price_update:focus {
    outline: none;
    }

    .rfp_price_update::placeholder {
    color: black;
    }

    .EdSubmitFinal {
        background: #16bdae;
        border: 0;
        border-radius: 7px;
        color: white;
        padding: 8px;
        position: relative;
        right: 17%;
        top: 0px;
        font-family: 'Roboto',sans-serif !important;
        font-size: 14px !important;
        font-weight: 700 !important;
        line-height: 28px;
        letter-spacing: 0.25px;
        text-align: center;
    }

    .pt-site-footer__submit {
    position: relative;
    display: inline-block;
    width: 50%;
    }


    .sub_data_addition_info
    {
        margin-bottom: 24px;
    }
    .title_addtional_info
    {
        font-family: 'Roboto',sans-serif !important;
        font-size: 16px;
        font-weight: 700;
        line-height: 20px;
        letter-spacing: -0.0004em;
        text-align: left;
        color: #333333;
    }
    .data_addtional_info
    {
        font-family: 'Roboto',sans-serif !important;
        font-size: 16px;
        font-weight: 400;
        line-height: 32px;
        letter-spacing: -0.0004em;
        text-align: left;
        color: #797979;
    }
    .addtional_info_buyer
    {
        margin-top: 2rem;
        height: auto;
        max-width: 871px;
        border: 1px solid #D1D1D1;
        border-radius: 10px;
        padding: 0px 0px 0px 24px;
    }
    .addtional_info_shipping_schdule
    {
        margin-top: 2rem;
        margin-left: 1rem;
        height: auto;
        max-width: 871px;
        border: 1px solid #D1D1D1;
        border-radius: 10px;
        padding: 0px 0px 0px 24px;
    }
    .head_addtional_info_buyer
    {
        height: auto;
        border-bottom: 1px solid #D1D1D1;
        font-family: 'Quicksand',sans-serif !important;
        font-size: 24px !important; 
        font-weight: 700 !important; 
        line-height: 32px;
        letter-spacing: -0.0004em;
        text-align: left;
        color: #253D4E;
        padding: 24px 0px 24px 0px;
    }
    .body_addtional_info_buyer
    {
        display: flex;
        padding: 24px 0px 32px 0px;
    }
    .EdReject
    {
        font-family: 'Roboto',sans-serif !important;
        font-size: 14px !important;
        font-weight: 700 !important;
        line-height: 28px;
        letter-spacing: 0.25px;
        text-align: center;
        color: #FFFFFF;
    }
    .EdSubmit
    {
        font-family: 'Roboto',sans-serif !important;
        font-size: 14px !important;
        font-weight: 700 !important;
        line-height: 28px;
        letter-spacing: 0.25px;
        text-align: center;

    }
    .text_approval
    {
        font-family: 'Roboto',sans-serif !important;
        font-size: 14px;
        font-weight: 400;
        line-height: 28px;
        letter-spacing: 0.25px;
        text-align: left;
        color: #797979;
        margin-right: 1rem;
    }
    .parent_appprove_rfp
    {
        margin-top: 1rem;
        display: flex;
        align-items:center;
        height: auto;
    }
    .rfp_code
    {
        font-family: 'Quicksand',sans-serif !important;
        font-size: 24px;
        font-weight: 700;
        line-height: 32px;
        letter-spacing: -0.0004em;
        text-align: left;
        color: #333333;
    }
    .rfp_product_name
    {
        font-family: 'Quicksand',sans-serif !important;
        font-size: 16px;
        font-weight: 700;
        line-height: 20px;
        letter-spacing: -0.0004em;
        text-align: left;
        color: #333333;
        display: block;
        max-width: 200px;
        word-wrap: break-word;
    }
    .rfp_attribute_name
    {
        font-family: 'Roboto', sans-serif !important;
        font-size: 12px !important;
        font-weight: 400 !important;
        line-height: 20px;
        letter-spacing: -0.0004em;
        text-align: left;
        color: #797979;
    }
    .btn-primary
    {
        background-color: #0cc618 !important;
        border-color: #0cc618 !important;
        border-radius: 0px !important;
    }
    .card .card-footer
    {
        justify-content: flex-end !important
    }
    .data_rfp
    {
        background-color: #F5F5F5;
    }
    .seller_data
    {
        background-color: #F5F5F5;
        margin-bottom: 2rem;
    }
    .buyer_data
    {
        background-color: #F5F5F5
    }
    .img_product
    {
        max-width: 300px;
        height: 300px;
    }
    #modal-size {
        position:fixed;
        left:0;
        right:0;
        bottom:0;
        top:0;
        display:block;
    }

    .modal-content {
        /* 80% of window height */
        height: 100% !important;
    }

    .modal-body {
        /* 100% = dialog height, 120px = header + footer */
        max-height: calc(100% - 120px) !important;
    }
</style>

@endsection


@section('script')
<script>
    $(document).on("click", ".EdSubmitFinal", function()
    {
        var price = $('#unit_price').val();
        var serviceID = $(this).attr('id');
        if(price > 0 )
        {
            $.ajax
            ({
                url: "{{route('seller.request_for_product.seller_update_price')}}",
                method:'post',
                data:{
                    id_rfp:serviceID,
                    price:price,
                },
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                success: function(data){
                    location.reload();
                    AIZ.plugins.notify('success','Update Price Successfully!!!!');
                }, 
                error: function(){
                    AIZ.plugins.notify('danger','Some Thing Went Wrong!!!!');
                }
            });
            
        }
        else
        {
            AIZ.plugins.notify('danger','Please Input Price');
        }
        
    });

    $(document).on("click", ".EdApprove", function()
    {
        var serviceID = $(this).attr('id');
        var product_id = $('#product_id').val();
        $.ajax
        ({
            url: "{{route('seller.request_for_product.seller_accept_request')}}",
            method:'post',
            data:{
                id_rfp:serviceID,
                product_id:product_id,
            },
            headers: {
                'X-CSRF-Token': '{{ csrf_token() }}',
            },
            success: function(data){
                location.reload();
                AIZ.plugins.notify('success','Aceept Request Successfully!!!!');
            }, 
            error: function(){
                AIZ.plugins.notify('danger','Some Thing Went Wrong!!!!');
            }
        });
    });

    function open_update_price(data)
    {
        $('#rfp_price').attr('hidden',true);
        $('#rfp_price_update').removeAttr('hidden');
        // alert('aaa');
    }
</script>
@endsection