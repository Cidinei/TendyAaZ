@extends('admin.layouts.master')
@section("title") Editar Coupom - Dashboard
@endsection
@section('content')
<div class="page-header">
    <div class="page-header-content header-elements-md-inline">
        <div class="page-title d-flex">
            <h4>
                <span class="font-weight-bold mr-2">Editando</span>
                <i class="icon-circle-right2 mr-2"></i>
                <span class="font-weight-bold mr-2">{{ $coupon->name }} -  {{ $coupon->code }}</span>
            </h4>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>
<div class="content">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.updateCoupon') }}" method="POST">
                    <legend class="font-weight-semibold text-uppercase font-size-sm">
                        <i class="icon-address-book mr-2"></i> Detalhes do cupom
                    </legend>
                    <input type="hidden" name="id" value="{{ $coupon->id }}">
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label"><span class="text-danger">*</span>Nome:</label>
                        <div class="col-lg-9">
                            <input value="{{ $coupon->name }}" type="text" class="form-control form-control-lg" name="name"
                                placeholder="Nome do cupom" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Descrição:</label>
                        <div class="col-lg-9">
                            <input value="{{ $coupon->description }}" type="text" class="form-control form-control-lg" name="description"
                                placeholder="Descrição do cupom">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label"><span class="text-danger">*</span>Código:</label>
                        <div class="col-lg-9">
                            <input value="{{ $coupon->code }}" type="text" class="form-control form-control-lg" name="code"
                                placeholder="Código do cupom" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label"><span class="text-danger">*</span>Tipo de desconto:</label>
                        <div class="col-lg-9">
                            <select class="form-control select-search select" name="discount_type" required>
                            <option value="AMOUNT" class="text-capitalize" @if($coupon->discount_type == "AMOUNT") selected="selected" @endif>
                            Valor fixo
                            </option>
                            <option value="PERCENTAGE" class="text-capitalize" @if($coupon->discount_type == "PERCENTAGE") selected="selected" @endif>
                            Valor percentual
                            </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row @if($coupon->discount_type =="AMOUNT") hidden @endif" id="max_discount">
                        <label class="col-lg-3 col-form-label">Desconto máximo</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control form-control-lg max_discount" name="max_discount"
                                placeholder="Valor máximo em {{ config('appSettings.currencyFormat') }}" value="{{ $coupon->max_discount }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label"><span class="text-danger">*</span>Desconto do cupom:</label>
                        <div class="col-lg-9">
                            <input value="{{ $coupon->discount }}" type="text" class="form-control form-control-lg discount" name="discount"
                                placeholder="Desconto" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-lg-3 col-form-label"><span class="text-danger">*</span>Data de expiração:</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control form-control-lg daterange-single" value="{!! $coupon->expiry_date->format('m-d-Y') !!}" name="expiry_date">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label"><span class="text-danger">*</span>Lojas aplicáveis:</label>
                        <div class="col-lg-9">
                            <select class="form-control select-search couponStoreSelect" name="restaurant_id[]" required multiple="multiple" id="storeSelect">
                                @foreach ($restaurants as $restaurant)
                                <option value="{{ $restaurant->id }}" class="text-capitalize" {{ isset($coupon) && in_array($restaurant->id, $couponAssignedRestaurants) ? 'selected' : '' }}>{{ $restaurant->name }}</option>
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
                        <label class="col-lg-3 col-form-label"><span class="text-danger">*</span>Número máximo de uso por usuário:</label>
                        <div class="col-lg-9">
                            <input value="{{ $coupon->max_count }}" type="text" class="form-control form-control-lg max_count" name="max_count"
                                placeholder="Número máximo de uso" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Subtotal Mínimo</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control form-control-lg min_subtotal" name="min_subtotal"
                                placeholder="Valor do subtotal mínimo em {{ config('appSettings.currencyFormat') }}" value="{{ $coupon->min_subtotal }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Mensagem de subtotal não alcançado</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control form-control-lg" name="subtotal_message"
                                placeholder="Mensagem de subtotal não alcançado" value="{{ $coupon->subtotal_message }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label"><span class="text-danger">*</span>Tipo de uso</label>
                        <div class="col-lg-9">
                        <select class="form-control select-search select" name="user_type" required>
                            <option value="ALL" class="text-capitalize" @if($coupon->user_type == "ALL") selected="selected" @endif>
                            Ilimitado para todos os usuários
                            </option>
                            <option value="ONCENEW" class="text-capitalize" @if($coupon->user_type == "ONCENEW") selected="selected" @endif>
                            Uma vez para o primeiro pedido do usuário
                            </option>
                            <option value="ONCE" class="text-capitalize" @if($coupon->user_type == "ONCE") selected="selected" @endif>
                            Uma vez por usuário
                            </option>
                            <option value="CUSTOM" class="text-capitalize" @if($coupon->user_type == "CUSTOM") selected="selected" @endif>
                            Definir limite personalizado
                            </option>
                         </select>
                     </div>
                    </div>
                    <div class="form-group row @if($coupon->user_type != "CUSTOM") hidden @endif" id="maxUsePerUser">
                        <label class="col-lg-3 col-form-label">Uso máximo por usuário:</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control form-control-lg max_count_per_user" name="max_count_per_user"
                                placeholder="Número de uso máximo por usuário" @if($coupon->user_type == "CUSTOM") required="required" @endif value="{{ $coupon->max_count_per_user }}">
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
                                <input value="true" type="checkbox" class="switchery-primary isactive" @if($coupon->is_active) checked="checked" @endif name="is_active">
                            </div>
                        </div>
                    </div>
                    @csrf
                    <div class="text-left">
                        <a class="btn btn-danger text-white" data-toggle="modal" data-target="#deleteCouponConfirmModal" id="deleteCouponButton">
                        DELETAR
                        <i class="icon-trash ml-1"></i>
                        </a>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">
                        ATUALIZAR
                        <i class="icon-database-insert ml-1"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="deleteCouponConfirmModal" class="modal fade mt-5" tabindex="-1">
    <div class="modal-dialog modal-xs">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="font-weight-bold">Are you sure?</span></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="mt-4 d-flex justify-content-center align-items-center">
                    <a href="{{ route('admin.deleteCoupon', $coupon->id) }}" class="btn btn-primary mr-2">Yes</a>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
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