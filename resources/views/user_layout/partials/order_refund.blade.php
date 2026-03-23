<div class="modal-header">
    <h5 class="modal-title h6">{{translate('Refund Request')}}</h5>
    <button type="button" class="close" data-dismiss="modal">
    </button>
</div>


    <!-- Add new review -->
    <form action="{{ route('refund.store') }}" method="POST" >
        @csrf
        <input type="hidden" name="order_detail_id" value="{{ $order_detail->id }}">
        <input type="hidden" name="price" value="{{ $order_detail->price }}">
        <input type="hidden" name="shipping_price" value="{{ $order_detail->shipping_cost }}">
        <div class="modal-body">
            <div class="form-group row">
                <label class="col-md-3 col-from-label">{{ translate('Order Code') }}</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="order_code"
                        placeholder="{{ translate('Product Name') }}" value="{{$order_detail->order->code}}" disabled>
                </div>
            </div>
           
            <div class="form-group row">
                <label class="col-md-3 col-from-label">{{ translate('Product') }}</label>
                <div class="col-md-8">
                    <input type="text" class="form-control"
                        placeholder="{{ translate('Product Name') }}" value="{{$order_detail->product->name}}" disabled>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-3 col-from-label">{{ translate('Quantity') }}</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" 
                        placeholder="{{ translate('Product Name') }}" value="{{$order_detail->quantity}}" disabled>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-3 col-from-label">{{ translate('Price') }}</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name=""
                        placeholder="{{ translate('Product Name') }}" value="{{single_price($order_detail->price)}}" disabled>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-3 col-from-label">{{ translate('Shipping Price') }}</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name=""
                        placeholder="{{ translate('Product Name') }}" value="{{single_price($order_detail->shipping_cost)}}" disabled>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-3 col-from-label">{{ translate('Total Price') }}</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="total_price"
                        placeholder="{{ translate('Product Name') }}" value="{{single_price($order_detail->shipping_cost + $order_detail->price )}}" disabled>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-3 col-from-label">{{ translate('Delivery Status') }}</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name=""
                        value="{{ucfirst($order_detail->delivery_status)}}" disabled>
                </div>
            </div>
        
     @if(!isset($order_detail->refund_requets))       
            <div class="form-group">
                <label class="opacity-60">{{ translate('Reason')}}</label>
                <textarea class="form-control rounded-0" rows="4" name="reason" placeholder="{{ translate('Your reason')}}" required></textarea>
            </div>

            

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-secondary rounded-0" data-dismiss="modal">{{translate('Cancel')}}</button>
            <button type="submit" class="btn btn-sm btn-primary rounded-0">{{translate('Submit Request')}}</button>
        </div>
    @else
            <div class="form-group">
                <label class="opacity-60">{{ translate('Reason')}}</label>
                <textarea class="form-control rounded-0" rows="4" name="reason" placeholder="{{ translate('Your reason')}}">{{$order_detail->refund_requets->reason}}</textarea>
            </div>

            <div class="form-group row">
                <label class="col-md-3 col-from-label">{{ translate('Refund Code') }}</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="order_code"
                        placeholder="{{ translate('Product Name') }}" value="{{$order_detail->refund_requets->code}}" disabled>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-3 col-from-label">{{ translate('Refund Status') }}</label>
                <div class="col-md-8">
                    @if($order_detail->refund_requets->status == 0 )
                        <input type="text" class="form-control" name="order_code"
                        placeholder="{{ translate('Product Name') }}" value="Waiting For Approve" disabled>
                    @elseif($order_detail->refund_requets->status == 1 )
                        <input type="text" class="form-control" name="order_code"
                        placeholder="{{ translate('Product Name') }}" value="Waiting For Refund" disabled>
                    @elseif($order_detail->refund_requets->status == 2 )
                        <input type="text" class="form-control" name="order_code"
                            placeholder="{{ translate('Product Name') }}" value="Refunded" disabled>
                        <p class="text-muted mb-2 fw-bold"><a href="{{uploaded_asset($order_detail->refund_requets->img_proof)}}" target="_blank">Click to see Image Proof</a></p>
                    @else
                        <input type="text" class="form-control" name="order_code"
                        placeholder="{{ translate('Product Name') }}" value="Request Rejected" disabled>
                    @endif
                    
                </div>
            </div>

        </div>
    @endif
    </form>
{{-- @else
    <!-- Review -->
    <li class="media list-group-item d-flex">
        <div class="media-body text-left">
            <!-- Rating -->
            <div class="form-group">
                <label class="opacity-60">{{ translate('Rating')}}</label>
                <p class="rating rating-sm">
                    @for ($i=0; $i < $review->rating; $i++)
                        <i class="fa fa-star active"></i>
                    @endfor
                    @for ($i=0; $i < 5-$review->rating; $i++)
                        <i class="fa fa-star"></i>
                    @endfor
                </p>
            </div>
            <!-- Comment -->
            <div class="form-group">
                <label class="opacity-60">{{ translate('Comment')}}</label>
                <p class="comment-text">
                    {{ $review->comment }}
                </p>
            </div>
            <!-- Review Images -->
            @if($review->photos != null)
                <div class="form-group">
                    <label class="opacity-60">{{ translate('Images')}}</label>
                    <div class="d-flex flex-wrap">
                        @foreach (explode(',', $review->photos) as $photo)
                            <div class="mr-3 mb-3 size-90px">
                                <img class="img-fit h-100 lazyload border"
                                    src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                    data-src="{{ uploaded_asset($photo) }}"
                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </li>
@endif --}}