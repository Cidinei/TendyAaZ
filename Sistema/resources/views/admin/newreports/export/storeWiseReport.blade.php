@foreach ($restaurants as $restaurant_select)
@endforeach
<table class="table">
    <thead>
      <tr>
        <th>Date</th>
        <th>Store Name</th>
        <th>Order ID</th>
        <th>Order Type</th>
        <th>Completed in</th>
        <th>Payment Mode</th>
        <th>Paid with Wallet</th>
        <th>Net Amount</th>
        <th>Commission Rate</th>
        <th>Earnings</th>
        <th>Subtotal</th>
        <th>Coupon</th>
        @if (config('appSettings.taxApplicable') == "true")
        <th>Tax</th>
        @endif
        <th>Restaurant Charge</th>
        <th>Delivery Charge</th>
        <th>Delivery Tip</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
      @php 
      $earningNet = 0;
      $subTotalNet = 0;
      $deliveryTotalNet = 0;
      $totalEarn = 0;
      $totalNet = 0;
      $totalWallet = 0;
      $couponTotalNet = 0;
      $taxTotalNet = 0;
      $totalTip = 0;
      $totalRestaurantCharge = 0;
      @endphp
      
      @foreach ($orders as $order)
        @php
        $orderDate = $order->created_at->format('d-m-Y');
        $restaurantName = $order->restaurant->name;
        
        if ($order->delivery_type == 1) {
          $orderType = 'Delivery';
          } elseif ($order->delivery_type == 2) {
            $orderType = 'Self-Pickup';
        }

        $orderCompletionTime = $order->updated_at->diffInMinutes($order->created_at);
        $paymentMethod = $order->payment_mode;

        if ($order->wallet_amount != NULL) {
          $walletAmount = $order->wallet_amount;
          } else {
            $walletAmount = 0;
        }

        $orderTotal = $order->total;
        $orderDeliveryCharge = $order->delivery_charge;
        
        $orderTipAmount = $order->tip_amount != NULL ? $order->tip_amount : '0';

        $orderCouponAmount = $order->coupon_amount != NULL ? $order->coupon_amount : '0';

        if (($order->tax_amount == NULL) && (config('appSettings.taxApplicable') == "true")) {
          $orderTaxAmount = ($order->total - $order->tip_amount) * ($order->tax_rate/100);
          } else {
            $orderTaxAmount = $order->tax_amount;
        }
        
        $orderRestaurantCharge = $order->restaurant_charge != NULL ? $order->restaurant_charge : '0';
        
        if ($order->sub_total == NULL) {
          $orderSubTotal = $orderTotal - ($orderDeliveryCharge + $orderCouponAmount + $orderTipAmount + $orderTaxAmount + $orderRestaurantCharge);
          } else {
            $orderSubTotal = ($order->sub_total - $orderCouponAmount + $orderRestaurantCharge);
          }

        $commissionRate = $order->restaurant->commission_rate/100;
        $commissionAmount = $orderSubTotal * $commissionRate;
        
        $restaurantNetAmount = $orderSubTotal - $commissionAmount;
        
        $earningNet += $restaurantNetAmount;
        $subTotalNet += $orderSubTotal;
        $deliveryTotalNet += $orderDeliveryCharge;
        $totalEarn += $commissionAmount;
        $totalNet += $orderTotal;
        $totalWallet += $walletAmount;
        $couponTotalNet += $orderCouponAmount;
        $taxTotalNet += $orderTaxAmount;
        $totalTip += $orderTipAmount;
        $totalRestaurantCharge += $orderRestaurantCharge;

        @endphp

      <tr>
        <td>{{ $orderDate}}</td>
        <td>{{ $restaurantName }}</td>
        <td>{{ $order->unique_order_id }}</td>
        <td>{{ $orderType }}</td>
        <td>{{ $orderCompletionTime }} minutes</td>
        <td>{{ $paymentMethod }}</td>
        <td>{{ $walletAmount }}</td>
        <td>{{ $restaurantNetAmount }}</td>
        <td>{{ $order->restaurant->commission_rate }}%</td>
        <td>{{ $commissionAmount }}</td>
        <td>{{ $orderSubTotal }}</td>
        <td>{{ $orderCouponAmount }}</td>
        @if (config('appSettings.taxApplicable') == "true")
        <td>{{ $orderTaxAmount }}</td>
        @endif
        <td>{{ $orderRestaurantCharge }}</td>
        <td>{{ $orderDeliveryCharge }}</td>
        <td>{{ $orderTipAmount }}</td>
        <td>{{ $orderTotal }}</td>
        @endforeach
    </tbody>
    <tfoot>
      <tr>
        <th></th>
        <th>TOTAL</th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th>{{$totalWallet}}</th>
        <th>{{$earningNet}}</th>
        <th></th>
        <th>{{$totalEarn}}</th>
        <th>{{$subTotalNet}}</th>
        <th>{{$couponTotalNet}}</th>
        @if(config('appSettings.taxApplicable') == "true")
        <th>{{$taxTotalNet}}</th>
        @endif
        <th>{{$totalRestaurantCharge}}</th>
        <th>{{$deliveryTotalNet}}</th>
        <th>{{$totalTip}}</th>
        <th>{{$totalNet}}</th>
      </tr>
    </tfoot>
</table>