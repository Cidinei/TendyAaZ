@extends('admin.layouts.master')
@section("title") {{__('storeDashboard.ovTitle')}}
@endsection 
@section('content')

@php
function calculateAddonTotal($addons) {
    $total = 0;
    foreach ($addons as $addon) {
        $total += $addon->addon_price;
    }
    return $total;
}
@endphp                    

<div class="content">
    <br/><div class="col-md-6">	 
    <a href="javascript:void(0)" id="printButton">
        <input type='button' class="btn btn-lg btn-danger" id='btn' value='{{ Lang::get('thermalprinterpro::default.thermalPrinterOrder') }}' >
        <div class="clearfix"></div>
    </a>
    </div><br/>

    <div id="ticket_imprimir">
        <table class="printer-ticket">
            <thead>
                <tr>
                    <th style="text-align: center;" class="title" colspan="3">
                        {{ $order->unique_order_id }} <br>
                        {{__('storeDashboard.ovOrderPlaced')}}: <br>
                        {{ $order->created_at}}  ( {{ $order->created_at->diffForHumans() }} ) <br>
                        {{__('storeDashboard.ovStoreName')}}: {{ $order->restaurant->name }}<br><br>
                    </th>
                </th>
                <tr>
                    <th colspan="3">
                        <tr class="top">
                            <td colspan="3">
                                <b>{{__('storeDashboard.ovCustomerDetails')}}:</b><br/>
                                <b>{{__('storeDashboard.ovName')}}: </b> {{ $order->user->name }}   <br/>
                                <b>{{__('storeDashboard.ovEmail')}}: </b> {{ $order->user->email }}  <br/>
                                <b>{{__('storeDashboard.ovContactNumber')}}:  </b> {{ $order->user->phone }} <br/>
                                <b>{{__('storeDashboard.ovAddress')}}:  </b> <br/>
                                    {{ $order->address }} <br/> <br/>
                                <b>{{__('storeDashboard.ovOrderType')}}: </b> 
                                    @if($order->delivery_type == 1)
                                    {{__('storeDashboard.ovOrderTypeDelivery')}}
                                    @else
                                        {{__('storeDashboard.ovOrderTypeSelfPickup')}}
                                    @endif   
                                <br/><br/>
                            </td>
                        </tr>
                    </th>
                </tr>
                <tr>
                    <th colspan="3">
                        <tr class="top">
                            <td colspan="3">
                                <b>{{__('storeDashboard.navSubItems')}}:</b><br/>
                                @foreach($order->orderitems as $item)
                                    <tr class="top">
                                        <td colspan="2">{{ $item->quantity }} - {{ $item->name }}...</td>
                                        <td align="right">{{ config('appSettings.currencyFormat') }} {{ ($item->price +calculateAddonTotal($item->order_item_addons)) * $item->quantity }}</td>
                                    </tr>
                                        @if(count($item->order_item_addons))
                                            @foreach($item->order_item_addons as $addon)
                                            <tr class="top"> 
                                                <td colspan="2"> {{ $addon->addon_category_name }}- {{ $addon->addon_name }}</td>
                                                <td align="right">{{ config('appSettings.currencyFormat') }}{{ $addon->addon_price }}</td>
                                            </tr> 
                                            @endforeach
                                        @endif
                                @endforeach

                                @if(!$order->coupon_name == NULL)
                                <tr class="top">
                                    <td colspan="2">{{__('storeDashboard.ovCoupon')}}:</td>
                                    <td align="right">{{ $order->coupon_name }}</td>
                                </tr>
                                @endif

                                @if(!$order->restaurant_charge == NULL)
                                <tr class="top">
                                    <td colspan="2">{{__('storeDashboard.ovStoreCharge')}}: </td>
                                    <td align="right">{{ config('appSettings.currencyFormat') }}{{ $order->restaurant_charge }}</td>
                                </tr>
                                @endif

                                @if(!$order->delivery_charge == NULL)
                                <tr class="top">
                                    <td colspan="2">{{__('storeDashboard.ovDeliveryCharge')}}:</td>
                                    <td align="right">{{ config('appSettings.currencyFormat') }}{{ $order->delivery_charge }}</td>
                                </tr>
                                @endif

                                @if(!$order->tax == NULL)
                                <tr class="top">
                                    <td colspan="2">{{__('storeDashboard.ovTax')}}: </td>
                                    <td align="right">{{ $order->tax }}%</td>
                                </tr>
                                @endif

                                @if($order->wallet_amount != NULL)
                                <tr>
                                    <td colspan="2">{{__('storeDashboard.ovPaidWithWallet')}} {{ config('appSettings.walletName') }}:</td>
                                    <td align="right"> {{ config('appSettings.currencyFormat') }}{{ $order->wallet_amount }} </td>
                                </tr>
                                @endif

                            </td>
                        </tr>
                    </th>
                </tr> 

                <tr class="top">
                    <td colspan="2"> {{ Lang::get('thermalprinterpro::default.ovTip') }} </td>
                        <td align="right">{{ config('appSettings.currencyFormat') }} {{ $order->tip_amount }}</td>
                    </td>
                </tr> 
                
                <tr class="top">
                    <td colspan="2"> {{__('storeDashboard.ovTotal')}} </td>
                        <td align="right">{{ config('appSettings.currencyFormat') }} {{ $order->total }}</td>
                    </td>
                </tr>    
                
                
                @php
                    if(!is_null($order->tip_amount)) {
                        $payable = $order->payable - $order->tip_amount;
                    } else {
                        $payable = $order->payable;
                    }
                @endphp
                @if($order->payable != NULL)
                    <tr class="top">
                        <td colspan="2"><b>{{ __('storeDashboard.ovPayable') }}</b></td>
                        <td align="right"><b> {{ config('appSettings.currencyFormat') }}{{ $payable }}</b></td>
                    </tr>
                @endif


                <tr>
                    <th class="top" colspan="3">
                        <br/><b>{{__('storeDashboard.ovPaymentMode')}}:</b><br/>{{ $order->payment_mode }}
                    </th>
                </tr>

                @if(!$order->order_comment == NULL)
                <tr>
                    <th class="top" colspan="3">
                        <br/><b>{{__('storeDashboard.ovCommentSuggestion')}}:</b><br/>
                        {{ $order->order_comment }}
                    </th>
                </tr>                           
                @endif
            </thead>
        </table>
    </div>                
</div> 

 <script>
   window.onload = function() {
    document.getElementById("printButton").click();
    //window.history.back();
   }

    $('#printButton').on('click',function(){
        $('#ticket_imprimir').printThis({
            removeScripts: true,
            pageTitle: "&nbsp;", 
            importCSS: false,
            loadCSS:'<style type="text/css">' +
					'table th, table td {' +
					'border:0px solid #000;' +
					'padding;0;' +
					'}' +
					'</style>'});
    })

    //on single click, accpet order and disable button
    $('body').on("click", ".acceptOrderBtn", function(e) {
        $(this).addClass('pointer-none');
    });
    
    //on Single click donot cancel order
    $('body').on("click", ".cancelOrderBtn", function(e) {
        return false;
    });
    
    //cancel order on double click
    $('body').on("dblclick", ".cancelOrderBtn", function(e) {
        $(this).addClass('pointer-none');
        window.location = this.href;
        return false;
     });

     function printFunc() {
				var divToPrint = document.getElementById('ticket_imprimir');
				var htmlToPrint = '' +
					'<style type="text/css">' +
					'table th, table td {' +
					'border:0px solid #000;' +
					'padding;0;' +
					'}' +
					'</style>';
				htmlToPrint += divToPrint.outerHTML;
				newWin = window.open("");
				newWin.document.write(htmlToPrint);
				newWin.document.write("&nbsp;<br>");
				newWin.document.write("&nbsp;<br>");
				newWin.document.write("&nbsp;<br>");
				newWin.document.write("&nbsp;<br>");				
				newWin.document.write("&nbsp;<br>");
				newWin.print();
				newWin.close();
			}				      
</script>
@endsection
