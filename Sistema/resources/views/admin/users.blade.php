@extends('admin.layouts.master')
@section("title") Usuário - Dashboard
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


<div class="content mt-3">
    <div class="d-flex justify-content-between my-2">
        <h3><strong> <i class="icon-circle-right2 mr-2"></i>  Todos os Usuáios</strong></h3>
        <div>

            @if(\Nwidart\Modules\Facades\Module::find('CallAndOrder') && \Nwidart\Modules\Facades\Module::find('CallAndOrder')->isEnabled())
                @can("login_as_customer")
                   <button type="button" class="btn btn-secondary btn-labeled btn-labeled-left mr-2" id="manualOrderForGuest">
                   <b><i class="icon-clipboard3"></i></b>
                        Criar Pedido
                   </button>
                @endcan
            @endif
            @can('all_users_edit')
            <button type="button" class="btn btn-secondary btn-labeled btn-labeled-left mr-2" id="addNewUser"
                data-toggle="modal" data-target="#addNewUserModal">
            <b><i class="icon-plus2"></i></b>
            Novo Usuário
            </button>
            @endcan
            @role('Admin')
            <a href="{{ route('admin.rolesManagement') }}" class="btn btn-secondary btn-labeled btn-labeled-left mr-2">
            <b><i class="icon-collaboration"></i></b>
            Grenciar Funções e Permissões
            </a>
            @endrole
            <button type="button" class="btn btn-secondary btn-labeled btn-labeled-left" id="clearFilterAndState"> <b><i class=" icon-reload-alt"></i></b> Reset All Filters</button>
        </div>
    </div>

    @if(Request::is('callandorder/users'))
        @if(config('appSettings.allowStoreOwnersPlaceLoginOrders') == "true")
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                        <table class="table table-striped" id="usersDatatable" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Telefone</th>
                                <th>Função</th>
                                <th>{{ config('appSettings.walletName') }}</th>
                                <th>Data de criação</th>                            
                                <th class="text-center"><i class="
                                    icon-circle-down2"></i></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    @else
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                    <table class="table table-striped" id="usersDatatable" width="100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Telefone</th>
                            <th>Função</th>
                            <th>{{ config('appSettings.walletName') }}</th>
                            <th>Data de criação</th>                            
                            <th class="text-center"><i class="
                                icon-circle-down2"></i></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

</div>
<div id="addNewUserModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="font-weight-bold">Novo Usuário</span></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{ route("admin.saveNewUser") }}" method="POST" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Nome:</label>
                        <div class="col-lg-9">
                            <input type="text" name="name" class="form-control form-control-lg"
                                placeholder="Nome completo" required autocomplete="new-name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Email:</label>
                        <div class="col-lg-9">
                            <input type="text" name="email" class="form-control form-control-lg"
                                placeholder="Endereço de email" required autocomplete="new-email">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Telefone:</label>
                        <div class="col-lg-9">
                            <input type="text" name="phone" class="form-control form-control-lg"
                                placeholder="Número de telefone" required autocomplete="new-phone">
                        </div>
                    </div>
                    <div class="form-group row form-group-feedback form-group-feedback-right">
                        <label class="col-lg-3 col-form-label">Senha:</label>
                        <div class="col-lg-9">
                            <input name="password" type="password" class="form-control form-control-lg" placeholder="Digite a senha (min 6 caracteres)" required
                                autocomplete="new-password" id="newUserPassword">
                        </div>
                        <div class="form-control-feedback form-control-feedback-lg">
                            <span id="showPassword"><i class="icon-unlocked2"></i> Mostrar</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Função:</label>
                        <div class="col-lg-9">
                            <select name="role" class="form-control select" data-fouc>
                                @foreach ($roles->reverse() as $role)
                                <option value="{{ $role->name }}" class="text-capitalize">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div id="deliveryGuyDetails" class="hidden">
                        <legend class="font-weight-semibold text-uppercase font-size-sm">
                            <i class="icon-truck mr-2"></i> Dados do Entregador
                        </legend>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Nome:</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control form-control-lg" name="delivery_name" placeholder="Nome ou apelido"
                                    autocomplete="new-name">
                                    <span class="help-text text-muted">Este nome aparecerá para clientes</span>
                            </div>
                            
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Data de nascimento</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control form-control-lg" name="delivery_age" placeholder="Data de nascimento">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Foto do Entregador :</label>
                            <div class="col-lg-9">
                                <input type="file" class="form-control-uniform" name="delivery_photo" data-fouc>
                                <span class="help-text text-muted">Dimensão da imagem 250x250</span>
                            </div>
                        </div>
                         <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Placa do Veículo</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control form-control-lg" name="delivery_description" placeholder="Placa do veículo se necessário">
                            </div>
                        </div>

                        <!-- Módulo RaioEntregador -->
                        @if (\Module::find("DeliveryRadiusPro") && \Module::find("DeliveryRadiusPro")->isEnabled())
                            <label class="col-lg-3 col-form-label mb-3">Raio de entrega em km</label>
                            <div class="col-lg-9 mb-3">
                                <input type="text" class="form-control form-control-lg" name="delivery_radius" placeholder="Raio em km" value="<?=!empty($user->delivery_guy_detail->delivery_radius) ? $user->delivery_guy_detail->delivery_radius : "0"?>">
                            </div>
                        @endif
                        <!-- Módulo RaioEntregador END -->

                         <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Tipo de Veículo</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control form-control-lg" name="delivery_vehicle_number" placeholder="Carro / Moto / Bike..">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Taxa de comissão %</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control form-control-lg commission_rate" name="delivery_commission_rate" placeholder="Geralmente 100%" value="5" required="required">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Limite de dinheiro em mãos ({{ config('appSettings.currencyFormat') }})</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control form-control-lg cash_limit" name="cash_limit" value="0.00"/>
                                <p>Insira um valor após o qual você não deseja que o entregador receba nenhum pedido. <strong><mark>Deixe 0 para sem limites.</mark></strong></p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Comissão da gorjeta %</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control form-control-lg tip-commission_rate" name="tip_commission_rate" placeholder="Commission Rate % (By detault, it's set to 5%)" value="100" required="required">
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">
                        SALVAR
                        <i class="icon-database-insert ml-1"></i></button>
                    </div>
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        $('.form-control-uniform').uniform();

        $("#showPassword").click(function (e) { 
            $("#newUserPassword").attr("type", "text");
        });
    
        $('.select').select2({
            minimumResultsForSearch: Infinity,
            placeholder: 'Select Role/s (Old roles will be revoked and these roles will be applied)',
        });

         $("[name='role']").change(function(event) {
            if ($(this).val() == "Delivery Guy") {
                $('#deliveryGuyDetails').removeClass('hidden');
                $("[name='delivery_name']").attr('required', 'required');
            }
            else {
                $('#deliveryGuyDetails').addClass('hidden');
                $("[name='delivery_name']").removeAttr('required')
            }
        });
        
        $('.commission_rate').numeric({ allowThouSep:false, maxDecimalPlaces: 2, max: 100, allowMinus: false });
        $('.cash_limit').numeric({allowThouSep:false, maxDecimalPlaces: 2, allowMinus: false });

        $('body').tooltip({selector: '[data-popup="tooltip"]'});
         var datatable = $('#usersDatatable').DataTable({
            processing: true,
            serverSide: true,
            stateSave: true,
            lengthMenu: [ 10, 25, 50, 100, 200, 500 ],
            order: [[ 0, "desc" ]],
            @if(\Nwidart\Modules\Facades\Module::find('CallAndOrder') && \Nwidart\Modules\Facades\Module::find('CallAndOrder')->isEnabled() && Request::is('callandorder/users'))
            ajax: '{{ route('cao.usersDatatable') }}',
            @else
            ajax: '{{ route('admin.usersDatatable') }}',
            @endif
            columns: [
                {data: 'id', visible: false, searchable: false},
                {data: 'name'},
                {data: 'email'},
                {data: 'phone'},
                {data: 'role', sortable: false, name: 'roles.name'},
                {data: 'wallet', sortable: false, searchable: false,},
                {data: 'created_at'},
                {data: 'action', sortable: false, searchable: false},
            ],
            colReorder: true,
            drawCallback: function( settings ) {
                $('select').select2({
                   minimumResultsForSearch: Infinity,
                   width: 'auto'
                });
            },
            scrollX: true,
            scrollCollapse: true,
            @role('Admin')
            dom: '<"custom-processing-banner"r>flBtip',
            @else
            dom: '<"custom-processing-banner"r>fltip',
            @endrole
            language: {
                search: '_INPUT_',
                searchPlaceholder: 'Search with anything...',
                lengthMenu: '_MENU_',
                paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' },
                processing: '<i class="icon-spinner10 spinner position-left mr-1"></i>Waiting for server response...'
            },
            
           buttons: {
                   dom: {
                       button: {
                           className: 'btn btn-default'
                       }
                   },
                   buttons: [
                       {extend: 'csv', filename: 'users-'+ new Date().toISOString().slice(0,10), text: 'Export as CSV'},
                   ]
               }
        });

         $('#clearFilterAndState').click(function(event) {
            if (datatable) {
                datatable.state.clear();
                window.location.reload();
            }
         });
    });
</script>

@if(\Nwidart\Modules\Facades\Module::find('CallAndOrder') && \Nwidart\Modules\Facades\Module::find('CallAndOrder')->isEnabled())
   @include('callandorder::scripts')
@endif

@endsection