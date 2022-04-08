@extends('admin.layouts.master')
@section('content')
<div class="page-header">
    <div class="page-header-content header-elements-md-inline">
        <div class="page-title d-flex">
            <h4>
                <span class="font-weight-bold mr-2">Módulos</span>
                <i class="icon-circle-right2 mr-2"></i>
                <span class="font-weight-bold mr-2">Configurações de PDV de Pedidos</span>
            </h4>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
        <div class="header-elements d-none py-0 mb-3 mb-md-0">
            <div class="breadcrumb">
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="card">
        <div class="card-body">
            
            <form action="{{ route('cao.saveSettings') }}" method="POST" enctype="multipart/form-data">

                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="font-weight-semibold text-uppercase font-size-sm mb-0">
                            <i class="icon-phone2 mr-1"></i> Configurações de PDV de Pedidos
                        </h3>
                    </div>
                    <div>
                        <div class="float-right">
                            <a href="#" target="_blank" class="btn btn-warning btn-md">
                                <i class="icon-file-text2 mr-1"></i> Peça ajuda ao suporte
                            </a>
                        </div>
                    </div>
                </div>
                <hr>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label"><strong>Proprietários de Lojas</strong></label>
                    <div class="col-lg-9">
                        <select class="form-control select storeOwnerSelect" name="user_id[]" multiple="multiple" id="storeOwnerSelect">
                            @foreach ($storeOwners as $storeOwner)
                            <option value="{{ $storeOwner->id }}" class="text-capitalize" {{ isset($storeOwner) && in_array($storeOwner->id, $storeOwnersIdsWithPermission) ? 'selected' : '' }}>{{ $storeOwner->name }}</option>
                            @endforeach
                        </select>
                        <input type="checkbox" id="selectAllStoreOwners"><span class="ml-1">Selecionar todos os Proprietários</span>

                        <div class="mt-2">
                            <small>Selecione os proprietários da loja que terão permissão para receber pedidos sob reserva apenas por <b>Novos usuários (Guest Checkout)</b></small> <br>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label"><strong>Permitir que o proprietário da loja faça login para clientes registrados
                    </strong></label>
                    <div class="col-lg-9">
                        <div class="checkbox checkbox-switchery mt-2">
                            <label>
                            <input value="true" type="checkbox" class="switchery-primary"
                            @if(config('appSettings.allowStoreOwnersPlaceLoginOrders') == "true") checked="checked" @endif
                            name="allowStoreOwnersPlaceLoginOrders">
                            </label>
                            <br>
                            <b class="text-danger">Tenha muito cuidado se precisar habilitar esta função.</b><br>
                            <small>Por padrão, apenas o <b>Admin</b> e a equipe com a permissão de <b>Login dos clientes</b> têm permissão para acessar os dados do cliente registrado para fazer o login. Se esta opção for ativada, os proprietários da loja selecionados também serão capazes de visualizar e acessar o login do cliente registrado</small>
                            
                        </div>
                    </div>
                </div>
                
            @csrf
            <div class="text-right">
                <button type="submit" class="btn btn-primary btn-labeled btn-labeled-left btn-lg">
                <b><i class="icon-database-insert ml-1"></i></b>
                Salvar Configurações
                </button>
            </div>
            </form>

        </div>
    </div>
</div>

<script>
    "use strict";
    $(function() {
        var elems = document.querySelectorAll('.switchery-primary');
        for (var i = 0; i < elems.length; i++) {
            var switchery = new Switchery(elems[i], { color: '#8360c3' });
        }

        $('.storeOwnerSelect').select2({
            closeOnSelect: false
        })

        $("#selectAllStoreOwners").click(function(){
            if($("#selectAllStoreOwners").is(':checked') ){
                $("#storeOwnerSelect > option").prop("selected","selected");
                $("#storeOwnerSelect").trigger("change");
            }else{
                $("#storeOwnerSelect > option").removeAttr("selected");
                 $("#storeOwnerSelect").trigger("change");
             }
        });
    })
</script>
@endsection