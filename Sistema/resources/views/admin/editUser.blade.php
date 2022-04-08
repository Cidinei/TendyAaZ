@extends('admin.layouts.master')
@section("title") Editar Usuário - Dashboard
@endsection
@section('content')
<style>
    #showPassword {
    cursor: pointer;
    padding: 5px;
    border: 1px solid #E0E0E0;
    border-radius: 0.275rem;
    color: #9E9E9E;
    }
    #showPassword:hover {
    color: #616161;
    }
</style>
<div class="page-header">
    <div class="page-header-content header-elements-md-inline">
        <div class="page-title d-flex">
            <h4><i class="icon-circle-right2 mr-2"></i>
                <span class="font-weight-bold mr-2">Editando</span>
                <i class="icon-circle-right2 mr-2"></i>
                <span class="font-weight-bold mr-2">{{ $user->name }}</span>
            </h4>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>


<div class="content">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body" style="min-height: 60vh;">
                <form action="{{ route('admin.updateUser') }}" method="POST" enctype="multipart/form-data" id="storeMainForm" style="min-height: 60vh;">
                    @csrf
                    <input type="hidden" name="window_redirect_hash" value="">
                    <input type="hidden" name="id" value="{{ $user->id }}">

                    <div class="text-right">
                        <button type="submit" class="btn btn-primary btn-labeled btn-labeled-left btn-lg btnUpdateUser">
                        <b><i class="icon-database-insert ml-1"></i></b>
                        Atualizar Usuário
                        </button>
                    </div>

                    <div class="d-lg-flex justify-content-lg-left">
                        <ul class="nav nav-pills flex-column mr-lg-3 wmin-lg-250 mb-lg-0">
                            <li class="nav-item">
                                <a href="#userDetails" class="nav-link active" data-toggle="tab">
                                <i class="icon-store2 mr-2"></i>
                                Detalhes do Usuário
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#userRole" class="nav-link" data-toggle="tab">
                                <i class="icon-tree7 mr-2"></i>
                                Função do Usuário
                                </a>
                            </li>
                            @if($user->hasRole("Delivery Guy"))
                            <li class="nav-item">
                                <a href="#deliveryGuyDetails" class="nav-link" data-toggle="tab">
                                <i class="icon-truck mr-2"></i>
                                Detalhes do Entregador
                                </a>
                            </li>
                            @endif
                            <li class="nav-item">
                                <a href="javascript:void(0)" class="nav-link" data-toggle="tab" id="walletBalance">
                                <i class="icon-piggy-bank mr-2"></i>
                                Saldo da Carteira
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#walletTransactions" class="nav-link" data-toggle="tab">
                                <i class="icon-transmission mr-2"></i>
                                Transações na Carteira
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#userOrders" class="nav-link" data-toggle="tab">
                                <i class="icon-basket mr-2"></i>
                                Pedidos
                                </a>
                            </li>
                            @if($user->hasRole("Delivery Guy"))
                            <li class="nav-item">
                                <a href="{{ route('admin.viewDeliveryReviews', $user->id) }}" class="nav-link">
                                <i class="icon-stars mr-2"></i>
                                Classificações e Avaliações <span class="ml-1 badge badge-flat text-white {{ ratingColorClass($rating) }}">{{ $rating }} <i class="icon-star-full2 text-white" style="font-size: 0.6rem;"></i></span>
                                </a>
                            </li>
                            @endif
                        </ul>
                        <div class="tab-content" style="width: 100%; padding: 0 25px;">

                            <div class="tab-pane fade show active" id="userDetails">
                                <legend class="font-weight-semibold text-uppercase font-size-sm">
                                    Detalhes do Usuário
                                </legend>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Nome:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control form-control-lg" name="name"
                                            value="{{ $user->name }}" placeholder="Nome completo" required
                                            autocomplete="new-name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Email:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control form-control-lg" name="email"
                                            value="{{ $user->email }}" placeholder="Endereço de email" required
                                            autocomplete="new-email">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Telefone:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control form-control-lg" name="phone" value="{{ $user->phone }}" 
                                            placeholder="Número de telefone" required autocomplete="new-phone">
                                    </div>
                                </div>
                                <div class="form-group row form-group-feedback form-group-feedback-right">
                                    <label class="col-lg-3 col-form-label">Senha:</label>
                                    <div class="col-lg-9">
                                        <input id="passwordInput" type="password" class="form-control form-control-lg"
                                            name="password" placeholder="Senha (min 6 caracteres)"
                                            autocomplete="new-password">
                                    </div>
                                    <div class="form-control-feedback form-control-feedback-lg">
                                        <span id="showPassword"><i class="icon-unlocked2"></i> Mostrar</span>
                                    </div>
                                </div>

                                <div class="text-left">
                                    <div class="btn-group btn-group-justified" style="width: 150px">
                                        @if($user->is_active)
                                        <a class="btn btn-danger" href="{{ route('admin.banUser', $user->id) }}" data-popup="tooltip" title="User will not be able to place orders if banned">
                                            Banir Usuário
                                            <i class="icon-switch2 ml-1"></i>
                                        </a>
                                        @else
                                        <a class="btn btn-primary" href="{{ route('admin.banUser', $user->id) }}" data-popup="tooltip" title="Currently, {{ $user->name }} is banned from placing any orders">
                                            Reativar Usuário
                                            <i class="icon-switch2 ml-1"></i>
                                        </a>
                                        @endif
                                    </div>
                                </div>

                                <p class="mt-2">IP do usuário usado durante o registro: @if($user->user_ip != null) <b>{{ $user->user_ip }}</b> @else IP Not found @endif </p> 
                                
                            </div>

                            <div class="tab-pane fade" id="userRole">
                                <legend class="font-weight-semibold text-uppercase font-size-sm">
                                    Gerenciar Função
                                </legend>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Função atual:</label>
                                    <div class="col-lg-9">
                                        @foreach ($user->roles as $role)
                                        <span class="badge badge-flat border-grey-800 text-default text-capitalize font-size-lg">
                                        {{ $role->name }}
                                        </span> @endforeach
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Nova função:</label>
                                    <div class="col-lg-9">
                                        @if($user->id == "1")
                                        <span>A função de superadministrador não pode ser alterada</span>
                                        @else
                                        <select class="form-control select" data-fouc name="roles">
                                            <option></option>
                                            @foreach ($roles as $key => $role)
                                            @if($key != 1)
                                                <option value="{{ $role->name }}" class="text-capitalize">{{ $role->name }}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            @if($user->hasRole("Delivery Guy"))
                            <div class="tab-pane fade" id="deliveryGuyDetails">
                                <legend class="font-weight-semibold text-uppercase font-size-sm">
                                    Detalhes do Entregador
                                </legend>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Nome:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control form-control-lg" name="delivery_name"
                                            value="{{ !empty($user->delivery_guy_detail->name) ? $user->delivery_guy_detail->name : "" }}" placeholder="Nome do entregador" required
                                            autocomplete="new-name">
                                            <span class="help-text text-muted">Este nome será exibido para o usuário / clientes</span>
                                    </div>
                                    
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Data de nascimento</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control form-control-lg" name="delivery_age"
                                            value="{{ !empty($user->delivery_guy_detail->age) ? $user->delivery_guy_detail->age : "" }}" placeholder="Digite a data de nascimento">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    @if(!empty($user->delivery_guy_detail->photo))
                                    <div class="col-lg-9 offset-lg-3">
                                        <img src="{{ substr(url('/'), 0, strrpos(url('/'), '/')) }}/assets/img/delivery/{{ $user->delivery_guy_detail->photo }}" alt="delivery-photo" class="img-fluid mb-2" style="width: 90px; border-radius: 50%">
                                    </div>
                                    @endif
                                    <label class="col-lg-3 col-form-label">Foto do entregador:</label>
                                    <div class="col-lg-9">
                                        <input type="file" class="form-control-uniform" name="delivery_photo" data-fouc>
                                        <span class="help-text text-muted">Dimensão da imagem 250x250px</span>
                                    </div>
                                </div>
                                 <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Placa do Veículo</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control form-control-lg" name="delivery_description"
                                            value="{{ !empty($user->delivery_guy_detail->description) ? $user->delivery_guy_detail->description : "" }}" placeholder="Digite a placa do veículo se necessário">
                                    </div>
                                </div>
                                 <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Tipo de veículo</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control form-control-lg" name="delivery_vehicle_number"
                                            value="{{ !empty($user->delivery_guy_detail->vehicle_number) ? $user->delivery_guy_detail->vehicle_number : "" }}" placeholder="Carro / Moto / Bike">
                                    </div>
                                </div>
                                <!-- <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Notificações de sms para?</label>
                                    <div class="col-lg-9">
                                        <div class="checkbox checkbox-switchery mt-2">
                                            <label>
                                            <input value="true" type="checkbox" class="switchery-primary"
                                            @if(!empty($user->delivery_guy_detail->is_notifiable) && $user->delivery_guy_detail->is_notifiable) checked="checked" @endif name="is_notifiable">
                                            </label> -->
                                        </div>
                                    </div>
                                </div>

                                <!-- Módulo DeliveryRadiusPRO -->
                                @if (\Module::find("DeliveryRadiusPro") && \Module::find("DeliveryRadiusPro")->isEnabled())
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Raio de entrega em km</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control form-control-lg" name="delivery_radius" placeholder="Raio em km" value="<?=!empty($user->delivery_guy_detail->delivery_radius) ? $user->delivery_guy_detail->delivery_radius : "0"?>">
                                            <span class="help-text text-muted">Distância máxima do endereço da loja para visualizar e aceitar corridas. Deixe 0 para sem limites.</span>
                                        </div>
                                    </div>
                                @endif
                                <!-- Módulo DeliveryRadiusPRO -->

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Taxa de comissão %</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control form-control-lg commission_rate" name="delivery_commission_rate" placeholder="Geralmente 100%" value="{{  !empty($user->delivery_guy_detail->commission_rate) ? $user->delivery_guy_detail->commission_rate : "0" }}" required="required">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Limite de dinheiro em mãos ({{ config('appSettings.currencyFormat') }})</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control form-control-lg cash_limit" name="cash_limit" value="{{  !empty($user->delivery_guy_detail->cash_limit) ? $user->delivery_guy_detail->cash_limit : "0" }}" />
                                        <p>Insira um valor após o qual você não deseja que o entregador receba nenhum pedido. <strong><mark>Deixe 0 para sem limites.</mark></strong></p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Máximo de pedidos na fila</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control form-control-lg max_orders" name="max_accept_delivery_limit" placeholder="Máximo de pedidos na fila" value="{{  !empty($user->delivery_guy_detail->max_accept_delivery_limit) ? $user->delivery_guy_detail->max_accept_delivery_limit : "100" }}" required="required">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Comissão da gorjeta %</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control form-control-lg commission_rate" name="tip_commission_rate" placeholder="Geralmente 100%" value="{{  !empty($user->delivery_guy_detail->tip_commission_rate) ? $user->delivery_guy_detail->tip_commission_rate : "100" }}" required="required">
                                        </div>
                                </div>
                            </div>
                            @endif

                            <div class="tab-pane fade" id="walletTransactions">
                                <legend class="font-weight-semibold text-uppercase font-size-sm">
                                    Transações na Carteira
                                </legend>
                                @if(count($user->transactions) > 0)
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>
                                                    Tipo
                                                </th>
                                                <th width="20%">
                                                    Valor
                                                </th>
                                                <th>
                                                    Descrição
                                                </th>
                                                <th>
                                                    Data
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($user->transactions->reverse() as $transaction)
                                            <tr>
                                                <td>
                                                    @if($transaction->type === "deposit")
                                                        <span class="badge badge-flat border-grey-800 text-success text-capitalize">{{$transaction->type}}</span>
                                                    @else
                                                        <span class="badge badge-flat border-grey-800 text-danger text-capitalize">{{$transaction->type}}</span>
                                                    @endif
                                                </td>
                                                <td class="text-right">
                                                    {{ config('appSettings.currencyFormat') }} {{ number_format($transaction->amount / 100, 2,'.', '') }}
                                                </td>
                                                <td>
                                                    {{ $transaction->meta["description"] }}
                                                </td>
                                                <td class="small">
                                                   {{ $transaction->created_at->format('m-d-Y  - h:i A')}}  ({{ $transaction->created_at->diffForHumans() }})
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @else
                                <p class="text-muted text-center mb-0">Nenhuma transação foi feita de {{ config('appSettings.walletName') }}</p>
                                @endif   
                            </div>

                            <div class="tab-pane fade" id="userOrders">
                                <legend class="font-weight-semibold text-uppercase font-size-sm">
                                    Pedidos
                                </legend>
                                    @if(count($orders) > 0)
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        ID do Pedido
                                                    </th>
                                                    <th width="20%">
                                                        Status do pedido
                                                    </th>
                                                    <th>
                                                        Data do pedido
                                                    </th>
                                                    <th>
                                                        Total do pedido
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($orders->reverse() as $order)
                                                <tr>
                                                <td>
                                                <a href="{{ route('admin.viewOrder', $order->unique_order_id ) }}">{{$order->unique_order_id}}</a>
                                                
                                                </td>
                                                    <td>
                                                        <span class="badge badge-flat border-grey-800 text-primary @if ($order->orderstatus_id == 6) text-danger @endif text-capitalize">
                                                        @if ($order->orderstatus_id == 1) Pedido Feito @endif
                                                        @if ($order->orderstatus_id == 2) Pedido Aceito @endif
                                                        @if ($order->orderstatus_id == 3) Entregador Atribuído @endif
                                                        @if ($order->orderstatus_id == 4) Entregador pedou @endif
                                                        @if ($order->orderstatus_id == 5) Comcluído @endif
                                                        @if ($order->orderstatus_id == 6) Cancelado @endif
                                                        @if ($order->orderstatus_id == 7) Pronto para Retirada @endif
                                                        @if ($order->orderstatus_id == 8) Aguardando Pagamento @endif
                                                        @if ($order->orderstatus_id == 9) Pagamento Falhou @endif
                                                        @if ($order->orderstatus_id == 10) Pedido Agendado @endif
                                                        </span>
                                                    </td>
                                                  
                                                    <td class="small">
                                                     {{ $order->created_at->format('m-d-Y  - h:i A')}}  ({{ $order->created_at->diffForHumans() }})
                                                    </td>

                                                    <td class="text-right">
                                                      {{ config('appSettings.currencyFormat') }}{{ $order->total }} 
                                                    </td>
                                             </tr>
                                                @endforeach
                                        </tbody>
                                        </table>
                                </div>
                                @else
                                <p class="text-muted text-center mb-0">Nenhum pedido realizado pelo usuário</p>
                                @endif   
                            </div>
                            </div>
                    </div>
                        <div class="text-right mt-5">
                            <button type="submit" class="btn btn-primary btn-labeled btn-labeled-left btn-lg btnUpdateUser">
                            <b><i class="icon-database-insert ml-1"></i></b>
                            Atualizar Usuário
                            </button>
                        </div>
                </form>                
            </div>
        </div>
    </div>
</div>


<div class="content" id="walletBalanceBlock" style="margin-bottom: 10rem;">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <legend class="font-weight-semibold text-uppercase font-size-sm">
                        <i class="icon-piggy-bank mr-2"></i> {{ config("appSettings.walletName") }} Saldo:  <span style="font-size: 1rem;">{{ config('appSettings.currencyFormat') }}{{ $user->balanceFloat }}</span>
                </legend>
                <button class="btn btn-primary btn-labeled btn-labeled-left mr-2" id="addAmountButton"><b><i class="icon-plus2"></i></b> Add Saldo</button>
                <button class="btn btn-secondary btn-labeled btn-labeled-left mr-2" id="substractAmountButton"><b><i class="icon-minus3"></i></b> Retirar Saldo</button>

                <form action="{{ route('admin.addMoneyToWallet') }}" method="POST" id="addAmountForm" class="hidden" style="margin-top: 2rem;">
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                     <div class="form-group row">
                        <label class="col-lg-4 col-form-label"><span class="text-danger">*</span>Add Dinheiro:</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control form-control-lg balance" name="add_amount"
                                placeholder="Valor em {{ config('appSettings.currencyFormat') }}" required>
                        </div>
                    </div>
                     <div class="form-group row">
                        <label class="col-lg-4 col-form-label"><span class="text-danger">*</span>Mensagem:</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control form-control-lg" name="add_amount_description"
                                placeholder="Curta descrição ou mensagem" required>
                        </div>
                    </div>
                    @csrf
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">
                        Atualizar Saldo
                        <i class="icon-database-insert ml-1"></i>
                        </button>
                    </div>
                </form>

                <form action="{{ route('admin.substractMoneyFromWallet') }}" method="POST" id="substractAmountForm" class="hidden" style="margin-top: 2rem;">
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                     <div class="form-group row">
                        <label class="col-lg-4 col-form-label"><span class="text-danger">*</span>Retirar Dinheiro:</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control form-control-lg balance" name="substract_amount"
                                placeholder="Valor em {{ config('appSettings.currencyFormat') }}" required>
                        </div>
                    </div>
                     <div class="form-group row">
                        <label class="col-lg-4 col-form-label"><span class="text-danger">*</span>Mensagem:</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control form-control-lg" name="substract_amount_description"
                                placeholder="Descrição curta ou mensagem" required>
                        </div>
                    </div>
                    @csrf
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">
                        Atualizar Saldo
                        <i class="icon-database-insert ml-1"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {

        if (Array.prototype.forEach) {
                 var elems = Array.prototype.slice.call(document.querySelectorAll('.switchery-primary'));
                 elems.forEach(function(html) {
                     var switchery = new Switchery(html, { color: '#2196F3' });
                 });
             }
             else {
                 var elems = document.querySelectorAll('.switchery-primary');
                 for (var i = 0; i < elems.length; i++) {
                     var switchery = new Switchery(elems[i], { color: '#2196F3' });
                 }
             }
             
        $('.form-control-uniform').uniform();

        $("#showPassword").click(function (e) { 
            $("#passwordInput").attr("type", "text");
        });
        $('.select').select2({
            minimumResultsForSearch: Infinity,
            placeholder: 'Select Role (Old role will be revoked and the new role will be applied)',
        });
        $('.balance').numeric({allowThouSep:false, maxDecimalPlaces: 2 });

        $("#addAmountButton").click(function(event) {
            $('#addAmountButton').hide();
            $('#substractAmountButton').hide();
            $("#addAmountForm").removeClass('hidden');
            $("#substractAmountForm").addClass('hidden');
        });

        $("#substractAmountButton").click(function(event) {
            $('#addAmountButton').hide();
            $('#substractAmountButton').hide();
            $("#addAmountForm").addClass('hidden');
            $("#substractAmountForm").removeClass('hidden');
        });

        $("#viewTransactions").click(function(event) {
            var targetOffset = $('#tansactionsDiv').offset().top - 70;
            $('html, body').animate({scrollTop: targetOffset}, 500);
        });

        $('.commission_rate').numeric({ allowThouSep:false, maxDecimalPlaces: 2, max: 100, allowMinus: false });
        $('.max_orders').numeric({ allowThouSep:false, maxDecimalPlaces: 0, max: 99999, allowMinus: false });
        $('.cash_limit').numeric({allowThouSep:false, maxDecimalPlaces: 2, allowMinus: false });

        /* Navigate with hash */
        var hash = window.location.hash;
        $("[name='window_redirect_hash']").val(hash);
        hash && $('ul.nav a[href="' + hash + '"]').tab('show');
        $('.nav-pills a').click(function (e) {
            $(this).tab('show');
            var scrollmem = $('body').scrollTop();
            window.location.hash = this.hash;
            $("[name='window_redirect_hash']").val(this.hash);
            $('html, body').scrollTop(scrollmem);
        });

        $('#walletBalance').click(function(event) {
            var targetOffset = $('#walletBalanceBlock').offset().top - 70;
            $('html, body').animate({scrollTop: targetOffset}, 500);
        });

        $('.btnUpdateUser').click(function () {
            $('input:invalid').each(function () {
                // Find the tab-pane that this element is inside, and get the id
                var $closest = $(this).closest('.tab-pane');
                var id = $closest.attr('id');

                // Find the link that corresponds to the pane and have it show
                $('ul.nav a[href="#' + id + '"]').tab('show');

                // var hash = '#'+id;
                // window.location.hash = hash;
                // console.log("hash: ", hash)
                // $("[name='window_redirect_hash']").val(hash);

                return false;
            });
        });
    });
</script>
@endsection