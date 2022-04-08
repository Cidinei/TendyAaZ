@extends('admin.layouts.master')
@section("title") Order - Dashboard
@endsection
@section('content')
<style>
    .content-wrapper {
        overflow: hidden;
    }
    .bill-calc-table tr td {
        padding: 6px 80px;
    }
    @media (min-width: 320px) and (max-width: 767px) {
        .bill-calc-table tr td {
            padding: 6px 50px;
        }
    }
    .td-title {
        padding-left: 15px !important;
    }
    .td-data {
        padding-right: 15px !important;
    }
</style>
<div class="content">
    <div class="row">
        <div class="col-lg-8 mt-4">
            @if(\Nwidart\Modules\Facades\Module::find('ThermalPrinter') && \Nwidart\Modules\Facades\Module::find('ThermalPrinter')->isEnabled())

            <button type="button" class="btn btn-sm btn-secondary my-2 ml-2 thermalPrintButton" disabled="disabled" title="{{__('thermalPrinterLang.connectingToPrinterMessage')}}" style="color: #fff; float: right; border-radius: 8px" data-type="kot"><i class="icon-printer4 mr-1 thermalPrinterIcon"></i> {{__('thermalPrinterLang.printKotWithThermalPrinter')}}</button>

            <button type="button" class="btn btn-sm btn-secondary my-2 ml-2 thermalPrintButton" disabled="disabled" title="{{__('thermalPrinterLang.connectingToPrinterMessage')}}" style="color: #fff; float: right; border-radius: 8px" data-type="invoice"><i class="icon-printer4 mr-1 thermalPrinterIcon"></i> {{__('thermalPrinterLang.printInvoiceWithThermalPrinter')}}</button>

            <input type="hidden" id="thermalPrinterCsrf" value="{{ csrf_token() }}">
            <script>
                var socket = null;
                var socket_host = 'ws://127.0.0.1:6441';

                initializeSocket = function() {
                    try {
                        if (socket == null) {
                            socket = new WebSocket(socket_host);
                            socket.onopen = function() {};
                            socket.onmessage = function(msg) {
                                let message = msg.data;
                                $.jGrowl("", {
                                    position: 'bottom-center',
                                    header: message,
                                    theme: 'bg-danger',
                                    life: '5000'
                                });
                            };
                            socket.onclose = function() {
                                socket = null;
                            };
                        }
                    } catch (e) {
                        console.log("ERROR", e);
                    }

                    var checkSocketConnecton = setInterval(function() {
                        if (socket == null || socket.readyState != 1) {
                            $('.thermalPrintButton').attr({
                                disabled: 'disabled',
                                title: '{{__('thermalPrinterLang.connectingToPrinterFailedMessage')}}'
                            });
                        }
                        if (socket != null && socket.readyState == 1) {
                             $('.thermalPrintButton').removeAttr('disabled').removeAttr('title');
                        }
                        clearInterval(checkSocketConnecton);
                    }, 500)
                };

                initializeSocket();

                $('.thermalPrintButton').click(function(event) {
                    $('.thermalPrinterIcon').removeClass('icon-printer').addClass('icon-spinner10 spinner');
                    let printButton = $('.thermalPrintButton');
                    printButton.attr('disabled', 'disabled');
                    let printType = $(this).data("type");

                    let order_id = '{{ $order->id }}';
                    let token = $('#thermalPrinterCsrf').val();

                    $.ajax({
                        url: '{{ route('thermalprinter.getOrderData') }}',
                        type: 'POST',
                        dataType: 'JSON',
                        data: {order_id: order_id, _token: token, print_type: printType },
                    })
                    .done(function(response) {
                        let content = {};
                        content.type = 'print-receipt';
                        content.data = response;
                        let sendData = JSON.stringify(content);
                        if (socket != null && socket.readyState == 1) {
                                socket.send(sendData);
                                $.jGrowl("", {
                                    position: 'bottom-center',
                                    header: '{{__('thermalPrinterLang.printCommandSentMessage')}}',
                                    theme: 'bg-success',
                                    life: '3000'
                                });
                                setTimeout(function() {
                                    $('.thermalPrinterIcon').removeClass('icon-spinner10 spinner').addClass('icon-printer');
                                    printButton.removeAttr('disabled');
                                }, 1000);
                            } else {
                                initializeSocket();
                                setTimeout(function() {
                                    socket.send(sendData);
                                    $.jGrowl("", {
                                        position: 'bottom-center',
                                        header: '{{__('storeDashboard.printCommandSentMessage')}}',
                                        theme: 'bg-success',
                                        life: '5000'
                                    });
                                }, 700);
                            }
                    })
                    .fail(function() {
                        alert("ERROR")
                    })
                });
            </script>
            @endif

            <a href="javascript:void(0)" id="printButton" class="btn btn-sm btn-primary my-2" style="color: #fff; border: 1px solid #ccc; float: right;border-radius: 8px;"><i class="icon-printer mr-1"></i> Print Bill</a>
            <a href="{{ route('admin.printThermalBill', $order->unique_order_id) }}" id="printButton" class="btn btn-sm btn-success my-2 mx-2" style="color: #fff; border: 1px solid #ccc; float: right;border-radius: 8px;"><i class="icon-printer mr-1"></i> Print Thermal Bill</a>
            <div class="clearfix"></div>
            <div class="card" id="printThis">
                <div href="#" class="btn btn-block content-group" style="text-align: left; background-color: #8360c3; color: #fff; border-radius: 8px 8px 0 0;"><strong style="font-size: 1.2rem;">{{ $order->unique_order_id }}</strong>
                </div>
                <div class="p-3">

                    <div class="d-flex justify-content-between">
                        <div class="form-group mb-0">
                            <h3><strong>{{ $order->restaurant->name }}</strong></h3>
                        </div>
                        <div class="form-group mb-0">
                            <label class="control-label no-margin text-semibold mr-1"><strong>Data do Pedido:</strong></label>
                            {{ $order->created_at->format('Y-m-d  - h:i A')}} 
                        </div>
                    </div>

                    <hr>

                    <div>
                        <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="control-label no-margin text-semibold mr-1"><strong><h5 class="font-weight-bold">Customer Details</h5></strong></label>
                                <br>
                                <p><b>Nome: </b> {{ $order->user->name }}</p>
                                <p><b>Email: </b> {{ $order->user->email }}</p>
                                <p><b>Número: </b> {{ $order->user->phone }}</p>

                                @if($order->delivery_type == 1)
                                <p><b>Endereço de entrega: </b> {{ $order->address }}</p>
                                @endif

                                @if($order->user->tax_number != NULL)
                                <p><b>Taxa: </b> {{ strtoupper($order->user->tax_number) }}</p>
                                @endif

                                @if($order->order_comment != NULL)
                                    <p><b>Comentários/Sugestões : </b> {{ $order->order_comment }}</p>
                                @endif

                            </div>
                        </div>

                        <div class="col-md-6 col-sm-12">
                            <div class="form-group mb-1">
                                <div class="d-flex justify-content-center align-items-center flex-column mb-1" style="border: 1px solid #ddd;">
                                    <div class="py-1" style="font-weight: 900;">STATUS</div>
                                    <hr style="width: 100%;" class="m-0">
                                    <div class="py-1 text-success @if ($order->orderstatus_id == 6) text-danger @endif" style="font-weight: 500;">
                                        @if ($order->orderstatus_id == 1) Pedido Feito @endif
                                        @if ($order->orderstatus_id == 2) Pedido Aceito @endif
                                        @if ($order->orderstatus_id == 3) Entregador Atribuído @endif
                                        @if ($order->orderstatus_id == 4) Entregador Pegou @endif
                                        @if ($order->orderstatus_id == 5) Completo @endif
                                        @if ($order->orderstatus_id == 6) Cancelado @endif
                                        @if ($order->orderstatus_id == 7) Pronto para Retirada @endif
                                        @if ($order->orderstatus_id == 8) Aguardando Pagamento @endif
                                        @if ($order->orderstatus_id == 9) Pagamento Falhou @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-1 mt-2">
                                <div class="d-flex">
                                    <div class="col p-0 mr-2">
                                    <div class="d-flex justify-content-center align-items-center flex-column mb-1" style="border: 1px solid #ddd;">
                                        <div class="py-1" style="font-weight: 900;">Tipo de Pedido</div>
                                        <hr style="width: 100%;" class="m-0">
                                        <div class="py-1 text-warning" style="font-weight: 500;">
                                            @if($order->delivery_type == 1)
                                                Delivery
                                            @else
                                                Retirada
                                            @endif
                                        </div>
                                    </div>
                                    </div>
                                    <div class="col p-0">
                                    <div class="d-flex justify-content-center align-items-center flex-column mb-1" style="border: 1px solid #ddd;">
                                        <div class="py-1" style="font-weight: 900;">Modo de Pagamento</div>
                                        <hr style="width: 100%;" class="m-0">
                                        <div class="py-1 text-warning" style="font-weight: 500;">
                                        @if($order->payment_mode == "COD")
    DINHEIRO
 @elseif($order->payment_mode == "WALLET")
     CARTEIRA VIRTUAL
 @else
     {{ $order->payment_mode }}
 @endif
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        </div>
                    </div>
                    

                    @php
                    $subTotal = 0;
                    function calculateAddonTotal($addons) {
                        $total = 0;
                        foreach ($addons as $addon) {
                            $total += $addon->addon_price;
                        }
                        return $total;
                    }
                    @endphp
                    <div class="text-right mt-3">
                        <div class="form-group mb-2">
                            <div class="clearfix"></div>
                            <div class="row">
                                <div class="col-md-12 p-2 mb-3" style="background-color: #f7f8fb; float: right; text-align: left;">
                                    @foreach($order->orderitems as $item)
                                    <div>
                                        <div class="d-flex mb-1 align-items-start" style="font-size: 1.2rem;">
                                            <span class="badge badge-flat border-grey-800 text-default mr-2">{{ $item->quantity }}x</span>
                                            <strong class="mr-1" style="width: 100%;">{{ $item->name }}</strong>
                                            @php
                                            $itemTotal = ($item->price +calculateAddonTotal($item->order_item_addons)) * $item->quantity;
                                            $subTotal = $subTotal + $itemTotal;
                                            @endphp
                                            <span class="badge badge-flat border-grey-800 text-default">{{ config('appSettings.currencyFormat') }}{{ $itemTotal }}</span>
                                        </div>
                                        @if(count($item->order_item_addons))
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Categoria</th>
                                                        <th>Adicionais</th>
                                                        <th>Valor</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($item->order_item_addons as $addon)
                                                    <tr>
                                                        <td>{{ $addon->addon_category_name }}</td>
                                                        <td>{{ $addon->addon_name }}</td>
                                                        <td>{{ config('appSettings.currencyFormat') }}{{ $addon->addon_price }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        @endif
                                        @if(!$loop->last)
                                        <div class="mb-2" style="border-bottom: 2px solid #dcdcdc;"></div>
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        
                        <div class="clearfix"></div>

                        <div class="float-right">
                            <table class="table table-bordered table-striped bill-calc-table">

                                <tr>
                                    <td class="text-left td-title">SubTotal</td>
                                    <td class="td-data"> {{ config('appSettings.currencyFormat') }}{{ $subTotal }}</td>
                                </tr>

                                @if($order->coupon_name != NULL)
                                    <tr>
                                        <td class="text-left td-title">Cupom</td>
                                        <td class="td-data"> {{ $order->coupon_name }} @if($order->coupon_amount != NULL) ({{ config('appSettings.currencyFormat') }}{{ $order->coupon_amount }}) @endif </td>
                                    </tr>
                                @endif

                                @if($order->restaurant_charge != NULL)
                                <tr>
                                    <td class="text-left td-title">Taxa da Loja</td>
                                    <td class="td-data"> {{ config('appSettings.currencyFormat') }}{{ $order->restaurant_charge }} </td>
                                </tr>
                                @endif

                                <tr>
                                    <td class="text-left td-title">Taxa de Entrega</td>
                                    <td class="td-data"> {{ config('appSettings.currencyFormat') }}{{ $order->delivery_charge }} </td>
                                </tr>

                                @if($order->tax != NULL)
                                    <tr>
                                        <td class="text-left td-title">Taxas</td>
                                        <td class="td-data">{{ $order->tax }}% @if($order->tax_amount != NULL) ({{ config('appSettings.currencyFormat') }}{{ $order->tax_amount }}) @endif </td>
                                    </tr>
                                @endif

                                @if(!$order->tip_amount == NULL)
                                    <tr>
                                        <td class="text-left td-title">Gorjeta</td>
                                        <td class="td-data">{{ config('appSettings.currencyFormat') }}{{ $order->tip_amount }}</td>
                                    </tr>
                                @endif

                                @if($order->wallet_amount != NULL)
                                    <tr>
                                        <td class="text-left td-title">Pago com {{ config('appSettings.walletName') }}</td>
                                        <td class="td-data"> {{ config('appSettings.currencyFormat') }}{{ $order->wallet_amount }} </td>
                                    </tr>
                                @endif

                                <tr>
                                    <td class="text-left td-title"><b>TOTAL</b></td>
                                    <td class="td-data"> {{ config('appSettings.currencyFormat') }}{{ $order->total }} </td>
                                </tr>

                                @if($order->payable != NULL)
                                    <tr>
                                        <td class="text-left td-title">A pagar</td>
                                        <td class="td-data"><b> {{ config('appSettings.currencyFormat') }}{{ $order->payable }}</b></td>
                                    </tr>
                                @endif

                            </table>
                        </div>

                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-5">
            <div style="margin-top: 5.2rem"></div>
            @if($order->rating)
            <div class="card">
                <div class="card-body">
                    <p class="text-center mb-3"><b>Classificação e avaliação</b></p>
                    <div>
                        <p> <b>Avaliação do Entregador </b> <span class="ml-1 badge badge-flat text-white {{ ratingColorClass($order->rating->rating_delivery) }}">{{ $order->rating->rating_delivery }} <i class="icon-star-full2 text-white" style="font-size: 0.6rem;"></i></span></p>
                        
                        <p>{{ $order->rating->review_delivery }}</p>
                        <hr>
                        <p> <b>Avaliação da Loja </b>  <span class="ml-1 badge badge-flat text-white {{ ratingColorClass($order->rating->rating_store) }}">{{ $order->rating->rating_store }} <i class="icon-star-full2 text-white" style="font-size: 0.6rem;"></i></span> </p>
                       
                        <p>{{ $order->rating->review_store }}</p>
                    </div>
                </div>
            </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <p class="text-center mb-3"><b>Pin de Segurança: {{ $order->user->delivery_pin }}</b></p>
                    <hr>
                    <div class="text-center">
                        @if($order->orderstatus_id ==5 )
                            <h4 class="mb-0"><b>Pedido completado em:</b></h4>
                            <span>{{ timeStrampDiffFormatted($order->created_at, $order->updated_at) }}</span>
                        @elseif($order->orderstatus_id ==6)
                            <h4 class="mb-0"><b>Pedido cancelado em:</b></h4>
                            <span>{{ timeStrampDiffFormatted($order->created_at, $order->updated_at) }}</span>
                        @else
                            <h4 class="mb-0"><b>Pedido em andamento</b></h4>
                            <span class="liveTimerNonCompleteOrder"></span>
                        @endif
                    </div>
                    <hr>

                    @if($order->orderstatus_id != 5 && $order->orderstatus_id != 6)
                        <h3 class="text-center"> <strong> Ações do Pedido </strong> </h3>
                        <hr class="mt-1">
                    @endif
                    
                    <div class="form-group d-flex justify-content-center">
                        @if($order->orderstatus_id == 1) 
                        <form action="{{ route('admin.acceptOrderFromAdmin') }}" class="mr-1" method="POST">
                            <input type="hidden" name="id" value="{{ $order->id }}">
                            @csrf
                            <button 
                                class="btn btn-primary btn-labeled btn-labeled-left mr-1"> <b><i
                                class="icon-checkmark3 ml-1"></i> </b> Aceitar Pedido </button>
                        </form>
                        @endif  
                        @if($order->orderstatus_id == 1 || $order->orderstatus_id == 2 || $order->orderstatus_id == 3 || $order->orderstatus_id == 4 || $order->orderstatus_id == 7 || $order->orderstatus_id == 8 || $order->orderstatus_id == 9) 
                        <a href="javascript:void(0)" class="btn btn-danger btn-labeled dropdown-toggle" data-toggle="dropdown">
                        Cancelar Pedido
                        </a>
                        <div class="dropdown-menu">
                            <form action="{{ route('admin.cancelOrderFromAdmin') }}" method="POST">
                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                <input type="hidden" name="refund_type" value="NOREFUND">
                                @csrf
                                <button class="dropdown-item" @if($order->wallet_amount) type="submit" data-popup="tooltip" data-placement="bottom" title="{{ config('appSettings.currencyFormat') }}{{ $order->wallet_amount }} will be refunded as user has paid @if($order->payment_mode != "WALLET") partially @endif with Wallet" @endif>
                                Cancelar Pedido
                                </button>
                            </form>
                            <form action="{{ route('admin.cancelOrderFromAdmin') }}" method="POST">
                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                <input type="hidden" name="refund_type" value="FULL">
                                @csrf
                                <button class="dropdown-item" type="submit" data-popup="tooltip" data-placement="bottom" title="Full refund of {{ config('appSettings.currencyFormat') }}{{ $order->total }} will be refunded to users wallet. (Even if user has not made any payment)">
                                Cancelar com reembolso total
                                </button>
                            </form>
                            <form action="{{ route('admin.cancelOrderFromAdmin') }}" method="POST">
                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                <input type="hidden" name="refund_type" value="HALF">
                                @csrf
                                <button class="dropdown-item" type="submit" data-popup="tooltip" data-placement="bottom" title="Half refund of {{ config('appSettings.currencyFormat') }}{{ $order->total/2 }} will be refunded to users wallet. (Even if user has not made any payment)">
                                Cancelar com meio reembolso
                                </button>
                            </form>
                        </div>
                        @endif
                        @if($order->orderstatus_id == 8)
                        <a href="{{ route('admin.approvePaymentOfOrder', $order->id) }}" class="btn btn-secondary ml-2 approvePayment" data-popup="tooltip" data-placement="bottom" title="Double Click to Approve Payment">
                            Aprovar Pagamento
                        </a>
                        @endif
                    </div>
                    @if($order->delivery_type==1)
                        @if($order->orderstatus_id ==  1 || $order->orderstatus_id ==  2) 
                            <label class="control-label no-margin text-semibold mr-1"><strong>Atribuir entregador</strong></label>
                            <form action="{{route('admin.assignDeliveryFromAdmin')}}" method="POST">
                                <input type="text" hidden value="{{$order->id}}" name="order_id">
                                <input type="text" hidden value="{{$order->user->id}}" name="customer_id">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <select class="form-control select" data-fouc  name="user_id" required="required">
                                            <option></option>
                                            @foreach ($users as $user)
                                            @if ($user->hasRole('Delivery Guy'))
                                            <option value="{{$user->id}}" @if(!$user->delivery_guy_detail) disabled="disabled" @endif>{{$user->name}}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <br>
                                    <div class="col-lg-12 mt-1 text-right float-right">
                                        <button type="submit" class="btn btn-secondary mr-1">
                                        Atribuir entregador
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @endif
                    @endif 
                    
                    @if($order->delivery_type==1)
                        @if($order->orderstatus_id == 3 || $order->orderstatus_id == 4)
                           @if($order->accept_delivery && $order->accept_delivery->user && $order->accept_delivery->user->name)
                           <p class="text-center mb-2"> <strong>Assigned Delivery Guy: {{ $order->accept_delivery->user->name }}</strong></p>
                           @endif
                           

                            <form action="{{route('admin.reAssignDeliveryFromAdmin')}}" method="POST">
                                <input type="text" hidden value="{{$order->id}}" name="order_id">
                                <input type="text" hidden value="{{$order->user->id}}" name="customer_id">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <select class="form-control select" data-fouc name="user_id" required="required">
                                            <option></option>
                                            @foreach ($users as $user)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-12 mt-2 text-center">
                                        <button type="submit" class="btn btn-secondary">
                                        Re-atribuir entregador
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @endif
                    @endif

                    @if($order->orderstatus_id == 5 || $order->orderstatus_id == 6)
                        @if($order->accept_delivery && $order->accept_delivery->user && $order->accept_delivery->user->name)
                            <p class="text-center mb-3"> <strong>Assigned Delivery Guy: {{ $order->accept_delivery->user->name }}</strong></p>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    $(function() {
        var orderCreatedData = "{{ $order->created_at }}";
        var startDateTime = new Date(orderCreatedData); 
        var startStamp = startDateTime.getTime();

        var newDate = new Date();
        var newStamp = newDate.getTime();

        var timer; // for storing the interval (to stop or pause later if needed)

        function updateClock() {
            newDate = new Date();
            newStamp = newDate.getTime();
            var diff = Math.round((newStamp-startStamp)/1000);
            
            var d = Math.floor(diff/(24*60*60)); /* though I hope she won't be working for consecutive days :) */
            diff = diff-(d*24*60*60);
            var h = Math.floor(diff/(60*60));
            diff = diff-(h*60*60);
            var m = Math.floor(diff/(60));
            diff = diff-(m*60);
            var s = diff;
            var checkDay = d > 0 ? true : false;
            var checkHour = h > 0 ? true : false;
            var checkMin = m > 0 ? true : false;
            var checkSec = s > 0 ? true : false;
            var formattedTime = checkDay ? d+ " day" : "";
            formattedTime += checkHour ? " " +h+ " hour" : "";
            formattedTime += checkMin ? " " +m+ " minute" : "";
            formattedTime += checkSec ? " " +s+ " second" : "";

            $('.liveTimerNonCompleteOrder').text(formattedTime);
        }

        timer = setInterval(updateClock, 1000);
            

            $('#printButton').on('click',function(){
                $('#printThis').printThis();
            })
            
             $('.select').select2({
                 placeholder: 'Selecionar Entregador',
                allowClear: true,
             }); 

             $('body').on("click", ".approvePayment", function(e) {
                 return false;
             });
             $('body').on("dblclick", ".approvePayment", function(e) {
                 window.location = this.href;
                 return false;
             });
    });
    
</script>
@endsection