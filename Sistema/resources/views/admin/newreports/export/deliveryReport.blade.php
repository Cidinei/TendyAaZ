<table>
	<thead>
		<tr>
		<th>Date</th>
		<th>Order ID</th>
		<th>Store Name</th>
		<th>Completed in</th>
		<th>Delivery By</th>
		<th>Order Total</th>
		<th>Delivery Charges</th>
		@if(config('appSettings.enableDeliveryGuyEarning')=="true")
		<th>Delivery Guy Earnings</th>
		@if(config('appSettings.deliveryGuyCommissionFrom')=="DELIVERYCHARGE" )
		<th>Admin Balance Earnings</th>
		@endif
		@endif
		<th>Tip Amount</th>
		<th>Tip Earnings</th>
		<th>Sum Earnings</th>
		</tr>
	</thead>
	<tbody>
	@php
		$orderTotalNet = 0;
		$deliveryChargesTotalNet = 0;
		$deliveryChargesEarningNet = 0;
		$tipAmountNet = 0;
		$tipAmountEarningNet = 0;
		$adminBalanceTotalNet = 0;
		$sumEarningNet = 0;
	@endphp

	@foreach ($orders as $order)
		@if($order->accept_delivery && $order->accept_delivery->user && $order->accept_delivery->user->name)
			@php
				$orderDate = $order->created_at->format('d-m-Y');
				$restaurantName = $order->restaurant->name;
				
				$orderCompletedTime = $order->updated_at->diffInMinutes($order->created_at);

				$deliveryGuyId = $order->accept_delivery->user->id; 
				$deliveryGuyName = $order->accept_delivery->user->name;

				$orderTotal = $order->total;
				$deliveryCharge = $order->delivery_charge;
				$tipAmount = $order->tip_amount;
				$orderTotalLessTip = $orderTotal - $tipAmount;

				$deliveryChargeCommission = $order->accept_delivery->user->delivery_guy_detail->commission_rate/100;

				if (config('appSettings.enableDeliveryGuyEarning') == "true") {
					if (config('appSettings.deliveryGuyCommissionFrom')=="DELIVERYCHARGE" ) {
						$deliveryChargeEarning = $deliveryCharge * $deliveryChargeCommission;
						$adminBalance = ($deliveryCharge - $deliveryChargeEarning);
					} 
					if (config('appSettings.deliveryGuyCommissionFrom')=="FULLORDER" ) {
						$deliveryChargeEarning = $orderTotalLessTip * $deliveryChargeCommission;
					}
				}
				else {
                        $deliveryChargeEarning = 0;
				}

				$tipAmountCommission = $order->accept_delivery->user->delivery_guy_detail->tip_commission_rate/100;

				if ($tipAmount != NULL) {
					$tipAmountEarning = $tipAmount * $tipAmountCommission;
				} else {
					$tipAmountEarning = 0;
				}

				if (config('appSettings.enableDeliveryGuyEarning') == "true") {
					$sumEarning = $deliveryChargeEarning + $tipAmountEarning;
				} else {
					$sumEarning = $tipAmountEarning;
				}

				$orderTotalNet += $orderTotal;
				$deliveryChargesTotalNet += $deliveryCharge;
				$deliveryChargesEarningNet += $deliveryChargeEarning;
				$tipAmountNet += $tipAmount;
				$tipAmountEarningNet += $tipAmountEarning;
				if (config('appSettings.enableDeliveryGuyEarning') == "true") {
					if (config('appSettings.deliveryGuyCommissionFrom')=="DELIVERYCHARGE" ) {
						$adminBalanceTotalNet += $adminBalance;
					}
				}
				$sumEarningNet += $sumEarning;

			@endphp
			<tr>
				<td>{{ $orderDate }}</td>
				<td>{{ $order->unique_order_id }}</td>
				<td>{{ $restaurantName }}</td>
				<td>{{ $orderCompletedTime }} minutes</td>
				<td>{{ $deliveryGuyId }} - {{ $deliveryGuyName }}</td>
				<td>{{ $orderTotal }}</td>
				<td>{{ $deliveryCharge }}</td>
				@if(config('appSettings.enableDeliveryGuyEarning')=="true")
					<td>{{ $deliveryChargeEarning }}</td>
				@if(config('appSettings.deliveryGuyCommissionFrom')=="DELIVERYCHARGE" )
					<td>{{ $adminBalance }}</td>
				@endif
				@endif
				<td>{{ $tipAmount }}</td>
				<td>{{ $tipAmountEarning }}</td>
				<td>{{ $sumEarning }}</td>
			</tr>
		@endif
		@endforeach
	</tbody>
	<tfoot>
		<tr>
			<th>TOTAL</th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th>{{ $orderTotalNet }}</th>
			<th>{{ $deliveryChargesTotalNet }} </th>
			@if(config('appSettings.enableDeliveryGuyEarning')=="true")
			<th>{{ $deliveryChargesEarningNet }} </th>
			@if(config('appSettings.deliveryGuyCommissionFrom')=="DELIVERYCHARGE" )
			<th>{{ $adminBalanceTotalNet }}</th>
			@endif
			@endif
			<th>{{ $tipAmountNet }} </th>
			<th>{{ $tipAmountEarningNet }} </th>
			<th>{{ $sumEarningNet }} </th>
		</tr>
	</tfoot>
</table>