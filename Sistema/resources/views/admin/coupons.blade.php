@extends('admin.layouts.master')
@section("title") Cupons - Dashboard
@endsection
@section('content')
<div class="page-header">
    <div class="page-header-content header-elements-md-inline">
        <div class="page-title d-flex">
            <h4>
                <span class="font-weight-bold mr-2">TOTAL</span>
                <i class="icon-circle-right2 mr-2"></i>
                <span class="font-weight-bold mr-2">{{ count($coupons) }} Cupons</span>
            </h4>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
        <div class="header-elements d-none py-0 mb-3 mb-md-0">
            <div class="breadcrumb">
                <button type="button" class="btn btn-secondary btn-labeled btn-labeled-left" id="addNewCoupon"
                    data-toggle="modal" data-target="#addNewCouponModal">
                    <b><i class="icon-plus2"></i></b>
                    Novo cupom
                </button>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Lojas aplicáveis</th>
                            <th>Código</th>
                            <th>Tipo</th>
                            <th>Desconto</th>
                            <th>Status</th>
                            <th>Uso</th>
                            <th style="min-width: 150px;">Expira em</th>
                            <th>Subtotal Min</th>
                            <th>Desconto Max</th>
                            <th class="text-center" style="width: 10%;"><i class="
                                icon-circle-down2"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($coupons as $coupon)
                        <tr>
                            <td>{{ $coupon->name }}</td>
                            <td>
                            @if(count($coupon->restaurants) > 1)
                           <span class="badge badge-flat border-grey-800 text-default text-capitalize">MÚLTIPLAS LOJAS</span>
                           @else
                           @foreach($coupon->restaurants as $couponRestaurant)
                                <span class="badge badge-flat border-grey-800 text-default text-capitalize">{{ $couponRestaurant->name }}</span>
                           @endforeach
                           @endif
                           </td>
                            <td><b>{{ $coupon->code }}</b></td>
                            <td>
                                <span class="badge badge-flat border-grey-800 text-default text-capitalize">
                                    {{ $coupon->discount_type }}
                                </span>
                            </td>
                            <td>
                                @if($coupon->discount_type == "AMOUNT")
                                {{ config('appSettings.currencyFormat') }} {{ $coupon->discount }}
                                @else
                                {{ $coupon->discount }} <strong>%</strong>
                                @endif
                            </td>
                            <td>@if($coupon->is_active)
                                <span class="badge badge-flat border-grey-800 text-default text-capitalize">
                                    Ativo
                                </span>
                                @else
                                <span class="badge badge-flat border-grey-800 text-default text-capitalize">
                                    Inativo
                                </span>
                                @endif
                            </td>
                            <td><span
                                    class="badge badge-flat border-grey-800 text-default text-capitalize">{{ $coupon->count }}</span>
                            </td>
                            <td class="small">{{ $coupon->expiry_date->diffForHumans() }}
                                <br>({{ $coupon->expiry_date->format('m-d-Y') }})
                            </td>
                            <td>{{ $coupon->min_subtotal }}</td>
                            <td>@if($coupon->max_discount) {{ $coupon->max_discount }} @else <span class="badge badge-flat border-grey-800 text-default text-capitalize">NA</span> @endif</td>
                            <td class="text-center">
                                <div class="btn-group btn-group-justified">
                                    <a href="{{ route('admin.get.getEditCoupon', $coupon->id) }}"
                                        class="btn btn-sm btn-primary"> Editar</a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div id="addNewCouponModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="font-weight-bold">Novo Cupom</span></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.post.saveNewCoupon') }}" method="POST">
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label"><span class="text-danger">*</span>Nome:</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control form-control-lg" name="name"
                                placeholder="Nome do cupom" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Descrição:</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control form-control-lg" name="description"
                                placeholder="Descrição do cupom">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label"><span class="text-danger">*</span>Código:</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control form-control-lg" name="code"
                                placeholder="Código do cupom" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label"><span class="text-danger">*</span>Tipo de desconto:</label>
                        <div class="col-lg-9">
                            <select class="form-control select-search select" name="discount_type" required>
                                <option value="AMOUNT" class="text-capitalize">
                                    Valor fixo
                                </option>
                                <option value="PERCENTAGE" class="text-capitalize">
                                    Valor percentual
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row hidden" id="max_discount">
                        <label class="col-lg-3 col-form-label">Desconto máximo</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control form-control-lg max_discount" name="max_discount"
                                placeholder="Limite do desconto em {{ config('appSettings.currencyFormat') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label"><span class="text-danger">*</span>Desconto:</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control form-control-lg discount" name="discount"
                                placeholder="Desconto do cupom" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-lg-3 col-form-label"><span class="text-danger">*</span>Data de expiração:</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control form-control-lg daterange-single"
                                    value="{{ $todaysDate }}" name="expiry_date">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label"><span class="text-danger">*</span>Lojas aplicáveis:</label>
                        <div class="col-lg-9">
                            <select multiple="multiple" class="form-control select-search couponStoreSelect" name="restaurant_id[]" required id="storeSelect">
                                @foreach ($restaurants as $restaurant)
                                <option value="{{ $restaurant->id }}" class="text-capitalize">{{ $restaurant->name }}
                                </option>
                                @endforeach
                            </select>
                             <input type="checkbox" id="selectAllStores"><span class="ml-1">Selecionar todas as lojas</span>
                        </div>
                    </div>
                    <script>
                        $("#selectAllStores").click(function(){
                            if($("#selectAllStores").is(':checked') ){
                                $("#storeSelect > option").prop("selected","selected");
                                $("#storeSelect").trigger("change");
                            }else{
                                $("#storeSelect > option").removeAttr("selected");
                                 $("#storeSelect").trigger("change");
                             }
                        });
                    </script>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label"><span class="text-danger">*</span>Número máximo de uso</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control form-control-lg max_count" name="max_count"
                                placeholder="Limite de uso" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Subtotal mínimo</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control form-control-lg min_subtotal" name="min_subtotal"
                                placeholder="Valor mínimo para usar o cupom em {{ config('appSettings.currencyFormat') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Mensagem de subtotal não alcançado</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control form-control-lg" name="subtotal_message"
                                placeholder="Mensagem de subtotal não alcançado">
                        </div>
                    </div>
                     <div class="form-group row">
                        <label class="col-lg-3 col-form-label"><span class="text-danger">*</span>Tipo de uso</label>
                        <div class="col-lg-9">
                    <select class="form-control select-search select" name="user_type" required>
                        <option value="ALL" class="text-capitalize">
                            Ilimitado para todos os usuários
                        </option>
                        <option value="ONCENEW" class="text-capitalize">
                            Uma vez para o primeiro pedido do usuário
                        </option>
                        <option value="ONCE" class="text-capitalize">
                            Uma vez por usuário
                        </option>
                        <option value="CUSTOM" class="text-capitalize">
                            Definir limite personalizado
                        </option>
                     </select>
                     </div>
                    </div>
                    <div class="form-group row hidden" id="maxUsePerUser">
                        <label class="col-lg-3 col-form-label">Número máximo de uso por usuário:</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control form-control-lg max_count_per_user" name="max_count_per_user"
                                placeholder="Número máximo de uso por usuário">
                        </div>
                    </div>
                    <script>
                        $("[name='user_type']").change(function() {
                            let selectedUserType = $(this).val();
                            if (selectedUserType == "CUSTOM") {
                                 $("[name='max_count_per_user']").attr('required', 'required');
                                $('#maxUsePerUser').removeClass('hidden');
                            } else {
                               $("[name='max_count_per_user']").removeAttr('required')
                               $('#maxUsePerUser').addClass('hidden');
                            }
                        });
                    </script>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Ativo?</label>
                        <div class="col-lg-9 d-flex align-items-center">
                            <div class="checkbox checkbox-switchery">
                                    <input value="true" type="checkbox" class="switchery-primary isactive"
                                        checked="checked" name="is_active">
                                </label>
                            </div>
                        </div>
                    </div>
                    @csrf
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">
                            SALVAR
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
           $('.select').select2();
           $('.couponStoreSelect').select2({
               closeOnSelect: false
           })
    
           var isactive = document.querySelector('.isactive');
           new Switchery(isactive, { color: '#2196f3' });
           
           $('.form-control-uniform').uniform();
    
           $('.daterange-single').daterangepicker({ 
               singleDatePicker: true,
           });
           $('[name="discount_type"]').change(function(event) {
            console.log($(this).val());
               if ($(this).val() == "PERCENTAGE") {
                $('#max_discount').removeClass('hidden');
               } else {
                 $('#max_discount').addClass('hidden');
               }
           });
           $('.min_subtotal').numeric({ allowThouSep:false, maxDecimalPlaces: 2, allowMinus: false });
           $('.max_discount').numeric({ allowThouSep:false, maxDecimalPlaces: 2, allowMinus: false });
           $('.max_count').numeric({ allowThouSep:false, maxDecimalPlaces: 0, allowMinus: false });
           $('.max_count_per_user').numeric({ allowThouSep:false, maxDecimalPlaces: 0, allowMinus: false, max: 99999999 });
           $('.discount').numeric({ allowThouSep:false, maxDecimalPlaces: 2, allowMinus: false });
       });    
</script>
@endsection