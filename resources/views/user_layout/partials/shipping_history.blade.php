<div class="modal-header">
    <h5 class="modal-title h6">{{translate('Shipping History')}}</h5>
    <button type="button" class="close" data-dismiss="modal">
    </button>
</div>


<div class="modal-body">
   
    <section class="py-5">
        <ul class="timeline-with-icons">
            @php
                $order = App\Models\OrderDetail::find($shipping_history[0]->order_detail_id)->order;
            @endphp
            @foreach($shipping_history as $each_shipping_history)
            @if($each_shipping_history->status == "receive_order")
                <li class="timeline-item mb-5">
                    <span class="timeline-icon">
                    <i class="fas fa-user-check"></i>
                    </span>
            
                    <h5 class="fw-bold">Shipper Recive Order</h5>
                    <p class="text-muted mb-2 fw-bold">{{ date('d-m-Y H:i:s', strtotime($each_shipping_history->created_at."+7hours")) }}</p>
                    <p class="text-muted">
                       
                            
                                {{ translate('Order code: ') }}
                                {{ $order->code }}
                                {{ translate('has been ' . (str_replace('_', ' ', $each_shipping_history->status))) }}
                                by shipper {{ $each_shipping_history->shipper_name }}
                            
                        
                    </p>
                </li>
                @elseif($each_shipping_history->status == "order_picking")
                    <li class="timeline-item mb-5">
                        <span class="timeline-icon">
                            <i class="fa-solid fa-box"></i>
                        </span>
                
                        <h5 class="fw-bold">Shipper Take Order From Shop</h5>
                        <p class="text-muted mb-2 fw-bold">{{ date('d-m-Y H:i:s', strtotime($each_shipping_history->created_at."+7hours")) }}</p>
                        <p class="text-muted">
                            Shipper {{ $each_shipping_history->shipper_name }} doing order picking
                                    {{ translate('order code: ') }} {{ $order->code }}
                        </p>
                    </li>
                @elseif($each_shipping_history->status == "shipping")
                <li class="timeline-item mb-5">
                    <span class="timeline-icon">
                        <i class="fa-solid fa-truck-fast"></i>
                    </span>
            
                    <h5 class="fw-bold">Shipper Is Delivering Order To You</h5>
                    <p class="text-muted mb-2 fw-bold">{{ date('d-m-Y H:i:s', strtotime($each_shipping_history->created_at."+7hours")) }}</p>
                    <p class="text-muted">
                        Shipper {{ $each_shipping_history->shipper_name }} is on the way to deliver
                                {{ translate('order code: ') }} {{ $order->code }}
                            
                    </p>
                </li>
                @elseif($each_shipping_history->status == "delivered")
                <li class="timeline-item mb-5">
                    <span class="timeline-icon">
                        <i class="fa-solid fa-square-check"></i>
                    </span>
            
                    <h5 class="fw-bold">Shipper Is Delivered Order</h5>
                    <p class="text-muted mb-2 fw-bold">{{ date('d-m-Y H:i:s', strtotime($each_shipping_history->created_at."+7hours")) }}</p>
                    <p class="text-muted mb-2 fw-bold"><a href="{{$each_shipping_history->photo}}" target="_blank">Click to see Image Proof</a></p>
                    <p class="text-muted">
                        Shipper {{ $each_shipping_history->shipper_name }} delivered successfully {{ translate('Order code: ') }} {{ $order->code }}
                    </p>
                </li>
                @endif
            @endforeach
        </ul>
      </section>
</div>

    