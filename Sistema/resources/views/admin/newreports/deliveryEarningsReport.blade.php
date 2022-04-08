@extends('admin.layouts.master')
@section("title") Ganhos do Entregador - Relatório
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
        <span class="font-weight-bold mr-2">Relatório de ganhos do entregador</span>
        <span class="badge badge-primary badge-pill animated flipInX mr-2"></span>
      </h4>
      <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
    </div>
  </div>
  <div>
    <div class="header-elements">
      <form action="{{ route('admin.deliveryEarningsReport') }}" method="GET">
        <div class="form-group row mb-0">
          <div class="col-lg-4">
            <select class="form-control selectDB" name="deliver_by_id">
              <option value="">Selecione o Entregador</option>
              @foreach ($delivery_details as $delivery_boy)
              <option value="{{ $delivery_boy->id }}" @if( app('request')->input('deliver_by_id') == $delivery_boy->id) selected @endif class="text-capitalize">{{ $delivery_boy->id }} - {{ $delivery_boy->name }} </option>
              @endforeach

            </select>
          </div>
          <div class="col-lg-5" style="display: inline-flex;">
            <label style="margin: 5px auto">A partir de </label>
            <input type="text" class="form-control-sm form-control daterange-single" name="report_start_date" value="{{@$search_data['start_date']}}" placeholder="Start Date" style="width: 43%" />&nbsp;&nbsp;&nbsp;
            <label style="margin: 5px auto">Até </label>

            <input type="text" class="form-control form-control-sm daterange-single"
            value="{{@$search_data['end_date']}}" name="report_end_date" style="width: 43%">

          </div>
          <div class="col-lg-2">
            <button type="submit" class="btn btn-primary">
              <i class="icon-search4"></i>
            </button>
          </div>
        </div>
      </form>
    </div>

    <div class="page-header-content header-elements-md-inline">
      <div class="page-title d-flex">
        <div class="card">
          <div class="card-body">
            <a href="javascript:void(0)" id="printButton" class="btn btn-sm btn-primary my-2" style="color: #fff; border: 1px solid #ccc; float: right;"><i class="icon-printer mr-1"></i> Imprimir Relatório</a>
            <a href="{{ route('admin.exportReport', 'delivery_details') }}?deliver_by_id={{@$search_data['deliver_by_id']}}&report_start_date={{@$search_data['start_date']}}&report_end_date={{@$search_data['end_date']}}" class="btn btn-sm btn-primary my-2" style="color: #fff; border: 1px solid #ccc; float: right;"><i class="icon-file-excel mr-1"></i> Exportar para XLS</a>
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                   <th>Data</th>
                   <th>ID do pedido</th>
                   <th>Nome da loja</th>
                   <th>Concluído em</th>
                   <th>Entregue por</th>
                   <th>Total de pedidos</th>
                   <th>Taxas de entrega</th>
                   @if(config('appSettings.enableDeliveryGuyEarning')=="true")
                   <th>Lucro do entregador</th>
                   @if(config('appSettings.deliveryGuyCommissionFrom')=="DELIVERYCHARGE" )
                   <th>Ganhos da Plataforma</th>
                   @endif
                   @endif
                   <th>Valor da gorjeta</th>
                   <th>Ganhos da gorjeta</th>
                   <th>Ganhos totais</th>
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
                    $tipAmount = ( $order->tip_amount != NULL ? $order->tip_amount : '0');
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

                    $tipAmountEarning = ($tipAmount != NULL ? ($tipAmount * $tipAmountCommission) : '0' );

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
                 <td><a href="{{ route('admin.viewOrder', $order->unique_order_id) }}"><span style="font-size: 0.8rem; font-weight: 700;">{{ $order->unique_order_id }}</span></a></td>
                 <td>{{ $restaurantName }}</td>
                 <td>
                   @if ($order->orderstatus_id == 5 && ($order->updated_at->diffInMinutes($order->created_at) > 45 || $order->updated_at->diffInMinutes($order->created_at) == 45))
                   <span class="badge badge-flat border-grey-800 text-default text-capitalize text-left" style="background-color: red; color: white;">
                    {{ $orderCompletedTime }} minutos
                  </span>
                  @endif
                  @if ($order->orderstatus_id == 5 && ($order->updated_at->diffInMinutes($order->created_at) > 30 && $order->updated_at->diffInMinutes($order->created_at) < 45))
                  <span class="badge badge-flat border-grey-800 text-default text-capitalize text-left" style="background-color: #ff8400; color: white;">
                    {{ $orderCompletedTime }} minutos
                  </span>
                  @endif
                  @if (($order->orderstatus_id == 5 && ($order->updated_at->diffInMinutes($order->created_at) < 30) || $order->updated_at->diffInMinutes($order->created_at) == 30))
                  <span class="badge badge-flat border-grey-800 text-default text-capitalize text-left" style="background-color: green; color: white;">
                    {{ $orderCompletedTime }} minutos
                  </span>
                  @endif
                </td>
                <td>
                  <span class="badge badge-flat border-grey-800 text-default text-capitalize text-left">
                    {{ $deliveryGuyId }} - {{ $deliveryGuyName }}
                  </span>
                </td>
                <td>{{ config('appSettings.currencyFormat') }}{{ $orderTotal }}</td>
                <td>{{ config('appSettings.currencyFormat')}}{{ $deliveryCharge }}</td>
                @if(config('appSettings.enableDeliveryGuyEarning')=="true")
                <td>{{ config('appSettings.currencyFormat')}}{{ $deliveryChargeEarning }}</td>
                 @if(config('appSettings.deliveryGuyCommissionFrom')=="DELIVERYCHARGE" )
                  <td>{{ config('appSettings.currencyFormat') }}{{ $adminBalance }}</td>
                 @endif
                @endif
                 <td>{{ config('appSettings.currencyFormat') }}{{ $tipAmount }}</td>
                 <td>{{ config('appSettings.currencyFormat') }}{{ $tipAmountEarning }}</td>
                 <td>{{ config('appSettings.currencyFormat') }}{{ $sumEarning }}</td>
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
               <th>{{ config('appSettings.currencyFormat') }}{{ $orderTotalNet }}</th>
               <th>{{ config('appSettings.currencyFormat') }}{{ $deliveryChargesTotalNet }} </th>
               @if(config('appSettings.enableDeliveryGuyEarning')=="true")
               <th>{{ config('appSettings.currencyFormat') }}{{ $deliveryChargesEarningNet }} </th>
               @if(config('appSettings.deliveryGuyCommissionFrom')=="DELIVERYCHARGE" )
               <th>{{ config('appSettings.currencyFormat') }}{{ $adminBalanceTotalNet }}</th>
               @endif
               @endif
               <th>{{ config('appSettings.currencyFormat') }}{{ $tipAmountNet }} </th>
               <th>{{ config('appSettings.currencyFormat') }}{{ $tipAmountEarningNet }} </th>
               <th>{{ config('appSettings.currencyFormat') }}{{ $sumEarningNet }} </th>
             </tr>
           </tfoot>
         </table>
         <div class="mt-3">
          {{ $orders->appends($_GET)->links() }}
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>
</div>
</div>

<script>
  $('#printButton').on('click',function(){
    $('.table').printThis();
  });

  $('.daterange-single').daterangepicker({ 
   singleDatePicker: true,
 });

  $('.selectDB').select2({
    placeholder: 'Selecione o Entregador',
    allowClear: true,
    width: "300px"
  });

</script>
@endsection