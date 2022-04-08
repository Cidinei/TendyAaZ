@extends('admin.layouts.master')
@section("title") Ganhos da Plataforma - Relatório
@endsection
@section('content')
<style>
    .select2-selection--single .select2-selection__rendered {
        padding-left: .875rem !important;
        padding-right: 5.375rem !important;
    }

    .range-selector {
        margin: 10px;
    }
</style>
<div class="page-header">
    <div class="page-header-content header-elements-md-inline">
        <div class="page-title d-flex">
            <h4><i class="icon-circle-right2 mr-2"></i>
                <span class="font-weight-bold mr-2">Relatório de ganhos da Plataforma</span>
                <span class="badge badge-primary badge-pill animated flipInX mr-2"></span>
            </h4>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
    </div>
    <div>
        <div class="header-elements">
            <form action="{{ route('admin.adminEarningsReport') }}" method="GET">
                <div class="form-group row mb-0">
                    <div class="col-lg-2.5">
                        <select class="form-control selectRest" name="restaurant_id" style="width: 100px !important;">
                            <option></option>
                            @foreach ($restaurants as $restaurant_select)
                            <option value="{{ $restaurant_select->id }}" @if( app('request')->input('restaurant_id') ==
                                $restaurant_select->id) selected @endif class="text-capitalize">{{
                                $restaurant_select->id }} - {{ $restaurant_select->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <input type="text" class="form-control" placeholder="Método de Pagamento..." name="payment_mode"
                            value="{{@$search_data['payment_mode']}}">
                    </div>
                    <div class="col-lg-2">
                        <select name="delivery_type" class="form-control form-control-lg selectOrderType">
                            <option></option>
                            <option value="1" @if($search_data['delivery_type']=="1" ) selected @endif>Delivery</option>
                            <option value="2" @if($search_data['delivery_type']=="2" ) selected @endif>Retirada na Loja
                            </option>
                        </select>
                    </div>
                    <div class="col-lg-4" style="display:inline-flex;">
                        <label style="margin: 5px auto">A partir de </label>
                        <input type="text" class="form-control-sm form-control daterange-single"
                            name="report_start_date" value="{{@$search_data['start_date']}}" placeholder="Start Date"
                            style="width: 43%" />
                        <label style="margin: 5px auto">Até </label>
                        <input type="text" class="form-control-sm form-control daterange-single" name="report_end_date"
                            value="{{@$search_data['end_date']}}" placeholder="End Date" style="width: 43%" />
                    </div>
                    <div class="col-lg-0">
                        <button type="submit" class="btn btn-primary">
                            <i class="icon-search4"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="row">
            <div class="col-md-8 mt-4">
                <a href="javascript:void(0)" id="printButton" class="btn btn-sm btn-primary my-2"
                    style="color: #fff; border: 1px solid #ccc; float: right;"><i class="icon-printer mr-1"></i> Print
                    Report</a>
                <!-- <a href="{{ route('admin.exportReport', 'store_wise') }}?restaurant_id={{@$search_data['restaurant_id']}}&payment_mode={{@$search_data['payment_mode']}}&report_start_date={{@$search_data['start_date']}}&report_end_date={{@$search_data['end_date']}}"
                    id="printButton" class="btn btn-sm btn-primary my-2" style="color: #fff; border: 1px solid #ccc; float: right;"><i class="icon-file-excel mr-1"></i>Export to XLS</a> -->
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Nome da Loja</th>
                                <th>ID do pedido</th>
                                <th>Tipo de pedido</th>
                                <th>Concluído em</th>
                                <th>Método de pagamento</th>
                                <th>Valor líquido do pedido</th>
                                <th>Taxa de entrega</th>
                                <th>Valor da gorjeta</th>
                                <th>Valor do pedido</th>
                                <th>Ganhos do pedido (%)</th>
                                @if(config('appSettings.enableDeliveryGuyEarning')=="true")
                                <th>Ganhos de taxa de entrega (%)</th>
                                @endif
                                <th>Ganhos de gorjeta (%)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $totalNetOrder = 0;
                            $totalDeliveryCharge = 0;
                            $totalTipAmount = 0;
                            $totalOrderAmount = 0;
                            $totalOrderEarnings = 0;
                            $totalDeliveryEarnings = 0;
                            $totalTipEarnings = 0;
                            $totalAdminEarnings = 0;
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

                            $orderTotal = $order->total;
                            $orderDeliveryCharge = $order->delivery_charge != NULL ? $order->delivery_charge : '0';

                            $orderTipAmount = $order->tip_amount != NULL ? $order->tip_amount : '0';

                            $orderCouponAmount = $order->coupon_amount != NULL ? $order->coupon_amount : '0';

                            if (($order->tax_amount == NULL) && (config('appSettings.taxApplicable') == "true")) {
                            $orderTaxAmount = ($order->total - $order->tip_amount) * ($order->tax_rate/100);
                            } else {
                            $orderTaxAmount = $order->tax_amount;
                            }

                            $orderRestaurantCharge = $order->restaurant_charge != NULL ? $order->restaurant_charge : '0';

                            if ($order->sub_total == NULL) {
                            $orderSubTotal = $orderTotal - ($orderDeliveryCharge + $orderCouponAmount + $orderTipAmount
                            + $orderTaxAmount + $orderRestaurantCharge);
                            } else {
                            $orderSubTotal = ($order->sub_total - $orderCouponAmount + $orderRestaurantCharge);
                            }

                            if ($order->accept_delivery && $order->accept_delivery->user && $order->accept_delivery->user->name) {
                                if (config('appSettings.enableDeliveryGuyEarning') == "true") {
                                    $deliveryChargeCommission = $order->accept_delivery->user->delivery_guy_detail->commission_rate/100;
                                    if (config('appSettings.deliveryGuyCommissionFrom')=="DELIVERYCHARGE" ) {
                                        $deliveryChargeEarning = $orderDeliveryCharge * $deliveryChargeCommission;
                                        $adminBalanceOnDeliveryCharge = ($orderDeliveryCharge - $deliveryChargeEarning);
                                    } elseif (config('appSettings.deliveryGuyCommissionFrom')=="FULLORDER" ) {
                                        $adminBalanceOnDeliveryCharge = 0;
                                    }
                                }

                            $tipAmountCommission = $order->accept_delivery->user->delivery_guy_detail->tip_commission_rate/100;
                            $tipAmountEarning = ($orderTipAmount != NULL ? ($orderTipAmount * $tipAmountCommission) : '0' );
                            $adminBalanceOnTipAmount = ($orderTipAmount - $tipAmountEarning);
                            } else {
                                $adminBalanceOnDeliveryCharge = 0;
                                $adminBalanceOnTipAmount = 0;
                            }

                            $netOrderValue = $orderTotal - $orderDeliveryCharge - $orderTipAmount;

                            $commissionRate = $order->restaurant->commission_rate/100;
                            $commissionAmount = $orderSubTotal * $commissionRate;

                            $totalNetOrder += $netOrderValue;
                            $totalDeliveryCharge += $orderDeliveryCharge;
                            $totalTipAmount += $orderTipAmount;
                            $totalOrderAmount += $orderTotal;
                            $totalOrderEarnings += $commissionAmount;
                            $totalDeliveryEarnings += $adminBalanceOnDeliveryCharge;
                            $totalTipEarnings += $adminBalanceOnTipAmount;

                            $totalAdminEarnings = $totalOrderEarnings + $totalDeliveryEarnings + $totalTipEarnings;

                            @endphp

                            <tr>
                                <td>{{ $orderDate}}</td>
                                <td>{{ $restaurantName }}</td>
                                <td>
                                    <a href="{{ route('admin.viewOrder', $order->unique_order_id) }}">
                                        <span style="font-size: 0.8rem; font-weight: 700;">
                                            {{ $order->unique_order_id }}
                                        </span>
                                    </a>
                                </td>
                                <td>
                                    <span class="badge badge-flat border-grey-800 text-default text-capitalize">
                                        {{ $orderType }}
                                    </span>
                                </td>
                                <td>
                                    @if ($order->orderstatus_id == 5 &&
                                    ($order->updated_at->diffInMinutes($order->created_at) > 45 ||
                                    $order->updated_at->diffInMinutes($order->created_at) == 45))
                                    <span
                                        class="badge badge-flat border-grey-800 text-default text-capitalize text-left"
                                        style="background-color: red; color: white;">
                                        {{ $orderCompletionTime }} minutos
                                    </span>
                                    @endif
                                    @if ($order->orderstatus_id == 5 &&
                                    ($order->updated_at->diffInMinutes($order->created_at) > 30 &&
                                    $order->updated_at->diffInMinutes($order->created_at) < 45)) <span
                                        class="badge badge-flat border-grey-800 text-default text-capitalize text-left"
                                        style="background-color: #ff8400; color: white;">
                                        {{ $orderCompletionTime }} minutos
                                        </span>
                                        @endif
                                        @if (($order->orderstatus_id == 5 &&
                                        ($order->updated_at->diffInMinutes($order->created_at) < 30) || $order->
                                            updated_at->diffInMinutes($order->created_at) == 30))
                                            <span
                                                class="badge badge-flat border-grey-800 text-default text-capitalize text-left"
                                                style="background-color: green; color: white;">
                                                {{ $orderCompletionTime }} minutos
                                            </span>
                                            @endif
                                </td>
                                <td>
                                    <span class="badge badge-flat border-grey-800 text-default text-capitalize">
                                        {{ $paymentMethod }}
                                    </span>
                                </td>
                                <td>{{ config('appSettings.currencyFormat') }}{{ $netOrderValue }}</td>
                                <td>{{ config('appSettings.currencyFormat') }}{{ $orderDeliveryCharge }}</td>
                                <td>{{ config('appSettings.currencyFormat') }}{{ $orderTipAmount }}</td>
                                <td>{{ config('appSettings.currencyFormat') }}{{ $orderTotal }}</td>
                                <td>{{ config('appSettings.currencyFormat') }}{{ $commissionAmount }}</td>
                                @if(config('appSettings.enableDeliveryGuyEarning')=="true")
                                <td>{{ config('appSettings.currencyFormat') }}{{ $adminBalanceOnDeliveryCharge }}</td>
                                @endif
                                <td>{{ config('appSettings.currencyFormat') }}{{ $adminBalanceOnTipAmount }}</td>
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
                                <th>{{ config('appSettings.currencyFormat') }}{{ $totalNetOrder }}</th>
                                <th>{{ config('appSettings.currencyFormat') }}{{ $totalDeliveryCharge }}</th>
                                <th>{{ config('appSettings.currencyFormat') }}{{ $totalTipAmount }}</th>
                                <th>{{ config('appSettings.currencyFormat') }}{{ $totalOrderAmount }}</th>
                                <th>{{ config('appSettings.currencyFormat') }}{{ $totalOrderEarnings }}</th>
                                @if(config('appSettings.enableDeliveryGuyEarning')=="true")
                                <th>{{ config('appSettings.currencyFormat') }}{{ $totalDeliveryEarnings }}</th>
                                @endif
                                <th>{{ config('appSettings.currencyFormat') }}{{ $totalTipEarnings }}</th>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="mt-3" style="font-weight: 600; font-size: 1rem;">
                        Lucro total da Plataforma: {{ config('appSettings.currencyFormat') }}{{ $totalAdminEarnings }}
                    </div>
                    <div class="mt-3">
                        {{ $orders->appends($_GET)->links() }}
                    </div>
                </div>
            </div>
        </div>
        <script>
            $('.selectRest').select2({
                placeholder: 'Selecione a Loja',
                allowClear: true,
                width: "200px"
            });
            $('.selectOrderType').select2({
                placeholder: 'Tipo de Entrega',
                allowClear: true,
                width: "150px"
            });

            $('.selectRange').select2();

            $('.daterange-single').daterangepicker({
                singleDatePicker: true,
            });

            $('#printButton').on('click', function () {
                $('.table').printThis();
            });
        </script>
        @endsection